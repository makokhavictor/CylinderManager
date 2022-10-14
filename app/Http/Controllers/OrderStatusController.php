<?php

namespace App\Http\Controllers;

use App\Events\OrderAcceptedEvent;
use App\Events\OrderUpdatedEvent;
use App\Http\Requests\StoreOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Canister;
use App\Models\CanisterLog;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Order;
use App\Models\Transporter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;

class OrderStatusController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(StoreOrderStatusRequest $request, Order $order)
    {
        $responseMessage = '';
        if ($request->boolean('acceptOrder')) {

            if(!User::find(auth()->id())->can('accept refill order') && !User::find(auth()->id())->can('admin: accept refill order')){
                throw new AuthorizationException( 'You are not authorised to accept order');
            }

            $order->accepted_at = Carbon::now();
            $order->save();

            $responseMessage = 'Order Successfully acknowledged';
        }

        if ($request->get('transporterId')) {

            if(!User::find(auth()->id())->can('assign order') && !User::find(auth()->id())->can('admin: assign order')){
                throw new AuthorizationException( 'You are not authorised to assign order');
            }

            $order->assigned_at = Carbon::now();
            $order->assigned_to = $request->get('transporterId');
            $order->save();

            $responseMessage = 'Order Successfully assigned';

            OrderAcceptedEvent::dispatch($order);

        }

        if ($request->get('depotToTransporterOk') !== null) {

            if(!User::find(auth()->id())->can('confirm dispatch from depot') && !User::find(auth()->id())->can('admin: confirm dispatch from depot')){
                throw new AuthorizationException( 'You are not authorised to confirm dispatch from depot');
            }

            $order->depot_transporter_ok = $request->boolean('depotToTransporterOk');
            $order->depot_transporter_ok_at = Carbon::now();
            $order->save();
            $responseMessage = 'Order from depot confirmed';
        }

        if ($request->get('transporterToDepotOk') !== null) {

            if(!User::find(auth()->id())->can('confirm delivery by depot from transporter') && !User::find(auth()->id())->can('admin: confirm delivery by depot from transporter')){
                throw new AuthorizationException( 'You are not authorised to confirm delivery to depot');
            }

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
            $responseMessage = 'Order from depot transporter';
        }

        if ($request->get('dealerToTransporterOk') !== null) {

//            if(!User::find(auth()->id())->can('confirm delivery by depot from transporter') && !User::find(auth()->id())->can('admin: confirm delivery by depot from transporter')){
//                throw new AuthorizationException( 'You are not authorised to confirm delivery to depot');
//            }

            $order->dealer_transporter_ok = $request->boolean('dealerToTransporterOk');
            $order->dealer_transporter_ok_at = Carbon::now();
            $order->save();
            $responseMessage = 'Order from dealer confirmed';
        }

        if ($request->get('transporterToDealerOk') !== null) {

            if(!User::find(auth()->id())->can('confirm delivery by dealer from transporter') && !User::find(auth()->id())->can('admin: confirm delivery by dealer from transporter')){
                throw new AuthorizationException( 'You are not authorised to confirm delivery to depot');
            }

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

            $responseMessage = 'Order from transporter confirmed';
        }
        OrderUpdatedEvent::dispatch($order);
        return response()->json([
            'data' => OrderResource::make($order),
            'headers' => [
                'message' => $responseMessage
            ]
        ]);
    }
}
