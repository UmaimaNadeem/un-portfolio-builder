@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h2>Edit Service</h2>

    @if ($errors->any())
        <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('services.update', $service->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Icon (e.g. fas fa-code)</label> <a href='https://fontawesome.com/icons' target= '_blank'><b>Font Awesome</b></a>
            <label>Icon</label>
            <input type="text" name="icon" class="form-control" value="{{ old('icon', $service->icon) }}">
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
        </div>
        <div class="form-group">
            <label>Detail</label>
            <textarea name="detail" class="form-control" required>{{ old('detail', $service->detail) }}</textarea>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $service->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$service->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
