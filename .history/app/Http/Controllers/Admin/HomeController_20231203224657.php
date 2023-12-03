<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\InventoryItem;
use App\LoadingBay;
use App\Yard;

class HomeController
{
    public function index()
    {
        $events = [];

        $appointments = Appointment::with(['hauler', 'yard', 'creator'])->get();
        $inventory_items = InventoryItem::all();
        $yards = Yard::all();
        $at_bay = LoadingBay::whereIn('status', ['waiting','started_loading'])->get();
        $waiting = LoadingBay::whereIn('status', ['waiting','started_loading'])->get();
        $loading = LoadingBay::whereIn('status', ['started_loading'])->get();
        $offloading = LoadingBay::whereIn('status', ['started_offloading'])->get();

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
        return view('home', compact(
            'events',
            'appointments',
            'inventory_items',
            'yards',
            'at_bay',
            'waiting',
            'loading',
            'offlloading'
        ));
    }

}
