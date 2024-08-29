<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM | Verify OTP</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>OTP has been sent successfully.</strong>
        </div>

        <!-- /.login-logo -->
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <a href="{{ route('home') }}" class="h1"><img src="{{ asset('dist/img/logo.png') }}"
                        width="180px"></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Please Enter OTP !</p>

                <form method="POST" action="{{ route('verify-otp') }}">
                    @csrf
                    <div class="input-group mb-3">
                        Enter the code we just send on your mobile phone {{ $user->phone }}.
                        <input type="hidden" class="form-control" name="phone" value="{{ $user->phone }}">
                    </div>

                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="otp" name="otp"
                            placeholder="Enter OTP here" value="{{ old('otp') }}">
                        @error('otp')
                            <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        @if ($message = Session::get('error'))
                            <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                        @endif
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="mt-3 text-center">
                        <p>Don't receive the code?</p>
                        <a href="{{ route('send-otp', ['phone' => $user->phone ]) }}">Resend</a>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    <div class="mt-4 text-center footercopyright">
        <p>© 2022 Jungle Safari India</p>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>

</html>
