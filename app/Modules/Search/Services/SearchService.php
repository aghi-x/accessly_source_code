<?php

namespace App\Modules\Search\Services;

use App\Modules\Search\Interfaces\SearchServiceInterface;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SearchService implements SearchServiceInterface
{
    public function performSearch(string $query): array
    {
        $users = User::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get(['id', 'first_name', 'last_name', 'email','profile_picture']);

        $roles = Role::where('name', 'like', "%{$query}%")->get(['id', 'name']);

        $permissions = Permission::where('name', 'like', "%{$query}%")->get(['id', 'name']);

        return [
            'users' => $users,
            'roles' => $roles,
            'permissions' => $permissions,
        ];
    }
}
