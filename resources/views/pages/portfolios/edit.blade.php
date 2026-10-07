@extends(auth()->user()->isAdmin() ? 'layouts.app' : 'layouts.member')

@section('title', 'Edit Portfolio')
@section('page_title', 'Portfolio settings')
@section('page_subtitle', 'Update type, theme, and visibility')

@push('styles')
<style>
    .type-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 0.75rem;
    }
    .type-option { position: relative; }
    .type-option input { position: absolute; opacity: 0; pointer-events: none; }
    .type-option label {
        display: block; height: 100%;
        padding: 1rem 0.9rem;
        border-radius: 16px;
        border: 1px solid rgba(15,20,25,0.1);
        background: rgba(255,255,255,0.65);
        cursor: pointer;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .type-option label i { font-size: 1.25rem; color: #1d6a63; display: block; margin-bottom: 0.45rem; }
    .type-option label strong { display: block; font-size: 0.92rem; margin-bottom: 0.2rem; }
    .type-option label span { font-size: 0.75rem; color: #5a6570; line-height: 1.35; display: block; }
    .type-option input:checked + label {
        border-color: #e85d04;
        box-shadow: 0 0 0 3px rgba(232,93,4,0.15);
        transform: translateY(-2px);
        background: #fff;
    }
    .theme-option { position: relative; }
    .theme-option input { position: absolute; opacity: 0; }
    .theme-option label {
        display: block; height: 100%;
        padding: 1.1rem;
        border-radius: 16px;
        border: 1px solid rgba(15,20,25,0.1);
        background: rgba(255,255,255,0.65);
        cursor: pointer;
    }
    .theme-option input:checked + label {
        border-color: #1d6a63;
        box-shadow: 0 0 0 3px rgba(29,106,99,0.15);
    }
    .preview-swatch { height: 72px; border-radius: 12px; margin-bottom: 0.75rem; }
    .swatch-classic { background: linear-gradient(135deg, #0b0f14, #1f2a37 50%, #00ffc8); }
    .swatch-modern { background: linear-gradient(145deg, #061820, #0d7377 45%, #7ee8fa); }
    .swatch-minimal { background: linear-gradient(145deg, #111827, #334155 40%, #f97316); }
    .btn-accent {
        background: linear-gradient(135deg, #e85d04, #ff9f1c); border: 0; color: #fff;
        font-weight: 600; border-radius: 14px; padding: 0.65rem 1.15rem;
    }
    .btn-accent:hover { color: #fff; filter: brightness(1.05); }
    .btn-ghost {
        border: 1px solid rgba(15,20,25,0.12); background: rgba(255,255,255,0.55);
        color: #0f1419; border-radius: 14px; font-weight: 600;
    }
</style>
@endpush

@section('content')
<div>
    <h1 class="mb-3" style="font-family:'Syne',sans-serif;letter-spacing:-0.03em;font-weight:800;">Edit Portfolio</h1>

    @if($errors->any())
        <div class="alert alert-danger rounded-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('portfolios.update', $portfolio) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="form-label fw-semibold">Title</label>
            <input type="text" name="title" class="form-control form-control-lg rounded-3" value="{{ old('title', $portfolio->title) }}" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold mb-2">Portfolio type</label>
            <div class="type-grid">
                @foreach(\App\Models\Portfolio::TYPES as $key => $meta)
                    <div class="type-option">
                        <input type="radio" name="type" id="type-{{ $key }}" value="{{ $key }}"
                            @checked(old('type', $portfolio->type ?? 'developer') === $key) required>
                        <label for="type-{{ $key }}">
                            <i class="bi {{ $meta['icon'] }}"></i>
                            <strong>{{ $meta['label'] }}</strong>
                            <span>{{ $meta['blurb'] }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Slug</label>
                <input type="text" name="slug" class="form-control rounded-3" value="{{ old('slug', $portfolio->slug) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select rounded-3" required>
                    @foreach(['draft', 'private', 'public'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $portfolio->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <h5 class="fw-semibold mb-3">Theme</h5>
        <div class="row g-3 mb-4">
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
                    <div class="theme-option">
                        <input type="radio" name="theme_id" id="theme-{{ $theme->id }}" value="{{ $theme->id }}"
                            @checked(old('theme_id', $portfolio->theme_id) == $theme->id) required>
                        <label for="theme-{{ $theme->id }}">
                            <div class="preview-swatch {{ $swatch }}"></div>
                            <strong>{{ $theme->name }}</strong>
                            <p class="small text-muted mb-0 mt-1">{{ $theme->description }}</p>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-accent">Save changes</button>
            <a href="{{ route('portfolios.manage', $portfolio) }}" class="btn btn-ghost">Back</a>
        </div>
    </form>
</div>
@endsection
