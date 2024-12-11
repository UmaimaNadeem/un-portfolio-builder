@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1>Education Details</h1>
    <a href="{{ route('education.create') }}" class="btn btn-primary">Add Education</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2" id="success-alert">
            {{ $message }}
        </div>
    @endif
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Degree</th>
                <th>Institution</th>
                <th>Start Year</th>
                <th>End Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($educations as $education)
                <tr>
                    <td>{{ $education->degree }}</td>
                    <td>{{ $education->institution }}</td>
                    <td>{{ $education->start_year }}</td>
                    <td>{{ $education->end_year }}</td>
                    <td>
                        <a href="{{ route('education.show', $education->id) }}" class="btn btn-info">View Details</a>
                        <a href="{{ route('education.edit', $education->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('education.destroy', $education->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
