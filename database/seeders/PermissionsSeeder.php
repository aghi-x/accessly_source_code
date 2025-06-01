<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view_all_user',
            'create_user',
            'profile_picture',
            'view_user_details',
            'edit_user',
            'delete_user',
            'view_online_users',
            'create_role',
            'view_all_roles',
            'view_role_details',
            'edit_role',
            'delete_role',
            'create_permission',
            'view_all_permissions',
            'edit_permission',
            'view_permission_details',
            'delete_permission',
            'view_dashboard',
            'view_settings',
            'update_settings',
            'view_activities',
            'edit_own_profile',
            'search',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
