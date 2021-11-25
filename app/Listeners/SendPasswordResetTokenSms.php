<?php

namespace App\Listeners;

use App\Events\PasswordResetEvent;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetTokenSms
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
     * @param PasswordResetEvent $event
     * @return void
     */
    public function handle(PasswordResetEvent $event)
    {

        if ($event->user->email) {
            Mail::to($event->user->email)->send(new PasswordResetMail($event->otp->token));
        }

    }
}
