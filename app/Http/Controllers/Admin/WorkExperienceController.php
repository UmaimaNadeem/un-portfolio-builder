<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesActivePortfolio;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkExperienceController extends Controller
{
    use ResolvesActivePortfolio;

    public function index()
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $workExperiences = WorkExperience::where('portfolio_id', $portfolio->id)->get();

        return view('pages.admin.work_experiences.index', compact('workExperiences', 'portfolio'));
    }

    public function create()
    {
        if (!$this->activePortfolio()) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        return view('pages.admin.work_experiences.create');
    }

    public function store(Request $request)
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        WorkExperience::create([
            'user_id' => Auth::id(),
            'portfolio_id' => $portfolio->id,
            'company_name' => $request->company_name,
            'job_title' => $request->job_title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        return redirect()->route('work_experiences.index')->with('success', 'Work experience added successfully.');
    }

    public function edit(WorkExperience $workExperience)
    {
        return view('pages.admin.work_experiences.edit', compact('workExperience'));
    }

    public function update(Request $request, WorkExperience $workExperience)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $workExperience->update($request->only([
            'company_name', 'job_title', 'start_date', 'end_date', 'description',
        ]));

        return redirect()->route('work_experiences.index')->with('success', 'Work experience updated successfully.');
    }

    public function destroy(WorkExperience $workExperience)
    {
        $workExperience->delete();

        return redirect()->route('work_experiences.index')->with('success', 'Work experience deleted successfully.');
    }

    public function show($id)
    {
        $workExperience = WorkExperience::findOrFail($id);

        return view('pages.admin.work_experiences.view', compact('workExperience'));
    }
}
