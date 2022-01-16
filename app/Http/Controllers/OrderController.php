<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\CanisterSize;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\jsonResponse;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $orders = new Order();
        return OrderResource::collection($orders->paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreOrderRequest $request)
    {
        $permissions = User::find(auth()->id())->permissibleRoles()
            ->wherePivot('permissible_type', Dealer::class)
            ->wherePivot('permissible_id', $request->get('toDealerId'))
            ->get()
            ->map(function ($role) {
                return $role->permissions->pluck('name');
            })->toArray();
        if (!in_array('create refill order', array_merge(...$permissions))) {
            throw new AuthorizationException('You are not authorised to make a refill order for this dealer');
        }
        $order = Order::create([
            'depot_id' => $request->get('fromDepotId'),
            'dealer_id' => $request->get('toDealerId'),
        ]);

        foreach ($request->get('orderQuantities') as $orderQuantity) {
            $order->canisterSizes()->save(CanisterSize::find($orderQuantity['canisterSizeId']), ['quantity' => $orderQuantity['quantity']]);
        }
        return response()->json([
            'data' => OrderResource::make($order),
            'headers' => [
                'message' => 'Order successfully created'
            ]
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Response
     */
    public function show(Order $order)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(DeleteOrderRequest $request, Order $order)
    {
        $order->canisterSizes()->detach();
        $order->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted order'
            ]
        ]);

    }
}
