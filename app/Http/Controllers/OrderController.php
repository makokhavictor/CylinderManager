<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $orders = new Order();

        if ($request->get('searchTerm')) {
            $orders = $orders->whereHas('depot', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->get('searchTerm') . '%');
            })->orWhereHas('dealer', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->get('searchTerm') . '%');
            });
        }

        if ($request->get('toDealerIds')) {
            $orders = $orders->whereIn('dealer_id', $request->get('toDealerIds'));
        }
        if ($request->get('fromDepotIds')) {
            $orders = $orders->whereIn('depot_id', $request->get('fromDepotIds'));
        }

        if ($request->get('toDealerId')) {
            $orders = $orders->where('dealer_id', $request->get('toDealerId'));
        }
        if ($request->get('fromDepotId')) {
            $orders = $orders->whereIn('depot_id', $request->get('fromDepotId'));
        }

        if ($request->get('assignedToTransporterIds')) {
            $orders = $orders->whereIn('assigned_to', $request->get('assignedToTransporterIds'));
        }

        $orderBys = [
            ['name' => 'orderId', 'value' => 'id']
        ];
        foreach ($orderBys as $orderBy) {
            if ($request->get('orderBy') === $orderBy['name']) {
                $orders = $orders->orderBy($orderBy['value'], $request->boolean('orderByDesc') ? 'desc' : 'asc');
                break;
            }
        }

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
        if (!User::find(\auth()->id())->can('admin: create order')) {
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
        }

        $order = Order::create([
            'depot_id' => $request->get('fromDepotId'),
            'dealer_id' => $request->get('toDealerId'),
        ]);

        foreach ($request->get('orderQuantities') as $orderQuantity) {
            $order->canisterSizes()->save(CanisterSize::find($orderQuantity['canisterSizeId']),
                ['quantity' => $orderQuantity['quantity'], 'brand_id' => $orderQuantity['canisterBrandId']]);
        }

        OrderCreatedEvent::dispatch($order);

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
     * @return OrderResource|Response
     */
    public function show(Order $order)
    {
        return OrderResource::make($order);
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
