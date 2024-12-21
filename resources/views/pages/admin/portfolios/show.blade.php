@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <div class="container">
        <div class="profile-header">
            <h1>{{ $user->name }}</h1>
            <p>{{ $personalInfo->email }}</p>
            <p>{{ $personalInfo->phone }}</p>
            <p>{{ $personalInfo->address }}</p>
        </div>

        <div class="profile-section">
            <h2>Skills</h2>
            <ul>
                @foreach ($skills as $skill)
                    <li>{{ $skill->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="profile-section">
            <h2>Work Experience</h2>
            @foreach ($workExperiences as $work)
                <div class="experience">
                    <h3>{{ $work->job_title }} at {{ $work->company_name }}</h3>
                    <p>{{ \Carbon\Carbon::parse($work->start_date)->format('M Y') }} - {{ $work->end_date ? \Carbon\Carbon::parse($work->end_date)->format('M Y') : 'Present' }}</p>
                    <p>{{ $work->description }}</p>
                </div>
            @endforeach
        </div>

        <div class="profile-section">
            <h2>Projects</h2>
            @foreach ($projects as $project)
                <div class="project">
                    <h3>{{ $project->title }}</h3>
                    <p>{{ $project->description }}</p>
                    <p><a href="{{ $project->link }}" target="_blank">Project Link</a></p>
                    @if ($project->media)
                        @if (Str::endsWith($project->media, ['.jpg', '.jpeg', '.png']))
                            <img src="{{ url($project->media) }}" alt="Project Media" style="width: 100%;">
                        @else
                            <video width="100%" controls>
                                <source src="{{ url($project->media) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>

        <div class="profile-section">
            <h2>Education</h2>
            @foreach ($educations as $education)
                <div class="education">
                    <h3>{{ $education->degree }} from {{ $education->institution }}</h3>
                    <p>{{ \Carbon\Carbon::parse($education->start_date)->format('M Y') }} - {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('M Y') : 'Present' }}</p>
                    <p>{{ $education->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .portfolio {
        padding: 20px;
        background-color: #f5f5f5;
    }
    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .profile-section {
        background: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .profile-section h2 {
        margin-bottom: 20px;
    }
    .experience, .project, .education {
        margin-bottom: 20px;
    }
    .project img, .project video {
        margin-top: 10px;
    }
</style>
@endsection
