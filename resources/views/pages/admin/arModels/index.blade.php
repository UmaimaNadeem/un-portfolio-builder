@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h1>3D Models</h1>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2" id="success-alert">
            {{ $message }}
        </div>
    @endif

    <a href="{{ route('armodels.create') }}" class="btn btn-primary mb-3">Add New Model</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Link</th>
                <th>Media</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arModels as $armodel)
                <tr>
                    <td>{{ $armodel->id }}</td>
                    <td>{{ $armodel->title }}</td>
                    <td>{{ $armodel->description }}</td>
                    <td><a href="{{ $armodel->link }}" target="_blank">Project Link</a></td>
                    <td>
                        @if ($armodel->media)
                            @if (Str::endsWith($armodel->media, ['.jpg', '.jpeg', '.png']))
                                <img src="{{ url($armodel->media) }}" alt="Project Media" style="width: 100px;">
                            @else
                                <video width="100" controls>
                                    <source src="{{ url($armodel->media) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('armodels.show', $armodel->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('armodels.edit', $armodel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('armodels.destroy', $armodel->id) }}" method="POST" style="display:inline;">
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
