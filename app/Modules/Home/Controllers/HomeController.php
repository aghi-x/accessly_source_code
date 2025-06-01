<?php

namespace App\Modules\Home\Controllers;
use Inertia\Inertia;


class HomeController
{
    public function GetLandingPage()
    {
        return Inertia::render('Home/Pages/LandingPage');
    }
}
