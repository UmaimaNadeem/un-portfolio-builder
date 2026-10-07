@extends('layouts.app')

@section('title', 'Themes')
@section('page_title', 'Themes')
@section('page_subtitle', 'Visual systems members can pick for each portfolio')

@push('styles')
<style>
    .theme-card {
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 1.2rem;
        background: rgba(255,255,255,0.55);
        height: 100%;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .theme-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
    .theme-swatch {
        height: 88px;
        border-radius: 14px;
        margin-bottom: 1rem;
    }
    .swatch-classic { background: linear-gradient(135deg, #0b0f14, #1f2a37 50%, #00ffc8); }
    .swatch-modern { background: linear-gradient(145deg, #061820, #0d7377 45%, #7ee8fa); }
    .swatch-minimal { background: linear-gradient(145deg, #111827, #334155 40%, #f97316); }
</style>
@endpush

@section('content')
<div>
    <h1 class="display-font h3 mb-2">Themes</h1>
    <p class="muted mb-4">Users select one of these when creating or editing a portfolio.</p>

    <div class="row g-3">
        @foreach($themes as $theme)
            @php
                $swatch = match($theme->slug) {
                    'classic-dark' => 'swatch-classic',
                    'modern-light' => 'swatch-modern',
                    'minimal-pro' => 'swatch-minimal',
                    default => 'swatch-modern',
                };
            @endphp
            <div class="col-md-4">
                <div class="theme-card">
                    <div class="theme-swatch {{ $swatch }}"></div>
                    <h5 class="display-font mb-2">{{ $theme->name }}</h5>
                    <p class="muted small mb-2">{{ $theme->description }}</p>
                    <p class="mb-1 small"><code>{{ $theme->slug }}</code></p>
                    <p class="mb-2 small muted">Used by {{ $theme->portfolios_count }} portfolio(s)</p>
                    <span class="badge rounded-pill {{ $theme->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                        {{ $theme->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
