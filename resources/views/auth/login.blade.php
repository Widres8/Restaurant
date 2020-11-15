@extends('auth.layout') @section('content')
<div class="auth">
    <div class="auth-container">
        <div class="card">
            <header class="auth-header">
                <h1 class="auth-title">
                    {{-- <div class="logo" style="width: 55px; height: 85px;">
                        <img class="" src="{{ asset('images/logo.png') }}" alt="" srcset="">
                    </div> --}}
                    {{ config('app.name', 'Asha Victoria Enterprises') }}
                </h1>
            </header>
            <div class="auth-content">
                <p class="text-center">{{ __('Login') }}</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="username">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control underlined {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Digite su Email" required autofocus> @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span> @endif
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" class="form-control underlined {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Contraseña" required> @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span> @endif
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">
                            {{ __('Login') }}
                        </button>
                        <a class="forgot-btn pull-right" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }} </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
