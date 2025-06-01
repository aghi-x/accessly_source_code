<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackOnlineUsers
{
    public function handle($request, Closure $next)
    {
    try {
        if (Auth::check()) {
            $userId = Auth::id();

            Cache::put('user-is-online-' . $userId, true, now()->addMinutes(2));
        }
    } catch (\Exception $e) {
        \Log::error('TrackOnlineUsers failed: ' . $e->getMessage());
        // optional: fallback, like skipping cache update
    }

        return $next($request);
    }
}
