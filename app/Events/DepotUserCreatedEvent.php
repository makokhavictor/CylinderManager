<?php

namespace App\Events;

use App\Models\DepotUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepotUserCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var DepotUser
     */
    public $depotUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DepotUser $depotUser)
    {
        $this->depotUser = $depotUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
}
