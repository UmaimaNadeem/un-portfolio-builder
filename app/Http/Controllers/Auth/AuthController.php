<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class AuthController extends BaseController
{
    public function register()
    {
        return view('pages.auth.register');
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (User::where('mobile_number', $request->mobile_number)->exists()) {
            return back()->withErrors('Mobile is already used')->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'city' => $request->city,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'status' => 1,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('member.dashboard')->with('success', 'Welcome! Create your first portfolio to get started.');
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'required' => 'The :attribute is required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->only('email'));
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $currentUser = Auth::user();

            if ($currentUser->status === 0 || $currentUser->status === false) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('auth.login')->withErrors('Your account is deactivated. Please contact support.');
            }

            if ($currentUser->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            if ($currentUser->isMember()) {
                return redirect()->intended(route('member.dashboard'));
            }

            Auth::logout();
        }

        return back()->withErrors('Credentials are wrong.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
