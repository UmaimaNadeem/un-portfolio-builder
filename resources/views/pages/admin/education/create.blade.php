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
            @error('degree')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="institution">Institution</label>
            <input type="text" class="form-control @error('institution') is-invalid @enderror" id="institution" name="institution" value="{{ old('institution') }}" required>
            @error('institution')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="start_year">Start Year</label>
            <input type="number" class="form-control @error('start_year') is-invalid @enderror" id="start_year" name="start_year" value="{{ old('start_year') }}" required>
            @error('start_year')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="end_year">End Year</label>
            <input type="number" class="form-control @error('end_year') is-invalid @enderror" id="end_year" name="end_year" value="{{ old('end_year') }}" required>
            @error('end_year')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
            @error('location')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</div>
@endsection
