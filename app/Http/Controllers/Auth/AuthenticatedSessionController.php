<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Activitylog\Models\Activity;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }


    
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();

        $user = auth()->user();


        $request->session()->regenerate();

        activity()
        ->causedBy($user)
        ->withProperties([
            'email' => $user->email,
        ])
        ->log('User logged in');


        return redirect()->intended('/dashboard');
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $user = auth()->user(); // ✅ Fix: define before logout
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

    // ✅ log logout using stored user
    activity()
        ->causedBy($user)
        ->withProperties([
            'email' => $user->email,
        ])
        ->log('User logged out');


        return redirect()->intended('/dashboard');
    }
}
