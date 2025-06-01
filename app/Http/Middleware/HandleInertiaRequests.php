<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Modules\AppSetting\Services\AppSettingService;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // ✅ Resolve the settings service and fetch the settings
        $settingsService = app(AppSettingService::class);
        $settings = $settingsService->getSetting();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => rescue(fn () => $request->user(), null),
            ],
            'appSettings' => [
                'app_name' => $settings?->name,
                'logo_picture' => $settings?->logo_picture
                    ? asset('storage/' . $settings->logo_picture)
                    : null,
                // Add more fields if needed
            ],
        ];
    }
}
