<?php

namespace App\Modules\User\Services;

use App\Modules\User\Interfaces\UserServiceInterface;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserService implements UserServiceInterface
{
        public function getPaginateUser()
        {
            $users = User::paginate(10);
            return $users;
        }


        public function createNewUser($request, $validated)
        {





                $imagePath = null;

                if ($request->hasFile('profile_picture')) {
                    $file = $request->file('profile_picture');
                    $fileName = time() . '_' . $file->getClientOriginalName();

                    // Move file to public/uploads/profile_pictures
                    $file->move(public_path('uploads/profile_pictures'), $fileName);

                    // Save full URL in database
                    $imagePath = url('uploads/profile_pictures/' . $fileName);
                } else {
                    // Default fallback image path
                    $imagePath = url('uploads/profile_pictures/avatar.jpg');
                }




                $user = User::create([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'phone_number' => $validated['phone_number'] ?? null,
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'profile_picture' => $imagePath,
                ]);


            

                if (!empty($validated['roles'])) {
                    $roleIds = $request->input('roles'); // these are IDs
                    $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
                    $user->syncRoles($roleNames);

                        }


            // Log the activity
            activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['email' => $user->email])
            ->log("Created user: ");


            return $user;




        }





        public function getUser($id)
        {

            $user = User::with(['roles'])->findOrFail($id)->append('is_online');
            $permissions = $user->getAllPermissions();

            return ['user'=>$user, 'permissions'=>$permissions];


        }

        public function updateUser($request, $user,   $validated)
        {



            $isOwner = auth()->id() === $user->id;
            $assignedRoles = [];




            // if ($request->hasFile('profile_picture')) {
    
            //     // Store uploaded image (if exists)
            //     $imagePath = null;
            //     if ($request->hasFile('profile_picture')) {
            //         $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            //         $validated['profile_picture'] = $imagePath;
            //     }
            // }
    
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Move to public/uploads/profile_pictures
                $file->move(public_path('uploads/profile_pictures'), $fileName);

                // Save full URL to DB
                $validated['profile_picture'] = url('uploads/profile_pictures/' . $fileName);
            }




            // Update user data
            $user->update($validated);
    
    
    
            // if (
            //     $user->hasRole('admin') &&
            //     (
            //         !$request->has('roles') ||
            //         !in_array('admin', $request->roles)
            //     )
            // ) {
            //     return 'You cannot change admin settings.';
            // }
    
    
    
            if (!empty($validated['roles'])) {
                $roleIds = $request->input('roles'); // these are IDs
                $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
                $user->syncRoles($roleNames);
            
            
            }
    
    
                // ✅ Log the update
        activity()
        ->causedBy(auth()->user())
        ->performedOn($user)
        ->withProperties([
            'changed_fields' => array_keys($validated),
            'assigned_roles' => $assignedRoles,
            'email' => $user->email,
        ])
        ->log("Updated user: ");
    
    
    
    
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user->load('roles'), // return with assigned permissions
                'isOwner' => $isOwner,
            ],201);

        }






        public function deleteUser($user)
        {



            // Log activity before deletion
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties([
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name'),
                ])
                ->log("Deleted user: ");


                // Delete the user
                $user->delete();

            return true;

        }




    public function UpdateFormDetails($id)
    {


        $user = User::with(['roles'])->findOrFail($id);
        $permissions = $user->getAllPermissions();
        $roles = Role::all();


        $data = [
            'user'=>$user,
            'permissions'=>$permissions,
            'roles'=>$roles,
        ];

        return $data;

    }

    public function getUserInfoByID($id)

    {
        return User::findOrFail($id); 

    }



}
