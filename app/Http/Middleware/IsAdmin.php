<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        if (Auth::check()) {
            return redirect()->route('member.dashboard')
                ->with('error', 'You do not have admin access.');
        }

        return redirect()->route('auth.login')
            ->with('error', 'Please sign in to continue.');
    }
}
