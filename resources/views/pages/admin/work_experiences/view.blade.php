@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h1>Work Experience Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $workExperience->company_name }} - {{ $workExperience->job_title }}</h5>
            <p><strong>Start Date:</strong> 
                <span class="date-style">{{ \Carbon\Carbon::parse($workExperience->start_date)->format('M d, Y') }}</span>
            </p>
            <p><strong>End Date:</strong> 
                @if ($workExperience->end_date)
                    <span class="date-style">{{ \Carbon\Carbon::parse($workExperience->end_date)->format('M d, Y') }}</span>
                @else
                    <span class="text-muted">Present</span>
                @endif
            </p>
            <p><strong>Description:</strong> {{ $workExperience->description }}</p>
            
            <a href="{{ route('work_experiences.edit', $workExperience->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('work_experiences.destroy', $workExperience->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

@endsection
