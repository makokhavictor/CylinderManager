<?php

namespace App\Listeners;

use App\Events\CanisterLogCreatedEvent;
use App\Models\CanisterLog;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkCanisterAsReleasedFromPreviousLocation
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
     * @param  \App\Events\CanisterLogCreatedEvent  $event
     * @return void
     */
    public function handle(CanisterLogCreatedEvent $event)
    {
        $previousLog = CanisterLog::whereNull('released_at')
            ->where('canister_id', $event->canisterLog->canister_id)
            ->where('id', '<>', $event->canisterLog->id)
            ->latest()
            ->first();
        if ($previousLog) {
            $previousLog->released_at = new Carbon();
            $previousLog->released_to_depot_id = $event->canisterLog->to_depot_id;
            $previousLog->released_to_dealer_id = $event->canisterLog->to_dealer_id;
            $previousLog->released_to_transporter_id = $event->canisterLog->to_transporter_id;
            $previousLog->save();
        }

    }
}
