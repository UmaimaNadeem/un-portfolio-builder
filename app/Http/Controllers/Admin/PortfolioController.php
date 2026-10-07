<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesActivePortfolio;
use App\Models\Education;
use App\Models\PersonalInfo;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Theme;
use App\Models\UserProfileLink;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    use ResolvesActivePortfolio;

    public function index()
    {
        $user = Auth::user();

        $portfolios = $user->isAdmin()
            ? Portfolio::with(['theme', 'user'])->latest()->get()
            : Portfolio::with('theme')->where('user_id', $user->id)->latest()->get();

        return view('pages.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $themes = Theme::where('is_active', true)->orderBy('name')->get();

        return view('pages.portfolios.create', compact('themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', Portfolio::typeKeys()),
            'slug' => 'nullable|string|max:255|unique:portfolios,slug',
            'theme_id' => 'required|exists:themes,id',
            'status' => 'required|in:public,private,draft',
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['title']);
        $slug = $this->uniqueSlug($slug);

        $portfolio = Portfolio::create([
            'user_id' => Auth::id(),
            'theme_id' => $validated['theme_id'],
            'title' => $validated['title'],
            'type' => $validated['type'],
            'slug' => $slug,
            'status' => $validated['status'],
        ]);

        $this->setActivePortfolio($portfolio);

        return redirect()
            ->route('portfolios.manage', $portfolio)
            ->with('success', 'Portfolio created. Add your content below.');
    }

    public function manage(Portfolio $portfolio)
    {
        $this->authorizePortfolio($portfolio);
        $this->setActivePortfolio($portfolio);

        $portfolio->load(['theme', 'personalInfo', 'profileLink', 'skills', 'projects', 'services', 'educations', 'workExperiences']);

        return view('pages.portfolios.manage', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        $this->authorizePortfolio($portfolio);
        $themes = Theme::where('is_active', true)->orderBy('name')->get();

        return view('pages.portfolios.edit', compact('portfolio', 'themes'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->authorizePortfolio($portfolio);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', Portfolio::typeKeys()),
            'slug' => 'required|string|max:255|unique:portfolios,slug,' . $portfolio->id,
            'theme_id' => 'required|exists:themes,id',
            'status' => 'required|in:public,private,draft',
        ]);

        $portfolio->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'slug' => Str::slug($validated['slug']),
            'theme_id' => $validated['theme_id'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('portfolios.manage', $portfolio)->with('success', 'Portfolio updated.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->authorizePortfolio($portfolio);

        if (session('active_portfolio_id') == $portfolio->id) {
            session()->forget('active_portfolio_id');
        }

        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Portfolio deleted.');
    }

    public function select(Portfolio $portfolio)
    {
        $this->authorizePortfolio($portfolio);
        $this->setActivePortfolio($portfolio);

        return redirect()->route('portfolios.manage', $portfolio)->with('success', 'Active portfolio selected.');
    }

    public function show(Portfolio $portfolio)
    {
        return $this->renderPortfolio($portfolio, false);
    }

    public function showBySlug(string $slug)
    {
        $portfolio = Portfolio::with('theme')->where('slug', $slug)->firstOrFail();

        return $this->renderPortfolio($portfolio, true);
    }

    public function publicIndex()
    {
        $portfolios = Portfolio::with(['theme', 'user', 'personalInfo'])
            ->public()
            ->latest()
            ->get();

        return view('pages.portfolios.public-index', compact('portfolios'));
    }

    protected function renderPortfolio(Portfolio $portfolio, bool $isPublicRoute)
    {
        $user = Auth::user();
        $canViewPrivate = $user && ($portfolio->isOwnedBy($user->id) || $user->isAdmin());

        if ($isPublicRoute && !$portfolio->isPublic() && !$canViewPrivate) {
            abort(403, 'This portfolio is not public.');
        }

        if (!$isPublicRoute && !$canViewPrivate) {
            abort(403);
        }

        $personalInfo = PersonalInfo::where('portfolio_id', $portfolio->id)->first();
        $userProfileLink = UserProfileLink::where('portfolio_id', $portfolio->id)->first();
        $workExperiences = WorkExperience::where('portfolio_id', $portfolio->id)->get();
        $educations = Education::where('portfolio_id', $portfolio->id)->get();
        $services = Service::where('portfolio_id', $portfolio->id)->get();
        $skills = Skill::where('portfolio_id', $portfolio->id)->get();
        $projects = Project::where('portfolio_id', $portfolio->id)->get();
        $owner = $portfolio->user;

        $view = $portfolio->theme?->view_path ?? 'themes.classic-dark.show';

        return view($view, compact(
            'portfolio',
            'owner',
            'personalInfo',
            'userProfileLink',
            'services',
            'skills',
            'workExperiences',
            'projects',
            'educations'
        ));
    }

    protected function authorizePortfolio(Portfolio $portfolio): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($user->isAdmin() || $portfolio->isOwnedBy($user->id)) {
            return;
        }

        abort(403);
    }

    protected function uniqueSlug(string $slug): string
    {
        $base = Str::slug($slug) ?: 'portfolio';
        $candidate = $base;
        $i = 1;

        while (Portfolio::where('slug', $candidate)->exists()) {
            $candidate = $base . '-' . $i;
            $i++;
        }

        return $candidate;
    }

    /** @deprecated kept for old form compatibility */
    public function storeFullPortfolio(Request $request)
    {
        $portfolio = $this->activePortfolio();

        if (!$portfolio) {
            return redirect()->route('portfolios.create')->with('error', 'Create a portfolio first.');
        }

        $userId = Auth::id();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'website_name' => 'required|string|max:255',
            'stack' => 'required|string|max:1000',
            'overview' => 'nullable|string',
            'portfolio_link' => 'nullable|url',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'whatsapp' => 'nullable|url',
            'instagram' => 'nullable|url',
            'cv_resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $profileImage = 'profileimg_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path("content/{$userId}/profile");
            File::makeDirectory($path, 0777, true, true);
            $file->move($path, $profileImage);
        }

        PersonalInfo::updateOrCreate(
            ['portfolio_id' => $portfolio->id],
            [
                'user_id' => $userId,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'profile_image' => $profileImage,
            ]
        );

        $cvPath = null;
        if ($request->hasFile('cv_resume')) {
            $file = $request->file('cv_resume');
            $cvName = 'resume_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path("content/{$userId}/cv");
            File::makeDirectory($path, 0777, true, true);
            $file->move($path, $cvName);
            $cvPath = "content/{$userId}/cv/{$cvName}";
        }

        UserProfileLink::updateOrCreate(
            ['portfolio_id' => $portfolio->id],
            [
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
            ]
        );

        foreach ($request->work ?? [] as $work) {
            WorkExperience::create(['user_id' => $userId, 'portfolio_id' => $portfolio->id, ...$work]);
        }

        foreach ($request->education ?? [] as $edu) {
            Education::create(['user_id' => $userId, 'portfolio_id' => $portfolio->id, ...$edu]);
        }

        foreach (($request->services ?? $request->service ?? []) as $service) {
            Service::create(['user_id' => $userId, 'portfolio_id' => $portfolio->id, ...$service]);
        }

        foreach (($request->skills ?? $request->skill ?? []) as $skill) {
            Skill::create(['user_id' => $userId, 'portfolio_id' => $portfolio->id, ...$skill]);
        }

        foreach (($request->projects ?? $request->project ?? []) as $index => $project) {
            $created = Project::create([
                'user_id' => $userId,
                'portfolio_id' => $portfolio->id,
                'title' => $project['title'],
                'description' => $project['description'] ?? null,
                'link' => $project['link'] ?? null,
            ]);

            $mediaFile = $request->file("projects.$index.media") ?? $request->file("project.$index.media");
            if ($mediaFile) {
                $mediaName = $mediaFile->getClientOriginalName();
                $path = public_path("content/{$userId}/projects/{$created->id}");
                File::makeDirectory($path, 0777, true, true);
                $mediaFile->move($path, $mediaName);
                $created->update(['media' => "content/{$userId}/projects/{$created->id}/{$mediaName}"]);
            }
        }

        return redirect()->route('portfolios.manage', $portfolio)->with('success', 'Portfolio content saved.');
    }
}
