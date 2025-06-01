<?php

namespace App\Modules\User\Controllers;
use App\Modules\User\Interfaces\OnlineUsersControllerInterface;
use App\Modules\User\Services\OnlineUserService;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;


class OnlineUsersController implements OnlineUsersControllerInterface
{

    protected $OnlineUserService;

    public function __construct(OnlineUserService $OnlineUserService) {
        $this->OnlineUserService = $OnlineUserService;
    }


    public function getOnlineUsers()
{
    if (Gate::denies('view_online_users')) {
        return Inertia::render('Unauthorized');
    }

    $onlineUsers = $this->OnlineUserService->get();

    return Inertia::render('User/Pages/OnlineUsers', [
        'online_users' => $onlineUsers,
        'online_users_count' => $onlineUsers->total(), // total online users
    ]);
}


}
