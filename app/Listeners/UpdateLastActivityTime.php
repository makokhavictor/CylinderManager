<?php

namespace App\Listeners;

use App\Events\UserActivityEvent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastActivityTime
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
     * @param  \App\Events\UserActivityEvent  $event
     * @return void
     */
    public function handle(UserActivityEvent $event)
    {
        $user = $event->user;
        if($event->user !== null) {
            $user->last_activity_at = new Carbon();
            $user->save();
        }
    }
}
