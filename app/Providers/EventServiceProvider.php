<?php

namespace App\Providers;

use App\Events\CanisterLogCreatedEvent;
use App\Events\DealerCreatedEvent;
use App\Events\DepotCreatedEvent;
use App\Events\OrderAcceptedEvent;
use App\Events\OrderCreatedEvent;
use App\Events\OrderUpdatedEvent;
use App\Events\PasswordResetEvent;
use App\Events\TransporterCreatedEvent;
use App\Events\UserActivityEvent;
use App\Listeners\APILogin;
use App\Listeners\AssignDealerDefaultRoles;
use App\Listeners\AssignDepotDefaultRoles;
use App\Listeners\AssignTransporterDefaultRoles;
use App\Listeners\MarkCanisterAsReleasedFromPreviousLocation;
use App\Listeners\DealerOrderCreatedNotification;
use App\Listeners\DepotOrderCreatedNotification;
use App\Listeners\SendPasswordResetTokenSms;
use App\Listeners\UpdateLastActivityTime;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;

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

        DealerCreatedEvent::class => [
            AssignDealerDefaultRoles::class
        ],

        TransporterCreatedEvent::class => [
            AssignTransporterDefaultRoles::class
        ],

        CanisterLogCreatedEvent::class => [
            MarkCanisterAsReleasedFromPreviousLocation::class
        ],
        AccessTokenCreated::class => [
            APILogin::class,
        ],
        UserActivityEvent::class => [
            UpdateLastActivityTime::class
        ],
        OrderCreatedEvent::class => [
            DealerOrderCreatedNotification::class,
            DepotOrderCreatedNotification::class
        ],
        OrderUpdatedEvent::class => [],
        OrderAcceptedEvent::class => []
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
