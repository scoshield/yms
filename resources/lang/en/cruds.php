<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'service'        => [
        'title'          => 'Services',
        'title_singular' => 'Service',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'price'             => 'Price',
            'price_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'employee'       => [
        'title'          => 'Employees',
        'title_singular' => 'Employee',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'email'             => 'Email',
            'email_helper'      => '',
            'phone'             => 'Phone',
            'phone_helper'      => '',
            'photo'             => 'Photo',
            'photo_helper'      => '',
            'services'          => 'Services',
            'services_helper'   => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'client'         => [
        'title'          => 'Clients',
        'title_singular' => 'Client',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'phone'             => 'Phone',
            'phone_helper'      => '',
            'email'             => 'Email',
            'email_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'department'         => [
        'title'          => 'Departments',
        'title_singular' => 'Department',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'phone'             => 'Phone',
            'phone_helper'      => '',
            'email'             => 'Email',
            'email_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'yard'         => [
        'title'          => 'Yards',
        'title_singular' => 'Yard',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'physical_location' => 'Physical Location',
            'physical_location_helper' => '',
            'phone'             => 'Phone',
            'phone_helper'      => '',
            'email'             => 'Email',
            'email_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'hauler'         => [
        'title'          => 'Haulers',
        'title_singular' => 'Hauler',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'phone'             => 'Phone',
            'phone_helper'      => '',
            'email'             => 'Email',
            'email_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'appointment'    => [
        'title'          => 'Appointments',
        'title_singular' => 'Appointment',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'client'             => 'Client',
            'client_helper'      => '',
            'employee'           => 'Employee',
            'employee_helper'    => '',
            'start_time'         => 'Start Time',
            'start_time_helper'  => '',
            'finish_time'        => 'Finish Time',
            'finish_time_helper' => '',
            'price'              => 'Price',
            'price_helper'       => '',
            'comments'           => 'Comments',
            'comments_helper'    => '',
            'services'           => 'Services',
            'services_helper'    => '',

            'purpose'           => 'Purpose',
            'purpose_helper'    => '',
            'yard'           => 'Yard',
            'yard_helper'    => '',
            'hauler'           => 'Hauler',
            'hauler_helper'    => '',
            'creator'           => 'Creator',
            'creator_helper'    => '',
            'truck_details'           => 'Truck Details',
            'track_details_helper'    => '',
            'driver_name'           => 'Driver Name',
            'driver_name_helper'    => '',
            'contact_details'           => 'Contact',
            'contact_details_helper'    => '',
            'file_number'           => 'File No.',
            'file_number_helper'    => '',
            'container_number'           => 'Container No.',
            'container_number_helper'    => '',
            'status'           => 'Status',
            'status_helper'    => '',

            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'inventory_item'    => [
        'title'          => 'Inventory Items',
        'title_singular' => 'Inventory Item',
        'fields'         => [
            'id'                            => 'ID',
            'id_helper'                     => '',
            'category'                      => 'Category',
            'category_helper'               => '',
            'yard'                          => 'Yard',
            'yard_helper'                   => '',
            'creator'                          => 'Creator',
            'creator_helper'                   => '',
            'department'                    => 'Department',
            'department_helper'             => '',
            'ref'                           => 'Ref No.',
            'ref_helper'                    => '',
            'um_number'                     => 'UM Number',
            'um_number_helper'              => '',
            'rtn_port'                      => 'RTN Port',
            'rtn_port_helper'               => '',
            'size'                          => 'Size',
            'size_helper'                   => '',
            'status'                        => 'Status',
            'status_helper'                 => '',
            'structural_status'             => 'Structural Status',
            'structural_status_helper'      => '',
            'inspected'                     => 'Inspected',
            'inspected_helper'              => '',
            'inspection_status'                     => 'Inspection Status',
            'inspection_status_helper'              => '',
            'general_condition'                     => 'General Condition',
            'general_condition_helper'              => '',
            'refurbished'                   => 'Refurbished',
            'refurbished_helper'            => '',
            'creator'                       => 'Creator',
            'creator_helper'                => '',
            'cnumbers_visible'              => 'C Numbers Visible',
            'cnumbers_visible_helper'       => '',

            'year_manufactured'             => 'Year Manufactured',
            'year_manufactured_helper'      => '',
            'type'                          => 'Type',
            'type_helper'                   => '',
            'remarks'                       => 'Remarks',
            'remarks_helper'                => '',
            'created_at'                    => 'Created at',
            'created_at_helper'             => '',
            'updated_at'                    => 'Updated at',
            'updated_at_helper'             => '',
            'deleted_at'                    => 'Deleted at',
            'deleted_at_helper'             => '',
        ],
    ],
];
