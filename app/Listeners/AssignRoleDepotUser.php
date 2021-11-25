<?php

namespace App\Listeners;

use App\Events\DepotUserCreatedEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignRoleDepotUser
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
     * @param  DepotUserCreatedEvent  $event
     * @return void
     */
    public function handle(DepotUserCreatedEvent $event)
    {
        User::find($event->depotUser->user_id)->assignRole('Depot User');
    }
}
