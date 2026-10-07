@extends('layouts.template')

@section('content')
@php
    $displayName = $personalInfo->name ?? $portfolio->title;
    $ownerId = $owner->id ?? ($personalInfo->user_id ?? null);
@endphp

<header class="header">
    <a href="#" class="logo"><span>UN</span> Portfolio</a>
    <i class="fas fa-bars" id="menu-icon"></i>
    <nav class="navbar">
        <a href="#home" class="active">Home</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#skills">Skills</a>
        <a href="#portfolio">Portfolio</a>
        <a href="#contact">Contact</a>
    </nav>
</header>

<section class="home" id="home">
    <div class="home-content">
        <h3>Hello, It's me</h3>
        <h1>{{ $displayName }}</h1>
        <h3>And I'm a <span class="multiple-text"></span></h3>
        <p>{{ optional($userProfileLink)->overview ?? 'Welcome to my portfolio' }}</p>
        <div class="social-media">
            @if ($userProfileLink?->linkedin)
                <a href="{{ $userProfileLink->linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a>
            @endif
            @if ($userProfileLink?->github)
                <a href="{{ $userProfileLink->github }}" target="_blank"><i class="fab fa-github"></i></a>
            @endif
            @if ($userProfileLink?->instagram)
                <a href="{{ $userProfileLink->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
            @endif
            @if ($userProfileLink?->whatsapp)
                <a href="https://wa.me/{{ $userProfileLink->whatsapp }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
            @endif
        </div>
        @if ($userProfileLink?->cv_resume)
            <a href="{{ asset($userProfileLink->cv_resume) }}" download class="unBtnBlue">Download CV</a>
        @endif
    </div>
    <div class="home-img">
        @if ($personalInfo?->profile_image && $ownerId)
            <img src="{{ asset('content/' . $ownerId . '/profile/' . $personalInfo->profile_image) }}" alt="Profile Picture">
        @endif
    </div>
</section>

<section class="about" id="about">
    <div class="about-img">
        <div class="aimg">
            @if ($personalInfo?->profile_image && $ownerId)
                <img src="{{ asset('content/' . $ownerId . '/profile/' . $personalInfo->profile_image) }}" alt="Profile Picture">
            @endif
        </div>
        <div class="acon">
            <h2 class="heading">About <span>Me</span></h2>
            <p>
                Following are my duties that I performed in a journey of becoming a
                <span>{{ $userProfileLink->stack ?? 'Developer' }}</span>.
            </p>
        </div>
    </div>
    <div class="about-content pt-5">
        @foreach ($workExperiences as $work)
            <div class="services-box mt-3 mb-5">
                <h3>{{ $work->job_title }} at {{ $work->company_name }}</h3>
                <p>
                    <strong>{{ \Carbon\Carbon::parse($work->start_date)->format('M Y') }} -
                        {{ $work->end_date ? \Carbon\Carbon::parse($work->end_date)->format('M Y') : 'Present' }}</strong>
                    <br><br>{{ $work->description }}
                </p>
            </div>
        @endforeach
    </div>
</section>

<section class="services" id="services">
    <h2 class="heading">Our <span>Services</span></h2>
    <div class="services-container">
        @foreach ($services as $service)
            <div class="services-box">
                <i class="{{ $service->icon }}"></i>
                <h3 class="pt-5">{{ $service->name }}</h3>
                <p>{{ $service->detail }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="skbox" id="skills">
    <h2 class="heading">My <span>Skills</span></h2>
    <div class="skills-container">
        <div class="skill-box">
            @foreach ($skills as $skill)
                <a href="#" class="unBtnBlue">{{ $skill->name }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="portfolio" id="portfolio">
    <h2 class="heading">Latest <span>Projects</span></h2>
    <div class="portfolio-container">
        @foreach ($projects as $project)
            <div class="portfolio-box">
                @if ($project->media && Str::endsWith(strtolower($project->media), ['.jpg', '.jpeg', '.png', '.webp']))
                    <img src="{{ asset($project->media) }}" alt="">
                @elseif ($project->media)
                    <video width="100%" controls>
                        <source src="{{ asset($project->media) }}" type="video/mp4">
                    </video>
                @endif
                <div class="portfolio-layer">
                    <h4>{{ $project->title }}</h4>
                    <p>{{ $project->description }}</p>
                    @if($project->link)
                        <a href="{{ $project->link }}" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="services" id="education">
    <h2 class="heading">My <span>Education</span></h2>
    <div class="services-container">
        @foreach ($educations as $edu)
            <div class="services-box">
                <i class="fas fa-graduation-cap"></i>
                <h3>{{ $edu->degree }} from {{ $edu->institution }}</h3>
                <p>
                    {{ \Carbon\Carbon::parse($edu->start_year)->format('M Y') }} -
                    {{ $edu->end_year ? \Carbon\Carbon::parse($edu->end_year)->format('M Y') : 'Present' }}
                    <br>{{ $edu->description }}
                </p>
            </div>
        @endforeach
    </div>
</section>

<section class="contact" id="contact">
    <h2 class="heading">Contact <span>Me</span></h2>
    <div class="contact-grid">
        @if ($personalInfo?->email)
        <a href="mailto:{{ $personalInfo->email }}" class="contact-card"><i class="fa fa-envelope"></i><h4>Email</h4><p>{{ $personalInfo->email }}</p></a>
        @endif
        @if ($personalInfo?->phone)
        <a href="tel:{{ $personalInfo->phone }}" class="contact-card"><i class="fa fa-phone"></i><h4>Phone</h4><p>{{ $personalInfo->phone }}</p></a>
        @endif
        @if ($personalInfo?->address)
        <div class="contact-card"><i class="fa fa-map-marker-alt"></i><h4>Location</h4><p>{{ $personalInfo->address }}</p></div>
        @endif
    </div>
</section>

<footer class="footer">
    <div class="footer-text text-white"><p>Copyright &copy; {{ date('Y') }} by UN | All rights Reserved</p></div>
    <div class="footer-iconTop"><a href="#home"><i class="fa fa-arrow-up"></i></a></div>
</footer>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Typed !== 'undefined') {
            new Typed('.multiple-text', {
                strings: {!! json_encode(array_values(array_filter(array_map('trim', explode(',', optional($userProfileLink)->stack ?? 'Developer'))))) !!},
                typeSpeed: 100, backSpeed: 100, backDelay: 1000, loop: true
            });
        }
    });
</script>
@endpush

@push('styles')
<style>
    .unBtnBlue { display:inline-block; box-shadow:0 0 1rem var(--main-color); font-size:1.6rem; color:var(--second-bg-color); letter-spacing:.1rem; font-weight:600; margin-bottom:4rem; cursor:pointer; padding:1rem 2.8rem; background:var(--main-color); border-radius:4rem; }
    body { background: black !important; }
    .aimg { border-radius:50%; border:3px dashed var(--main-color); padding:5px; background:#fff; }
    .aimg img { width:250px; }
    a { text-decoration:none !important; }
</style>
@endpush
