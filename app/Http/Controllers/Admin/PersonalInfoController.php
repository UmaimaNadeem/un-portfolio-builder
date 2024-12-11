<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonalInfo;
use Illuminate\Support\Facades\Auth;

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:personal_infos',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        PersonalInfo::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:personal_infos,email,' . $personalInfo->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $personalInfo->update($request->all());

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
