<?php

namespace App\Listeners;

use App\Events\CanistersFromDealerConfirmedByTransporterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
     * @param  \App\Events\CanistersFromDealerConfirmedByTransporterEvent  $event
     * @return void
     */
    public function handle(CanistersFromDealerConfirmedByTransporterEvent $event)
    {
        //
    }
}
