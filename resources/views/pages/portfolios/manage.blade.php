@extends(auth()->user()->isAdmin() ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="unMainContainer">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h1 class="mb-1">{{ $portfolio->title }}</h1>
            <p class="mb-0">
                Theme: <strong>{{ $portfolio->theme->name ?? '—' }}</strong> ·
                Status:
                <span class="badge bg-{{ $portfolio->status === 'public' ? 'success' : 'secondary' }}">{{ ucfirst($portfolio->status) }}</span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-outline-secondary">Settings / Theme</a>
            <a href="{{ route('portfolios.preview', $portfolio) }}" class="btn btn-outline-dark" target="_blank">Preview</a>
            @if($portfolio->status === 'public')
                <a href="{{ route('portfolios.public.show', $portfolio->slug) }}" class="btn btn-primary" target="_blank">Public Link</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="alert alert-info">
        This portfolio is now active. Content you add below will belong to <strong>{{ $portfolio->title }}</strong>.
    </div>

    @php
        $steps = [
            ['title' => 'Personal Info', 'route' => 'personal_info.index', 'count' => $portfolio->personalInfo ? 1 : 0],
            ['title' => 'Profile Links', 'route' => 'user-profile-links.index', 'count' => $portfolio->profileLink ? 1 : 0],
            ['title' => 'Experience', 'route' => 'work_experiences.index', 'count' => $portfolio->workExperiences->count()],
            ['title' => 'Education', 'route' => 'education.index', 'count' => $portfolio->educations->count()],
            ['title' => 'Services', 'route' => 'services.index', 'count' => $portfolio->services->count()],
            ['title' => 'Skills', 'route' => 'skills.index', 'count' => $portfolio->skills->count()],
            ['title' => 'Projects', 'route' => 'projects.index', 'count' => $portfolio->projects->count()],
        ];
    @endphp

    <div class="row g-3">
        @foreach($steps as $step)
            <div class="col-md-4 col-lg-3">
                <div class="border rounded p-3 bg-white h-100">
                    <h5>{{ $step['title'] }}</h5>
                    <p class="text-muted">{{ $step['count'] }} item(s)</p>
                    <a href="{{ route($step['route']) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
