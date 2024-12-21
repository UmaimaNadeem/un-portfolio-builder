@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h1>Education Details</h1>
    <div class="card">
        <div class="card-header">
            <h5>{{ $education->degree }} at {{ $education->institution }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Degree:</strong> {{ $education->degree }}</p>
            <p><strong>Institution:</strong> {{ $education->institution }}</p>
            <p><strong>Start Year:</strong> {{ $education->start_year }}</p>
            <p><strong>End Year:</strong> {{ $education->end_year }}</p>
            <p><strong>Location:</strong> {{ $education->location }}</p>
            <p><strong>Description:</strong> {{ $education->description }}</p>
        </div>
    </div>
    <a href="{{ route('education.index') }}" class="btn btn-primary mt-3">Back to Education List</a>
</div>
@endsection
