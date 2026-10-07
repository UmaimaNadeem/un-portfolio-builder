@extends(auth()->user()->isAdmin() ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="unMainContainer">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="mb-1">{{ auth()->user()->isAdmin() ? 'All Portfolios' : 'My Portfolios' }}</h1>
            <p class="text-muted mb-0">Create multiple portfolios and pick a theme for each.</p>
        </div>
        <a href="{{ route('portfolios.create') }}" class="btn btn-primary">Create Portfolio</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($portfolios->isEmpty())
        <div class="alert alert-info">No portfolios yet. Create your first one to get started.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle bg-white">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        @if(auth()->user()->isAdmin())
                            <th>Owner</th>
                        @endif
                        <th>Theme</th>
                        <th>Status</th>
                        <th>Public URL</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($portfolios as $portfolio)
                        <tr class="{{ session('active_portfolio_id') == $portfolio->id ? 'table-info' : '' }}">
                            <td>
                                <strong>{{ $portfolio->title }}</strong>
                                @if(session('active_portfolio_id') == $portfolio->id)
                                    <span class="badge bg-primary">Active</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge text-bg-light border">{{ $portfolio->typeLabel() }}</span>
                            </td>
                            @if(auth()->user()->isAdmin())
                                <td>{{ $portfolio->user->name ?? '—' }}</td>
                            @endif
                            <td>{{ $portfolio->theme->name ?? '—' }}</td>
                            <td>
                                <span class="badge bg-{{ $portfolio->status === 'public' ? 'success' : ($portfolio->status === 'private' ? 'secondary' : 'warning') }}">
                                    {{ ucfirst($portfolio->status) }}
                                </span>
                            </td>
                            <td>
                                @if($portfolio->status === 'public')
                                    <a href="{{ route('portfolios.public.show', $portfolio->slug) }}" target="_blank">/p/{{ $portfolio->slug }}</a>
                                @else
                                    <span class="text-muted">Private</span>
                                @endif
                            </td>
                            <td class="d-flex flex-wrap gap-1">
                                <form action="{{ route('portfolios.select', $portfolio) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-primary">Manage</button>
                                </form>
                                <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="{{ route('portfolios.preview', $portfolio) }}" class="btn btn-sm btn-outline-dark" target="_blank">Preview</a>
                                <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Delete this portfolio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
