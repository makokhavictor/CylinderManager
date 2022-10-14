<?php

namespace App\Providers;

use App\Events\CanisterLogCreatedEvent;
use App\Events\CanistersDispatchedFromDealerEvent;
use App\Events\CanistersDispatchedFromDepotEvent;
use App\Events\CanistersFromDealerAcceptedByDepotEvent;
use App\Events\CanistersFromDealerAcceptedEvent;
use App\Events\CanistersFromDepotAcceptedByDealerEvent;
use App\Events\DealerCreatedEvent;
use App\Events\DepotCreatedEvent;
use App\Events\OrderAcceptedEvent;
use App\Events\OrderAssignedEvent;
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
use App\Listeners\SendCanisterDispatchFromDepotNotifications;
use App\Listeners\SendCreatedOrderNotifications;
use App\Listeners\SendOrderAcceptedNotification;
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
            SendCreatedOrderNotifications::class,
        ],
        OrderUpdatedEvent::class => [],
        OrderAcceptedEvent::class => [
            SendOrderAcceptedNotification::class
        ],
        OrderAssignedEvent::class => [
//            SendOrderAcceptedNotification::class
            'App\\Listeners\\SendOrderAssignedNotification'
        ],
        CanistersDispatchedFromDealerEvent::class => [],
        CanistersDispatchedFromDepotEvent::class => [
            SendCanisterDispatchFromDepotNotifications::class
        ],
        CanistersFromDealerAcceptedByDepotEvent::class => [],
        CanistersFromDepotAcceptedByDealerEvent::class => [],
        CanistersFromDealerAcceptedEvent::class => [],
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
