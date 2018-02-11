<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>

    <title>Omnilife</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/login.css') }}"/>

</head>
<body>

<div class="login-container">

    <div class="login-box animated fadeInDown">
        <div class="login-logo"></div>
        <div class="login-body">
            <div class="login-title"><strong>@lang('login.welcome')</strong>, @lang('login.message')</div>
            <form action="{{ route('login') }}" class="form-horizontal" method="POST">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input type="email" name="email" class="form-control" required="required" autofocus="autofocus" value="{{ old('email') }}" placeholder="@lang('login.email')"/>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input type="password" name="password" class="form-control" required="required" placeholder="@lang('login.pass')"/>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-link btn-block">@lang('login.remember')</a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block">@lang('login.login')</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="login-footer">
            <div class="text-center">
                &copy; {{ date("Y") }}
            </div>
        </div>
    </div>

</div>

</body>
</html>




