@extends('layouts.template')

@section('content')

<!-- header -->
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

<!-- home section -->
<section class="home" id="home">
  <div class="home-content">
    <h3>Hello, It's me</h3>
    <h1>{{ $user->name }}</h1>
    <h3>And I'm a <span class="multiple-text"></span></h3>
    <p>{{ $personalInfo->summary ?? 'Experienced Web Developer' }}</p>

    <div class="social-media">
      <a href="{{ $personalInfo->linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a>
      <a href="{{ $personalInfo->github }}" target="_blank"><i class="fab fa-github"></i></a>
      <a href="{{ $personalInfo->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
      <a href="https://wa.me/{{ $personalInfo->whatsapp }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
    </div>
    {{-- <a href="{{ asset('storage/'.$personalInfo->cv) }}" download class="btn">Download CV</a> --}}
    <a href="{{ asset('assets/files/Umaima_CV.pdf') }}" download="Umaima_CV.pdf" class="btn">Download CV</a>
</div>
  <div class="home-img">
    {{-- <img src="{{ asset('storage/'.$personalInfo->profile_picture) }}" alt="profilePic" /> --}}
    <img src="{{ asset('assets/images/new logo.png') }}" alt="profilPic" />
</div>
</section>

<!-- skills section -->
<section class="skbox" id="skills">
  <h2 class="heading">My <span>Skills</span></h2>
  <div class="skills-container">
    <div class="skill-box">
      @foreach ($skills as $skill)
        <a href="#" class="btn">{{ $skill->name }}</a>
      @endforeach
    </div>
  </div>
</section>

<!-- Work Experience -->
<section class="services" id="services">
  <h2 class="heading">My <span>Work Experience</span></h2>
  <div class="services-container">
    @foreach ($workExperiences as $work)
      <div class="services-box">
        <i class="fas fa-briefcase"></i>
        <h3>{{ $work->job_title }} at {{ $work->company_name }}</h3>
        <p>
          <strong>{{ \Carbon\Carbon::parse($work->start_date)->format('M Y') }} - 
            {{ $work->end_date ? \Carbon\Carbon::parse($work->end_date)->format('M Y') : 'Present' }}</strong>
          <br>
          {{ $work->description }}
        </p>
      </div>
    @endforeach
  </div>
</section>

<!-- Portfolio Projects -->
<section class="portfolio" id="portfolio">
  <h2 class="heading">Latest <span>Projects</span></h2>
  <div class="portfolio-container">
    @foreach ($projects as $project)
      <div class="portfolio-box">
        @if(Str::endsWith($project->media, ['.jpg', '.jpeg', '.png']))
          <img src="{{ asset($project->media) }}" alt="">
        @else
          <video width="100%" controls>
            <source src="{{ asset($project->media) }}" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        @endif
        <div class="portfolio-layer">
          <h4>{{ $project->title }}</h4>
          <p>{{ $project->description }}</p>
          <a href="{{ $project->link }}" target="_blank"><i class="fas fa-external-link-alt"></i></a>
        </div>
      </div>
    @endforeach
  </div>
</section>

<!-- Education Section -->
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
      <br>
      {{ $edu->description }}
    </p>
  </div>
@endforeach

  </div>
</section>

@endsection
