<?php

namespace  App\Modules\Permission\Services;

use App\Modules\Permission\Interfaces\PermissionServiceInterface;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;



class PermissionService implements PermissionServiceInterface
{


            public function getAllPermissions()
            {
                return Permission::paginate(10);
            }




            public function getPermission($id)
            {

                $permission = Permission::with(['roles'])->findOrFail($id);
    
                // Get all users who have any of the roles associated with this permission
                $users = User::whereHas('roles', function ($query) use ($permission) {
                    $query->whereIn('id', $permission->roles->pluck('id'));
                })->with('roles')->get();

                $data = [
                    'permission'=>$permission,
                    'users'=>$users,
                ];

                return $data;
            }






            public function createPermission($request)
            {

                $permission = Permission::create(['name' => $request->name]);

                activity()
                ->causedBy(auth()->user())
                ->performedOn($permission)
                ->withProperties(['permission_name' => $permission->name])
                ->log("Created permission: ");

                return $permission;
            }


            public function updatePermission($request, $id)
            {

                $permission = Permission::findOrFail($id);
                $permission->name = $request->name;
                $permission->save();



                activity()
                ->causedBy(auth()->user())
                ->performedOn($permission)
                ->withProperties(['permission_name' => $permission->name])
                ->log("Updated permission: ");

                return $permission;
            }
                   
            


            public function deletePermission($id)
            {

                $permission = Permission::findOrFail($id);




                activity()
                ->causedBy(auth()->user())
                ->performedOn($permission)
                ->withProperties(['permission_name' => $permission->name])
                ->log("Deleted permission: ");



                $permission->delete();

                return true;

                
            }

            public function UpdateFormDetails($id)
            {

                $permission = Permission::with(['roles'])->findOrFail($id);
                // Get all users who have any of the roles associated with this permission
                $users = User::whereHas('roles', function ($query) use ($permission) {
                    $query->whereIn('id', $permission->roles->pluck('id'));
                })->with('roles')->get();

                $data = [
                    'permission'=>$permission,
                    'users'=>$users,
                ];

                return $data;

                

            }

        }




