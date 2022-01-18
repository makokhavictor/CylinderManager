<?php

namespace App\Http\Controllers;

use App\Events\CanisterLogCreatedEvent;
use App\Http\Requests\StoreCanisterLogRequest;
use App\Http\Resources\CanisterLogBatchResource;
use App\Http\Resources\CreatedCanisterLogResource;
use App\Models\CanisterLogBatch;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Order;
use Illuminate\Http\Request;

class CanisterDispatchController extends Controller
{
    public function index(Request $request)
    {
        // inTransit;
        // transporterId;
        $batches = new CanisterLogBatch();

        if($request->get('transporterId')) {
            $batches = $batches->where('transporter_id', $request->get('transporterId'));
        }

        if($request->boolean('received')) {
            $batches = $batches->where('received', $request->boolean('received'));
        }

        return CanisterLogBatchResource::collection($batches->paginate());
    }

    public function store(StoreCanisterLogRequest $request)
    {
        // TODO add check for order against number of items

        $order = Order::find($request->get('orderId'));
        logger($order->canisterSizes->toArray());
        logger($request->get('canisters'));
        $toableId = $request->get('toDepotId');
        $toableType = Depot::class;
        $fromableId = $request->get('fromDealerId');
        $fromableType = Dealer::class;
        if ($request->get('toDealerId') !== null) {
            $toableId = $request->get('toDealerId');
            $toableType = Dealer::class;
            $fromableId = $request->get('fromDepotId');
            $fromableType = Depot::class;
        }
        $batch = CanisterLogBatch::create([
            'order_id' => $request->get('orderId'),
            'toable_id' => $toableId,
            'toable_type' => $toableType,
            'fromable_id' => $fromableId,
            'fromable_type' => $fromableType,
            'transporter_id' => $request->get('transporterId')
        ]);
        foreach ($request->get('canisters') as $canister) {
            $canisterLog = $batch->canisterLogs()->create([
                'toable_id' => $toableId,
                'toable_type' => $toableType,
                'fromable_id' => $fromableId,
                'fromable_type' => $fromableType,
                'canister_id' => $canister['id'],
                'filled' => $canister['filled'],
                'user_id' => auth()->id()
            ]);
            CanisterLogCreatedEvent::dispatch($canisterLog);
        }

        return response()->json(CreatedCanisterLogResource::make($batch));
    }
}
