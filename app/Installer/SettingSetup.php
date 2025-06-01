<?php

namespace App\Installer;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Modules\AppSetting\Models\Setting;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;


class SettingSetup
{
    // GET /api/settings
    public function index()
    {
        try {
            $settings = Setting::first();
    
            return Inertia::render('Installer/SettingsSetup', [
                'settings' => $settings,
                'logoUrl' => $settings && $settings->logo_picture
                    ? asset('uploads/' . $settings->logo_picture)
                    : null,
            ]);
    
        } catch (\Exception $e) {
           // Log::error('Settings could not be loaded: ' . $e->getMessage());
    
            return Inertia::render('Installer/SettingsSetup', [
                'settings' => null,
                'logoUrl' => null,
                'error' => 'Settings could not be loaded. Please complete the database configuration first.',
            ]);
        }
    }


    public function update(Request $request)
    {
        try {
                // $validated = $request->validate([
                //     'name' => 'required|string',
                //     'logo_picture' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
                // ]);


            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'logo_picture' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'status' => 'validation_failed'
                ], 200); // ✅ Avoids red 422 errors
            }
        
            $validated = $validator->validated();





            $settings = Setting::firstOrCreate(
                ['id' => 1],
                ['name' => $validated['name']]
            );
            
    
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
                // Delete the old image (if exists)
                if ($settings->logo_picture && file_exists(public_path('uploads/' . $settings->logo_picture))) {
                    unlink(public_path('uploads/' . $settings->logo_picture));
                }

                // Save new logo
                $file = $request->file('logo_picture');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/logos'), $fileName);

                // Save relative path like 'logos/filename.png'
                $settings->logo_picture = 'logos/' . $fileName;
            }

















        
    
            $settings->name = $validated['name'];
    
            $settings->save();
    
            file_put_contents(storage_path('installed'), now()->toDateTimeString());

            

            return response()->json(['success' => true]);
    
        } catch (ValidationException $e) {
            // Clean error structure
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->validator->errors()->messages(), // you could sanitize this further
            ], 200); // ✅ Return 200 to prevent browser/Axios issues
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage(),
            ], 200);
        }
    }
















}
