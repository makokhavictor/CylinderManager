<?php

namespace App\Listeners;

use App\Events\TransporterCreatedEvent;

class AssignTransporterDefaultRoles
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
     * @param  \App\Events\DepotCreatedEvent  $event
     * @return void
     */
    public function handle(TransporterCreatedEvent $event)
    {
        $event->transporter->assignDefaultUserRoles();

    }
}
