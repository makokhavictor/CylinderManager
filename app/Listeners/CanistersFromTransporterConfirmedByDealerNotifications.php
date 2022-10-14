<?php

namespace App\Listeners;

use App\Events\CanistersFromTransporterConfirmedByDealerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CanistersFromTransporterConfirmedByDealerNotifications
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
     * @param  \App\Events\CanistersFromTransporterConfirmedByDealerEvent  $event
     * @return void
     */
    public function handle(CanistersFromTransporterConfirmedByDealerEvent $event)
    {
        //
    }
}
