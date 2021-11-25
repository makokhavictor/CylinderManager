<?php

namespace App\Providers;

use App\Events\BuyerCreatedEvent;
use App\Events\DepotUserCreatedEvent;
use App\Events\FarmerCreatedEvent;
use App\Events\PasswordResetEvent;
use App\Events\TransporterCreatedEvent;
use App\Listeners\AssignBuyerWallet;
use App\Listeners\AssignFarmerWallet;
use App\Listeners\AssignRoleBuyer;
use App\Listeners\AssignRoleDepotUser;
use App\Listeners\AssignRoleFarmer;
use App\Listeners\AssignRoleTransporter;
use App\Listeners\SendPasswordResetTokenSms;
use App\Models\DepotUser;
use App\Models\Transporter;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
