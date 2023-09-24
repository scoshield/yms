<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'title'      => 'user_management_access',
            ],
            [
                'title'      => 'permission_create',
            ],
            [
                'title'      => 'permission_edit',
            ],
            [
                'title'      => 'permission_show',
            ],
            [
                'title'      => 'permission_delete',
            ],
            [
                'title'      => 'permission_access',
            ],
            [
                'title'      => 'role_create',
            ],
            [
                'title'      => 'role_edit',
            ],
            [
                'title'      => 'role_show',
            ],
            [
                'title'      => 'role_delete',
            ],
            [
                'title'      => 'role_access',
            ],
            [
                'title'      => 'user_create',
            ],
            [
                'title'      => 'user_edit',
            ],
            [
                'title'      => 'user_show',
            ],
            [
                'title'      => 'user_delete',
            ],
            [
                'title'      => 'user_access',
            ],
            [
                'title'      => 'service_create',
            ],
            [
                'title'      => 'service_edit',
            ],
            [
                'title'      => 'service_show',
            ],
            [
                'title'      => 'service_delete',
            ],
            [
                'title'      => 'service_access',
            ],
            [
                'title'      => 'employee_create',
            ],
            [
                'title'      => 'employee_edit',
            ],
            [
                'title'      => 'employee_show',
            ],
            [
                'title'      => 'employee_delete',
            ],
            [
                'title'      => 'employee_access',
            ],
            [
                'title'      => 'client_create',
            ],
            [
                'title'      => 'client_edit',
            ],
            [
                'title'      => 'client_show',
            ],
            [
                'title'      => 'client_delete',
            ],
            [
                'title'      => 'client_access',
            ],
            [
                'title'      => 'appointment_create',
            ],
            [
                'title'      => 'appointment_edit',
            ],
            [
                'title'      => 'appointment_show',
            ],
            [
                'title'      => 'appointment_delete',
            ],
            [
                'title'      => 'appointment_access',
            ],


            [
                'title'      => 'master_data_access',
            ],
            [
                'title'      => 'yard_create',
            ],
            [
                'title'      => 'yard_delete',
            ],
            [
                'title'      => 'inventory_item_delete',
            ],
            [
                'title'      => 'inventory_item_create',
            ],
            [
                'title'      => 'hauler_delete',
            ],
            [
                'title'      => 'hauler_create',
            ],
            [
                'title'      => 'hauler_edit',
            ],
            [
                'title'      => 'department_edit',
            ],
            [
                'title'      => 'department_create',
            ],
            [
                'title'      => 'department_delete',
            ],
            [
                'title'      => 'inventory_item_edit',
            ],
            [
                'title'      => 'appointment_admit',
            ],
        ];

        Permission::insert($permissions);
    }
}
