<?php

namespace App\Listeners;

use App\Events\OrderAcceptedEvent;
use App\Events\OrderAssignedEvent;
use App\Models\User;
use App\Notifications\DealerOrderAssignedNotification;
use App\Notifications\DepotOrderAssignedNotification;
use App\Notifications\TransporterOrderAssignedNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderAssignedNotification
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
     * @param  \App\Events\OrderAssignedEvent  $event
     * @return void
     */
    public function handle(OrderAssignedEvent $event)
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

        Notification::send($dealers, new DealerOrderAssignedNotification($event->order));
        Notification::send($depots, new DepotOrderAssignedNotification($event->order));
        Notification::send($transporters, new TransporterOrderAssignedNotification($event->order));
    }
}
