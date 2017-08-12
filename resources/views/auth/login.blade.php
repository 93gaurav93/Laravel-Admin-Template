<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login</title>
    <!-- Favicon-->
    <link rel="icon" href="{{url('favicon.ico')}}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{url('js/admin/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{url('js/admin/plugins/node-waves/waves.css')}}" rel="stylesheet"/>

    <!-- Animation Css -->
    <link href="{{url('js/admin/plugins/animate-css/animate.css')}}" rel="stylesheet"/>

    <!-- Custom Css -->
    <link href="{{url('css/admin/style.css')}}" rel="stylesheet">
</head>

<body class="login-page">
<div class="login-box">
    <div class="logo">
        <a target="_blank" style="font-size: 25px;" href="#">Laravel Admin Panel</a>
        <small>Login</small>
    </div>
    <div class="card">
        <div class="body">
            <form id="sign_in" action="{{ route('login') }}" method="POST">
                {!! csrf_field() !!}
                <div class="msg">Sign in to start your session</div>
                @if ($errors->has('email'))
                    <div class="alert bg-red">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <div class="input-group">

                    <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="email" placeholder="Username/Email"
                               value="{{ old('email') }}"
                               required autofocus>
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password" required
                               autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="remember" id="rememberme" class="filled-in chk-col-pink"
                                {{ old('remember') ? 'checked' : '' }}>
                        <label for="rememberme">Remember Me</label>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                    </div>
                </div>
                <div class="row m-t-15 m-b--20">
                    <div class="col-xs-6">
                        {{--<a href="{{ route('password.request') }}">Forgot Password?</a>--}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="{{url('js/admin/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{url('js/admin/plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{url('js/admin/plugins/node-waves/waves.js')}}"></script>

<!-- Validation Plugin Js -->
<script src="{{url('js/admin/plugins/jquery-validation/jquery.validate.js')}}"></script>

<!-- Custom Js -->
<script src="{{url('js/admin/admin.js')}}"></script>
<script src="{{url('js/admin/pages/examples/sign-in.js')}}"></script>

</body>

</html>