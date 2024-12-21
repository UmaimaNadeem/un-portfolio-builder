@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h1>Projects</h1>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2" id="success-alert">
            {{ $message }}
        </div>
    @endif

    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Add New Project</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Link</th>
                <th>Media</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->description }}</td>
                    <td><a href="{{ $project->link }}" target="_blank">Project Link</a></td>
                    <td>
                        @if ($project->media)
                            @if (Str::endsWith($project->media, ['.jpg', '.jpeg', '.png']))
                                <img src="{{ url($project->media) }}" alt="Project Media" style="width: 100px;">
                            @else
                                <video width="100" controls>
                                    <source src="{{ url($project->media) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
