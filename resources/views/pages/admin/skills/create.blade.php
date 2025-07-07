@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h1>Add Skill</h1>

    <form action="{{ route('skills.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Skill Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="proficiency">Proficiency (1-5)</label>
            <input type="range" name="proficiency" class="form-control-range" min="1" max="5" required oninput="this.nextElementSibling.value = this.value">
            <output>3</output>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>
@endsection
