@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h2>Services</h2>
    <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Add New</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Icon</th>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td><i class="{{ $service->icon }}"></i></td>
                <td>{{ $service->name }}</td>
                <td>{{ $service->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-info">View</a>
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
