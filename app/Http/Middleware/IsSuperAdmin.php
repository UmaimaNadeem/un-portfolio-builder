<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isSuperAdmin()) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Super admin access required.');
        }

        if (Auth::check()) {
            return redirect()->route('member.dashboard')
                ->with('error', 'You do not have access.');
        }

        return redirect()->route('auth.login')
            ->with('error', 'Please sign in to continue.');
    }
}
