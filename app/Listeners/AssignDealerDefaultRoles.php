<?php

namespace App\Listeners;

use App\Events\DealerCreatedEvent;

class AssignDealerDefaultRoles
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\DepotCreatedEvent  $event
     * @return void
     */
    public function handle(DealerCreatedEvent $event)
    {
        $event->dealer->assignDefaultUserRoles();
    }
}
