<?php


// app/Modules/User/Interfaces/OnlineUsersControllerInterface.php

namespace App\Modules\User\Interfaces;

use Illuminate\Http\JsonResponse;

interface OnlineUsersControllerInterface
{
    /**
     * Get all online users.
     *
     * @return \Inertia\Response
     */
    public function getOnlineUsers();
}
