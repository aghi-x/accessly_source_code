<?php


namespace App\Modules\AppSetting\Interfaces;

interface AppSettingServiceInterface
{
    public function getSetting();
    public function updateSetting($validated, $request);
}