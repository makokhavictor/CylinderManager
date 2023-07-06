<?php

namespace App\Events;

use App\Models\CanisterLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CanisterLogCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $canisterLog;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CanisterLog $canisterLog)
    {
        $this->canisterLog = $canisterLog;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
