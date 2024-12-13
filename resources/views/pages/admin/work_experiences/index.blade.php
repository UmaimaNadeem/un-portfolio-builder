@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1>Work Experiences</h1>
    @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('work_experiences.create') }}" class="btn btn-primary mb-3">Add New Work Experience</a>

    <table class="table">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Job Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workExperiences as $workExperience)
                <tr>
                    <td>{{ $workExperience->company_name }}</td>
                    <td>{{ $workExperience->job_title }}</td>
                    <td>{{ $workExperience->start_date }}</td>
                    <td>{{ $workExperience->end_date }}</td>
                    <td>
                        <a href="{{ route('work_experiences.show', $workExperience->id) }}" class="btn btn-info btn-sm">View Detail</a>
                        <a href="{{ route('work_experiences.edit', $workExperience->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('work_experiences.destroy', $workExperience->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<script>
    var alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(function () {
            alert.style.display = 'none';
        }, 5000);
    }
</script>
