@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1>Personal Information</h1>
    <div class="card">
        <div class="card-header">
            <h5>{{ $personalInfo->first_name }} {{ $personalInfo->last_name }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $personalInfo->email }}</p>
            <p><strong>Phone:</strong> {{ $personalInfo->phone }}</p>
            <p><strong>Address:</strong> {{ $personalInfo->address }}</p>
        </div>
    </div>
    <a href="{{ route('personal_info.index') }}" class="btn btn-primary mt-3">Back to Personal Info List</a>
</div>
@endsection
