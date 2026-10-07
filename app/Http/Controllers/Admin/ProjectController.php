<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesActivePortfolio;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    use ResolvesActivePortfolio;

    public function index()
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $projects = Project::where('portfolio_id', $portfolio->id)->get();

        return view('pages.admin.projects.index', compact('projects', 'portfolio'));
    }

    public function create()
    {
        if (!$this->activePortfolio()) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        return view('pages.admin.projects.create');
    }

    public function store(Request $request)
    {
        $portfolio = $this->activePortfolio();
        if (!$portfolio) {
            return redirect()->route('portfolios.index')->with('error', 'Select or create a portfolio first.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url',
            'media' => 'nullable|file|mimes:jpg,png,jpeg,mp4,avi,mov|max:20480',
        ]);

        $userId = Auth::id();
        $project = Project::create([
            'user_id' => $userId,
            'portfolio_id' => $portfolio->id,
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        if ($request->hasFile('media')) {
            $path = public_path("content/{$userId}/projects/{$project->id}");
            File::ensureDirectoryExists($path);
            $fileName = $request->file('media')->getClientOriginalName();
            $request->file('media')->move($path, $fileName);
            $project->update(['media' => "content/{$userId}/projects/{$project->id}/{$fileName}"]);
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('pages.admin.projects.view', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('pages.admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url',
            'media' => 'nullable|file|mimes:jpg,png,jpeg,mp4,avi,mov|max:20480',
        ]);

        $data = $request->only(['title', 'description', 'link']);
        $userId = Auth::id();

        if ($request->hasFile('media')) {
            if ($project->media && File::exists(public_path($project->media))) {
                File::delete(public_path($project->media));
            }

            $path = public_path("content/{$userId}/projects/{$project->id}");
            File::ensureDirectoryExists($path);
            $fileName = $request->file('media')->getClientOriginalName();
            $request->file('media')->move($path, $fileName);
            $data['media'] = "content/{$userId}/projects/{$project->id}/{$fileName}";
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->media && File::exists(public_path($project->media))) {
            File::delete(public_path($project->media));
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
