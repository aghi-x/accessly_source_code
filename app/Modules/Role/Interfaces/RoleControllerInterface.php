<?php

// app/Modules/Role/Interfaces/RoleControllerInterface.php

namespace App\Modules\Role\Interfaces;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Inertia\Response;

interface RoleControllerInterface
{
    /**
     * Create a new role.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request);

    /**
     * Show the role creation form.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @return \Inertia\Response
     */
    public function storeForm(Role $role);

    /**
     * Get all roles.
     *
     * @return \Inertia\Response
     */
    public function index();

    /**
     * Show a specific role.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id);

    /**
     * Update an existing role.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id);

    /**
     * Show the role edit form.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function updateForm($id);

    /**
     * Delete a role.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id);
}
