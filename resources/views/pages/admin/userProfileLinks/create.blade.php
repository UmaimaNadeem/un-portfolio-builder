@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h2>Add New Profile</h2>

    <form action="{{ route('user-profile-links.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('pages.admin.userProfileLinks._form', ['submit' => 'Create'])
    </form>
</div>
@endsection
