<?php

namespace App\Modules\Dashboard\Interfaces;

interface DashboardServiceInterface
{
    
    public function getUser();
    public function getAllUsers();
    public function getActivities();
    public function getRecentRegisteredUsers();
    public function getOnlineUsersCount();
    public function getPermissionsCount();
    public function getRolesCount();
    public function getFailedLogins();
    public function getLastUpdatedUsers();
    public function getMostActiveUsers();
    public function getRecentLoggedUsers();
    public function getAdmins();
    public function getSystemInfo();

}
