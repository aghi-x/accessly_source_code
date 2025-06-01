<?php
// app/Modules/Role/Interfaces/RoleServiceInterface.php

namespace App\Modules\Role\Interfaces;

use Spatie\Permission\Models\Role;

interface RoleServiceInterface
{
    /**
     * Create a new role and assign permissions.
     *
     * @param array $validated The validated input data
     * @return \Spatie\Permission\Models\Role
     */
    public function createNewRole(array $validated);

    /**
     * Get all roles, paginated.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllRoles();

    /**
     * Get a specific role by ID.
     *
     * @param int $id The role ID
     * @return \Spatie\Permission\Models\Role
     */
    public function getRole(int $id);

    /**
     * Update an existing role by ID.
     *
     * @param array $validated The validated input data
     * @param int $id The role ID
     * @return \Spatie\Permission\Models\Role
     */
    public function updateRole(array $validated, int $id);

    /**
     * Delete a role by ID.
     *
     * @param int $id The role ID
     * @return bool
     */
    public function deleteRole(int $id);

    /**
     * Get details for the role edit form, including permissions.
     *
     * @param int $id The role ID
     * @return array
     */
    public function UpdateFormDetails(int $id);
}