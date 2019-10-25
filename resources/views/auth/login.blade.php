@extends('layouts.master')

@section('session-content')

<div class="page-single">
    <div class="container">
        <div class="row">
            <div class="col col-login mx-auto">
                <div class="text-center mb-6">
                    <img src="assets/images/brand/logo.png" class="h-6" alt="">
                </div>
                <form class="card" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card-body p-6">
                        <div class="card-title text-center">Login to your Account</div>
                        <div class="form-group">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            id="email" name="email"  placeholder="Enter email" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password
                                @if (Route::has('password.request'))
                                    <a class="float-right small" href="{{ route('password.request') }}">I forgot password</a>
                                @endif
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            id="password" name="password" placeholder="Password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <span class="custom-control-label">Remember me</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                        </div>
                        <div class="text-center text-muted mt-3">
                            Don't have account yet? <a href="{{ route('register') }}">Sign up</a>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
