<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Administration</title>

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">

</head>
<body>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <div class="logo">
            <h1>Admin Login</h1>
        </div>
        <div class="login-box">
            <form class="login-form" method="POST" action="{{ route('admin.login') }}">
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
                    <!-- <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p> -->
                    <p class="semibold-text mb-2"><a href="{{ route('admin_password_request') }}">Forgot Password ?</a></p>
                </div>
                </div>
                <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
                </div>
            </form>
            <!-- <form class="forget-form" method="POST" action="{{ route('admin_password_email') }}">
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
                <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
                </div>
            </form> -->
        </div>
    </section>

    <!-- Essential javascripts for application to work-->
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <!-- <script type="text/javascript">
        // Login Page Flipbox control
        $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
        });
    </script> -->
    
</body>
</html>