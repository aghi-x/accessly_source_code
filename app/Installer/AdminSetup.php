<?php

namespace App\Installer;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;




class AdminSetup
{
    public function showAdminSetup()
    {
        return inertia('Installer/AdminSetup');
    }




public function setAdminCredentiels(Request $request)
{
    try {
        // Validate input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'nullable|string|max:20',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation_failed'
            ], 200);
        }

        // Attempt to create user and assign role
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'profile_picture' => 'uploads/profile_pictures/avatar.jpg',
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole($adminRole);

        return response()->json([
            'success' => true,
            'message' => 'Admin user created successfully',
            'user_id' => $user->id,
        ]);

    } catch (\Exception $e) {
        // Likely due to DB connection or missing tables
        return response()->json([
            'success' => false,
            'status' => 'db_error',
            'message' => 'Could not create admin. Make sure the database is configured correctly.',
            'error' => $e->getMessage(), // You can hide this in production
        ], 200);
    }
}




}