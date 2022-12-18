<?php

namespace App\Http\Controllers;

use App\Events\DealerCreatedEvent;
use App\Events\DepotCreatedEvent;
use App\Http\Requests\DeleteDepotRequest;
use App\Http\Resources\CreatedDepotResource;
use App\Http\Resources\UpdatedDepotResource;
use App\Http\Resources\DepotCollection;
use App\Http\Resources\DepotResource;
use App\Models\Depot;
use App\Http\Requests\StoreDepotRequest;
use App\Http\Requests\UpdateDepotRequest;
use App\Models\StationRole;
use App\Models\Transporter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DepotCollection
     */
    public function index(Request $request)
    {
        $depots = new Depot();

        if ($request->get('ids')) {
            $depots = $depots->whereIn('id', $request->get('ids'));
        }

        if ($request->get('searchTerm')) {
            $depots = $depots->where(function ($q) use ($request) {
                $q->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($request->get('searchTerm')) . '%')
                    ->orWhere(DB::raw('lower(code)'), 'LIKE', '%' . strtolower($request->get('searchTerm')) . '%')
                    ->orWhere(DB::raw('lower(EPRA_licence_no)'), 'LIKE', '%' . strtolower($request->get('searchTerm')) . '%')
                    ->orWhere(DB::raw('lower(location)'), 'LIKE', '%' . strtolower($request->get('searchTerm')) . '%');
            });
        }

        if ($request->get('canisterBrandId')) {
            $depots = $depots->whereHas('brands', function ($q) use ($request) {
                $q->where('brand_id', $request->get('canisterBrandId'));
            });
        }

        if ($request->boolean('userEnabledOnly')) {
            $depots = $depots->userEnabled();
        }

        $orderBys = [
            ['name' => 'depotId', 'value' => 'id'],
            ['name' => 'depotCode', 'value' => 'code'],
            ['name' => 'depotName', 'value' => 'name'],
            ['name' => 'depotEPRALicenceNo', 'value' => 'EPRA_licence_no'],
            ['name' => 'depotLocation', 'value' => 'location'],
        ];
        foreach ($orderBys as $orderBy) {
            if ($request->get('orderBy') === $orderBy['name']) {
                $depots = $depots->orderBy($orderBy['value'], $request->boolean('orderByDesc') ? 'desc' : 'asc');
                break;
            }
        }

        return DepotCollection::make($depots->paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDepotRequest $request
     * @return JsonResponse
     */
    public function store(StoreDepotRequest $request)
    {
        $depot = Depot::create([
            'name' => $request->get('depotName'),
            'code' => $request->get('depotCode'),
            'EPRA_licence_no' => $request->get('depotEPRALicenceNo'),
            'location' => $request->get('depotLocation'),
        ]);
        $depot->brands()->attach($request->get('canisterBrandIds'));

        if ($request->get('transporters')) {
            foreach ($request->get('transporters') as $transporter) {
                $depot->contractedTransporters()->save(
                    Transporter::find($transporter['transporterId']),
                    [
                        'expires_at' => key_exists('contractExpiryDate', $transporter) ? new Carbon($transporter['contractExpiryDate']) : null
                    ]
                );
            }
        }

        if ($request->get('userLoginEnabled')) {
            DepotCreatedEvent::dispatch($depot);
        }


        return response()->json(
            CreatedDepotResource::make($depot)
        )->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param Depot $depot
     * @return DepotResource
     */
    public function show(Depot $depot)
    {
        return DepotResource::make($depot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDepotRequest $request
     * @param Depot $depot
     * @return UpdatedDepotResource
     */
    public function update(UpdateDepotRequest $request, Depot $depot)
    {
        $depot->update([
            'name' => $request->get('depotName'),
            'code' => $request->get('depotCode'),
            'EPRA_licence_no' => $request->get('depotEPRALicenceNo'),
            'location' => $request->get('depotLocation'),
        ]);

        $depot->brands()->detach();
        $depot->brands()->attach($request->get('canisterBrandIds'));

        $depot->contractedTransporters()->detach();
        if ($request->get('transporters')) {
            foreach ($request->get('transporters') as $transporter) {
                $depot->contractedTransporters()->save(
                    Transporter::find($transporter['transporterId']),
                    [
                        'expires_at' => key_exists('contractExpiryDate', $transporter) ? new Carbon($transporter['contractExpiryDate']) : null
                    ]
                );
            }
        }

        if ($request->boolean('userLoginEnabled') && $depot->stationRoles->count() < 1) {
            DepotCreatedEvent::dispatch($depot);
        } elseif (!$request->boolean('userLoginEnabled') && $depot->stationRoles->count() > 1) {
            $depot->stationRoles()->delete();
        }

        return UpdatedDepotResource::make($depot);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Depot $depot
     * @return JsonResponse
     */
    public function destroy(DeleteDepotRequest $request, Depot $depot)
    {
        $depot->brands()->detach();
        $depot->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted depot'
            ]
        ]);
    }
}
