<?php

namespace App\Modules\AppSetting\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use App\Modules\AppSetting\Services\AppSettingService;
use  App\Modules\AppSetting\Interfaces\AppSettingControllerInterface;


class AppSettingController implements AppSettingControllerInterface
{

    protected $AppSettingService;

    public function __construct(AppSettingService $AppSettingService) {
        $this->AppSettingService = $AppSettingService;
    }


    // GET /api/settings
    public function index()
    {

        if (Gate::denies('view_settings')) {
            return Inertia::render('Unauthorized');

        }

       $settings = $this->AppSettingService->getSetting();

        return Inertia::render('Setting/Pages/AppSetting', [
            'settings' => $settings,
            'logoUrl' => $settings && $settings->logo_picture
            ? asset('uploads/' . $settings->logo_picture)
            : null,
            
            
        ]);
    
    }

    // POST /api/settings
    public function update(Request $request)
    {

        if (Gate::denies('update_settings')) {
            return Inertia::render('Unauthorized');

        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'logo_picture' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 200);
        }
        
        $validated = $validator->validated();


        $result = $this->AppSettingService->updateSetting($validated, $request);

        return $result;
    }

}
