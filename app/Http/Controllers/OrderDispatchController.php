<?php

namespace App\Http\Controllers;

use App\Events\CanisterLogCreatedEvent;
use App\Http\Requests\StoreOrderDispatchRequest;
use App\Http\Resources\CreatedCanisterLogResource;
use App\Models\CanisterLogBatch;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Order;
use App\Models\Transporter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderDispatchController extends Controller
{
    public function store(StoreOrderDispatchRequest $request, Order $order)
    {
        if ($order->assigned_to === null) {
            abort(400, 'This order has not been assigned!');
        }
        $batch = $order->canisterLogBatches()->create([
            'toable_id' => $order->dealer_id,
            'toable_type' => Dealer::class,
            'fromable_id' => $order->depot_id,
            'fromable_type' => Depot::class,
            'transporter_id' => $order->assigned_to
        ]);
        foreach ($request->get('canisters') as $canister) {
            $canisterLog = $batch->canisterLogs()->create([
                'toable_id' => $order->assigned_to,
                'toable_type' => Transporter::class,
                'fromable_id' => $order->depot_id,
                'fromable_type' => Depot::class,
                'canister_id' => $canister['canisterId'],
                'filled' => true,
                'user_id' => auth()->id()
            ]);
            CanisterLogCreatedEvent::dispatch($canisterLog);
        }

        return response()->json(CreatedCanisterLogResource::make($batch));

    }
}
