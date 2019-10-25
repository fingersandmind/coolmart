<!doctype html>
<html lang="en" dir="ltr">
	
<!-- Mirrored from www.spruko.com/demo/viboon/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 Oct 2018 18:11:26 GMT -->
@include('partials.head')

	<body class="{{ Request::routeIs(['login', 'register']) ? 'login-img' : '' }}">
		{{-- <div id="global-loader" ></div> --}}
		<div class="page" >
                        @if(Request::routeIs(['login', 'register']))
                                @yield('session-content')
                        @else
                                <div class="page-main">
                                        {{-- Header --}}
                                        @include('partials.header')
                                        {{-- /Header --}}
                                        {{-- Navigation --}}
                                        @include('partials.nav')
                                        {{-- /Navigation --}}
                                        @yield('content')
                                </div>
                                @include('partials.footer')
                                @include('sweetalert::alert')
                        @endif
                </div>
        @include('partials.scripts')

	</body>

<!-- Mirrored from www.spruko.com/demo/viboon/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 Oct 2018 18:12:27 GMT -->
</html>