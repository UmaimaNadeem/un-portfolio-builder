@extends('layouts.guest')

@section('title', 'Create account — UN Portfolio')

@section('content')
<div class="auth-shell">
    <aside class="auth-visual">
        <div class="brand">
            <div class="brand-mark"><i class="bi bi-layers-half"></i></div>
            UN Portfolio
        </div>
        <div class="visual-copy">
            <h1>Your craft. Your type. Your site.</h1>
            <p>Join and launch portfolios for design, engineering, SEO, SQA, marketing, and every niche in between.</p>
        </div>
        <div class="visual-copy" style="opacity:.7;font-size:.85rem;">Free to start · Publish when ready</div>
    </aside>

    <div class="auth-panel">
        <div class="auth-card">
            <h2>Create account</h2>
            <p class="sub">Set up your studio in under a minute.</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.register.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">Full name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="mobile_number">Mobile</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <span class="input-group-text" data-toggle-password="password"><i class="bi bi-eye-slash"></i></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="confirmPassword">Confirm password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                        <span class="input-group-text" data-toggle-password="confirmPassword"><i class="bi bi-eye-slash"></i></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-auth">Create account</button>
            </form>

            <div class="auth-foot">
                Already have an account? <a href="{{ route('auth.login') }}">Sign in</a>
            </div>
        </div>
    </div>
</div>
@endsection
