<?php

namespace App\Listeners;

use App\Events\UserActivityEvent;
use Carbon\Carbon;

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
     * @param UserActivityEvent $event
     * @return void
     */
    public function handle(UserActivityEvent $event)
    {
        $user = $event->user;
        if($user !== null) {
            $user->last_activity_at = new Carbon();
            $user->save();
        }
    }
}
