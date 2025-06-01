<?php

namespace App\Modules\Activity\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Modules\Activity\Services\ActivityService;
use App\Modules\Activity\Interfaces\ActivityControllerInterface;
use Inertia\Inertia;

class ActivityController implements ActivityControllerInterface
{

    protected $ActivityService;

    public function __construct(ActivityService $ActivityService) {
        $this->ActivityService = $ActivityService;
    }

    public function getAllActivities()
    {

        if (Gate::denies('view_activities')) {
            return Inertia::render('Unauthorized');

        }

        $activities = $this->ActivityService->getActivities();

        return Inertia::render('Activity/Pages/AllActivities', [
            'activities' => $activities
        ]);
    }


}
