<?php

namespace App\Http\Controllers;

use App\Events\DealerCreatedEvent;
use App\Http\Requests\StoreDealerRequest;
use App\Http\Requests\UpdateDealerRequest;
use App\Http\Requests\DeleteDealerRequest;
use App\Http\Resources\CreatedDealerResource;
use App\Http\Resources\DealerCollection;
use App\Http\Resources\DealerResource;
use App\Http\Resources\UpdatedDealerResource;
use App\Models\Dealer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DealerCollection
     */
    public function index(Request $request)
    {
        $dealers = new Dealer();

        if ($request->get('searchTerm')) {
            $dealers = $dealers->where('name', 'LIKE', '%' . $request->get('searchTerm') . '%')
                ->orWhere('code', 'LIKE', '%' . $request->get('searchTerm') . '%')
                ->orWhere('EPRA_licence_no', 'LIKE', '%' . $request->get('searchTerm') . '%')
                ->orWhere('location', 'LIKE', '%' . $request->get('searchTerm') . '%');
        }

        $orderBys = [
            ['name' => 'dealerId', 'value' => 'id'],
            ['name' => 'dealerCode', 'value' => 'code'],
            ['name' => 'dealerName', 'value' => 'name'],
            ['name' => 'dealerEPRALicenceNo', 'value' => 'EPRA_licence_no'],
            ['name' => 'dealerLocation', 'value' => 'location'],
        ];
        foreach ($orderBys as $orderBy) {
            if ($request->get('orderBy') === $orderBy['name']) {
                $dealers = $dealers->orderBy($orderBy['value'], $request->boolean('orderByDesc') ? 'desc': 'asc');
                break;
            }
        }

        return DealerCollection::make($dealers->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDealerRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(StoreDealerRequest $request)
    {
        $dealer = Dealer::create([
            'code' => $request->get('dealerCode'),
            'name' => $request->get('dealerName'),
            'EPRA_licence_no' => $request->get('dealerEPRALicenceNo'),
            'location' => $request->get('dealerLocation'),
            'GPS' => $request->get('dealerGPS')
        ]);

        if($request->boolean('userLoginEnabled') ) {
            DealerCreatedEvent::dispatch($dealer);
        }

        return response()
            ->json(CreatedDealerResource::make($dealer))
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param Dealer $dealer
     * @return JsonResponse
     */
    public function show(Dealer $dealer)
    {
        return response()->json([
            'data' => DealerResource::make($dealer)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDealerRequest $request
     * @param Dealer $dealer
     * @return JsonResponse
     */
    public function update(UpdateDealerRequest $request, Dealer $dealer)
    {
        $dealer->update([
            'code' => $request->get('dealerCode'),
            'name' => $request->get('dealerName'),
            'EPRA_licence_no' => $request->get('dealerEPRALicenceNo'),
            'location' => $request->get('dealerLocation'),
            'GPS' => $request->get('dealerGPS'),
        ]);

        if($request->get('userLoginEnabled') && $dealer->stationRoles->count() < 1) {
            DealerCreatedEvent::dispatch($dealer);
        } else {
            $dealer->stationRoles()->delete();
        }

        return response()->json(UpdatedDealerResource::make($dealer));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dealer $dealer
     * @return JsonResponse
     */
    public function destroy(DeleteDealerRequest $request, Dealer $dealer)
    {
        $dealer->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted depot'
            ]
        ]);

    }
}
