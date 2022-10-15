<?php

namespace App\Listeners;

use App\Events\OrderAcceptedEvent;
use App\Events\OrderDeclinedEvent;
use App\Models\User;
use App\Notifications\DealerOrderAcceptedNotification;
use App\Notifications\DealerOrderDeclinedNotification;
use App\Notifications\DepotOrderAcceptedNotification;
use App\Notifications\DepotOrderDeclinedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderDeclinedNotification
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
     * @param  \App\Events\OrderDeclinedEvent  $event
     * @return void
     */
    public function handle(OrderDeclinedEvent $event)
    {
        $dealers = User::whereHas('dealers', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->dealer_id);
        })->get();

        $depots = User::whereHas('depots', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->depot_id);
        })->get();

        Notification::send($dealers, new DealerOrderDeclinedNotification($event->order));
        Notification::send($depots, new DepotOrderDeclinedNotification($event->order));
    }
}
