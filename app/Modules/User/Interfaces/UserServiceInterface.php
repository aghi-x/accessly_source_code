<?php



// app/Modules/User/Interfaces/UserServiceInterface.php

namespace App\Modules\User\Interfaces;

use Illuminate\Http\Request;
use App\Models\User;

interface UserServiceInterface
{
    /**
     * Get paginated list of users.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginateUser();

    /**
     * Create a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $validated The validated input data
     * @return \App\Models\User
     */
    public function createNewUser(Request $request, array $validated);

    /**
     * Get a specific user with roles and permissions.
     *
     * @param int $id The user ID
     * @return array
     */
    public function getUser(int $id);

    /**
     * Update a specific user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user The user to be updated
     * @param array $validated The validated input data
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, User $user, array $validated);

    public function getUserInfoByID($id);

    public function UpdateFormDetails($id);



}
