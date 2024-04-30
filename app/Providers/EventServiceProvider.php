<?php

namespace App\Providers;

use App\Events\AppointmentApproved;
use App\Events\AppointmentCreatedEvent;
use App\Listeners\AppointmentApprovedListener;
use App\Listeners\AppointmentCreatedListener;
use Illuminate\Support\Facades\Event;
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
        AppointmentCreatedEvent::class => [
            AppointmentCreatedListener::class
        ],
        AppointmentApproved::class => [
            AppointmentApprovedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
