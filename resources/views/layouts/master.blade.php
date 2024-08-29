<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('head')
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(count(getLongWeekendDates()) > 0)
            <marquee direction="ltr" class="bg-danger">
                Long Weekends: @foreach (getLongWeekendDates() as $weekend)
                From <span class="badge bg-success">{{ \Carbon\Carbon::parse($weekend->start)->format('d-m-Y') }}</span> to  <span class="badge bg-dark">{{ \Carbon\Carbon::parse($weekend->end)->format('d-m-Y') }}</span> @if($loop->last) @else & @endif
                @endforeach
            </marquee>
            @endif
            @if(count(getMarquees()) > 0)
            @foreach (getMarquees() as $marquee)
            <marquee direction="ltr" style="background-color:{{ $marquee['background_color'] }}">
               <span style="color:{{ $marquee['text_color'] }}">{{ $marquee['content'] }}</span>
            </marquee>
            @endforeach

            @endif
            @include('layouts.flash-message')
            @yield('content')
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        @include('layouts.controlbar')
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
    <script>
        function executeQuery() {
            $.ajax({
                url: "{{route('reminder')}}",
                method: 'get',
                success: function(data){
                    $("#reminder_div").html(data);
                }
            });

        };

        $(document).ready(function(){
            setInterval(executeQuery,3000);
        });

    </script>

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
<script>
  window.OneSignal = window.OneSignal || [];
  let externalUserId = 'user_{{ Auth::user()->id }}';
  OneSignal.push(function() {
    OneSignal.setExternalUserId(externalUserId);
    OneSignal.init({
      appId: "89dc85d4-af5c-4a27-9c13-47343e775e4a",      
      notifyButton: {
        enable: true,
      },
      allowLocalhostAsSecureOrigin: true,
    });
  });
</script>
    @stack('scripts')    
</body>

</html>
