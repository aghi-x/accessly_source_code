<?php

namespace App\Modules\User\Controllers;

use App\Modules\User\Interfaces\UserControllerInterface;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use App\Modules\User\Services\UserService;

class UserController implements UserControllerInterface
{

    public function __construct(UserService $UserService) {
        $this->UserService = $UserService;
    }




    // Show all users
    public function index()
    {
        if (Gate::denies('view_all_user')) {
            return Inertia::render('Unauthorized');
        }
    

        $users = $this->UserService->getPaginateUser();

        return Inertia::render('User/Pages/Users', [
            'users' => [
                'data' => $users->getCollection()->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'phone_number' => $user->phone_number,
                        'email' => $user->email,
                        'is_online' => $user->is_online,
                        'profile_picture' => $user->profile_picture,
                    ];
                }),
                'links' => $users->linkCollection(),
                'meta' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ]
            ],
        ]);
        
    }



    // Create a new user
    public function store(Request $request)
    {
        if (Gate::denies('create_user')) {
            return Inertia::render('Unauthorized');
        }
    

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:20',
            'last_name' => 'required|string|min:2|max:20',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 200);
        }
        
        $validated = $validator->validated();





        $user = $this->UserService->createNewUser($request, $validated);
   
       return response()->json([
           'message' => 'User created successfully',
           'user' => $user->load('roles') // return with assigned permissions
       ],201);

    }



    // Update a user
    public function storeForm(User $user)
    {

        if (Gate::denies('create_user')) {
            return Inertia::render('Unauthorized');
        }
    
        return Inertia::render('User/Pages/AddUser', [
            'user' => [],
            'roles' => Role::all(), // Fetch and pass all roles
        ]);
    }







    // Show a specific user
    public function show($id)
    {

     if (Gate::denies('view_user_details')) {
        return Inertia::render('Unauthorized');
    }
    
        $data = $this->UserService->getUser($id);


        return Inertia::render('User/Pages/UserDetails', [
            'user' => $data['user'],
            'permissions' => $data['permissions']]);

    }







    // Update a user
    public function update(Request $request, User $user)
    {
        
    // Check if the authenticated user is editing their own profile
    if (auth()->id() === $user->id) {

        

        if (Gate::denies('edit_own_profile')) {
            return Inertia::render('Unauthorized');
        }

        // Get the user's current roles and normalize them into strings
        $currentRoles = $user->roles->pluck('id')->map('strval')->toArray();  // Convert to string

        // Get the requested roles from the request and normalize them into strings
        $requestedRoles = array_map('strval', $request->input('roles', []));  // Convert to string

        // Check if any roles were added or removed
        $rolesAdded = array_diff($requestedRoles, $currentRoles);
        $rolesRemoved = array_diff($currentRoles, $requestedRoles);

        // If there are any roles that have been added or removed, prevent the change
        if (!empty($rolesAdded) || !empty($rolesRemoved)) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot edit your own role.',
            ], 200);
        }



    } else {

        if (Gate::denies('edit_user')) {
            return Inertia::render('Unauthorized');
        }
    }



        $validated = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:20',
            'last_name' => 'required|string|min:2|max:20',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);
    
        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validated->errors()
            ], 200);
        }
    
        $validatedData = $validated->validated();
    

        $data = $this->UserService->updateUser($request, $user, $validatedData);
        return $data;

    }





    // Update a user
    public function updateForm($id)
    {
        // 🛠️ You need to load the user first
        $user = $this->UserService->getUserInfoByID($id);

    // Check if the authenticated user is editing their own profile
    if (auth()->id() === $user->id) {

//        return "Yes";
        // User is trying to edit their own profile
        if (Gate::denies('edit_own_profile')) {
            return Inertia::render('Unauthorized');
        }
    } else {
      //  return "No";
        // User is trying to edit another user's profile
        if (Gate::denies('edit_user')) {
            return Inertia::render('Unauthorized');
        }
    }


    $data = $this->UserService->UpdateFormDetails($id);





        return Inertia::render('User/Pages/EditUser', [
            'user' => $data['user'],
            'allRoles' => $data['roles'],
            'permissions' => $data['permissions']
        ]);

    }





    // Delete a user
    public function destroy(User $user)
    {

        if (Gate::denies('delete_user')) {
            return Inertia::render('Unauthorized');
        }
    

        if ($user->hasRole('admin')) {
            return response()->json([
                'deleted' => false,
                'message' => 'You cannot delete the admin user.'
            ], 200);
        }

        $result = $this->UserService->deleteUser($user);

        // Return success message
        return response()->json(['message' => 'User deleted successfully', 'deleted'=>$result], 200);
    }
}
