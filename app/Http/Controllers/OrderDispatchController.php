<?php

namespace App\Http\Controllers;

use App\Events\CanisterLogCreatedEvent;
use App\Http\Requests\StoreOrderDispatchRequest;
use App\Http\Resources\CreatedCanisterLogResource;
use App\Models\Canister;
use App\Models\CanisterLogBatch;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Order;
use App\Models\Transporter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderDispatchController extends Controller
{
    public function store(StoreOrderDispatchRequest $request, Order $order)
    {
        if ($order->assigned_to === null) {
            abort(400, 'This order has not been assigned!');
        }
        $batch = $order->canisterLogBatches()->create([
            'toable_id' => $request->get('from') === 'depot' ? $order->dealer_id : $order->depot_id,
            'toable_type' => $request->get('from') === 'depot' ? Dealer::class: Depot::class,
            'fromable_id' => $request->get('from') === 'depot' ? $order->depot_id : $order->dealer_id,
            'fromable_type' => $request->get('from') === 'depot' ? Depot::class : Dealer::class,
            'transporter_id' => $order->assigned_to
        ]);
        foreach ($request->get('canisters') as $canister) {
            if (key_exists('canisterId', $canister)) {
                $canisterId = $canister['canisterId'];
            } else {
                $canisterId = Canister::create([
                    'RFID' => Str::random(16),
                    'code' => '-',
                    'recertification' => '-',
                    'manuf' => '-',
                    'manuf_date' => Carbon::now(),
                    'brand_id' => $canister['canisterBrandId'],
                    'canister_size_id' => $canister['canisterSizeId'],
                ])->id;
            }
            $canisterLog = $batch->canisterLogs()->create([
                'toable_id' => $order->assigned_to,
                'toable_type' => Transporter::class,
                'fromable_id' => $request->get('from') === 'depot' ? $order->depot_id : $order->dealer_id,
                'fromable_type' => $request->get('from') === 'depot' ? Depot::class : Dealer::class,
                'canister_id' => $canisterId,
                'filled' => true,
                'user_id' => auth()->id()
            ]);
            CanisterLogCreatedEvent::dispatch($canisterLog);
        }

        return response()->json(CreatedCanisterLogResource::make($batch));

    }
}
