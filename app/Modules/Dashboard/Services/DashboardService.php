<?php

namespace App\Modules\Dashboard\Services;

use App\Modules\Dashboard\Interfaces\DashboardServiceInterface;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;



class DashboardService implements DashboardServiceInterface
{
    public function getUser()
    {
        return auth()->user()?->only(['id', 'first_name', 'last_name', 'email', 'profile_picture']);

    }


    public function getAllUsers()
    {
        return User::all();
    }

    public function getActivities()
    {
        return Activity::with('causer', 'subject')
        ->latest()
        ->take(5) // You can adjust the number
        ->get();
    }


    public function getRecentRegisteredUsers()
    {
        return User::latest() // order by created_at descending
        ->take(10)
        ->get(['id', 'first_name', 'last_name', 'email', 'created_at', 'profile_picture']); // limit fields

    }


    public function getOnlineUsersCount()
    {

        $users = User::all();
        return $users->filter(function ($user) {
            return Cache::has('user-is-online-' . $user->id);
        })->count();
    }

    public function getPermissionsCount()
    {
        return Permission::count();
    }



    public function getRolesCount()
    {
        return Role::count();
    }


    public function getFailedLogins()
    {
        return Activity::where('log_name', 'failed_login')
        ->latest()
        ->take(5)
        ->get();
    }



    public function getLastUpdatedUsers()
    {
        return User::orderBy('updated_at', 'desc')
        ->take(10)
        ->get(['id', 'first_name', 'last_name', 'email', 'updated_at', 'profile_picture']);

    }


    public function getMostActiveUsers()
    {
        $mostActiveUserId = Activity::select('causer_id')
        ->whereNotNull('causer_id') // skip anonymous actions
        ->groupBy('causer_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->value('causer_id');

        $mostActiveUser = $mostActiveUserId
        ? User::select('id', 'first_name', 'last_name', 'email', 'profile_picture')
            ->find($mostActiveUserId)
        : null;

        return $mostActiveUser;
    }



    public function getRecentLoggedUsers()
    {

        return Activity::with('causer')
        ->where('description', 'User logged in')
        ->latest()
        ->take(10)
        ->get();
        
    }


    public function getAdmins()
    {
        return  User::role('admin')
        ->orderBy('created_at', 'desc') // Optional: newest first
        ->get(['id', 'first_name', 'last_name', 'email', 'created_at', 'profile_picture']);

    }


    public function getSystemInfo()
    {
        



        $laravelVersion = app()->version();
        $phpVersion = phpversion();
        $uptime = trim(shell_exec('uptime -p')) ?? 'Unavailable'; // fallback in case shell_exec is disabled



        try {
            DB::connection()->getPdo();
            $databaseStatus = 'connected';
        } catch (\Exception $e) {
            $databaseStatus = 'not connected';
        }


        $logPath = storage_path('logs/laravel.log');
        $logSizeMB = file_exists($logPath) ? round(filesize($logPath) / 1024 / 1024, 2) : 0;
        


        $diskTotal = disk_total_space('/');
        $diskFree = disk_free_space('/');
        $diskUsed = $diskTotal - $diskFree;
        
        $diskUsagePercent = round(($diskUsed / $diskTotal) * 100, 2);


        $sysInfo = [
            'laravelVersion'=>$laravelVersion,
            'phpVersion'=>$phpVersion,
            'uptime'=>$uptime,
            'databaseStatus'=>$databaseStatus,
            'diskUsagePercent'=>$diskUsagePercent,
            'logSizeMB'=>$logSizeMB,
            'diskTotal'=>$diskTotal,
            'diskFree'=>$diskFree,
            'diskUsed'=>$diskUsed,
            'logPath'=>$logPath,

        ];

        return $sysInfo;

    }





}
