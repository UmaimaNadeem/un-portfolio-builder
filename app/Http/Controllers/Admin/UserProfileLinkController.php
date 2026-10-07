<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesActivePortfolio;
use App\Models\UserProfileLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserProfileLinkController extends Controller
{
    use ResolvesActivePortfolio;

    public function index()
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $userProfileLinks = UserProfileLink::where('portfolio_id', $portfolio->id)->get();

        return view('pages.admin.userProfileLinks.index', compact('userProfileLinks', 'portfolio'));
    }

    public function create()
    {
        if (!$this->activePortfolio()) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        return view('pages.admin.userProfileLinks.create');
    }

    public function store(Request $request)
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $request->validate([
            'website_name' => 'required|string|max:255',
            'stack' => 'required|string|max:1000',
            'overview' => 'nullable|string',
            'portfolio_link' => 'nullable|url',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'whatsapp' => 'nullable|url',
            'instagram' => 'nullable|url',
            'cv_resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $userId = Auth::id();
        $data = $request->only([
            'website_name', 'stack', 'overview', 'portfolio_link',
            'github', 'linkedin', 'whatsapp', 'instagram',
        ]);

        $data['user_id'] = $userId;
        $data['portfolio_id'] = $portfolio->id;
        $data['stack'] = implode(',', array_map('trim', explode(',', $request->input('stack'))));

        if ($request->hasFile('cv_resume')) {
            $file = $request->file('cv_resume');
            $filename = 'resume_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path("content/{$userId}/cv");
            File::ensureDirectoryExists($path);
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
            'stack' => 'required|string|max:1000',
            'overview' => 'nullable|string',
            'portfolio_link' => 'nullable|url',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'whatsapp' => 'nullable|url',
            'instagram' => 'nullable|url',
            'cv_resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only([
            'website_name', 'overview', 'portfolio_link',
            'github', 'linkedin', 'whatsapp', 'instagram',
        ]);
        $data['stack'] = implode(',', array_map('trim', explode(',', $request->input('stack'))));
        $userId = Auth::id();

        if ($request->hasFile('cv_resume')) {
            if ($userProfileLink->cv_resume && File::exists(public_path($userProfileLink->cv_resume))) {
                File::delete(public_path($userProfileLink->cv_resume));
            }

            $file = $request->file('cv_resume');
            $filename = 'resume_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path("content/{$userId}/cv");
            File::ensureDirectoryExists($path);
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
