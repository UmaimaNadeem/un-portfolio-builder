@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h1>Add Education</h1>

    <!-- Display All Errors in a Single Alert -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('education.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="degree">Degree</label>
            <input type="text" class="form-control @error('degree') is-invalid @enderror" id="degree" name="degree" value="{{ old('degree') }}" required>
        </div>
        <div class="form-group">
            <label for="institution">Institution</label>
            <input type="text" class="form-control @error('institution') is-invalid @enderror" id="institution" name="institution" value="{{ old('institution') }}" required>
        </div>
    
        <div class="form-group">
            <label for="start_year">Start Date</label>
            <input type="date" name="start_year" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_year">End Date</label>
            <input type="date" name="end_year" class="form-control">
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</div>
@endsection
