<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesActivePortfolio;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    use ResolvesActivePortfolio;

    public function index()
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $educations = Education::where('portfolio_id', $portfolio->id)->get();

        return view('pages.admin.education.index', compact('educations', 'portfolio'));
    }

    public function create()
    {
        if (!$this->activePortfolio()) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        return view('pages.admin.education.create');
    }

    public function store(Request $request)
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'start_year' => 'required|date',
            'end_year' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Education::create([
            'user_id' => Auth::id(),
            'portfolio_id' => $portfolio->id,
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
            'start_year' => 'required|date',
            'end_year' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $education->update($request->only([
            'degree', 'institution', 'start_year', 'end_year', 'location', 'description',
        ]));

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
