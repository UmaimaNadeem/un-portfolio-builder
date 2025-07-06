@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h2>Add New Service</h2>

    @if ($errors->any())
        <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('services.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Icon (e.g. fas fa-code)</label> <a href='https://fontawesome.com/icons' target= '_blank'><b>Font Awesome</b></a>
            <input type="text" name="icon" class="form-control" placeholder="Enter FontAwesome class" value="{{ old('icon') }}">
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label>Detail</label>
            <textarea name="detail" class="form-control" required>{{ old('detail') }}</textarea>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>
</div>
@endsection
