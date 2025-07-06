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


            <p>{{ $userProfileLink->overview ?? 'Experienced Web Developer' }}</p>

            <div class="social-media">
                @if ($userProfileLink->linkedin)
                    <a href="{{ $userProfileLink->linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a>
                @endif
                @if ($userProfileLink->github)
                    <a href="{{ $userProfileLink->github }}" target="_blank"><i class="fab fa-github"></i></a>
                @endif
                @if ($userProfileLink->instagram)
                    <a href="{{ $userProfileLink->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                @endif
                @if ($userProfileLink->whatsapp)
                    <a href="https://wa.me/{{ $userProfileLink->whatsapp }}" target="_blank"><i
                            class="fab fa-whatsapp"></i></a>
                @endif
            </div>

            @if ($userProfileLink->cv)
                <a href="{{ asset('content/' . $user->id . '/cv/' . $userProfileLink->cv) }}" download
                    class="unBtnBlue">Download CV</a>
            @endif
        </div>

        <div class="home-img">
            @if ($personalInfo->profile_image)
                <img src="{{ asset('content/' . $personalInfo->user_id . '/profile/' . $personalInfo->profile_image) }}"
                    alt="Profile Picture">
            @endif
        </div>
    </section>

    <!-- about section -->
    <section class="about" id="about">
        <div class="about-img">
            <div class="aimg">
                @if ($personalInfo->profile_image)
                    <img src="{{ asset('content/' . $personalInfo->user_id . '/profile/' . $personalInfo->profile_image) }}"
                        alt="Profile Picture">
                @endif
            </div>
            <div class="acon">
                <h2 class="heading">About <span>Me</span></h2>
                <p>
                    Following are my duties that i performed in a journey of becomming a
                    <span>{{ $userProfileLink->stack }}</span> in the time span.
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
                        <br><br>
                        {{ $work->description }}
                    </p>
                    <a href="#portfolio" class="unBtnBlue">See Project</a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Service section -->
    <section class="services" id="services">
        <h2 class="heading">Our <span>Services</span></h2>
        <div class="services-container">
            @foreach ($services as $service)
                <div class="services-box">

                    <i class="{{ $service->icon }}"></i>
                    <h3>{{ $service->name }}</h3>
                    <p>
                        {{ $service->detail }}
                    </p>
                    <a href="#" class="unBtnBlue">Read More</a>

                </div>
            @endforeach

        </div>
    </section>
    <!-- skills section -->
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

    <!-- Portfolio Projects -->
    <section class="portfolio" id="portfolio">
        <h2 class="heading">Latest <span>Projects</span></h2>
        <div class="portfolio-container">
            @foreach ($projects as $project)
                <div class="portfolio-box">
                    @if (Str::endsWith($project->media, ['.jpg', '.jpeg', '.png']))
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

<section class="contact" id="contact">
  <h2 class="heading">Contact <span>Me</span></h2>
  <div class="contact-grid">

    <a href="mailto:{{ $personalInfo->email }}" class="contact-card" target="_blank">
      <i class="fa fa-envelope"></i>
      <h4>Email</h4>
      <p>{{ $personalInfo->email }}</p>
    </a>

    <a href="tel:{{ $personalInfo->phone }}" class="contact-card" target="_blank">
      <i class="fa fa-phone"></i>
      <h4>Phone</h4>
      <p>{{ $personalInfo->phone }}</p>
    </a>

    <div class="contact-card">
      <i class="fa fa-map-marker-alt"></i>
      <h4>Location</h4>
      <p>{{ $personalInfo->address }}</p>
    </div>

    <a href="{{ $userProfileLink->portfolio_link }}" class="contact-card" target="_blank">
      <i class="fa fa-globe"></i>
      <h4>Portfolio</h4>
      <p>{{ $userProfileLink->portfolio_link }}</p>
    </a>

    <a href="{{ $userProfileLink->linkedin }}" class="contact-card" target="_blank">
      <i class="fab fa-linkedin"></i>
      <h4>LinkedIn</h4>
      <p>{{ $userProfileLink->linkedin }}</p>
    </a>

  </div>
</section>




  <!-- footer -->
  <footer class="footer">
    <div class="footer-text text-white">
      <p>Copyright &copy; 2025 by UN | All rights Reserved</p>
    </div>
    <div class="footer-iconTop">
        <a href="#home"><i class="fa fa-arrow-up"></i></a>
    </div>

  </footer>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typed = new Typed('.multiple-text', {
                strings: {!! json_encode(explode(',', $userProfileLink->stack)) !!},
                typeSpeed: 100,
                backSpeed: 100,
                backDelay: 1000,
                loop: true
            });
        });
    </script>
@endpush
@push('styles')
    <style>
        .unBtnBlue {
            display: inline-block;
            box-shadow: 0 0 1rem var(--main-color);
            font-size: 1.6rem;
            color: var(--second-bg-color);
            letter-spacing: 0.1rem;
            font-weight: 600;
            margin-bottom: 4rem;
            cursor: pointer;
            padding: 1rem 2.8rem;
            background: var(--main-color);
            border-radius: 4rem;
            transition: 0.5s;
        }

        body {
            background: black !important;
        }

        .aimg {
            border-radius: 50%;
            border: 3px dashed var(--main-color);
            box-shadow: 0 0 20px rgba(0, 136, 255, 0.3), 0 0 10px var(--main-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 5px;
            background-color: white;
        }
        .aimg img{
          width: 250px;
        }

        .aimg:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(0, 136, 255, 0.6), 0 0 15px var(--main-color);
        }
        a{
          text-decoration: none !important;
        }
        
    </style>
@endpush
