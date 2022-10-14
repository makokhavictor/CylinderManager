<?php

namespace App\Listeners;

use App\Events\CanistersFromDepotConfirmedByTransporterEvent;
use App\Models\User;
use App\Notifications\DepotCanisterDispatchedFromDepotConfirmedByTransporterNotification;
use App\Notifications\DealerCanisterDispatchedFromDepotConfirmedByTransporterNotification;
use App\Notifications\TransporterCanisterDispatchedFromDepotConfirmedByTransporterNotification;
use Illuminate\Support\Facades\Notification;

class SendCanistersFromDepotConfirmedByTransporterNotifications
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
     * @param \App\Events\CanistersFromDepotConfirmedByTransporterEvent $event
     * @return void
     */
    public function handle(CanistersFromDepotConfirmedByTransporterEvent $event)
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

        Notification::send($dealers, new DepotCanisterDispatchedFromDepotConfirmedByTransporterNotification($event->order));
        Notification::send($depots, new DealerCanisterDispatchedFromDepotConfirmedByTransporterNotification($event->order));
        Notification::send($depots, new TransporterCanisterDispatchedFromDepotConfirmedByTransporterNotification($event->order));
    }
}
