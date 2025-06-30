@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h2>Personal Info List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('personal_info.create') }}" class="btn btn-primary mb-3">Add New</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($personalInfos as $info)
                <tr>
                    <td>
                        @if($info->profile_image)
                        <img src="{{ asset('content/' . $info->user_id . '/profile/' . $info->profile_image) }}" width="60">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    
                    <td>{{ $info->name }}</td>
                    <td>{{ $info->email }}</td>
                    <td>{{ $info->phone }}</td>
                    <td>{{ $info->address }}</td>
                    <td>
                        <a href="{{ route('personal_info.show', $info->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('personal_info.edit', $info->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('personal_info.destroy', $info->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
