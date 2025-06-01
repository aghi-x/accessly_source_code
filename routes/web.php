<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\UserController;
use App\Modules\User\Controllers\OnlineUsersController;
use App\Modules\Permission\Controllers\PermissionController;
use App\Modules\Role\Controllers\RoleController;
use App\Modules\Role\Controllers\RoleAssignmentController;
use App\Modules\Dashboard\Controllers\DashboardController;
use App\Modules\Home\Controllers\HomeController;
use App\Modules\Activity\Controllers\ActivityController;
use App\Modules\AppSetting\Controllers\AppSettingController;
use App\Modules\Search\Controllers\SearchController;
use App\Installer\DatabaseSetup;
use App\Installer\AdminSetup;
use App\Installer\CheckDatabase;
use App\Installer\SettingSetup;
use App\Installer\CheckAdmin;
use App\Installer\CheckSettings;
use App\Installer\CheckDependencies;
use App\Http\Middleware\PreventAccessToInstaller;
use Inertia\Inertia;



Route::middleware(PreventAccessToInstaller::class)->prefix('installer')->group(function () {
    Route::get('/database', [DatabaseSetup::class, 'showDatabaseSetup'])->name('installer.database');
    Route::post('/database', [DatabaseSetup::class, 'saveDatabaseConfig']);
    Route::get('/checkdb', [CheckDatabase::class, 'checkMigrations']);
    Route::get('/admin', [AdminSetup::class, 'showAdminSetup']);
    Route::post('/admin/set-credentiels', [AdminSetup::class, 'setAdminCredentiels']);
    Route::get('/admin/check-admin', [CheckAdmin::class, 'isAdminExist']);
    Route::get('/settings', [SettingSetup::class, 'index']);
    Route::post('/settings', [SettingSetup::class, 'update']);
    Route::get('/settings/check-setting', [CheckSettings::class, 'isSettingConfigured']);
    Route::get('/check', [CheckDependencies::class, 'checkSystem']);

});






Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});







Route::middleware('auth')->group(function () {


        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');



            /////////////////////////////////////////
        //////////////////////////////////////////




        Route::get('users', [UserController::class, 'index']);
        Route::get('users/add', [UserController::class, 'storeForm'])->name('users.add');
        Route::get('/users/online', [OnlineUsersController::class, 'getOnlineUsers']);
        Route::post('users', [UserController::class, 'store']);
        Route::get('users/{user}/edit', [UserController::class, 'updateForm'])->name('users.edit');
        Route::post('users/{user}', [UserController::class, 'update']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);




        ///////////////////////////////////////////
        ////////////////////////////////////////////




        Route::prefix('permissions')->group(function () {
            Route::post('/', [PermissionController::class, 'store']);        // Create permission
            Route::get('/add', [PermissionController::class, 'storeForm'])->name('permissions.add');
            Route::get('/{permission}/edit', [PermissionController::class, 'updateForm']);
            Route::get('/{permission}', [PermissionController::class, 'show']);
            Route::get('/', [PermissionController::class, 'index']);         // Get all permissions
            Route::put('/{id}', [PermissionController::class, 'update']);    // Update permission
            Route::delete('/{id}', [PermissionController::class, 'destroy']); // Delete permission
        });


        ///////////////////////////////////////////
        ////////////////////////////////////////////



        Route::prefix('roles')->group(function () {
            Route::post('/', [RoleController::class, 'store']);        // Create role
            Route::get('/add', [RoleController::class, 'storeForm'])->name('roles.add');
            Route::get('/{role}/edit', [RoleController::class, 'updateForm']);
            Route::get('/', [RoleController::class, 'index']);         // Get all roles
            Route::put('/{id}', [RoleController::class, 'update']);    // Update role
            Route::delete('/{id}', [RoleController::class, 'destroy']); // Delete role
            Route::get('/{role}', [RoleController::class, 'show']);

        });


        ///////////////////////////////////////////
        ////////////////////////////////////////////



            Route::get('/dashboard', [DashboardController::class, 'GetDashboadData'])->name('dashboard');
            Route::get('/profile', [ProfileController::class, 'show']);
            Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);
            Route::get('/activity-log', [ActivityController::class, 'getAllActivities']);
            Route::get('/settings', [AppSettingController::class, 'index']);
            Route::post('/settings', [AppSettingController::class, 'update']);


            Route::get('/search', [SearchController::class, 'search']);

            
});



use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    $path = public_path('LandingPage/index.html');

    if (!File::exists($path)) {
        abort(404);
    }

    $content = File::get($path);
    return Response::make($content, 200)
                   ->header('Content-Type', 'text/html');
});







Route::get('/documentation', function () {
    return Inertia::render('Documentation/Pages/IntroductionSection');
});


Route::get('/documentation/installation', function () {
    return Inertia::render('Documentation/Pages/InstallationSection');
});

Route::get('/documentation/features', function () {
    return Inertia::render('Documentation/Pages/FeaturesSection');
});


Route::get('/documentation/customize', function () {
    return Inertia::render('Documentation/Pages/CustomizeSection');
});
