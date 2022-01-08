<?php

namespace App\Providers;

use App\Events\CanisterLogCreatedEvent;
use App\Events\DepotCreatedEvent;
use App\Events\PasswordResetEvent;
use App\Listeners\AssignDepotDefaultRoles;
use App\Listeners\MarkCanisterAsReleasedFromPreviousLocation;
use App\Listeners\SendPasswordResetTokenSms;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PasswordResetEvent::class => [
            SendPasswordResetTokenSms::class
        ],
        DepotCreatedEvent::class => [
            AssignDepotDefaultRoles::class
        ],
        CanisterLogCreatedEvent::class => [
            MarkCanisterAsReleasedFromPreviousLocation::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
