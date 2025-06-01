<?php

namespace App\Modules\User\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Modules\User\Interfaces\OnlineUserServiceInterface;


class OnlineUserService implements OnlineUserServiceInterface
{
        public function get()
        {

            // Get only the IDs of users
            $userIds = User::pluck('id');

            // Filter online user IDs
            $onlineUserIds = $userIds->filter(function ($id) {
                return Cache::has('user-is-online-' . $id);
            });

            // Fetch only online users from database, and paginate
            $onlineUsers = User::whereIn('id', $onlineUserIds)
                ->select('id', 'first_name', 'last_name', 'phone_number', 'email', 'profile_picture')
                ->paginate(10); // ✅ pagination backend side

            return $onlineUsers;





        }
}
