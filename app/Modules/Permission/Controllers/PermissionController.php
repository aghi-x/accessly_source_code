<?php

namespace App\Modules\Permission\Controllers;

use App\Modules\Permission\Interfaces\PermissionControllerInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use  App\Modules\Permission\Services\PermissionService;

class PermissionController implements PermissionControllerInterface
{

    protected $PermissionService;

    public function __construct(PermissionService $PermissionService) {
        $this->PermissionService = $PermissionService;
    }


    // Create a new permission
    public function store(Request $request)
    {
        if (Gate::denies('create_permission')) {
            return Inertia::render('Unauthorized');
        }



    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:2|max:50|unique:permissions,name',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
            'status' => 'validation_failed'
        ], 200);
    }

    $validated = $validator->validated();




    $permission = $this->PermissionService->createPermission($request);
    return response()->json(['message' => 'Permission created successfully', 'permission' => $permission]);
    }





    public function storeForm(Permission $permission)
    {
        if (Gate::denies('create_permission')) {
            return "Access Denied";
        }
        return Inertia::render('Permission/Pages/AddPermission', [
            'permission' => [],
        ]);
    }
    


    // Get all permissions
    public function index()
    {
        if (Gate::denies('view_all_permissions')) {
            //return "Access Denied";
            return Inertia::render('Unauthorized');
        }
        $permissions = $this->PermissionService->getAllPermissions();

        return Inertia::render('Permission/Pages/Permissions', [
            'permissions' => $permissions
        ]);
    }







    // Update a permission
    public function update(Request $request, $id)
    {
        if (Gate::denies('edit_permission')) {
            return Inertia::render('Unauthorized');
        }


        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:50|unique:permissions,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation_failed'
            ], 200);
        }

        $permission = $this->PermissionService->updatePermission($request, $id);
        return response()->json(['message' => 'Permission updated successfully', 'permission' => $permission]);
    }







    // Update a user
    public function updateForm($id)
    {
        if (Gate::denies('edit_permission')) {
            return Inertia::render('Unauthorized');
        }
        $data = $this->PermissionService->UpdateFormDetails($id);
        return Inertia::render('Permission/Pages/EditPermission', [
            'permission' => $data['permission'],
            'users' => $data['users'],
        ]);

    }





    public function show($id)
    {
        if (Gate::denies('view_permission_details')) {
            return Inertia::render('Unauthorized');
        }
        $data = $this->PermissionService->getPermission($id);
            return Inertia::render('Permission/Pages/PermissionDetails', [
                'permission' => $data['permission'],
                'users' => $data['users'],
            ]);
    }




    // Delete a permission
    public function destroy($id)
    {
        if (Gate::denies('delete_permission')) {
            return Inertia::render('Unauthorized');
        }
        $permission = Permission::findOrFail($id);
        $result = $this->PermissionService->deletePermission($id);
        return response()->json(['message' => 'Permission deleted successfully','deleted'=>$result]);
    }
}
