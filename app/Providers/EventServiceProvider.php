<?php

namespace App\Providers;

use App\Events\CanisterLogCreatedEvent;
use App\Events\CanistersDispatchedFromDealerEvent;
use App\Events\CanistersDispatchedFromDepotEvent;
use App\Events\CanistersFromDealerConfirmedByTransporterEvent;
use App\Events\CanistersFromDepotConfirmedByTransporterEvent;
use App\Events\CanistersFromTransporterConfirmedByDealerEvent;
use App\Events\CanistersFromTransporterConfirmedByDepotEvent;
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
use App\Listeners\SendCanisterDispatchFromDealerNotifications;
use App\Listeners\SendCanisterDispatchFromDepotNotifications;
use App\Listeners\SendCanistersFromDealerConfirmedByTransporterNotifications;
use App\Listeners\SendCanistersFromTransporterConfirmedByDealerNotifications;
use App\Listeners\SendCanistersFromTransporterConfirmedByDepotNotifications;
use App\Listeners\SendCreatedOrderNotifications;
use App\Listeners\SendOrderAcceptedNotification;
use App\Listeners\SendOrderAssignedNotification;
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
            SendOrderAssignedNotification::class
        ],
        CanistersDispatchedFromDealerEvent::class => [
            SendCanisterDispatchFromDealerNotifications::class
        ],
        CanistersDispatchedFromDepotEvent::class => [
            SendCanisterDispatchFromDepotNotifications::class
        ],
        CanistersFromTransporterConfirmedByDepotEvent::class => [
            SendCanistersFromTransporterConfirmedByDepotNotifications::class
        ],
        CanistersFromTransporterConfirmedByDealerEvent::class => [
            SendCanistersFromTransporterConfirmedByDealerNotifications::class
        ],
        CanistersFromDealerConfirmedByTransporterEvent::class => [
            SendCanistersFromDealerConfirmedByTransporterNotifications::class
        ],
        CanistersFromDepotConfirmedByTransporterEvent::class => [
            'App\\Listeners\\SendCanistersFromDepotConfirmedByTransporterNotifications'
        ],
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
