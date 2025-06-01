<?php

namespace App\Installer;

use App\Models\User;
use Spatie\Permission\Models\Role;

class CheckAdmin
{

    public function isAdminExist()
{
    try {
        // Check if the 'admin' role exists first
        $adminRoleExists = Role::where('name', 'admin')
            ->where('guard_name', 'web')
            ->exists();

        $adminUserExists = false;

        if ($adminRoleExists) {
            $adminUserExists = User::role('admin')->exists();
        }

        return response()->json([
            'success' => true,
            'roleExists' => $adminRoleExists,
            'adminUserExists' => $adminUserExists,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Database not configured or unreachable: ' . $e->getMessage(),
        ], 200);
    }
}




}
