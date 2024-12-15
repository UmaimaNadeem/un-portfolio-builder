<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use App\Models\PersonalInfo;
use App\Models\WorkExperience;
use App\Models\Project;
use App\Models\Education;

class PortfolioController extends Controller
{
    public function show(User $user)
    {
        $personalInfo = PersonalInfo::where('user_id', $user->id)->first();
        $skills = Skill::where('user_id', $user->id)->get();
        $workExperiences = WorkExperience::where('user_id', $user->id)->get();
        $projects = Project::where('user_id', $user->id)->get();
        $educations = Education::where('user_id', $user->id)->get();

        return view('pages.admin.portfolios.show', compact('user', 'personalInfo', 'skills', 'workExperiences', 'projects', 'educations'));
    }
}
