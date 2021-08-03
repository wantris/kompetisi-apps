<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>KompetisiApps - @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('assets/img/favicon.ico')}}">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <!-- CSS here -->
    @include('partials__.head')
    @stack('cs-css')

</head>

<body>

    <!-- Navbar -->
    @if (Route::currentRouteName() != "ormawa.eventinternal.publik")
        @include('partials__.navbar')
    @endif
    

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @if(\Route::current()->getName() !== 'event.detail' && \Route::current()->getName() !== 'ormawa.event.add')
    @include('partials__.footer')
    @endif

    <!-- Modal here -->
    @include('partials__.modal')

    <!-- JS here -->
    @include('partials__.js')

    <!-- Custom script -->
    @stack('cs-script')

    {{-- Validation --}}
    @if ($errors->has('username_mhs') || $errors->has('password_mhs'))
    <script>
        $('#mahasiswaLoginModal').modal('show');
    </script>
    @endif

</body>

</html>