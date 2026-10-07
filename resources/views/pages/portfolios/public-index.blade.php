<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Portfolios — UN Portfolio Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(160deg, #f7f3ee 0%, #e8eef5 100%); min-height: 100vh; font-family: Georgia, 'Times New Roman', serif; }
        .hero { padding: 4rem 0 2rem; }
        .hero h1 { font-size: clamp(2rem, 5vw, 3.2rem); letter-spacing: -0.02em; }
        .item { background: rgba(255,255,255,0.75); border: 1px solid rgba(0,0,0,0.06); padding: 1.25rem 1.5rem; margin-bottom: 1rem; }
        .item a { color: #1a1a1a; text-decoration: none; font-weight: 600; }
        .meta { color: #666; font-size: 0.9rem; font-family: system-ui, sans-serif; }
    </style>
</head>
<body>
<div class="container hero">
    <h1>Public Portfolios</h1>
    <p class="lead text-muted">Browse portfolios shared by our community.</p>

    @forelse($portfolios as $portfolio)
        <div class="item">
            <a href="{{ route('portfolios.public.show', $portfolio->slug) }}">{{ $portfolio->title }}</a>
            <div class="meta mt-1">
                by {{ $portfolio->user->name ?? 'Unknown' }}
                · {{ $portfolio->theme->name ?? 'Theme' }}
                @if($portfolio->personalInfo)
                    · {{ $portfolio->personalInfo->name }}
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">No public portfolios yet.</p>
    @endforelse

    <p class="mt-4">
        <a href="{{ route('auth.login') }}">Sign in</a> to create your own.
    </p>
</div>
</body>
</html>
