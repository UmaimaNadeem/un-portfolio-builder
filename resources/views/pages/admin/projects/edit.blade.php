@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1>Edit Project</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $project->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $project->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="link">Link</label>
            <input type="url" name="link" class="form-control" value="{{ $project->link }}">
        </div>
        <div class="form-group">
            <label for="media">Media (Image or Video)</label>
            <input type="file" name="media" class="form-control">
            @if ($project->media)
                <div class="mt-2">
                    @if (Str::endsWith($project->media, ['.jpg', '.jpeg', '.png']))
                        <img src="{{ url($project->media) }}" alt="Project Media" style="width: 100%;">
                    @else
                        <video width="100" controls>
                            <!-- <source src="{{ Storage::url($project->media) }}" type="video/mp4"> -->
                            <source src="{{ url($project->media) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
