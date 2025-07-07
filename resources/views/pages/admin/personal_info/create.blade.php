@extends('layouts.member')

@section('content')
<div class="unMainContainer">
        <h2>Add Personal Info</h2>
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
    
        <form action="{{ route('personal_info.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            </div>
            <div class="mb-3">
                <label>Profile Image</label>
                <input type="file" name="profile_image" class="form-control">
            </div>
            <button class="btn btn-success">Submit</button>
        </form>
    </div>
    @endsection
    