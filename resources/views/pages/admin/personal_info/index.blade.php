@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h1>Personal Info</h1>
    <a href="{{ route('personal_info.create') }}" class="btn btn-primary">Add Personal Info</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2" id="success-alert">
            {{ $message }}
        </div>
    @endif
    
    <table class="table mt-2">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personalInfos as $personalInfo)
                <tr>
                    <td>{{ $personalInfo->first_name }}</td>
                    <td>{{ $personalInfo->last_name }}</td>
                    <td>{{ $personalInfo->email }}</td>
                    <td>{{ $personalInfo->phone }}</td>
                    <td>{{ $personalInfo->address }}</td>
                    <td>
                        <a href="{{ route('personal_info.show', $personalInfo->id) }}" class="btn btn-info">View Detail</a>
                        <a href="{{ route('personal_info.edit', $personalInfo->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('personal_info.destroy', $personalInfo->id) }}" method="POST" style="display:inline-block;">
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
