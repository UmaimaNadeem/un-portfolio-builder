@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page_title', 'Admin studio')
@section('page_subtitle', 'Users, portfolios, themes — one place to run the platform')

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
        background: linear-gradient(145deg, #1a2b2f 0%, #234e4a 55%, #e85d04 140%);
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
    }
    .hero-aside h3 {
        font-family: 'Syne', sans-serif;
        font-size: 1.25rem;
        margin: 0 0 0.4rem;
        position: relative;
    }
    .hero-aside p { opacity: 0.85; margin: 0 0 1rem; position: relative; font-size: 0.95rem; }
    .quick-links { display: flex; flex-wrap: wrap; gap: 0.45rem; position: relative; }
    .quick-links a {
        font-size: 0.72rem; font-weight: 600;
        padding: 0.3rem 0.6rem; border-radius: 999px;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.18);
        color: #fff; text-decoration: none;
    }
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
    .recent-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .recent-table th {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--muted);
        font-weight: 600;
        padding: 0.65rem 0.75rem;
        border-bottom: 1px solid var(--line);
    }
    .recent-table td {
        padding: 0.85rem 0.75rem;
        border-bottom: 1px solid var(--line);
        vertical-align: middle;
    }
    .recent-table tr:last-child td { border-bottom: 0; }
    .status-pill {
        display: inline-flex;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 999px;
        background: rgba(29, 106, 99, 0.1);
        color: var(--accent-2);
    }
    .status-pill.draft { background: rgba(179, 107, 0, 0.12); color: #b36b00; }
    .status-pill.private { background: rgba(90, 101, 112, 0.12); color: #5a6570; }
    @keyframes floatCard {
        0%, 100% { transform: perspective(900px) rotateY(-4deg) translateY(0); }
        50% { transform: perspective(900px) rotateY(-4deg) translateY(-6px); }
    }
    @media (max-width: 900px) {
        .dash-hero { grid-template-columns: 1fr; }
        .hero-aside { transform: none; animation: none; }
        .stat-strip { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')
<div class="dash-hero">
    <div class="dash-intro">
        <h1>Welcome, {{ $user->name }}</h1>
        <p>Oversee members, portfolios, and themes from the same studio language your customers use — with the controls only admins need.</p>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('portfolios.create') }}" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i> Create portfolio</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Manage users</a>
        </div>
    </div>
    <aside class="hero-aside">
        <h3>Platform controls</h3>
        <p>Users, themes, and public explore — keep the product healthy.</p>
        <div class="quick-links">
            <a href="{{ route('admin.users.index') }}">Users</a>
            <a href="{{ route('admin.themes.index') }}">Themes</a>
            <a href="{{ route('portfolios.index') }}">All portfolios</a>
            <a href="{{ route('portfolios.public') }}" target="_blank">Explore</a>
        </div>
    </aside>
</div>

<div class="stat-strip">
    <div class="stat">
        <div class="label">Users</div>
        <div class="value">{{ $stats['users'] }}</div>
    </div>
    <div class="stat">
        <div class="label">Members</div>
        <div class="value">{{ $stats['members'] }}</div>
    </div>
    <div class="stat">
        <div class="label">Portfolios</div>
        <div class="value">{{ $stats['portfolios'] }}</div>
    </div>
    <div class="stat">
        <div class="label">Public</div>
        <div class="value">{{ $stats['public_portfolios'] }}</div>
    </div>
</div>

<div class="section-head">
    <div>
        <h2>Recent portfolios</h2>
        <p class="muted mb-0 small">Latest activity across the platform.</p>
    </div>
    <a href="{{ route('portfolios.index') }}" class="btn btn-sm btn-ghost">View all</a>
</div>

<div class="table-responsive">
    <table class="recent-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Owner</th>
                <th>Theme</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentPortfolios as $portfolio)
                <tr>
                    <td><strong>{{ $portfolio->title }}</strong></td>
                    <td class="muted">{{ $portfolio->user->name ?? '—' }}</td>
                    <td class="muted">{{ $portfolio->theme->name ?? '—' }}</td>
                    <td>
                        <span class="status-pill {{ $portfolio->status }}">{{ ucfirst($portfolio->status) }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('portfolios.manage', $portfolio) }}" class="btn btn-sm btn-ghost">Manage</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="muted">No portfolios yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex flex-wrap gap-2 mt-4">
    <a href="{{ route('admin.themes.index') }}" class="btn btn-ghost">Themes ({{ $stats['themes'] }})</a>
    <a href="{{ route('portfolios.public') }}" class="btn btn-ghost" target="_blank">Explore public</a>
</div>
@endsection
