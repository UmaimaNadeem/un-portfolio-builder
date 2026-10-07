<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::withCount('portfolios')->latest()->paginate(20);

        return view('pages.admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $portfolios = Portfolio::with('theme')->where('user_id', $user->id)->latest()->get();

        return view('pages.admin.users.edit', compact('user', 'portfolios'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:member,admin,superAdmin',
            'status' => 'required|boolean',
            'city' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->status = $validated['status'];
        $user->city = $validated['city'] ?? $user->city;
        $user->mobile_number = $validated['mobile_number'] ?? $user->mobile_number;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
