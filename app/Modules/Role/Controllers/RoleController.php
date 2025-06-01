<?php

namespace App\Modules\Role\Controllers;

use App\Modules\Role\Interfaces\RoleControllerInterface;
use Illuminate\Support\Facades\Validator;
use App\Modules\Role\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Inertia\Inertia;

class RoleController implements RoleControllerInterface
{

    protected $RoleService;

    public function __construct(RoleService $RoleService) {
        $this->RoleService = $RoleService;
    }

    // Create a new role
    public function store(Request $request)
    {

        if (Gate::denies('create_role')) {
            return Inertia::render('Unauthorized');
        }



        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:50|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 200);
        }

        $validated = $validator->validated();



        $role = $this->RoleService->createNewRole($validated);
        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role->load('permissions') // return with assigned permissions
        ]);
}



    public function storeForm(Role $role)
    {
        if (Gate::denies('create_role')) {
            return Inertia::render('Unauthorized');
        }
        $permissions = Permission::all();
        return Inertia::render('Role/Pages/AddRole', [
            'role' => [],
            'allPermissions' => $permissions
        ]);
    }




    // Get all roles
    public function index()
    {
        if (Gate::denies('view_all_roles')) {
            return Inertia::render('Unauthorized');
        }
        $roles = $this->RoleService->getAllRoles();
        return Inertia::render('Role/Pages/Roles', [
            'roles' => $roles
        ]);

    }






    public function show($id)
    {

        if (Gate::denies('view_role_details')) {
            return Inertia::render('Unauthorized');
        }
        $role = $this->RoleService->getRole($id);
        return inertia('Role/Pages/RoleDetails', [
            'role' => $role,
        ]);
    }




    public function update(Request $request, $id)
    {

        if (Gate::denies('edit_role')) {
            return Inertia::render('Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:50|unique:roles,name,' . $id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 200);
        }
        
        $validated = $validator->validated();
        $role = $this->RoleService->updateRole($validated, $id);

        if ($role === false) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot edit the admin role.',
            ], 200);
        }


        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
            'role' => $role->load('permissions'),
        ]);

}


    public function updateForm($id)
    {
        if (Gate::denies('edit_role')) {
            return Inertia::render('Unauthorized');
        }
        $data = $this->RoleService->UpdateFormDetails($id);
        return Inertia::render('Role/Pages/EditRole', [
            'role' => $data['role'],
            'allPermissions' => $data['permissions'],
        ]);
    }




    // Delete a role
    public function destroy($id)
    {
        if (Gate::denies('delete_role')) {
            return Inertia::render('Unauthorized');
        }
        $result = $this->RoleService->deleteRole($id);




        if (!$result) {
            return response()->json([
                'deleted' => false,
                'message' => 'You cannot delete the admin role.',
            ], 200);
        }
    
        return response()->json([
            'deleted' => true,
            'message' => 'Role deleted successfully',
        ]);







    }


}
