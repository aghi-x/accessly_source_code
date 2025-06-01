<?php

namespace App\Modules\Activity\Services;

use Spatie\Activitylog\Models\Activity;
use  App\Modules\Activity\Interfaces\ActivityServiceInterface;

class ActivityService implements ActivityServiceInterface
{
    public function getActivities()
    {
        $activities = Activity::with('causer', 'subject')
        ->latest()
        ->paginate(10); // 🔥 10 activities per page

        return $activities;
    }
}
