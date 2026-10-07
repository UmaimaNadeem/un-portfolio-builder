@extends('layouts.app')

@section('title', 'Users')
@section('page_title', 'Users')
@section('page_subtitle', 'Manage members and admin accounts')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="display-font h3 mb-1">Manage users</h1>
            <p class="muted mb-0">Roles, status, and portfolio counts across the platform.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-4">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Portfolios</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td class="muted">{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $user->portfolios_count }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-ghost">Edit</a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete user?')" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-3">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
