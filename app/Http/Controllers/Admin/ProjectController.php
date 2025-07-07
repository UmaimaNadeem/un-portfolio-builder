<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();

        return view('pages.admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('pages.admin.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url',
            'media' => 'nullable|file|mimes:jpg,png,jpeg,mp4,avi,mov|max:20480',
        ]);

        $data = $request->all();
        $userId = Auth::id();

        $data['user_id'] = $userId;
        $project = Project::create($data);

        if ($request->hasFile('media')) {
            $projectId = $project->id;
            $path = base_path("content/{$userId}/projects/{$projectId}");
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $fileName = $request->file('media')->getClientOriginalName();
            $request->file('media')->move($path, $fileName);
            $data['media'] = "content/{$userId}/projects/{$projectId}/{$fileName}";
            $project->update(['media' => $data['media']]);
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

        $data = $request->all();
        $userId = Auth::id();

        if ($request->hasFile('media')) {
            if ($project->media) {
                File::delete(base_path($project->media));
            }

            $projectId = $project->id;
            $path = base_path("content/{$userId}/projects/{$projectId}");
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $fileName = $request->file('media')->getClientOriginalName();
            $request->file('media')->move($path, $fileName);
            $data['media'] = "content/{$userId}/projects/{$projectId}/{$fileName}";
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->media) {
            File::delete(base_path($project->media));
        }

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}

