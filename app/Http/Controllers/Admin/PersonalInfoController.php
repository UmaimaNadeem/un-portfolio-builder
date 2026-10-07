<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesActivePortfolio;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PersonalInfoController extends Controller
{
    use ResolvesActivePortfolio;

    public function index()
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $personalInfos = PersonalInfo::where('portfolio_id', $portfolio->id)->get();

        return view('pages.admin.personal_info.index', compact('personalInfos', 'portfolio'));
    }

    public function create()
    {
        if (!$this->activePortfolio()) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        return view('pages.admin.personal_info.create');
    }

    public function store(Request $request)
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userId = Auth::id();
        $imageName = null;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $imageName = 'profileimg_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path("content/{$userId}/profile");
            File::ensureDirectoryExists($path);
            $file->move($path, $imageName);
        }

        PersonalInfo::create([
            'user_id' => $userId,
            'portfolio_id' => $portfolio->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $imageName,
        ]);

        return redirect()->route('personal_info.index')->with('success', 'Personal info created successfully.');
    }

    public function edit(PersonalInfo $personalInfo)
    {
        return view('pages.admin.personal_info.edit', compact('personalInfo'));
    }

    public function update(Request $request, PersonalInfo $personalInfo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('profile_image')) {
            $userId = Auth::id();
            $file = $request->file('profile_image');
            $imageName = 'profileimg_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path("content/{$userId}/profile");
            File::ensureDirectoryExists($path);

            if ($personalInfo->profile_image && File::exists("{$path}/{$personalInfo->profile_image}")) {
                File::delete("{$path}/{$personalInfo->profile_image}");
            }

            $file->move($path, $imageName);
            $data['profile_image'] = $imageName;
        }

        $personalInfo->update($data);

        return redirect()->route('personal_info.index')->with('success', 'Personal info updated successfully.');
    }

    public function show(PersonalInfo $personalInfo)
    {
        return view('pages.admin.personal_info.show', compact('personalInfo'));
    }

    public function destroy(PersonalInfo $personalInfo)
    {
        $personalInfo->delete();

        return redirect()->route('personal_info.index')->with('success', 'Personal info deleted successfully.');
    }
}
