<?php

namespace App\Modules\Dashboard\Controllers;

use App\Modules\Dashboard\Services\DashboardService;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use App\Modules\Dashboard\Interfaces\DashboardControllerInterface;


class DashboardController implements DashboardControllerInterface
{

    protected $DashboardService;

    public function __construct(DashboardService $DashboardService) {

        $this->DashboardService = $DashboardService;

    }
    public function GetDashboadData() {

        if (Gate::denies('view_dashboard')) {
            return Inertia::render('Unauthorized');
        }




        $user = $this->DashboardService->getUser();
        $users = $this->DashboardService->getAllUsers();
        $onlineUsersCount =$this->DashboardService->getOnlineUsersCount();
        $activities = $this->DashboardService->getActivities();
        $recentRegisteredUsers = $this->DashboardService->getRecentRegisteredUsers();
        $permissionsCount = $this->DashboardService->getPermissionsCount();
        $rolesCount = $this->DashboardService->getRolesCount();
        $failedLogins = $this->DashboardService->getFailedLogins();
        $lastUpdatedUsers = $this->DashboardService->getLastUpdatedUsers();
        $mostActiveUser = $this->DashboardService->getMostActiveUsers();
        $recentLoggedInUsers = $this->DashboardService->getRecentLoggedUsers();
        $admins = $this->DashboardService->getAdmins();
        $SystemInfo = $this->DashboardService->getSystemInfo();







        return Inertia::render('Dashboard/Pages/Dashboard', [
            'online_users_count' => $onlineUsersCount,
            'total_users' => $users->count(),
            'activities'=>$activities,
            'recentRegistration' => $recentRegisteredUsers,
            'permissions_count' => $permissionsCount, 
            'roles_count' => $rolesCount,
            'laravel_version' => $SystemInfo['laravelVersion'],
            'php_version' => $SystemInfo['phpVersion'],
            'system_uptime' => $SystemInfo['uptime'],
            'database_status' => $SystemInfo['databaseStatus'],
            'log_size_mb' => $SystemInfo['logSizeMB'],
            'disk_usage_percent' => $SystemInfo['diskUsagePercent'],
            'failed_logins'=> $failedLogins,
            'last_updated_users' => $lastUpdatedUsers,
            'most_active_user' => $mostActiveUser,
            'recent_logins' => $recentLoggedInUsers,
            'admins' => $admins,
            'user' => $user,
        ]);

    }

}