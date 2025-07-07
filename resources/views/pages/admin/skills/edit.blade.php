@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h1>Edit Skill</h1>

    <form action="{{ route('skills.update', $skill->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Skill Name</label>
            <input type="text" name="name" class="form-control" value="{{ $skill->name }}" required>
        </div>
        <div class="form-group">
            <label for="proficiency">Proficiency (1-5)</label>
            <input type="range" name="proficiency" class="form-control-range" min="1" max="5" value="{{ $skill->proficiency }}" required oninput="this.nextElementSibling.value = this.value">
            <output>{{ $skill->proficiency }}</output>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
