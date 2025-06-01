<?php


// app/Modules/Dashboard/Interfaces/DashboardControllerInterface.php

namespace App\Modules\Dashboard\Interfaces;

use Inertia\Response;

interface DashboardControllerInterface
{
    /**
     * Get the dashboard data.
     *
     * @return \Inertia\Response
     */
    public function GetDashboadData();
}
