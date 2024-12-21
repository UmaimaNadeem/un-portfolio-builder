@extends('layouts.guest')

@section('content')
<div class="container-fluid unAuthContainer d-flex justify-content-center align-items-center min-vh-100 ">
    <div class="row d-flex justify-content-center align-items-center w-100">
        <div class="col-lg-4 col-md-8 bsMainContainer">
            <div class="card unAuthCard">
                <div class="card-header text-center">
                    <img src="{{ asset('assets/img/dark-logo.png') }}" alt="Logo" class="img-fluid bs-pet-logo mt-2" style="max-width: 100px;">
                    <div class="bsgreen font-weight-bolder mt-4 text-left">
                        <h1>User Registration</h1>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile_number">Mobile</label>
                                    <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span class="input-group-text" id="toggle-password">
                                    <i class="fas fa-eye-slash" id="password-toggle-icon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                                <span class="input-group-text" id="toggle-confirm-password">
                                    <i class="fas fa-eye-slash" id="confirm-password-toggle-icon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn bsBtnLogin w-100"><i class="fas fa-user-plus"></i> Register</button>
                        </div>
                        <div class="mt-3 text-center">
                            <p class="text-white">Back to <a href="{{ route('auth.login') }}" class="bsTextPrimary font-weight-bold">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('custom-scripts')

@endpush

@push('scripts')
@endpush
