@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h1 class="mb-3">Edit User: {{ $user->name }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white p-4 rounded mb-4">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    @foreach(['member','admin','superAdmin'] as $role)
                        <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="1" @selected(old('status', $user->status) == 1)>Active</option>
                    <option value="0" @selected(old('status', $user->status) == 0)>Inactive</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Mobile</label>
                <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number', $user->mobile_number) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">New Password (optional)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>
        <div class="mt-3">
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>

    <h4>User Portfolios</h4>
    <ul class="list-group">
        @forelse($portfolios as $portfolio)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $portfolio->title }} ({{ $portfolio->status }}) — {{ $portfolio->theme->name ?? '—' }}</span>
                <a href="{{ route('portfolios.manage', $portfolio) }}">Manage</a>
            </li>
        @empty
            <li class="list-group-item">No portfolios.</li>
        @endforelse
    </ul>
</div>
@endsection
