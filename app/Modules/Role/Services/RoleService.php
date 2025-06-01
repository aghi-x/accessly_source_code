<?php


namespace App\Modules\Role\Services;

use App\Modules\Role\Interfaces\RoleServiceInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService implements RoleServiceInterface
{

    public function createNewRole($validated)
    {
        $assignedPermissions = []; 
        // Create the new role
        $role = Role::create(['name' => $validated['name']]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
            $assignedPermissions = Permission::whereIn('id', $validated['permissions'])->pluck('name')->toArray();
        }

            // ✅ Activity log
        activity()
        ->causedBy(auth()->user())
        ->performedOn($role)
        ->withProperties([
            'role_name' => $role->name,
            'assigned_permissions' => $assignedPermissions,
        ])
        ->log("Created role: ");

        return $role;
    }





    public function getAllRoles()
    {
        return Role::paginate(10);
    }


    public function getRole($id)
    {
        return Role::with(['permissions', 'users'])->findOrFail($id);
    }



    public function updateRole($validated, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            return false;
        }

        $originalName = null; // ✅ initialized
        $syncedPermissions = []; // ✅ initialized
//        $role = Role::findOrFail($id);
        $originalName = $role->name; // Save original name for logging
        $role->name = $validated['name'];
        $role->save();

                // Sync new permissions if provided
        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
            $syncedPermissions = Permission::whereIn('id', $validated['permissions'])->pluck('name')->toArray();
        }

        // ✅ Log the update
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties([
                'old_name' => $originalName,
                'new_name' => $role->name,
                'permissions' => $syncedPermissions,
            ])
            ->log("Updated role: ");
        return $role;
    }


    public function UpdateFormDetails($id)
    {
        $role = Role::with(['permissions', 'users'])->findOrFail($id);
        $permissions = Permission::all();

        $data = [
            'role'=>$role,
            'permissions'=>$permissions,
        ];
        return $data;

    }



    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            return false;
        }
        activity()
        ->causedBy(auth()->user())
        ->performedOn($role)
        ->withProperties([
            'role_name' => $role->name,
        ])

        ->log("Deleted role: ");


        $role->delete();
        return true;
    }



    
}
