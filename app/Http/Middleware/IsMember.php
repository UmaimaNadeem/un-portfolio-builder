<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsMember
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role == 'member') {
                return $next($request); 
            }
        }

        return redirect()->route('auth.login')->with('error', 'You have not valid access');
    }

}

