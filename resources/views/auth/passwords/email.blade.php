@extends('auth.layout')
@section('auth-title')
{{ __('Send Password Reset Link') }}
@endsection
@section('content')
<form class="login-form" method="POST" action="{{ route('password.email') }}">
    @csrf
    <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <p> Password change request link sent! </p>
        </div>
    @endif
    <div class="form-group">
        <label class="control-label">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group btn-container">
    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>{{ __('Send Password Reset Link') }}</button>
    </div>
    <div class="form-group mt-3">
    <p class="semibold-text mb-0"><a href="{{ route('login') }}" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
    </div>
</form>
@endsection
