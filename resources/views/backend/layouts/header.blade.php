

{{-- Navbar --}}
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="{{ url('/dashboard') }}">
            <img src="https://api.sainivetpharma.com/uploads/logo/1781064546_logo.png" alt="logo" /> 
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/dashboard') }}">
            <img src="https://api.sainivetpharma.com/uploads/logo/1776854215_logo.png" alt="logo" />
        </a>
    </div>
    
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        
        <div class="search-field d-none d-md-block">
            {{-- Search field --}}
        </div>
        
        <ul class="navbar-nav navbar-nav-right">
            {{-- Fullscreen Button --}} 
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
            
            {{-- User Profile Dropdown --}}
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="https://api.sainivetpharma.com/uploads/logo/1776854215_logo.png" alt="image">
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{ Session::get('username', 'User') }}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout me-2 text-primary"></i> Signout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
