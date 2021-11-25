<?php

namespace App\Listeners;

use App\Events\TransporterCreatedEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignRoleTransporter
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
     * @param  TransporterCreatedEvent  $event
     * @return void
     */
    public function handle(TransporterCreatedEvent $event)
    {
        User::find($event->transporter->user_id)->assignRole('Transporter');
    }
}
