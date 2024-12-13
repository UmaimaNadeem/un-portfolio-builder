<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::where('user_id', Auth::id())->get();
        return view('pages.admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('pages.admin.skills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'proficiency' => 'required|integer|min:1|max:5',
        ]);

        Skill::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'proficiency' => $request->proficiency,
        ]);

        return redirect()->route('skills.index')->with('success', 'Skill added successfully!');
    }

    public function edit(Skill $skill)
    {
        return view('pages.admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'proficiency' => 'required|integer|min:1|max:5',
        ]);

        $skill->update($request->all());

        return redirect()->route('skills.index')->with('success', 'Skill updated successfully!');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully!');
    }

    public function show(Skill $skill)
    {
        return view('pages.admin.skills.view', compact('skill'));
    }
}

