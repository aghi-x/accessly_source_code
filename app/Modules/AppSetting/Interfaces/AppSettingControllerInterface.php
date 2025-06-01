<?php


namespace App\Modules\AppSetting\Interfaces;

use Illuminate\Http\Request;

interface AppSettingControllerInterface
{
    public function index();
    public function update(Request $request);


}