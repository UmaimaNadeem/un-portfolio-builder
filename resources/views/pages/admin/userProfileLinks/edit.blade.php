@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h2>Edit Profile</h2>

    <form action="{{ route('user-profile-links.update', $userProfileLink->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('pages.admin.userProfileLinks._form', ['submit' => 'Update'])
    </form>
</div>
@endsection
