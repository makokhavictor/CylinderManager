<?php

namespace App\Listeners;

use App\Events\CanistersDispatchedFromDepotEvent;
use App\Events\OrderCreatedEvent;
use App\Models\User;
use App\Notifications\DealerOrderDispatchedFromDepotNotification;
use App\Notifications\DepotOrderDispatchedFromDepotNotification;
use App\Notifications\TransporterOrderDispatchedFromDepotNotification;
use Illuminate\Support\Facades\Notification;

class SendCanisterDispatchFromDepotNotifications
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreatedEvent  $event
     * @return void
     */
    public function handle(CanistersDispatchedFromDepotEvent $event)
    {
        $dealers = User::whereHas('dealers', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->dealer_id);
        })->get();

        $depots = User::whereHas('depots', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->depot_id);
        })->get();

        $transporters = User::whereHas('transporters', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->assigned_to);
        })->get();

        Notification::send($dealers, new DealerOrderDispatchedFromDepotNotification($event->order));
        Notification::send($depots, new DepotOrderDispatchedFromDepotNotification($event->order));
        Notification::send($transporters, new TransporterOrderDispatchedFromDepotNotification($event->order));
    }
}
