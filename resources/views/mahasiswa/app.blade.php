
<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Kompetisi-corner - @yield('title') </title>

    @include('partials__.deskapp.header')
</head>
<body>

	{{-- <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="{{url('assets/img/logo/logo.png')}}" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div> --}}

    {{-- Navbar --}}
    @include('partials__.deskapp.navbar')

    {{-- Sidebar --}}
    @include('partials__.deskapp.sidebar')

	<div class="main-container">
		<div class="pd-ltr-20">
			
            @yield('content')
			
            {{-- Footer --}}
            @include('partials__.deskapp.footer')

		</div>
	</div>
	<!-- js -->

    @include('partials__.deskapp.js')

    @stack('script')

</body>
</html>