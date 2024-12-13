@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1>Skills</h1>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2" id="success-alert">
            {{ $message }}
        </div>
    @endif

    <a href="{{ route('skills.create') }}" class="btn btn-primary mb-3">Add New Skill</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Proficiency</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($skills as $skill)
                <tr>
                    <td>{{ $skill->name }}</td>
                    <td>
                        <span class="badge 
                            @if($skill->proficiency == 5) badge-success
                            @elseif($skill->proficiency == 4) badge-info
                            @elseif($skill->proficiency == 3) badge-primary
                            @elseif($skill->proficiency == 2) badge-warning
                            @else badge-danger
                            @endif">
                            {{ $skill->proficiency }} / 5
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('skills.show', $skill->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('skills.edit', $skill->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('skills.destroy', $skill->id) }}" method="POST" style="display:inline;">
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

@section('scripts')
<script>
    var alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(function () {
            alert.style.display = 'none';
        }, 5000);
    }
</script>
@endsection
