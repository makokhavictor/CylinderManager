<?php

namespace App\Listeners;

use App\Events\CanistersFromTransporterConfirmedByDealerEvent;
use App\Models\User;
use App\Notifications\DealerCanistersFromTransporterConfirmedByDealerNotification;
use App\Notifications\DepotCanistersFromTransporterConfirmedByDealerNotification;
use App\Notifications\TransporterCanistersFromTransporterConfirmedByDealerNotification;
use Illuminate\Support\Facades\Notification;

class SendCanistersFromTransporterConfirmedByDealerNotifications
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
    public function handle(CanistersFromTransporterConfirmedByDealerEvent $event)
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

        Notification::send($dealers, new DealerCanistersFromTransporterConfirmedByDealerNotification($event->order));
        Notification::send($depots, new DepotCanistersFromTransporterConfirmedByDealerNotification($event->order));
        Notification::send($transporters, new TransporterCanistersFromTransporterConfirmedByDealerNotification($event->order));
    }
}
