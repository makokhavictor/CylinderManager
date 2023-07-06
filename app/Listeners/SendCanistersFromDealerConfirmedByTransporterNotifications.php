<?php

namespace App\Listeners;

use App\Events\CanistersFromDealerConfirmedByTransporterEvent;
use App\Events\CanistersFromTransporterConfirmedByDealerEvent;
use App\Models\User;
use App\Notifications\DealerCanistersFromDealerConfirmedByTransporterNotification;
use App\Notifications\DealerCanistersFromTransporterConfirmedByDealerNotification;
use App\Notifications\DepotCanistersFromDealerConfirmedByTransporterNotification;
use App\Notifications\DepotCanistersFromTransporterConfirmedByDealerNotification;
use App\Notifications\TransporterCanistersFromDealerConfirmedByTransporterNotification;
use App\Notifications\TransporterCanistersFromTransporterConfirmedByDealerNotification;
use Illuminate\Support\Facades\Notification;

class SendCanistersFromDealerConfirmedByTransporterNotifications
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
    public function handle(CanistersFromDealerConfirmedByTransporterEvent $event)
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

        Notification::send($dealers, new DealerCanistersFromDealerConfirmedByTransporterNotification($event->order));
        Notification::send($depots, new DepotCanistersFromDealerConfirmedByTransporterNotification($event->order));
        Notification::send($transporters, new TransporterCanistersFromDealerConfirmedByTransporterNotification($event->order));
    }
}
