@extends('auth.layout')
@section('auth-title')
{{ __('Reset Password') }}
@endsection
@section('content')
        <form class="login-form p-3" method="POST" action="{{ route('password.update') }}">
        @csrf
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>{{ __('Reset Password') }}</h3>
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label class="control-label">{{ __('E-Mail') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="Email" required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  placeholder="Confirm Password" required autocomplete="new-password">
            </div>
            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>{{ __('Reset Password') }}</button>
            </div>
        </form>
@endsection
