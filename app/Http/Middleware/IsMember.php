<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsMember
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isMember()) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('auth.login')
            ->with('error', 'Please sign in to continue.');
    }
}
