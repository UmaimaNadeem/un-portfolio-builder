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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('pages.admin.portfolios.index');
    }
    public function create()
    {
        return view('pages.admin.portfolios.create');
    }
public function show(User $user)
{
    if (auth()->id() !== $user->id && !auth()->user()->is_admin) {
        return response()->view('errors.custom-403', [], 403);
    }

    $personalInfo = PersonalInfo::where('user_id', $user->id)->first();
    $userProfileLink = UserProfileLink::where('user_id', $user->id)->first();
    $workExperiences = WorkExperience::where('user_id', $user->id)->get();
    $educations = Education::where('user_id', $user->id)->get();
    $services = Service::where('user_id', $user->id)->get();
    $skills = Skill::where('user_id', $user->id)->get();
    $projects = Project::where('user_id', $user->id)->get();

    return view('pages.admin.portfolios.show', compact(
        'user', 'personalInfo', 'userProfileLink', 'services', 'skills', 'workExperiences', 'projects', 'educations'
    ));
}


    public function storeFullPortfolio(Request $request)
{
    $userId = Auth::id();

    $request->validate([
        // Personal Info
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:personal_infos,email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        // Profile Link
        'website_name' => 'required|string|max:255',
        'stack' => 'required|string|max:1000',
        'overview' => 'nullable|string',
        'portfolio_link' => 'nullable|url',
        'github' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'whatsapp' => 'nullable|url',
        'instagram' => 'nullable|url',
        'cv_resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',

        // Work Experience
        'work.*.company_name' => 'required|string|max:255',
        'work.*.job_title' => 'required|string|max:255',
        'work.*.start_date' => 'required|date',
        'work.*.end_date' => 'nullable|date|after_or_equal:work.*.start_date',
        'work.*.description' => 'nullable|string',

        // Education
        'education.*.degree' => 'required|string|max:255',
        'education.*.institution' => 'required|string|max:255',
        'education.*.start_year' => 'required|date',
        'education.*.end_year' => 'nullable|date',
        'education.*.location' => 'nullable|string|max:255',
        'education.*.description' => 'nullable|string',

        // Services
        'services.*.icon' => 'nullable|string|max:255',
        'services.*.name' => 'required|string|max:255',
        'services.*.detail' => 'required|string',
        'services.*.status' => 'required|boolean',

        // Skills
        'skills.*.name' => 'required|string|max:255',
        'skills.*.proficiency' => 'required|integer|min:1|max:5',

        // Projects
        'projects.*.title' => 'required|string|max:255',
        'projects.*.description' => 'nullable|string',
        'projects.*.link' => 'nullable|url',
        'projects.*.media' => 'nullable|file|mimes:jpg,png,jpeg,mp4,avi,mov|max:20480',
    ]);

    // --- 1. Personal Info ---
    $profileImage = null;
    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $profileImage = 'profileimg_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = base_path("content/{$userId}/profile");
        File::makeDirectory($path, 0777, true, true);
        $file->move($path, $profileImage);
    }

    PersonalInfo::create([
        'user_id' => $userId,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'profile_image' => $profileImage,
    ]);

    // --- 2. Profile Links ---
    $cvPath = null;
    if ($request->hasFile('cv_resume')) {
        $file = $request->file('cv_resume');
        $cvName = 'resume_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = public_path("content/{$userId}/cv");
        File::makeDirectory($path, 0777, true, true);
        $file->move($path, $cvName);
        $cvPath = "content/{$userId}/cv/{$cvName}";
    }

    UserProfileLink::create([
        'user_id' => $userId,
        'website_name' => $request->website_name,
        'stack' => implode(',', array_map('trim', explode(',', $request->stack))),
        'overview' => $request->overview,
        'portfolio_link' => $request->portfolio_link,
        'github' => $request->github,
        'linkedin' => $request->linkedin,
        'whatsapp' => $request->whatsapp,
        'instagram' => $request->instagram,
        'cv_resume' => $cvPath,
    ]);

    // --- 3. Work Experiences ---
    foreach ($request->work ?? [] as $work) {
        WorkExperience::create([
            'user_id' => $userId,
            ...$work
        ]);
    }

    // --- 4. Education ---
    foreach ($request->education ?? [] as $edu) {
        Education::create([
            'user_id' => $userId,
            ...$edu
        ]);
    }

    // --- 5. Services ---
    foreach ($request->services ?? [] as $service) {
        Service::create([
            'user_id' => $userId,
            ...$service
        ]);
    }

    // --- 6. Skills ---
    foreach ($request->skills ?? [] as $skill) {
        Skill::create([
            'user_id' => $userId,
            ...$skill
        ]);
    }

    // --- 7. Projects ---
    foreach ($request->projects ?? [] as $index => $project) {
        $project['user_id'] = $userId;
        $created = Project::create($project);

        if (isset($project['media']) && $request->file("projects.$index.media")) {
            $mediaFile = $request->file("projects.$index.media");
            $mediaName = $mediaFile->getClientOriginalName();
            $path = base_path("content/{$userId}/projects/{$created->id}");
            File::makeDirectory($path, 0777, true, true);
            $mediaFile->move($path, $mediaName);
            $created->update(['media' => "content/{$userId}/projects/{$created->id}/{$mediaName}"]);
        }
    }

    return redirect()->route('dashboard')->with('success', 'Full portfolio created successfully!');
}

}
