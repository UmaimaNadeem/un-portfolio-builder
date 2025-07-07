@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h2>{{ $userProfileLink->website_name }}</h2>

    <p><strong>Stack:</strong> {{ $userProfileLink->stack }}</p>
    <p><strong>Overview:</strong> {{ $userProfileLink->overview }}</p>
    <p><strong>Portfolio:</strong> <a href="{{ $userProfileLink->portfolio_link }}" target="_blank">{{ $userProfileLink->portfolio_link }}</a></p>
    <p><strong>GitHub:</strong> <a href="{{ $userProfileLink->github }}" target="_blank">{{ $userProfileLink->github }}</a></p>
    <p><strong>LinkedIn:</strong> <a href="{{ $userProfileLink->linkedin }}" target="_blank">{{ $userProfileLink->linkedin }}</a></p>
    <p><strong>WhatsApp:</strong> {{ $userProfileLink->whatsapp }}</p>
    <p><strong>Instagram:</strong> {{ $userProfileLink->instagram }}</p>
    <p><strong>Resume:</strong> 
        @if($userProfileLink->cv_resume)
            <a href="{{ asset($userProfileLink->cv_resume) }}" target="_blank">Download</a>
        @else
            Not uploaded
        @endif
    </p>

    <a href="{{ route('user-profile-links.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
