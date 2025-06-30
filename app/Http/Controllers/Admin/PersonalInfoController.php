<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonalInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PersonalInfoController extends Controller
{
    public function index()
    {
        $personalInfos = PersonalInfo::where('user_id', Auth::id())->get();
        return view('pages.admin.personal_info.index', compact('personalInfos'));
    }

    public function create()
    {
        return view('pages.admin.personal_info.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:personal_infos',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $userId = Auth::id();
    $imageName = null;

    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $imageName = 'profileimg_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $path = base_path("content/{$userId}/profile");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $file->move($path, $imageName);
        $imagePath = "content/{$userId}/profile/{$imageName}";
    }

    PersonalInfo::create([
        'user_id' => $userId,
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
        'email' => 'required|string|email|max:255|unique:personal_infos,email,' . $personalInfo->id,
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->only(['name', 'email', 'phone', 'address']);

    if ($request->hasFile('profile_image')) {
        $userId = Auth::id();
        $oldImage = $personalInfo->profile_image;

        $file = $request->file('profile_image');
        $imageName = 'profileimg_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $path = base_path("content/{$userId}/profile");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if ($oldImage && File::exists("{$path}/{$oldImage}")) {
            File::delete("{$path}/{$oldImage}");
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
