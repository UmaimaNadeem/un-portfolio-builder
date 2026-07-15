@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h1>My Portfolio</h1>
    <p class="mt-4">Click the link below to get access to your portfolio for yoyur added data</p>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2" id="success-alert">
            {{ $message }}
        </div>
    @endif

    <a href="http://un-portfolio-builder.test/admin/portfolio/1'" class="btn btn-primary mb-3">View Your Portfolio</a>       
</div>
@endsection
