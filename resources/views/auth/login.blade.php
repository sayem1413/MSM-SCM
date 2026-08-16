@extends('auth.layout')
@section('auth-title')
Login
@endsection
@section('content')
        <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
            <div class="form-group">
            <label class="control-label">{{ __('E-Mail') }}</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            </div>
            <div class="form-group">
            <label class="control-label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            </div>
            <div class="form-group">
            <div class="utility">
                <div class="animated-checkbox">
                <label>
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span class="label-text">{{ __('Remember Me') }}</span>
                </label>
                </div>
                <p class="semibold-text mb-2"><a href="{{ route('password.request') }}">Forgot Password ?</a></p>
            </div>
            </div>
            <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
            </div>
        </form>
@endsection
