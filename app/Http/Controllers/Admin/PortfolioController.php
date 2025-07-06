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
use App\Models\UserProfileLink;
use App\Models\Service;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('pages.admin.portfolios.index');
    }

    public function show(User $user)
    {
        $personalInfo = PersonalInfo::where('user_id', $user->id)->first();
        $userProfileLink = UserProfileLink::where('user_id', $user->id)->first();
        $workExperiences = WorkExperience::where('user_id', $user->id)->get();
        $educations = Education::where('user_id', $user->id)->get();
        $services = Service::where('user_id', $user->id)->get();
        $skills = Skill::where('user_id', $user->id)->get();
        $projects = Project::where('user_id', $user->id)->get();

        return view('pages.admin.portfolios.show', compact('user', 'personalInfo','userProfileLink', 'services', 'skills', 'workExperiences', 'projects', 'educations'));
    }
}
