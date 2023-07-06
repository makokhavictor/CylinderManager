<?php

namespace App\Events;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $otp;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Otp $otp, User $user)
    {
        $this->otp = $otp;
        $this->user = $user;
    }


}
