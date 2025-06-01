<?php

// app/Modules/Permission/Interfaces/PermissionServiceInterface.php

namespace App\Modules\Permission\Interfaces;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

interface PermissionServiceInterface
{
    /**
     * Get all permissions, paginated.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllPermissions();

    /**
     * Get a specific permission with associated roles and users.
     *
     * @param int $id The permission ID
     * @return array
     */
    public function getPermission(int $id);

    /**
     * Create a new permission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Spatie\Permission\Models\Permission
     */
    public function createPermission(Request $request);

    /**
     * Update an existing permission.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The permission ID
     * @return \Spatie\Permission\Models\Permission
     */
    public function updatePermission(Request $request, int $id);

    /**
     * Delete a permission.
     *
     * @param int $id The permission ID
     * @return bool
     */
    public function deletePermission(int $id);

    /**
     * Get details for the permission edit form, including roles and users.
     *
     * @param int $id The permission ID
     * @return array
     */
    public function UpdateFormDetails(int $id);
}
