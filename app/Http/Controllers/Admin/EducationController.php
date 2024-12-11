<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::where('user_id', Auth::id())->get();
        return view('pages.admin.education.index', compact('educations'));
    }

    public function create()
    {
        return view('pages.admin.education.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'start_year' => 'required|integer|digits:4',
            'end_year' => 'required|integer|digits:4|gte:start_year|max:' . now()->year,
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Education::create([
            'user_id' => Auth::id(),
            'degree' => $request->degree,
            'institution' => $request->institution,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect()->route('education.index')->with('success', 'Education record added successfully.');
    }

    public function edit(Education $education)
    {
        return view('pages.admin.education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'start_year' => 'required|integer|digits:4',
            'end_year' => 'required|integer|digits:4|gte:start_year|max:' . now()->year,
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $education->update($request->all());

        return redirect()->route('education.index')->with('success', 'Education record updated successfully.');
    }

    public function show(Education $education)
    {
        return view('pages.admin.education.view', compact('education'));
    }

    public function destroy(Education $education)
    {
        $education->delete();
        return redirect()->route('education.index')->with('success', 'Education record deleted successfully.');
    }
}
