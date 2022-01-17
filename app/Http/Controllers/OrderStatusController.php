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
        $order->assigned_at = Carbon::now();
        $order->save();

        return response()->json([
            'data' => OrderResource::make($order),
            'headers' => [
                'message' => 'Order Successfully assigned'
            ]
        ]);
    }
}
