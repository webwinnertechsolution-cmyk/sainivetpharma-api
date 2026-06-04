@import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

<nav class="sidebar sidebar-offcanvas modern-sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="{{ asset('public/backend/assets/images/logo2.webp') }}" alt="logo" class="logo-img">
        </div>
    </div>

    <ul class="nav sidebar-nav">
        
        {{-- Dashboard --}}
        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <span class="nav-icon"><i class="mdi mdi-home"></i></span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- Announcement Bar --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/announcement-bar') }}">
                <span class="nav-icon"><i class="mdi mdi-bullhorn"></i></span>
                <span class="menu-title">Announcement Bar</span>
            </a>
        </li>

        {{-- Header --}}
        <li class="nav-item">
            <a class="nav-link nav-toggle" data-bs-toggle="collapse" href="#headerMenu" role="button" aria-expanded="false">
                <span class="nav-icon"><i class="mdi mdi-header"></i></span>
                <span class="menu-title">Header</span>
                <span class="nav-arrow"><i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="collapse" id="headerMenu">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/logo') }}">
                            <span class="sub-icon"><i class="mdi mdi-image-frame"></i></span>
                            Logo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/menus') }}">
                            <span class="sub-icon"><i class="mdi mdi-menu"></i></span>
                            Menu
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- HOME --}}
        <li class="nav-item">
            <a class="nav-link nav-toggle" data-bs-toggle="collapse" href="#homeMenu" role="button" aria-expanded="false">
                <span class="nav-icon"><i class="mdi mdi-home-variant"></i></span>
                <span class="menu-title">Home</span>
                <span class="nav-arrow"><i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="collapse" id="homeMenu">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/slider') }}">
                            <span class="sub-icon"><i class="mdi mdi-image-multiple"></i></span>
                            Slider
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/home-category') }}">
                            <span class="sub-icon"><i class="mdi mdi-folder-multiple"></i></span>
                            Home Category
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/home-product-section') }}">
                            <span class="sub-icon"><i class="mdi mdi-shopping"></i></span>
                            Home Product
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/promotional-banner') }}">
                            <span class="sub-icon"><i class="mdi mdi-flag"></i></span>
                            Promotional Banner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/brand-section') }}">
                            <span class="sub-icon"><i class="mdi mdi-briefcase"></i></span>
                            Brand Section
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/industries-we-serve') }}">
                            <span class="sub-icon"><i class="mdi mdi-lightning-bolt"></i></span>
                            Offers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/home-video-section') }}">
                            <span class="sub-icon"><i class="mdi mdi-play-circle"></i></span>
                            Video Section
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- About Us --}}
        <li class="nav-item">
            <a class="nav-link nav-toggle" data-bs-toggle="collapse" href="#aboutMenu" role="button" aria-expanded="false">
                <span class="nav-icon"><i class="mdi mdi-information"></i></span>
                <span class="menu-title">About Us</span>
                <span class="nav-arrow"><i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="collapse" id="aboutMenu">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/offering') }}">
                            <span class="sub-icon"><i class="mdi mdi-text-box"></i></span>
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/corevalues') }}">
                            <span class="sub-icon"><i class="mdi mdi-account-multiple"></i></span>
                            Teams
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/experience-the-power') }}">
                            <span class="sub-icon"><i class="mdi mdi-briefcase-check"></i></span>
                            Portfolio
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Product --}}
        <li class="nav-item">
            <a class="nav-link nav-toggle" data-bs-toggle="collapse" href="#productMenu" role="button" aria-expanded="false">
                <span class="nav-icon"><i class="mdi mdi-package-variant"></i></span>
                <span class="menu-title">Product</span>
                <span class="nav-arrow"><i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="collapse" id="productMenu">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/product') }}">
                            <span class="sub-icon"><i class="mdi mdi-list"></i></span>
                            Product List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/product/create') }}">
                            <span class="sub-icon"><i class="mdi mdi-plus-circle"></i></span>
                            Add Product
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/product-tag') }}">
                            <span class="sub-icon"><i class="mdi mdi-tag-multiple"></i></span>
                            Product Tags
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/product-category') }}">
                            <span class="sub-icon"><i class="mdi mdi-folder-multiple"></i></span>
                            Product Categories
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Blog --}}
        <li class="nav-item">
            <a class="nav-link nav-toggle" data-bs-toggle="collapse" href="#blogMenu" role="button" aria-expanded="false">
                <span class="nav-icon"><i class="mdi mdi-pencil-square"></i></span>
                <span class="menu-title">Blog</span>
                <span class="nav-arrow"><i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="collapse" id="blogMenu">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">
                            <span class="sub-icon"><i class="mdi mdi-list-box"></i></span>
                            All Blogs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog.category') }}">
                            <span class="sub-icon"><i class="mdi mdi-folder"></i></span>
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog.tag') }}">
                            <span class="sub-icon"><i class="mdi mdi-tag"></i></span>
                            Tags
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Pages --}}
        <li class="nav-item">
            <a class="nav-link nav-toggle" data-bs-toggle="collapse" href="#pagesMenu" role="button" aria-expanded="false">
                <span class="nav-icon"><i class="mdi mdi-file-document-multiple"></i></span>
                <span class="menu-title">Pages</span>
                <span class="nav-arrow"><i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="collapse" id="pagesMenu">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faq') }}">
                            <span class="sub-icon"><i class="mdi mdi-help-circle"></i></span>
                            FAQ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/gallery') }}">
                            <span class="sub-icon"><i class="mdi mdi-image-gallery"></i></span>
                            Gallery
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/contact-us-page') }}">
                            <span class="sub-icon"><i class="mdi mdi-email"></i></span>
                            Contact Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/privacy-policy') }}">
                            <span class="sub-icon"><i class="mdi mdi-shield-account"></i></span>
                            Privacy Policy
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/terms-of-service') }}">
                            <span class="sub-icon"><i class="mdi mdi-file-document"></i></span>
                            Terms & Services
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Contact --}}
        <li class="nav-item">
            <a class="nav-link nav-toggle" data-bs-toggle="collapse" href="#contactMenu" role="button" aria-expanded="false">
                <span class="nav-icon"><i class="mdi mdi-phone"></i></span>
                <span class="menu-title">Contact</span>
                <span class="nav-arrow"><i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="collapse" id="contactMenu">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/home-contact') }}">
                            <span class="sub-icon"><i class="mdi mdi-form-textbox"></i></span>
                            Contact Section
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.submissions') }}">
                            <span class="sub-icon"><i class="mdi mdi-email-multiple"></i></span>
                            Submissions
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- SEO Manager --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.pageseo.index') }}">
                <span class="nav-icon"><i class="mdi mdi-search-web"></i></span>
                <span class="menu-title">SEO Manager</span>
            </a>
        </li>

        {{-- Footer --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/footer-new') }}">
                <span class="nav-icon"><i class="mdi mdi-page-layout-footer"></i></span>
                <span class="menu-title">Footer</span>
            </a>
        </li>

    </ul>

    {{-- Email Submissions Widget --}}
    <div class="sidebar-widget mt-4">
        <div class="widget-card">
            <div class="widget-icon">
                <i class="mdi mdi-email-alert"></i>
            </div>
            <div class="widget-content">
                <p class="widget-label">Email Submissions</p>
                <a href="{{ route('contact.submissions') }}" class="widget-link">View All →</a>
            </div>
        </div>
    </div>

</nav>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    /* Modern Sidebar Styles */
    .modern-sidebar {
        background: linear-gradient(180deg, #0a214f 0%, #1872B5 100%);
        color: #ffffff;
        padding: 0;
        overflow-y: auto;
        overflow-x: hidden;
        box-shadow: 4px 0 20px rgba(10, 33, 79, 0.15);
        font-family: 'Nunito', sans-serif;
    }

    .modern-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .modern-sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .modern-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .modern-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 20px 16px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.08);
    }

    .sidebar-logo img {
        height: 40px;
        object-fit: contain;
        filter: brightness(1.2);
    }

    /* Sidebar Navigation */
    .sidebar-nav {
        list-style: none;
        padding: 12px 0;
        margin: 0;
    }

    .nav-item {
        margin: 4px 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        position: relative;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .nav-item.active .nav-link {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: inset 0 0 12px rgba(0, 0, 0, 0.1);
    }

    /* Nav Icons */
    .nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        font-size: 18px;
        flex-shrink: 0;
    }

    .nav-icon i {
        transition: transform 0.3s ease;
    }

    .nav-link:hover .nav-icon i {
        transform: scale(1.15);
    }

    /* Menu Title */
    .menu-title {
        flex: 1;
        font-family: 'Sora', sans-serif;
        font-weight: 600;
        font-size: 13px;
    }

    /* Nav Arrow */
    .nav-arrow {
        display: flex;
        align-items: center;
        font-size: 16px;
        transition: transform 0.3s ease;
        opacity: 0.7;
    }

    .nav-toggle[aria-expanded="true"] .nav-arrow {
        transform: rotate(180deg);
    }

    /* Sub Menu */
    .sub-menu {
        list-style: none;
        padding: 8px 0 8px 12px;
        margin: 0;
        background: rgba(0, 0, 0, 0.1);
        border-left: 3px solid rgba(255, 255, 255, 0.2);
        border-radius: 0 6px 6px 0;
    }

    .sub-menu .nav-item {
        margin: 2px 4px;
    }

    .sub-menu .nav-link {
        padding: 8px 10px;
        font-size: 12px;
        gap: 10px;
        color: rgba(255, 255, 255, 0.75);
    }

    .sub-menu .nav-link:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }

    .sub-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        font-size: 14px;
    }

    /* Sidebar Widget */
    .sidebar-widget {
        padding: 12px 8px;
        margin: 0 8px;
    }

    .widget-card {
        background: rgba(255, 255, 255, 0.1);
        border: 1.5px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 12px;
        display: flex;
        gap: 10px;
        align-items: center;
        transition: all 0.3s ease;
    }

    .widget-card:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .widget-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #f59e0b, #ec4899);
        border-radius: 6px;
        font-size: 18px;
        color: white;
        flex-shrink: 0;
    }

    .widget-content {
        flex: 1;
    }

    .widget-label {
        font-size: 11px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.9);
        margin: 0 0 3px;
        font-family: 'Sora', sans-serif;
    }

    .widget-link {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .widget-link:hover {
        color: #ffffff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modern-sidebar {
            width: 260px;
        }

        .menu-title {
            font-size: 12px;
        }

        .sidebar-header {
            padding: 16px 12px;
        }

        .nav-link {
            padding: 9px 10px;
            font-size: 12px;
        }
    }

    /* Scrollbar Styling */
    .sidebar-nav {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.25);
        border-radius: 3px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.4);
    }
</style>
