@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1>Project Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $project->title }}</h5>
            <p><strong>Description:</strong> {{ $project->description }}</p>
            <p><strong>Link:</strong> <a href="{{ $project->link }}" target="_blank">Project Link</a></p>
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
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
