<?php

namespace App\Http\Controllers;

use App\Events\CanisterLogCreatedEvent;
use App\Http\Requests\DeleteCanisterRequest;
use App\Http\Requests\StoreCanisterRequest;
use App\Http\Requests\UpdateCanisterRequest;
use App\Http\Resources\CanisterCollection;
use App\Http\Resources\CanisterResource;
use App\Http\Resources\CreatedCanisterResource;
use App\Http\Resources\UpdatedCanisterResource;
use App\Models\Canister;
use App\Models\CanisterLog;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CanisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CanisterCollection
     */
    public function index(Request $request)
    {
        $canisters = new Canister();

        if ($request->get('orderId') && $request->get('fromDepot') !== null) {
            $canisters = $canisters->whereHas('canisterLogs', function ($q) use ($request) {
                $q->whereHas('canisterLogBatch', function ($r) use ($request) {
                    $r->whereHas('order', function ($s) use ($request) {
                        $s->where('id', $request->get('orderId'));
                    });
                })->where('fromable_type', $request->boolean('fromDepot') ? Depot::class : Dealer::class);
            });
        } elseif($request->get('orderId')) {
            abort(400, 'fromDepot field is required when orderId is provided');
        }

        if ($request->get('searchTerm')) {
            $canisters = $canisters->whereHas('brand', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->get('searchTerm') . '%');
            });
        }

        if ($request->get('canisterBrandId')) {
            $canisters = $canisters->where('brand_id', $request->get('canisterBrandId'));
        }

        if ($request->get('depotId')) {
            $canisters = $canisters->whereHas('canisterDepotLogs', function ($q) use ($request) {
                $q->where('toable_id', $request->get('depotId'));
            });
        }

        if ($request->get('dealerId')) {
            $canisters = $canisters->whereHas('canisterDealerLogs', function ($q) use ($request) {
                $q->where('toable_id', $request->get('dealerId'));
            });
        }

        if ($request->get('transporterId')) {
            $canisters = $canisters->whereHas('canisterTransporterLogs', function ($q) use ($request) {
                $q->where('toable_id', $request->get('transporterId'));
            });
        }


        $orderBys = [
            ['name' => 'canisterId', 'value' => 'id']
        ];
        foreach ($orderBys as $orderBy) {
            if ($request->get('orderBy') === $orderBy['name']) {
                $canisters = $canisters->orderBy($orderBy['value'], $request->boolean('orderByDesc') ? 'desc' : 'asc');
                break;
            }
        }

        return CanisterCollection::make($canisters->paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCanisterRequest $request
     * @return CreatedCanisterResource
     */
    public function store(StoreCanisterRequest $request)
    {
        $canister = Canister::firstOrcreate(
            ['RFID' => $request->canisterRFID],
            [
                'code' => $request->canisterCode,
                'manuf' => $request->canisterManuf,
                'manuf_date' => new Carbon($request->canisterManufDate),
                'brand_id' => $request->canisterBrandId,
                'recertification' => $request->canisterRecertification,
                'canister_size_id' => $request->get('canisterSizeId')
            ]);
        if ($request->get('currentlyAtDepotId')) {
            $station = Depot::find($request->get('currentlyAtDepotId'));
        } elseif ($request->get('currentlyAtDealerId')) {
            $station = Dealer::find($request->get('currentlyAtDealerId'));
        } else {
            $station = Transporter::find($request->get('currentlyAtTransporterId'));
        }

        $canisterLog = $station->receivedCanisterLogs()->create([
            'canister_id' => $canister['id'],
            'filled' => $request->get('currentlyFilled'),
            'user_id' => auth()->id()
        ]);

        CanisterLogCreatedEvent::dispatch($canisterLog);

        return CreatedCanisterResource::make($canister);
    }

    /**
     * Display the specified resource.
     *
     * @param Canister $canister
     * @return CanisterResource
     */
    public function show(Depot $depot, Canister $canister)
    {
        return CanisterResource::make($canister);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCanisterRequest $request
     * @param Canister $canister
     * @return JsonResponse
     */
    public function update(UpdateCanisterRequest $request, Depot $depot, Canister $canister)
    {
        $canister->update([
            'code' => $request->canisterCode,
            'manuf' => $request->canisterManuf,
            'manuf_date' => $request->canisterManufDate,
            'brand_id' => $request->canisterBrandId,
            'RFID' => $request->canisterRFID,
            'recertification' => $request->canisterRecertification,
            'canister_size_id' => $request->get('canisterSizeId')
        ]);

        return response()->json(UpdatedCanisterResource::make($canister));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Canister $canister
     * @return JsonResponse
     */
    public function destroy(DeleteCanisterRequest $request, Depot $depot, Canister $canister)
    {
        $canister->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted canister'
            ]
        ]);
    }
}
