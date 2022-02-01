<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Canister;
use App\Models\CanisterLog;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Order;
use App\Models\Transporter;
use Carbon\Carbon;

class OrderStatusController extends Controller
{
    public function store(StoreOrderStatusRequest $request, Order $order)
    {
        if ($request->boolean('acceptOrder')) {
            $order->accepted_at = Carbon::now();
            $order->save();
            return response()->json([
                'data' => OrderResource::make($order),
                'headers' => [
                    'message' => 'Order Successfully acknowledged'
                ]
            ]);
        }

        if ($request->get('transporterId')) {
            $order->assigned_at = Carbon::now();
            $order->assigned_to = $request->get('transporterId');
            $order->save();

            return response()->json([
                'data' => OrderResource::make($order),
                'headers' => [
                    'message' => 'Order Successfully assigned'
                ]
            ]);
        }

        if ($request->get('depotToTransporterOk') !== null) {
            $order->depot_transporter_ok = $request->boolean('depotToTransporterOk');
            $order->depot_transporter_ok_at = Carbon::now();
            $order->save();
            return response()->json([
                'data' => OrderResource::make($order),
                'headers' => [
                    'message' => 'Order from depot confirmed'
                ]
            ]);
        }

        if ($request->get('transporterToDepotOk') !== null) {

            $canisterLogs = $order->canisterLogs->where('fromable_type', Dealer::class)
                ->where('toable_type', Transporter::class);
            logger($canisterLogs->toArray());

            foreach ($canisterLogs as $canisterLog) {
                CanisterLog::create([
                    'fromable_id' => $order->transporter_id,
                    'fromable_type' => Transporter::class,
                    'toable_id' => $order->depot_id,
                    'toable_type' => Depot::class,
                    'canister_id' => $canisterLog->canister_id,
                    'filled' => $canisterLog->filled,
                    'user_id' => auth()->id(),
                    'canister_log_batch_id' =>  $canisterLog->canister_log_batch_id,
                    'defective' => $canisterLog->defective,
                ]);

                $canisterLog->released_at = Carbon::now();
                $canisterLog->releasable_id = $order->dealer_id;
                $canisterLog->releasable_type = Dealer::class;
                $canisterLog->save();

            }






            $order->transporter_depot_ok = $request->boolean('transporterToDepotOk');
            $order->transporter_depot_ok_at = Carbon::now();
            $order->save();
            return response()->json([
                'data' => OrderResource::make($order),
                'headers' => [
                    'message' => 'Order from depot transporter'
                ]
            ]);
        }

        if ($request->get('dealerToTransporterOk') !== null) {
            $order->dealer_transporter_ok = $request->boolean('dealerToTransporterOk');
            $order->dealer_transporter_ok_at = Carbon::now();
            $order->save();
            return response()->json([
                'data' => OrderResource::make($order),
                'headers' => [
                    'message' => 'Order from dealer confirmed'
                ]
            ]);
        }

        if ($request->get('transporterToDealerOk') !== null) {

            $canisterLogs = $order->canisterLogs->where('fromable_type', Depot::class)
                ->where('toable_type', Transporter::class);

            foreach ($canisterLogs as $canisterLog) {
                CanisterLog::create([
                    'fromable_id' => $order->transporter_id,
                    'fromable_type' => Transporter::class,
                    'toable_id' => $order->dealer_id,
                    'toable_type' => Dealer::class,
                    'canister_id' => $canisterLog->canister_id,
                    'filled' => $canisterLog->filled,
                    'user_id' => auth()->id(),
                    'canister_log_batch_id' =>  $canisterLog->canister_log_batch_id,
                    'defective' => $canisterLog->defective,
                ]);

                $canisterLog->released_at = Carbon::now();
                $canisterLog->releasable_id = $order->dealer_id;
                $canisterLog->releasable_type = Dealer::class;
                $canisterLog->save();

            }

            $order->transporter_dealer_ok = $request->boolean('transporterToDealerOk');
            $order->transporter_dealer_ok_at = Carbon::now();
            $order->save();
            return response()->json([
                'data' => OrderResource::make($order),
                'headers' => [
                    'message' => 'Order from transporter confirmed'
                ]
            ]);
        }

        return [];
    }
}
