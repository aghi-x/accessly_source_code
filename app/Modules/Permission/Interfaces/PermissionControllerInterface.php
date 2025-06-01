<?php

// app/Modules/Permission/Interfaces/PermissionControllerInterface.php

namespace App\Modules\Permission\Interfaces;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Response;

interface PermissionControllerInterface
{
    /**
     * Create a new permission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request);

    /**
     * Show the permission creation form.
     *
     * @param \Spatie\Permission\Models\Permission $permission
     * @return \Inertia\Response
     */
    public function storeForm(Permission $permission);

    /**
     * Get all permissions.
     *
     * @return \Inertia\Response
     */
    public function index();

    /**
     * Update a permission.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The permission ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id);

    /**
     * Show the permission edit form.
     *
     * @param int $id The permission ID
     * @return \Inertia\Response
     */
    public function updateForm($id);

    /**
     * Show the details of a permission.
     *
     * @param int $id The permission ID
     * @return \Inertia\Response
     */
    public function show($id);

    /**
     * Delete a permission.
     *
     * @param int $id The permission ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id);
}
