<?php

// app/Modules/User/Interfaces/UserControllerInterface.php

namespace App\Modules\User\Interfaces;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

interface UserControllerInterface
{
    /**
     * Show all users.
     *
     * @return \Inertia\Response
     */
    public function index();

    /**
     * Store a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request);

    /**
     * Show the user creation form.
     *
     * @param \App\Models\User $user
     * @return \Inertia\Response
     */
    public function storeForm(User $user);

    /**
     * Show a specific user.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id);

    /**
     * Update a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user);

    /**
     * Show the user edit form.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function updateForm($id);

    /**
     * Delete a user.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user);
}
