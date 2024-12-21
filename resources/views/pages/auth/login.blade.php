@extends('layouts.guest')

@section('content')
    <div class="container-fluid unAuthContainer d-flex justify-content-center align-items-center min-vh-100">
        <div class="row d-flex justify-content-center align-items-center w-100">
            <div class="col-lg-4 col-md-8 bsMainContainer">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid bs-pet-logo mt-2" style="max-width: 250px;">
                </div>
                <div class="card unAuthCard">
                    <div class="card-header text-center">
                        <div class="bsgreen font-weight-bolder mt-4 text-left">
                            <h1>User Login</h1>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{Session::get('error')}}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('auth.login.process') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
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
        
                            <div class="text-center">
                                <button type="submit" class="btn bsBtnLogin w-100"><i class="fas fa-user"></i> Login</button>
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

@push('scripts')
@endpush

@push('custom-scripts')
@endpush
