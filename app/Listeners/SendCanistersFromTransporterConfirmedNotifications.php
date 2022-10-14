<?php

namespace App\Listeners;

use App\Events\CanistersFromTransporterConfirmedByDepotEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCanistersFromTransporterConfirmedNotifications
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
     * @param  \App\Events\CanistersFromTransporterConfirmedByDepotEvent  $event
     * @return void
     */
    public function handle(CanistersFromTransporterConfirmedByDepotEvent $event)
    {
        //
    }
}
