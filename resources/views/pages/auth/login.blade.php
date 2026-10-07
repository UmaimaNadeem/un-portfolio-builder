@extends('layouts.guest')

@section('title', 'Sign in — UN Portfolio')

@section('content')
<div class="auth-shell">
    <aside class="auth-visual">
        <div class="brand">
            <div class="brand-mark"><i class="bi bi-layers-half"></i></div>
            UN Portfolio
        </div>
        <div class="visual-copy">
            <h1>Build portfolios that get you hired.</h1>
            <p>Designer, developer, SEO, QA, and more — pick a type, choose a modern theme, and publish in minutes.</p>
        </div>
        <div class="visual-copy" style="opacity:.7;font-size:.85rem;">Digital studio for modern creators</div>
    </aside>

    <div class="auth-panel">
        <div class="auth-card">
            <h2>Welcome back</h2>
            <p class="sub">Sign in to your studio workspace.</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('auth.login.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="you@studio.com" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                        <span class="input-group-text" data-toggle-password="password"><i class="bi bi-eye-slash"></i></span>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                    <label class="form-check-label" for="remember" style="color:var(--muted);font-size:.9rem;">Remember me</label>
                </div>
                <button type="submit" class="btn btn-auth">Sign in</button>
            </form>

            <div class="auth-foot">
                New here? <a href="{{ route('auth.register') }}">Create an account</a>
            </div>
        </div>
    </div>
</div>
@endsection
