<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProfileLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserProfileLinkController extends Controller
{
    public function index()
    {
        $userProfileLinks = UserProfileLink::where('user_id', Auth::id())->get();
        return view('pages.admin.userProfileLinks.index', compact('userProfileLinks'));
    }

    public function create()
    {
        return view('pages.admin.userProfileLinks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'stack' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'portfolio_link' => 'nullable|url',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'cv_resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $userId = Auth::id();
        $data = $request->only([
            'website_name', 'stack', 'overview', 'portfolio_link',
            'github', 'linkedin', 'whatsapp', 'instagram'
        ]);
        $data['user_id'] = $userId;

        if ($request->hasFile('cv_resume')) {
            $file = $request->file('cv_resume');
            $filename = 'resume_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path("content/{$userId}/cv");
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $file->move($path, $filename);
            $data['cv_resume'] = "content/{$userId}/cv/{$filename}";
        }

        UserProfileLink::create($data);

        return redirect()->route('user-profile-links.index')->with('success', 'Profile link added successfully.');
    }

    public function show(UserProfileLink $userProfileLink)
    {
        return view('pages.admin.userProfileLinks.show', compact('userProfileLink'));
    }

    public function edit(UserProfileLink $userProfileLink)
    {
        return view('pages.admin.userProfileLinks.edit', compact('userProfileLink'));
    }

    public function update(Request $request, UserProfileLink $userProfileLink)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'stack' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'portfolio_link' => 'nullable|url',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'cv_resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only([
            'website_name', 'stack', 'overview', 'portfolio_link',
            'github', 'linkedin', 'whatsapp', 'instagram'
        ]);

        $userId = Auth::id();

        if ($request->hasFile('cv_resume')) {
            // Delete old resume
            if ($userProfileLink->cv_resume && File::exists(public_path($userProfileLink->cv_resume))) {
                File::delete(public_path($userProfileLink->cv_resume));
            }

            $file = $request->file('cv_resume');
            $filename = 'resume_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path("content/{$userId}/cv");
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $file->move($path, $filename);
            $data['cv_resume'] = "content/{$userId}/cv/{$filename}";
        }

        $userProfileLink->update($data);

        return redirect()->route('user-profile-links.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(UserProfileLink $userProfileLink)
    {
        if ($userProfileLink->cv_resume && File::exists(public_path($userProfileLink->cv_resume))) {
            File::delete(public_path($userProfileLink->cv_resume));
        }

        $userProfileLink->delete();

        return redirect()->route('user-profile-links.index')->with('success', 'Profile deleted.');
    }
}
