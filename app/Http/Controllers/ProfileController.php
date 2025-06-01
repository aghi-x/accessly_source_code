<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
 

    public function show(Request $request)
    {

        $user = $request->user();

        $permissions = $user->getAllPermissions()->pluck('name');

        return Inertia::render('Profile/Show', [
            'user' => $user,
            'permissions' => $permissions,
        ]);
    }










    

    public function changePassword(Request $request)
    {

        if (Gate::denies('reset_own_password')) {
            return response()->json([
                'message' => 'Unauthorized action.'
            ], 403); // Proper HTTP status
            
        }

        
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);
    
        $user = $request->user();
    
        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect.'
            ]);
    
        }
    
        // Update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully!'
        ]);
    }

}
