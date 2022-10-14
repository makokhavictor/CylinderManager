<?php

namespace App\Listeners;

use App\Events\OrderAcceptedEvent;
use App\Models\User;
use App\Notifications\DealerOrderAcceptedNotification;
use App\Notifications\DepotOrderAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderAcceptedNotification
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
     * @param  \App\Events\OrderAcceptedEvent  $event
     * @return void
     */
    public function handle(OrderAcceptedEvent $event)
    {
        $dealers = User::whereHas('dealers', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->dealer_id);
        })->get();

        $depots = User::whereHas('depots', function ($query) use ($event) {
            $query->where('permissible_id', $event->order->depot_id);
        })->get();

        Notification::send($dealers, new DealerOrderAcceptedNotification($event->order));
        Notification::send($depots, new DepotOrderAcceptedNotification($event->order));
    }
}
