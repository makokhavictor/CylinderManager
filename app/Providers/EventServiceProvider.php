<?php

namespace App\Providers;

use App\Events\CanisterLogCreatedEvent;
use App\Events\DepotUserCreatedEvent;
use App\Events\PasswordResetEvent;
use App\Events\TransporterCreatedEvent;
use App\Listeners\AssignRoleDepotUser;
use App\Listeners\AssignRoleTransporter;
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
        TransporterCreatedEvent::class => [
            AssignRoleTransporter::class
        ],

        DepotUserCreatedEvent::class => [
            AssignRoleDepotUser::class
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
