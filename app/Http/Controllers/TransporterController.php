<?php

namespace App\Http\Controllers;

use App\Events\DepotCreatedEvent;
use App\Events\TransporterCreatedEvent;
use App\Http\Requests\DeleteTransporterRequest;
use App\Http\Requests\StoreTransporterRequest;
use App\Http\Requests\UpdateTransporterRequest;
use App\Http\Resources\CreatedTransporterResource;
use App\Http\Resources\TransporterCollection;
use App\Http\Resources\TransporterResource;
use App\Http\Resources\UpdatedTransporterResource;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransporterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TransporterCollection
     */
    public function index(Request $request)
    {
        $transporters = new Transporter();

        if ($request->get('searchTerm')) {
            $transporters = $transporters->where(function ($q) use ($request) {
                $q->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($request->get('searchTerm')) . '%')
                    ->orWhere(DB::raw('lower(code)'), 'LIKE', '%' . strtolower($request->get('searchTerm')) . '%');
            });
        }

        if ($request->get('ids')) {
            $transporters = $transporters->whereIn('id', $request->get('ids'));
        }

        if ($request->get('depotIds')) {
            $transporters = $transporters->whereHas('contractedDealers', function ($q) use ($request) {
                $q->whereIn('depot_id', $request->get('depotIds'));
            });
        }

//        if ($request->boolean('userEnabledOnly')) {
//            $transporters = $transporters->userEnabled();
//        }

        $orderBys = [
            ['name' => 'transporterId', 'value' => 'id'],
            ['name' => 'transporterName', 'value' => 'name'],
            ['name' => 'transporterCode', 'value' => 'code']
        ];
        foreach ($orderBys as $orderBy) {
            if ($request->get('orderBy') === $orderBy['name']) {
                $transporters = $transporters->orderBy($orderBy['value'], $request->boolean('orderByDesc') ? 'desc' : 'asc');
                break;
            }
        }

        return TransporterCollection::make($transporters->paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransporterRequest $request
     * @return JsonResponse
     */
    public function store(StoreTransporterRequest $request)
    {

        $transporter = Transporter::create([
            'name' => $request->get('transporterName'),
            'code' => $request->get('transporterCode'),
        ]);

        if ($request->get('userLoginEnabled')) {
            TransporterCreatedEvent::dispatch($transporter);
        }

        return response()->json(
            CreatedTransporterResource::make($transporter)
        )->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param Transporter $transporter
     * @return TransporterResource
     */
    public function show(Transporter $transporter)
    {
        return TransporterResource::make($transporter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTransporterRequest $request
     * @param Transporter $transporter
     * @return UpdatedTransporterResource
     */
    public function update(UpdateTransporterRequest $request, Transporter $transporter)
    {
        $transporter->update([
            'name' => $request->get('transporterName'),
            'code' => $request->get('transporterCode'),
        ]);

        if ($request->get('userLoginEnabled') && $transporter->stationRoles->count() < 1) {
            TransporterCreatedEvent::dispatch($transporter);
        } else {
            $transporter->stationRoles()->delete();
        }

        return UpdatedTransporterResource::make($transporter);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transporter $transporter
     * @return JsonResponse
     */
    public function destroy(DeleteTransporterRequest $request, Transporter $transporter)
    {
        $transporter->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted transporter'
            ]
        ]);
    }
}
