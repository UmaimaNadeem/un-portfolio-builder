@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h2>Service Details</h2>

    <p><strong>Icon:</strong> <i class="{{ $service->icon }}"></i></p>
    <p><strong>Name:</strong> {{ $service->name }}</p>
    <p><strong>Detail:</strong> {{ $service->detail }}</p>
    <p><strong>Status:</strong> {{ $service->status ? 'Active' : 'Inactive' }}</p>

    <a href="{{ route('services.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
