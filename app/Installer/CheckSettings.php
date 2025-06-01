<?php

namespace App\Installer;

use App\Modules\AppSetting\Models\Setting;

class CheckSettings
{
    public function isSettingConfigured(): \Illuminate\Http\JsonResponse
    {
        try {
            $configured = Setting::exists();
    
            return response()->json([
                'success' => true,
                'configured' => $configured,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database not configured or unreachable: ' . $e->getMessage()
            ], 200); // ✅ Still 200 to avoid Axios .catch()
        }
    }
    
}
