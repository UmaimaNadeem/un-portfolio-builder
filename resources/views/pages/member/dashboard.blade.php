@extends('layouts.member')

@section('content')
    <div class="unMainContainer">

        <h2 class="mb-4">Welcome, {{ Auth::user()->name }} 👋</h2>
        <p>This is your portfolio management dashboard. Use the sidebar to navigate and update your content easily.</p>
<div class="">
    <h2 class="text-center mb-5 fw-bold text-secondary">Complete Your Portfolio</h2>

    <div class="row g-4 justify-content-center">
       @php
    $steps = [
        ['icon' => 'bi-person-circle', 'title' => 'Personal Info', 'route' => 'personal_info.index', 'color' => 'primary'],
        ['icon' => 'bi-link-45deg', 'title' => 'Profile Links', 'route' => 'user-profile-links.index', 'color' => 'info'],
        ['icon' => 'bi-briefcase-fill', 'title' => 'Experience', 'route' => 'work_experiences.index', 'color' => 'success'],
        ['icon' => 'bi-mortarboard-fill', 'title' => 'Education', 'route' => 'education.index', 'color' => 'warning'],
        ['icon' => 'bi-gear-fill', 'title' => 'Services', 'route' => 'services.index', 'color' => 'danger'],
        ['icon' => 'bi-lightning-charge-fill', 'title' => 'Skills', 'route' => 'skills.index', 'color' => 'secondary'],
        ['icon' => 'bi-grid-3x3-gap-fill', 'title' => 'Projects', 'route' => 'projects.index', 'color' => 'dark'],
    ];
@endphp

        @foreach ($steps as $step)
            <div class="col-md-4 col-lg-3">
                <div class="card step-card text-center border-0 shadow-sm p-3 rounded-4 h-100 hover-zoom">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-box bg-{{ $step['color'] }} text-white rounded-circle mb-3 d-flex justify-content-center align-items-center" style="width:70px;height:70px;">
                            <i class="bi {{ $step['icon'] }} fs-3"></i>
                        </div>
                        <h5 class="card-title mb-3">{{ $step['title'] }}</h5>
                        <a href="{{ route($step['route']) }}" class="btn btn-outline-{{ $step['color'] }} btn-sm px-4">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

        <div class="row mt-4">
            <div class="col-md-4">
    
                @php
                    $userId = auth()->id(); // Get current logged-in user ID
                @endphp

                <div class="card-glass text-center p-4 mb-4">
                    <h5 class="mb-3">Preview Your Portfolio</h5>
                    <p class="text-muted">See how your portfolio looks to visitors.</p>
                    <a href="{{ url('portfolio/' . $userId) }}" target="_blank" class="btn btn-primary">
                        <i class="bi bi-eye me-1"></i> View Your Portfolio
                    </a>
                </div>

            </div>
            <!-- Add similar cards for Projects, Skills, etc. -->
        </div>
    @endsection
@push('styles')
<style>
    .step-card {
        background: rgba(255, 255, 255, 0.02);
        transition: all 0.3s ease-in-out;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 136, 255, 0.15);
    }

    .icon-box {
        transition: all 0.4s ease;
    }

    .step-card:hover .icon-box {
        transform: rotate(10deg) scale(1.1);
        box-shadow: 0 0 15px rgba(0, 136, 255, 0.4);
    }

    body {
        background-color: #0a0a0a;
    }

    .card-title {
        color: white;
    }
</style>
@endpush
