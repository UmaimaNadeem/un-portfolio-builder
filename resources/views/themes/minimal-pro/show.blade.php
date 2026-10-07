<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $personalInfo->name ?? $portfolio->title }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0c0f14;
            --surface: #151a22;
            --ink: #f2efe8;
            --muted: #9aa3b2;
            --accent: #ff6b2c;
            --accent-soft: rgba(255, 107, 44, 0.16);
            --line: rgba(242, 239, 232, 0.1);
            --lift: 0 30px 70px rgba(0,0,0,0.45);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: 'Instrument Sans', sans-serif;
            background:
                radial-gradient(800px 420px at 80% -5%, rgba(255,107,44,0.18), transparent 55%),
                radial-gradient(700px 400px at 0% 30%, rgba(80,120,180,0.12), transparent 50%),
                linear-gradient(180deg, #0a0d12 0%, var(--bg) 40%, #10151d 100%);
            min-height: 100vh;
        }

        .world {
            max-width: 1080px;
            margin: 0 auto;
            padding: 1.5rem 1.25rem 4rem;
            perspective: 1600px;
        }

        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem;
        }
        .brand {
            font-size: 0.78rem; letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--muted); font-weight: 600;
        }
        .nav-pills a {
            color: var(--muted); text-decoration: none; margin-left: 1rem;
            font-size: 0.88rem; transition: color 0.2s;
        }
        .nav-pills a:hover { color: var(--accent); }

        .hero-slab {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 1.5rem;
            align-items: stretch;
            margin-bottom: 3rem;
            transform-style: preserve-3d;
        }
        .intro {
            background: linear-gradient(155deg, rgba(28,34,44,0.95), rgba(18,22,30,0.98));
            border: 1px solid var(--line);
            border-radius: 28px;
            padding: 2rem 2rem 2.2rem;
            box-shadow: var(--lift);
            transform: rotateY(4deg) rotateX(3deg);
            position: relative;
            overflow: hidden;
            animation: settle 8s ease-in-out infinite;
        }
        .intro::before {
            content: '';
            position: absolute; inset: auto -20% -40% 40%;
            height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,107,44,0.25), transparent 70%);
        }
        .role {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 0.8rem; font-weight: 600;
            margin-bottom: 1rem;
            position: relative;
        }
        h1 {
            font-family: 'Fraunces', serif;
            font-size: clamp(2.4rem, 5.5vw, 3.8rem);
            line-height: 1.02; margin: 0 0 0.85rem;
            letter-spacing: -0.03em; position: relative;
        }
        .lead {
            color: var(--muted); font-size: 1.05rem; max-width: 34rem;
            line-height: 1.65; margin: 0 0 1.4rem; position: relative;
        }
        .cta {
            display: inline-flex; align-items: center; gap: 0.45rem;
            background: var(--accent); color: #140c08;
            padding: 0.8rem 1.2rem; border-radius: 14px;
            font-weight: 700; text-decoration: none;
            box-shadow: 0 16px 40px rgba(255,107,44,0.35);
            position: relative;
            transition: transform 0.2s ease;
        }
        .cta:hover { transform: translateY(-2px); }

        .portrait-stack {
            position: relative;
            transform-style: preserve-3d;
            min-height: 320px;
        }
        .portrait {
            position: absolute; inset: 8% 6% 8% 6%;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid var(--line);
            background: var(--surface);
            box-shadow: var(--lift);
            transform: rotateY(-10deg) rotateX(6deg) translateZ(20px);
            animation: floatPortrait 6.5s ease-in-out infinite;
        }
        .portrait img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .portrait-fallback {
            width: 100%; height: 100%;
            display: grid; place-items: center;
            font-family: 'Fraunces', serif;
            font-size: 4rem; color: var(--accent);
            background: linear-gradient(145deg, #1a2030, #0f131a);
        }
        .iso-card {
            position: absolute;
            padding: 0.7rem 0.9rem;
            border-radius: 14px;
            background: rgba(21, 26, 34, 0.88);
            border: 1px solid var(--line);
            backdrop-filter: blur(10px);
            font-size: 0.78rem; font-weight: 600;
            box-shadow: 0 18px 40px rgba(0,0,0,0.4);
        }
        .iso-a { left: -4%; bottom: 14%; transform: translateZ(70px) rotate(-4deg); }
        .iso-b { right: -2%; top: 10%; transform: translateZ(90px) rotate(3deg); color: var(--accent); }

        .block { margin-bottom: 3rem; }
        .block h2 {
            font-family: 'Fraunces', serif;
            font-size: 1.55rem; margin: 0 0 1.15rem;
            letter-spacing: -0.02em;
        }

        .iso-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 1rem;
            transform-style: preserve-3d;
        }
        .tile {
            background: linear-gradient(165deg, rgba(28,34,44,0.95), rgba(16,20,28,0.98));
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 1.2rem;
            box-shadow: 0 18px 40px rgba(0,0,0,0.25);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            transform: translateZ(0);
        }
        .tile:hover {
            transform: translateY(-10px) rotateX(5deg) rotateY(-4deg) scale(1.01);
            border-color: rgba(255,107,44,0.35);
            box-shadow: 0 28px 60px rgba(0,0,0,0.4), 0 0 30px rgba(255,107,44,0.08);
        }
        .tile h3 { margin: 0 0 0.35rem; font-size: 1.05rem; font-weight: 650; }
        .tile .meta { color: var(--accent); font-size: 0.78rem; margin-bottom: 0.4rem; font-weight: 600; }
        .tile p { margin: 0; color: var(--muted); font-size: 0.9rem; line-height: 1.55; }
        .tile a { color: var(--accent); text-decoration: none; font-weight: 600; }
        .tile img {
            width: 100%; border-radius: 12px; margin-bottom: 0.8rem;
            aspect-ratio: 16/10; object-fit: cover;
        }

        .timeline { display: grid; gap: 0.85rem; }
        .timeline .tile { display: grid; grid-template-columns: 1fr; }

        .tags { display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .tags span {
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.03);
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            font-size: 0.82rem;
            transition: transform 0.2s, border-color 0.2s;
        }
        .tags span:hover { transform: translateY(-2px); border-color: var(--accent); }

        footer {
            margin-top: 2rem; padding-top: 1.5rem;
            border-top: 1px solid var(--line);
            color: var(--muted); font-size: 0.85rem;
        }

        @keyframes floatPortrait {
            0%, 100% { transform: rotateY(-10deg) rotateX(6deg) translateZ(20px) translateY(0); }
            50% { transform: rotateY(-8deg) rotateX(4deg) translateZ(28px) translateY(-10px); }
        }
        @keyframes settle {
            0%, 100% { transform: rotateY(4deg) rotateX(3deg) translateY(0); }
            50% { transform: rotateY(3deg) rotateX(2deg) translateY(-6px); }
        }

        @media (max-width: 820px) {
            .hero-slab { grid-template-columns: 1fr; }
            .intro, .portrait { transform: none; animation: none; }
            .portrait-stack { min-height: 280px; }
            .portrait { position: relative; inset: auto; }
            .iso-a, .iso-b { display: none; }
        }
    </style>
</head>
<body>
@php
    $displayName = $personalInfo->name ?? $portfolio->title;
    $ownerId = $owner->id ?? ($personalInfo->user_id ?? null);
    $typeLabel = method_exists($portfolio, 'typeLabel') ? $portfolio->typeLabel() : 'Professional';
@endphp

<div class="world">
    <div class="topbar">
        <div class="brand">{{ $portfolio->title }}</div>
        <div class="nav-pills">
            <a href="#experience">Experience</a>
            <a href="#projects">Work</a>
            <a href="#contact">Contact</a>
        </div>
    </div>

    <div class="hero-slab">
        <div class="intro">
            <div class="role">{{ $userProfileLink->stack ?? $typeLabel }}</div>
            <h1>{{ $displayName }}</h1>
            <p class="lead">{{ optional($userProfileLink)->overview ?? 'Selected work, experience, and background — presented with depth and clarity.' }}</p>
            @if($userProfileLink?->cv_resume)
                <a class="cta" href="{{ asset($userProfileLink->cv_resume) }}"><i class="fa-solid fa-arrow-down"></i> Download CV</a>
            @elseif($personalInfo?->email)
                <a class="cta" href="mailto:{{ $personalInfo->email }}"><i class="fa-solid fa-envelope"></i> Contact</a>
            @endif
        </div>
        <div class="portrait-stack">
            <div class="portrait">
                @if ($personalInfo?->profile_image && $ownerId)
                    <img src="{{ asset('content/' . $ownerId . '/profile/' . $personalInfo->profile_image) }}" alt="{{ $displayName }}">
                @else
                    <div class="portrait-fallback">{{ strtoupper(substr($displayName, 0, 1)) }}</div>
                @endif
            </div>
            <div class="iso-card iso-a"><i class="fa-solid fa-cube"></i> {{ $typeLabel }}</div>
            <div class="iso-card iso-b">Studio ready</div>
        </div>
    </div>

    <section class="block" id="experience">
        <h2>Experience</h2>
        <div class="timeline">
            @forelse($workExperiences as $work)
                <article class="tile">
                    <h3>{{ $work->job_title }} — {{ $work->company_name }}</h3>
                    <div class="meta">
                        {{ \Carbon\Carbon::parse($work->start_date)->format('M Y') }} –
                        {{ $work->end_date ? \Carbon\Carbon::parse($work->end_date)->format('M Y') : 'Present' }}
                    </div>
                    <p>{{ $work->description }}</p>
                </article>
            @empty
                <p style="color:var(--muted)">No experience added yet.</p>
            @endforelse
        </div>
    </section>

    <section class="block" id="projects">
        <h2>Projects</h2>
        <div class="iso-grid">
            @foreach($projects as $project)
                <article class="tile">
                    @if($project->media && \Illuminate\Support\Str::endsWith(strtolower($project->media), ['.jpg','.jpeg','.png','.webp']))
                        <img src="{{ asset($project->media) }}" alt="">
                    @endif
                    <h3>
                        @if($project->link)<a href="{{ $project->link }}" target="_blank">{{ $project->title }}</a>
                        @else{{ $project->title }}@endif
                    </h3>
                    <p>{{ $project->description }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="block">
        <h2>Services</h2>
        <div class="iso-grid">
            @foreach($services as $service)
                <article class="tile">
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->detail }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="block">
        <h2>Skills</h2>
        <div class="tags">
            @foreach($skills as $skill)
                <span>{{ $skill->name }}</span>
            @endforeach
        </div>
    </section>

    <section class="block">
        <h2>Education</h2>
        <div class="iso-grid">
            @foreach($educations as $edu)
                <article class="tile">
                    <h3>{{ $edu->degree }}</h3>
                    <div class="meta">{{ $edu->institution }}</div>
                    <p>{{ $edu->description }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="block" id="contact">
        <h2>Contact</h2>
        <div class="iso-grid">
            @if($personalInfo?->email)<article class="tile"><h3>Email</h3><p><a href="mailto:{{ $personalInfo->email }}">{{ $personalInfo->email }}</a></p></article>@endif
            @if($personalInfo?->phone)<article class="tile"><h3>Phone</h3><p>{{ $personalInfo->phone }}</p></article>@endif
            @if($personalInfo?->address)<article class="tile"><h3>Location</h3><p>{{ $personalInfo->address }}</p></article>@endif
            @if($userProfileLink?->linkedin)<article class="tile"><h3>LinkedIn</h3><p><a href="{{ $userProfileLink->linkedin }}" target="_blank">Profile</a></p></article>@endif
            @if($userProfileLink?->github)<article class="tile"><h3>GitHub</h3><p><a href="{{ $userProfileLink->github }}" target="_blank">Profile</a></p></article>@endif
        </div>
    </section>

    <footer>© {{ date('Y') }} {{ $displayName }} · UN Portfolio Builder</footer>
</div>
</body>
</html>
