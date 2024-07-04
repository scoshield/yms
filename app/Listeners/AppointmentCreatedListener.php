<?php

namespace App\Listeners;

use App\User;
use App\Events\AppointmentCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\AppointmentCreated;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AppointmentNotification;

class AppointmentCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AppointmentCreatedEvent  $event
     * @return void
     */
    public function handle(AppointmentCreatedEvent $event)
    {
        $appointment = $event->appointment;

        $users = User::where('yard_id', $appointment->yard_id)
            ->whereHas('roles', function ($query) {
                $query->whereHas('permissions', function ($_query) {
                    $_query->where('title', 'grant_hod_approval');
                });
            })->get();

        Notification::send($users, new AppointmentNotification($appointment, 1));
    }
}
