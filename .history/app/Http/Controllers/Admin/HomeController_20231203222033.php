<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;

class HomeController
{
    public function index()
    {
        $events = [];

        $appointments = Appointment::with(['hauler', 'yard', 'creator'])->get();

        foreach ($appointments as $appointment) {
            if (!$appointment->appointment_date) {
                continue;
            }

            $events[] = [
                'title' => $appointment->hauler->name . ', ' . $appointment->driver_name . ' (' . $appointment->yard->name . ')',
                'start' => $appointment->appointment_date,
                'url'   => route('admin.appointments.edit', $appointment->id),
            ];
        }
        return view('home', compact('events','appointments'));
    }

}
