@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h2 class="mb-4">User Profile Links</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('user-profile-links.create') }}" class="btn btn-primary mb-3">Add New Profile</a>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Website</th>
                <th>Stack</th>
                <th>Portfolio</th>
                <th>GitHub</th>
                <th>LinkedIn</th>
                <th>CV/Resume</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($userProfileLinks as $link)
                <tr>
                    <td>{{ $link->website_name }}</td>
                    <td>{{ $link->stack }}</td>
                    <td>
                        @if($link->portfolio_link)
                            <a href="{{ $link->portfolio_link }}" target="_blank">View</a>
                        @endif
                    </td>
                    <td>
                        @if($link->github)
                            <a href="{{ $link->github }}" target="_blank">GitHub</a>
                        @endif
                    </td>
                    <td>
                        @if($link->linkedin)
                            <a href="{{ $link->linkedin }}" target="_blank">LinkedIn</a>
                        @endif
                    </td>
                    <td>
                        @if($link->cv_resume)
                            <a href="{{ asset($link->cv_resume) }}" target="_blank">Download</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user-profile-links.show', $link->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('user-profile-links.edit', $link->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('user-profile-links.destroy', $link->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No profile links found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
