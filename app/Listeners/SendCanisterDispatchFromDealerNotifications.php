<?php

namespace App\Listeners;

use App\Events\CanistersDispatchedFromDealerEvent;
use App\Models\User;
use App\Notifications\DealerOrderDispatchedFromDealerNotification;
use App\Notifications\DepotOrderDispatchedFromDealerNotification;
use App\Notifications\TransporterOrderDispatchedFromDealerNotification;
use Illuminate\Support\Facades\Notification;

class SendCanisterDispatchFromDealerNotifications
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
     * @param \App\Events\OrderCreatedEvent $event
     * @return void
     */
    public function handle(CanistersDispatchedFromDealerEvent $event)
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

        Notification::send($dealers, new DealerOrderDispatchedFromDealerNotification($event->order));
        Notification::send($depots, new DepotOrderDispatchedFromDealerNotification($event->order));
        Notification::send($transporters, new TransporterOrderDispatchedFromDealerNotification($event->order));
    }
}
