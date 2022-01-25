<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
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
