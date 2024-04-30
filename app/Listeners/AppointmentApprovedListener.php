<?php

namespace App\Listeners;

use App\User;
use App\Events\AppointmentApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AppointmentNotification;

class AppointmentApprovedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AppointmentApproved  $event
     * @return void
     */
    public function handle(AppointmentApproved $event)
    {
        $appointment = $event->appointment;

        if ($appointment->status == 'hod_approved') {
            $users = User::where('yard_id', $appointment->yard_id)->whereHas('roles', function ($query) {
                $query->whereHas('permissions', function ($_query) {
                    $_query->where('title', 'grant_security_approval');
                });
            })->get(); // user must belong to same yard as appointment
            Notification::send($users, new AppointmentNotification($appointment, 2));
        }
    }
}
