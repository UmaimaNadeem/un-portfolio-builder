<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = [
            'US' => ['name' => 'United States', 'prefix' => '+1'],
            'CA' => ['name' => 'Canada', 'prefix' => '+1'],
            'IN' => ['name' => 'India', 'prefix' => '+91'],
            'GB' => ['name' => 'United Kingdom', 'prefix' => '+44'],
        ];

        return view('auth.register', compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'mobile_no' => ['nullable', 'string', 'unique:'.User::class],
            'country' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'in:user,admin'], // You can limit the roles to user/admin or other roles as needed
        ]);

        // Set default values for role and status if not provided
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user', // Default to 'user' if no role is provided
            'country' => $request->country,
            'mobile_no' => $request->mobile_no,
            'status' => true, // Default to active status (true)
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
