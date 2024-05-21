<?php

return [
    'status' => [
        'pending' => 'Pending',
        'hod_approved' => 'Approved by H.O.D',
        'security_approved' => 'Approved by Security',
        'waiting' => 'Waiting',
        'loading' => 'Loading',
        'finished_loading' => 'Finished',
        'finished_offloading' => 'Finished',
        'finished_offloading_and_loading' => 'Finished',
        'finished' => 'Finished',
        'admitted' => 'Admitted',
        'finished_cross_stuff' => 'Finished Cross Docking',
    ],

    'loading_bay_status' => [
        'started_loading' => 'Started',
        'started_offloading' => 'Started',
        'started_offloading_and_loading' => 'Started',
        'started_cross_stuff' => 'Started',

        'finished_loading' => 'Finished',
        'finished_offloading' => 'Finished',
        'finished_offloading_and_loading' => 'Finished',
        'finished_cross_stuff' => 'Finished',
    ],

    'purpose' => [ //type
        'loading' => 'Loading',
        'offloading' => 'Offloading',
        'offloading_and_loading' => 'Offloading and Loading',
        'cross_stuff' => 'Cross Docking',
    ],

    'type' => [
        'empty_gate_in' => 'Empty Gate In',
        'empty_gate_out' => 'Empty Gate Out',
        'full_gate_in' => 'Full Gate In',
        'full_gate_out' => 'Full Gate Out',
        'genset_clip_on' => 'Genset Clip On',
        'parcel_delivery' => 'Parcel Delivery',
        'parcel_pick_up' => 'Parcel Pick Up',
        'break_bulk_cargo_in' => 'Break Bulk Cargo In',
        'break_bulk_cargo_out' => 'Break Bulk Cargo Out'
    ],

    'security_checklist' => [
        'RCN',
        'DN',
        'GRN',
        'GDN',
        'SEAL NOS',
        'TRUCK',
        'TRAILER',
        'DRIVER DETAILS',
        'FILE NO',
        'CONTAINER NOS',
        'GENSET NO',
        'PARCEL TRACKING NUMBER',
        'PO NUMBER'
    ]
];
