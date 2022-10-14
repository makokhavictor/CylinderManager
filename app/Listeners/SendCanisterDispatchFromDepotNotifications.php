<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Models\User;
use App\Notifications\DealerOrderDispatchedFromDepotNotification;
use App\Notifications\DepotOrderCreatedNotification;
use App\Notifications\DepotOrderDispatchedFromDepotNotification;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
    public function handle(OrderCreatedEvent $event)
    {
        $dealers = User::whereHas('dealers', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->dealer_id);
        })->get();

        $depots = User::whereHas('depots', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->depot_id);
        })->get();

        Notification::send($dealers, new DealerOrderDispatchedFromDepotNotification($event->order));
        Notification::send($depots, new DepotOrderDispatchedFromDepotNotification($event->order));
    }
}
