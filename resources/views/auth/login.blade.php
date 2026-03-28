@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-0">
                            <!-- Github -->
                            <div class="col-md-6 offset-md-4 mt-2">
                                <a class="btn btn-dark d-flex align-items-center justify-content-center gap-2" href="{{ route('auth.github') }}">
                                    <svg width="20" height="20" fill="white" viewBox="0 0 16 16">
                                        <path d="M8 0C3.58 0 0 3.58 0 8a8.003 8.003 0 0 0 5.47 7.59c.4.07.55-.17.55-.38
                                        0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13
                                        -.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87
                                        2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95
                                        0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12
                                        0 0 .67-.21 2.2.82a7.65 7.65 0 0 1 2-.27c.68 0 1.36.09 2 .27
                                        1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12
                                        .51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95
                                        .29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2
                                        0 .21.15.46.55.38A8.003 8.003 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                    </svg>
                                    Login with GitHub
                                </a>
                            </div>

                            <!-- Facebook -->
                            <div class="col-md-6 offset-md-4 mt-2">
                                <a class="btn text-white d-flex align-items-center justify-content-center gap-2"
                                href="{{ route('auth.facebook') }}"
                                style="background-color: #1877F2;">
                                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                                        <path d="M22 12a10 10 0 1 0-11.63 9.88v-6.99H7.9V12h2.47V9.8
                                        c0-2.43 1.45-3.77 3.67-3.77 1.06 0 2.17.19 2.17.19v2.39h-1.22
                                        c-1.2 0-1.57.75-1.57 1.52V12h2.67l-.43 2.89h-2.24v6.99A10
                                        10 0 0 0 22 12z"/>
                                    </svg>
                                    Login with Facebook
                                </a>
                            </div>

                            <!-- Google -->
                            <div class="col-md-6 offset-md-4 mt-2">
                                <a class="btn btn-light border d-flex align-items-center justify-content-center gap-2"
                                href="{{ route('auth.google') }}">
                                    <svg width="20" height="20" viewBox="0 0 48 48">
                                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.7 1.22 9.2 3.6l6.9-6.9C35.8 2.4 30.3 0 24 0 14.6 0 6.5 5.4 2.6 13.3l8.1 6.3C12.6 13 17.9 9.5 24 9.5z"/>
                                        <path fill="#34A853" d="M46.5 24.5c0-1.6-.1-3.2-.4-4.7H24v9h12.7c-.6 3-2.3 5.6-4.9 7.3l7.5 5.8c4.4-4 7.2-9.9 7.2-17.4z"/>
                                        <path fill="#FBBC05" d="M10.7 28.6c-.5-1.5-.8-3-.8-4.6s.3-3.1.8-4.6l-8.1-6.3C.9 16.1 0 20 0 24s.9 7.9 2.6 11l8.1-6.4z"/>
                                        <path fill="#4285F4" d="M24 48c6.3 0 11.6-2.1 15.5-5.7l-7.5-5.8c-2.1 1.4-4.8 2.3-8 2.3-6.1 0-11.4-3.5-13.3-8.6l-8.1 6.3C6.5 42.6 14.6 48 24 48z"/>
                                    </svg>
                                    Login with Google
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection