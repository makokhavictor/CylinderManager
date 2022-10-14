<?php

namespace App\Http\Controllers;

use App\Events\CanisterLogCreatedEvent;
use App\Events\CanistersDispatchedFromDealerEvent;
use App\Events\CanistersDispatchedFromDepotEvent;
use App\Events\OrderUpdatedEvent;
use App\Http\Requests\StoreOrderDispatchRequest;
use App\Http\Resources\CreatedCanisterLogResource;
use App\Models\Brand;
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

        if ($order->canisterSizes->sum('pivot.quantity') > sizeof($request->get('canisters'))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'canisters' => ['The number of canisters is less than the total number of ordered canisters'],
            ]);
        }

        if ($order->canisterSizes->sum('pivot.quantity') < sizeof($request->get('canisters'))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'canisters' => ['The number of canisters is more than the total number of ordered canisters'],
            ]);
        }


        $canisterIds = collect($request->get('canisters'))->pluck(['canisterId'])->filter(function ($q) {
            return $q;
        });

        if ($canisterIds->count() !== $canisterIds->unique()->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'canisters' => ['You have duplicate canister with the same ID'],
            ]);
        }

        $canisters = [];

        foreach ($request->get('canisters') as $canisterInput) {
            if (key_exists('canisterId', $canisterInput)) {
                $canister = Canister::find($canisterInput['canisterId']);
                $canisters[] = [
                    'brand_id' => $canister->brand->id,
                    'canister_size_id' => $canister->canisterSize->id,
                ];
            } else {
                $canisters[] = [
                    'brand_id' => $canisterInput['canisterBrandId'],
                    'canister_size_id' => $canisterInput['canisterSizeId'],
                ];
            }
        }

        foreach ($order->canisterSizes as $canisterSize) {
            $orderQuantity = $order->canisterSizes->where('pivot.canister_size_id', $canisterSize->pivot->canister_size_id)
                ->where('pivot.brand_id', $canisterSize->pivot->brand_id)
                ->sum('pivot.quantity');
            $requestQuantity = collect($canisters)->where('canister_size_id', $canisterSize->pivot->canister_size_id)
                ->where('brand_id', $canisterSize->pivot->brand_id)
                ->count();

            if ($orderQuantity > $requestQuantity) {
                $brand = Brand::find($canisterSize->pivot->brand_id);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'canisters' => ["The order for {$brand->name}({$canisterSize->pivot->quantity} - {$canisterSize->name}) not satisfied"],
                ]);

            }
        }

        $batch = $order->canisterLogBatches()->create([
            'toable_id' => $request->get('from') === 'depot' ? $order->dealer_id : $order->depot_id,
            'toable_type' => $request->get('from') === 'depot' ? Dealer::class : Depot::class,
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

        OrderUpdatedEvent::dispatch(Order::find($order->id));

        if  ($request->get('from') === 'depot') {
            CanistersDispatchedFromDepotEvent::dispatch(Order::find($order->id));
        } elseif ( $request->get('from') === 'dealer') {
            CanistersDispatchedFromDealerEvent::dispatch(Order::find($order->id));
        }

        return response()->json(CreatedCanisterLogResource::make($batch));

    }
}
