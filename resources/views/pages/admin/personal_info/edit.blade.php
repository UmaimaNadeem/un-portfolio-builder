@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h2>Edit Personal Info</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('personal_info.update', $personalInfo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="{{ $personalInfo->name }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ $personalInfo->email }}">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $personalInfo->phone }}">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ $personalInfo->address }}</textarea>
        </div>
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
            @if($personalInfo->profile_image)
            <img src="{{ asset('content/' . $personalInfo->user_id . '/profile/' . $personalInfo->profile_image) }}" width="60">
            @endif
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
