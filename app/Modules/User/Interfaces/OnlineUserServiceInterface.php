<?php


// app/Modules/User/Interfaces/OnlineUserServiceInterface.php

namespace App\Modules\User\Interfaces;

use Illuminate\Http\JsonResponse;

interface OnlineUserServiceInterface
{
    /**
     * Get all online users.
     *
     * @return \Inertia\Response
     */
    public function get();
}
