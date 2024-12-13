@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1>Skill Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $skill->name }}</h5>
            <p class="card-text"><strong>Proficiency:</strong></p>
            <div class="progress mb-3" style="height: 30px;">
                <div class="progress-bar bg-{{ getProficiencyColor($skill->proficiency) }}" role="progressbar" style="width: {{ ($skill->proficiency / 5) * 100 }}%;" aria-valuenow="{{ $skill->proficiency }}" aria-valuemin="0" aria-valuemax="5">{{ $skill->proficiency }} / 5</div>
            </div>
            <a href="{{ route('skills.edit', $skill->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('skills.destroy', $skill->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
