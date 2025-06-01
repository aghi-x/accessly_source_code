<?php

namespace App\Modules\AppSetting\Services;

use  App\Modules\AppSetting\Interfaces\AppSettingServiceInterface;
use App\Modules\AppSetting\Models\Setting;
use Illuminate\Support\Facades\Storage;

class AppSettingService implements AppSettingServiceInterface
{

    public function getSetting()
    {


    try {
        return Setting::first();
    } catch (\Exception $e) {
        \Log::error('Failed to get setting: ' . $e->getMessage());
        return null;
    }

    


        return $settings;
    }



    public function updateSetting($validated, $request)
    {
 
 
    $settings = Setting::find(1);

    if (!$settings) {
        $settings = new Setting();
        $settings->id = 1;
    }


    
        // if ($request->hasFile('logo_picture')) {
        //     // Optionally delete the old image
        //     if ($settings->logo_picture) {
        //         Storage::disk('public')->delete($settings->logo_picture);
        //     }
    
        //     // Store new logo
        //     $logoPath = $request->file('logo_picture')->store('logos', 'public');
        //     $settings->logo_picture = $logoPath;
        // }




if ($request->hasFile('logo_picture')) {
    // Optionally delete the old image
    if ($settings->logo_picture && file_exists(public_path('uploads/' . $settings->logo_picture))) {
        unlink(public_path('uploads/' . $settings->logo_picture));
    }

    // Store new logo
    $file = $request->file('logo_picture');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('uploads/logos'), $fileName);

    // Save relative path to the DB (e.g., 'logos/mylogo.png')
    $settings->logo_picture = 'logos/' . $fileName;
}




    

        $settings->name = $validated['name'];

        $settings->save();


                // ✅ Log activity
        activity()
        ->causedBy(auth()->user())
        ->performedOn($settings)
        ->log("Updated application settings");




        \Log::info('Settings saved: ', $settings->toArray());

        return response()->json(['message' => 'Settings updated successfully', 'data' => $settings]);
 


    }
}
