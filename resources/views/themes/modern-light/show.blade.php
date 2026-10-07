<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $personalInfo->name ?? $portfolio->title }} — Portfolio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Sora:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #061820;
            --bg-2: #0a2430;
            --ink: #e8f4f6;
            --muted: #8fb0b8;
            --accent: #3ecfcf;
            --accent-2: #7ee8fa;
            --glass: rgba(14, 42, 52, 0.55);
            --line: rgba(126, 232, 250, 0.14);
            --glow: rgba(62, 207, 207, 0.35);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: 'Sora', sans-serif;
            background:
                radial-gradient(900px 500px at 15% -10%, rgba(62,207,207,0.22), transparent 55%),
                radial-gradient(700px 420px at 90% 10%, rgba(126,232,250,0.12), transparent 50%),
                linear-gradient(180deg, var(--bg) 0%, var(--bg-2) 45%, #07151c 100%);
            overflow-x: hidden;
        }
        .scene {
            perspective: 1400px;
            transform-style: preserve-3d;
        }
        .wrap { max-width: 1120px; margin: 0 auto; padding: 0 1.25rem 4rem; position: relative; z-index: 1; }

        .orb {
            position: fixed; border-radius: 50%; filter: blur(40px); pointer-events: none; z-index: 0;
            animation: drift 12s ease-in-out infinite;
        }
        .orb-a { width: 280px; height: 280px; top: 8%; left: -60px; background: rgba(62,207,207,0.22); }
        .orb-b { width: 360px; height: 360px; top: 40%; right: -100px; background: rgba(126,232,250,0.12); animation-delay: -4s; }

        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1.35rem 0 0.5rem; position: sticky; top: 0; z-index: 20;
            backdrop-filter: blur(12px);
        }
        .logo {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700; letter-spacing: -0.03em; font-size: 1.05rem;
        }
        nav .links a {
            color: var(--muted); text-decoration: none; margin-left: 1.1rem;
            font-size: 0.9rem; transition: color 0.2s ease;
        }
        nav .links a:hover { color: var(--accent-2); }

        .hero {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 2.5rem;
            align-items: center;
            padding: 3.5rem 0 4.5rem;
            min-height: min(78vh, 720px);
        }
        .hero-copy { transform: translateZ(40px); }
        .badge-3d {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.4rem 0.85rem; border-radius: 999px;
            background: rgba(62,207,207,0.12);
            border: 1px solid var(--line);
            color: var(--accent-2); font-size: 0.82rem; font-weight: 500;
            margin-bottom: 1.1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .hero h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2.6rem, 6vw, 4.4rem);
            line-height: 0.98; margin: 0 0 1rem;
            letter-spacing: -0.045em; font-weight: 700;
            text-shadow: 0 20px 60px rgba(0,0,0,0.35);
        }
        .hero p {
            color: var(--muted); font-size: 1.05rem; max-width: 34rem;
            line-height: 1.65; margin: 0 0 1.5rem;
        }
        .cta {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.85rem 1.35rem; border-radius: 14px;
            background: linear-gradient(135deg, var(--accent), #2bb8c4);
            color: #042028; font-weight: 600; text-decoration: none;
            box-shadow: 0 16px 40px var(--glow);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .cta:hover { transform: translateY(-3px); box-shadow: 0 22px 48px var(--glow); }

        .hero-stage {
            position: relative;
            transform-style: preserve-3d;
            animation: floatStage 7s ease-in-out infinite;
        }
        .plate {
            position: relative;
            border-radius: 28px;
            padding: 1rem;
            background: linear-gradient(160deg, rgba(20,55,68,0.85), rgba(8,28,36,0.9));
            border: 1px solid var(--line);
            box-shadow:
                0 40px 80px rgba(0,0,0,0.45),
                0 0 0 1px rgba(126,232,250,0.05) inset;
            transform: rotateY(-12deg) rotateX(8deg);
            transform-origin: center;
        }
        .plate img {
            width: 100%; aspect-ratio: 1; object-fit: cover;
            border-radius: 20px; display: block;
            box-shadow: 0 20px 50px rgba(0,0,0,0.35);
        }
        .plate-fallback {
            aspect-ratio: 1; border-radius: 20px;
            display: grid; place-items: center;
            background: linear-gradient(145deg, #0f3642, #1a5a66);
            font-family: 'Space Grotesk', sans-serif;
            font-size: 3rem; font-weight: 700; color: var(--accent-2);
        }
        .float-chip {
            position: absolute;
            padding: 0.65rem 0.9rem;
            border-radius: 14px;
            background: var(--glass);
            border: 1px solid var(--line);
            backdrop-filter: blur(10px);
            font-size: 0.8rem; font-weight: 500;
            box-shadow: 0 16px 40px rgba(0,0,0,0.3);
        }
        .chip-a { left: -12%; bottom: 18%; transform: translateZ(60px) rotateY(8deg); animation: bob 5s ease-in-out infinite; }
        .chip-b { right: -8%; top: 12%; transform: translateZ(80px); animation: bob 6s ease-in-out infinite reverse; }

        section { padding: 3.5rem 0; }
        .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            letter-spacing: -0.03em; margin: 0 0 1.5rem;
        }

        .deck {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            transform-style: preserve-3d;
        }
        .card-3d {
            background: var(--glass);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 1.25rem;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.22);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            transform: translateZ(0);
        }
        .card-3d:hover {
            transform: translateY(-8px) rotateX(4deg) rotateY(-3deg);
            border-color: rgba(126,232,250,0.35);
            box-shadow: 0 28px 60px rgba(0,0,0,0.35), 0 0 40px rgba(62,207,207,0.12);
        }
        .card-3d h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem; margin: 0 0 0.45rem; letter-spacing: -0.02em;
        }
        .card-3d p { color: var(--muted); margin: 0; font-size: 0.92rem; line-height: 1.55; }
        .card-3d .meta { color: var(--accent); font-size: 0.8rem; margin-bottom: 0.4rem; }
        .card-3d img { width: 100%; border-radius: 14px; margin-bottom: 0.85rem; aspect-ratio: 16/10; object-fit: cover; }
        .card-3d a { color: var(--accent-2); text-decoration: none; font-weight: 500; }

        .skills { display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .skills span {
            padding: 0.45rem 0.8rem; border-radius: 999px;
            background: rgba(62,207,207,0.1); border: 1px solid var(--line);
            font-size: 0.85rem; color: var(--ink);
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .skills span:hover { transform: translateY(-2px); background: rgba(62,207,207,0.2); }

        footer {
            padding: 2.5rem 0 1rem; color: var(--muted); font-size: 0.85rem;
            border-top: 1px solid var(--line); margin-top: 1rem;
        }

        @keyframes floatStage {
            0%, 100% { transform: translateY(0) rotateX(0); }
            50% { transform: translateY(-12px) rotateX(2deg); }
        }
        @keyframes bob {
            0%, 100% { translate: 0 0; }
            50% { translate: 0 -10px; }
        }
        @keyframes drift {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 20px); }
        }

        @media (max-width: 860px) {
            .hero { grid-template-columns: 1fr; min-height: auto; padding-top: 2rem; }
            .plate { transform: none; }
            .hero-stage { animation: none; max-width: 320px; margin: 0 auto; }
            .chip-a, .chip-b { display: none; }
            nav .links a { margin-left: 0.7rem; font-size: 0.8rem; }
        }
    </style>
</head>
<body>
@php
    $displayName = $personalInfo->name ?? $portfolio->title;
    $ownerId = $owner->id ?? ($personalInfo->user_id ?? null);
    $typeLabel = method_exists($portfolio, 'typeLabel') ? $portfolio->typeLabel() : 'Professional';
@endphp
<div class="orb orb-a"></div>
<div class="orb orb-b"></div>

<div class="scene">
<div class="wrap">
    <nav>
        <div class="logo">{{ $portfolio->title }}</div>
        <div class="links">
            <a href="#work">Work</a>
            <a href="#projects">Projects</a>
            <a href="#skills">Skills</a>
            <a href="#contact">Contact</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-copy">
            <div class="badge-3d"><i class="fa-solid fa-cube"></i> {{ $userProfileLink->stack ?? $typeLabel }}</div>
            <h1>{{ $displayName }}</h1>
            <p>{{ optional($userProfileLink)->overview ?? 'A dimensional showcase of experience, craft, and selected work — built for the modern web.' }}</p>
            @if($userProfileLink?->cv_resume)
                <a class="cta" href="{{ asset($userProfileLink->cv_resume) }}"><i class="fa-solid fa-download"></i> Download CV</a>
            @elseif($personalInfo?->email)
                <a class="cta" href="mailto:{{ $personalInfo->email }}"><i class="fa-solid fa-paper-plane"></i> Get in touch</a>
            @endif
        </div>
        <div class="hero-stage">
            <div class="plate">
                @if ($personalInfo?->profile_image && $ownerId)
                    <img src="{{ asset('content/' . $ownerId . '/profile/' . $personalInfo->profile_image) }}" alt="{{ $displayName }}">
                @else
                    <div class="plate-fallback">{{ strtoupper(substr($displayName, 0, 1)) }}</div>
                @endif
            </div>
            <div class="float-chip chip-a"><i class="fa-solid fa-layer-group"></i> {{ $typeLabel }}</div>
            <div class="float-chip chip-b"><i class="fa-solid fa-sparkles"></i> Available</div>
        </div>
    </header>

    <section id="work">
        <h2 class="section-title">Experience</h2>
        <div class="deck">
            @forelse($workExperiences as $work)
                <article class="card-3d">
                    <div class="meta">{{ $work->company_name }}</div>
                    <h3>{{ $work->job_title }}</h3>
                    <p>{{ $work->description }}</p>
                </article>
            @empty
                <p style="color:var(--muted)">No experience added yet.</p>
            @endforelse
        </div>
    </section>

    <section id="services">
        <h2 class="section-title">Services</h2>
        <div class="deck">
            @forelse($services as $service)
                <article class="card-3d">
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->detail }}</p>
                </article>
            @empty
                <p style="color:var(--muted)">No services listed yet.</p>
            @endforelse
        </div>
    </section>

    <section id="skills">
        <h2 class="section-title">Skills</h2>
        <div class="skills">
            @foreach($skills as $skill)
                <span>{{ $skill->name }}</span>
            @endforeach
        </div>
    </section>

    <section id="projects">
        <h2 class="section-title">Projects</h2>
        <div class="deck">
            @foreach($projects as $project)
                <article class="card-3d">
                    @if($project->media && \Illuminate\Support\Str::endsWith(strtolower($project->media), ['.jpg','.jpeg','.png','.webp']))
                        <img src="{{ asset($project->media) }}" alt="">
                    @endif
                    <h3>{{ $project->title }}</h3>
                    <p>{{ $project->description }}</p>
                    @if($project->link)<p style="margin-top:.75rem"><a href="{{ $project->link }}" target="_blank">View project →</a></p>@endif
                </article>
            @endforeach
        </div>
    </section>

    <section id="education">
        <h2 class="section-title">Education</h2>
        <div class="deck">
            @foreach($educations as $edu)
                <article class="card-3d">
                    <h3>{{ $edu->degree }}</h3>
                    <p>{{ $edu->institution }}</p>
                    <p style="margin-top:.5rem">{{ $edu->description }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section id="contact">
        <h2 class="section-title">Contact</h2>
        <div class="deck">
            @if($personalInfo?->email)<article class="card-3d"><h3>Email</h3><p><a href="mailto:{{ $personalInfo->email }}">{{ $personalInfo->email }}</a></p></article>@endif
            @if($personalInfo?->phone)<article class="card-3d"><h3>Phone</h3><p>{{ $personalInfo->phone }}</p></article>@endif
            @if($personalInfo?->address)<article class="card-3d"><h3>Location</h3><p>{{ $personalInfo->address }}</p></article>@endif
            @if($userProfileLink?->linkedin)<article class="card-3d"><h3>LinkedIn</h3><p><a href="{{ $userProfileLink->linkedin }}" target="_blank">Profile</a></p></article>@endif
            @if($userProfileLink?->github)<article class="card-3d"><h3>GitHub</h3><p><a href="{{ $userProfileLink->github }}" target="_blank">Profile</a></p></article>@endif
        </div>
    </section>

    <footer>© {{ date('Y') }} {{ $displayName }} · Powered by UN Portfolio Builder</footer>
</div>
</div>
</body>
</html>
