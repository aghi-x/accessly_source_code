<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventAccessToInstaller
{
    public function handle(Request $request, Closure $next)
    {
        // If the app is already installed and trying to access /installer
        if (file_exists(storage_path('installed')) && $request->is('installer*')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
