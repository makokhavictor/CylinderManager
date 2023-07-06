<?php

namespace App\Listeners;

use App\Events\DepotCreatedEvent;
use App\Models\Depot;
use App\Models\StationRole;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignDepotDefaultRoles
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
    public function handle(DepotCreatedEvent $event)
    {
        $event->depot->assignDefaultUserRoles();
    }
}
