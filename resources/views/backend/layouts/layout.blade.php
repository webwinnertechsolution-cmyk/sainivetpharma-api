<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Purple Admin')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('/uploads/logo/1776854215_logo.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')
	
	
	<style>
	.card-header.bg-primary.text-white {
		background-color: #30674d !important;
	}

	.card-header.bg-dark.text-white {
		background-color: #30674d !important;
	}
	.bg-warning {
		--bs-bg-opacity: 1;
		background-color: rgb(48 103 77) !important;
	}
	button.btn.btn-primary {
		background-color: #930e0ee8 !important;
	}
	.text-dark {
		--bs-text-opacity: 1;
		color: rgb(255 255 255) !important;
	}
	.btn-warning:not(.btn-light) {
		color: #ffffff;
		background: #930e0ee8 ;
	}
	.btn-success:not(.btn-light) {
    color: #ffffff;
    background: #930e0ee8;
}
        .navbar {
    background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%)!important;
}
        .navbar .navbar-brand-wrapper {
    background: #ff000000!important;
}
        .content-wrapper {
    background: #fff!important;
}
        .navbar .navbar-menu-wrapper .navbar-toggler {
    color: #ffffff!important;
}
        .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .dropdown-toggle:after {
    color: #fff!important;
}
        .navbar .navbar-brand-wrapper .navbar-brand img {
    width: 35%!important;
    height: 74px!important;
}
        .footer {
    background: #FFF!important;
}
	</style>
	
</head>
<body>
    <div class="container-scroller">
        
        {{-- Header Include --}}
        @include('backend.layouts.header')
        
        <div class="container-fluid page-body-wrapper">
            
            {{-- Sidebar Include --}}
            @include('backend.layouts.sidebar')
            
            <div class="main-panel">
                <div class="content-wrapper">
                    
                    {{-- Main Content Area --}}
                    @yield('content')
                    
                </div>
                
                {{-- Footer Include --}}
                @include('backend.layouts.footer')
            </div>
        </div>
    </div>
    
    {{-- Logout Form --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <!-- JavaScript -->
    <script src="{{ asset('backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('backend/assets/js/misc.js') }}"></script>
    <script src="{{ asset('backend/assets/js/settings.js') }}"></script>
    <script src="{{ asset('backend/assets/js/todolist.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('backend/assets/js/dashboard.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
