@extends('layouts.app')

@section('content')
<div class="unMainContainer">

        <h2>Personal Info Details</h2>
    
        <div class="card p-4">
            <div class="row">
                <div class="col-md-3">
                    @if($personalInfo->profile_image)
                    <img src="{{ asset('content/' . $personalInfo->user_id . '/profile/' . $personalInfo->profile_image) }}" width="100">
                    @else
                        <div class="bg-secondary text-white text-center p-4">No Image</div>
                    @endif
                </div>
                <div class="col-md-9">
                    <p><strong>Name:</strong> {{ $personalInfo->name }}</p>
                    <p><strong>Email:</strong> {{ $personalInfo->email }}</p>
                    <p><strong>Phone:</strong> {{ $personalInfo->phone }}</p>
                    <p><strong>Address:</strong> {{ $personalInfo->address }}</p>
                    <a href="{{ route('personal_info.edit', $personalInfo->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('personal_info.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
    @endsection
    