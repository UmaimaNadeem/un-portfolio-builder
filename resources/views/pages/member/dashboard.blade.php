@extends('layouts.member')

@section('title', 'Dashboard')
@section('page_title', 'Your studio')
@section('page_subtitle', 'Craft, publish, and grow portfolios for every craft')

@push('styles')
<style>
    .dash-hero {
        display: grid;
        grid-template-columns: 1.4fr 0.9fr;
        gap: 1.5rem;
        margin-bottom: 1.75rem;
        align-items: stretch;
    }
    .dash-intro h1 {
        font-family: 'Syne', sans-serif;
        font-size: clamp(1.8rem, 3vw, 2.55rem);
        font-weight: 800;
        letter-spacing: -0.04em;
        margin: 0 0 0.55rem;
        line-height: 1.08;
    }
    .dash-intro p { color: var(--muted); max-width: 36rem; margin-bottom: 1.25rem; }
    .stat-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.75rem;
    }
    .stat {
        padding: 1rem 1.1rem;
        border-radius: 18px;
        border: 1px solid var(--line);
        background: rgba(255,255,255,0.55);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .stat:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
    .stat .label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted); }
    .stat .value { font-family: 'Syne', sans-serif; font-size: 1.7rem; font-weight: 700; margin-top: 0.2rem; }
    .hero-aside {
        border-radius: 22px;
        padding: 1.35rem;
        color: #fff;
        background:
            linear-gradient(145deg, #1a2b2f 0%, #234e4a 55%, #e85d04 140%);
        position: relative;
        overflow: hidden;
        min-height: 180px;
        box-shadow: 0 22px 50px rgba(29, 106, 99, 0.28);
        transform: perspective(900px) rotateY(-4deg);
        transform-origin: left center;
        animation: floatCard 5.5s ease-in-out infinite;
    }
    .hero-aside::before {
        content: '';
        position: absolute; inset: auto -20% -30% 30%;
        height: 160px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.22), transparent 70%);
        filter: blur(2px);
    }
    .hero-aside h3 {
        font-family: 'Syne', sans-serif;
        font-size: 1.25rem;
        margin: 0 0 0.4rem;
        position: relative;
    }
    .hero-aside p { opacity: 0.85; margin: 0 0 1rem; position: relative; font-size: 0.95rem; }
    .section-head {
        display: flex; justify-content: space-between; align-items: end;
        gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;
    }
    .section-head h2 {
        font-family: 'Syne', sans-serif;
        font-size: 1.35rem;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .folio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1rem;
    }
    .folio-card {
        position: relative;
        border-radius: 20px;
        padding: 1.2rem;
        border: 1px solid var(--line);
        background: linear-gradient(165deg, rgba(255,255,255,0.9), rgba(255,252,247,0.7));
        box-shadow: 0 10px 30px rgba(15,20,25,0.04);
        transition: transform 0.28s ease, box-shadow 0.28s ease;
        overflow: hidden;
        min-height: 210px;
        display: flex; flex-direction: column;
    }
    .folio-card::after {
        content: '';
        position: absolute; right: -30px; top: -30px;
        width: 110px; height: 110px; border-radius: 28px;
        background: linear-gradient(135deg, rgba(232,93,4,0.18), rgba(29,106,99,0.12));
        transform: rotate(18deg);
        transition: transform 0.35s ease;
    }
    .folio-card:hover {
        transform: translateY(-6px) rotateX(2deg);
        box-shadow: 0 22px 48px rgba(15,20,25,0.1);
    }
    .folio-card:hover::after { transform: rotate(28deg) scale(1.08); }
    .folio-card.active {
        border-color: rgba(232, 93, 4, 0.45);
        box-shadow: 0 0 0 3px rgba(232, 93, 4, 0.12), var(--shadow);
    }
    .type-chip {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.75rem; font-weight: 600;
        padding: 0.28rem 0.65rem; border-radius: 999px;
        background: rgba(29, 106, 99, 0.1); color: var(--accent-2);
        margin-bottom: 0.7rem; position: relative; z-index: 1;
        width: fit-content;
    }
    .folio-card h3 {
        font-family: 'Syne', sans-serif;
        font-size: 1.15rem;
        margin: 0 0 0.35rem;
        position: relative; z-index: 1;
        letter-spacing: -0.02em;
    }
    .folio-meta { color: var(--muted); font-size: 0.88rem; position: relative; z-index: 1; margin-bottom: auto; }
    .folio-actions {
        display: flex; flex-wrap: wrap; gap: 0.4rem;
        margin-top: 1rem; position: relative; z-index: 1;
    }
    .status-dot {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.78rem; font-weight: 600;
    }
    .status-dot i { font-size: 0.55rem; }
    .status-public { color: #1d6a63; }
    .status-draft { color: #b36b00; }
    .status-private { color: #5a6570; }
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        border-radius: 20px;
        border: 1px dashed rgba(15,20,25,0.15);
        background: rgba(255,255,255,0.4);
    }
    .empty-state .orb {
        width: 72px; height: 72px; margin: 0 auto 1rem;
        border-radius: 24px;
        display: grid; place-items: center;
        background: linear-gradient(135deg, #1d6a63, #e85d04);
        color: #fff; font-size: 1.6rem;
        box-shadow: 0 18px 40px rgba(29,106,99,0.3);
        animation: floatCard 4s ease-in-out infinite;
    }
    .type-preview {
        display: flex; flex-wrap: wrap; gap: 0.45rem; margin-top: 1rem;
    }
    .type-preview span {
        font-size: 0.72rem; font-weight: 600;
        padding: 0.3rem 0.6rem; border-radius: 999px;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.18);
    }
    @keyframes floatCard {
        0%, 100% { transform: perspective(900px) rotateY(-4deg) translateY(0); }
        50% { transform: perspective(900px) rotateY(-4deg) translateY(-6px); }
    }
    @media (max-width: 900px) {
        .dash-hero { grid-template-columns: 1fr; }
        .hero-aside, .hero-aside, .stat:hover { transform: none; animation: none; }
        .stat-strip { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')
<div class="dash-hero">
    <div class="dash-intro">
        <h1>Welcome back, {{ $user->name }}</h1>
        <p>Build designer, developer, SEO, QA, and niche portfolios from one studio. Pick a type, choose a theme, and publish a site that feels current.</p>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('portfolios.create') }}" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i> Create portfolio</a>
            <a href="{{ route('portfolios.public') }}" class="btn btn-ghost" target="_blank">Explore public work</a>
        </div>
    </div>
    <aside class="hero-aside">
        <h3>Craft for every field</h3>
        <p>One account. Many portfolio types. Match your site to how clients hire.</p>
        <div class="type-preview">
            <span>Developer</span><span>Designer</span><span>SEO</span><span>SQA</span>
            <span>Marketing</span><span>Product</span>
        </div>
    </aside>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 mb-4">{{ session('success') }}</div>
@endif

<div class="stat-strip">
    <div class="stat">
        <div class="label">Portfolios</div>
        <div class="value">{{ $stats['total'] }}</div>
    </div>
    <div class="stat">
        <div class="label">Live</div>
        <div class="value">{{ $stats['public'] }}</div>
    </div>
    <div class="stat">
        <div class="label">Drafts</div>
        <div class="value">{{ $stats['draft'] }}</div>
    </div>
    <div class="stat">
        <div class="label">Types used</div>
        <div class="value">{{ $stats['types'] }}</div>
    </div>
</div>

<div class="section-head">
    <div>
        <h2>Your portfolios</h2>
        <p class="muted mb-0 small">Open a portfolio to manage content, theme, and visibility.</p>
    </div>
    <a href="{{ route('portfolios.create') }}" class="btn btn-sm btn-ghost">New portfolio</a>
</div>

@if($portfolios->isEmpty())
    <div class="empty-state">
        <div class="orb"><i class="bi bi-stars"></i></div>
        <h3 class="display-font h4">Start your first portfolio</h3>
        <p class="muted mx-auto" style="max-width:28rem">Choose a field — designer, developer, SEO, SQA, and more — then pick a modern theme and fill in your story.</p>
        <a href="{{ route('portfolios.create') }}" class="btn btn-accent mt-2">Create portfolio</a>
    </div>
@else
    <div class="folio-grid">
        @foreach($portfolios as $portfolio)
            @php $meta = $portfolio->typeMeta(); @endphp
            <article class="folio-card {{ $activePortfolioId == $portfolio->id ? 'active' : '' }}">
                <div class="type-chip"><i class="bi {{ $meta['icon'] }}"></i> {{ $meta['label'] }}</div>
                <h3>{{ $portfolio->title }}</h3>
                <div class="folio-meta">
                    {{ $portfolio->theme->name ?? 'No theme' }}
                    ·
                    <span class="status-dot status-{{ $portfolio->status }}">
                        <i class="bi bi-circle-fill"></i>{{ ucfirst($portfolio->status) }}
                    </span>
                    @if($activePortfolioId == $portfolio->id)
                        · <strong>Active</strong>
                    @endif
                </div>
                <div class="folio-actions">
                    <form action="{{ route('portfolios.select', $portfolio) }}" method="POST" class="m-0">
                        @csrf
                        <button class="btn btn-sm btn-accent">Manage</button>
                    </form>
                    <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-sm btn-ghost">Settings</a>
                    @if($portfolio->status === 'public')
                        <a href="{{ route('portfolios.public.show', $portfolio->slug) }}" class="btn btn-sm btn-ghost" target="_blank">View</a>
                    @else
                        <a href="{{ route('portfolios.preview', $portfolio) }}" class="btn btn-sm btn-ghost" target="_blank">Preview</a>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
