@import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

<nav class="navbar modern-navbar fixed-top">
    <div class="navbar-wrapper">
        
        {{-- Logo Section --}}
        <div class="navbar-brand-section">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <img src="{{ asset('public/backend/assets/images/logo2.webp') }}" alt="logo" class="brand-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <span class="toggler-icon">
                    <i class="mdi mdi-menu"></i>
                </span>
            </button>
        </div>

        {{-- Center Search --}}
        <div class="navbar-search-section d-none d-lg-flex">
            <div class="search-wrapper">
                <i class="mdi mdi-magnify search-icon"></i>
                <input type="text" class="search-input" placeholder="Search pages, products...">
                <span class="search-shortcut">⌘K</span>
            </div>
        </div>

        {{-- Right Actions --}}
        <div class="navbar-actions-section">
            
            {{-- Notifications --}}
            <div class="navbar-action-item notification-item">
                <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="icon-badge">
                        <i class="mdi mdi-bell-outline"></i>
                        <span class="badge-dot"></span>
                    </span>
                </button>
                <div class="dropdown-menu notification-dropdown">
                    <div class="dropdown-header">
                        <h6>Notifications</h6>
                        <a href="#" class="text-sm">Mark all as read</a>
                    </div>
                    <div class="notification-list">
                        <a href="#" class="notification-item">
                            <div class="notif-icon" style="background: linear-gradient(135deg, #059669, #34d399);">
                                <i class="mdi mdi-check-circle"></i>
                            </div>
                            <div class="notif-content">
                                <p class="notif-title">Blog post published</p>
                                <p class="notif-time">2 minutes ago</p>
                            </div>
                        </a>
                        <a href="#" class="notification-item">
                            <div class="notif-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                                <i class="mdi mdi-plus-circle"></i>
                            </div>
                            <div class="notif-content">
                                <p class="notif-title">New product added</p>
                                <p class="notif-time">15 minutes ago</p>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-footer">
                        <a href="#" class="text-center">View all notifications</a>
                    </div>
                </div>
            </div>

            {{-- Messages --}}
            <div class="navbar-action-item message-item d-none d-md-flex">
                <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="icon-badge">
                        <i class="mdi mdi-email-outline"></i>
                        <span class="badge-count">3</span>
                    </span>
                </button>
                <div class="dropdown-menu message-dropdown">
                    <div class="dropdown-header">
                        <h6>Messages</h6>
                    </div>
                    <div class="message-list">
                        <a href="#" class="message-item">
                            <img src="{{ asset('backend/assets/images/faces/face1.jpg') }}" alt="avatar" class="message-avatar">
                            <div class="message-content">
                                <p class="message-sender">John Doe</p>
                                <p class="message-text">Hey, how are you doing?</p>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-footer">
                        <a href="{{ route('contact.submissions') }}">All messages</a>
                    </div>
                </div>
            </div>

            {{-- Fullscreen --}}
            <div class="navbar-action-item d-none d-lg-flex">
                <button class="action-btn" id="fullscreen-btn" title="Toggle fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            {{-- Divider --}}
            <div class="navbar-divider"></div>

            {{-- User Profile --}}
            <div class="navbar-action-item user-profile-item">
                <button class="action-btn profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-avatar">
                        <img src="{{ asset('backend/assets/images/faces/face1.jpg') }}" alt="user" class="avatar-img">
                        <span class="avatar-status online"></span>
                    </div>
                    <div class="profile-info d-none d-md-block">
                        <p class="profile-name">{{ Session::get('username', 'Admin') }}</p>
                        <p class="profile-role">Administrator</p>
                    </div>
                </button>
                <div class="dropdown-menu profile-dropdown">
                    <div class="dropdown-header">
                        <div class="header-profile">
                            <img src="{{ asset('backend/assets/images/faces/face1.jpg') }}" alt="user" class="header-avatar">
                            <div class="header-info">
                                <p class="header-name">{{ Session::get('username', 'Admin') }}</p>
                                <p class="header-email">admin@example.com</p>
                            </div>
                        </div>
                    </div>
                    <a class="dropdown-item" href="{{ url('/dashboard') }}">
                        <i class="mdi mdi-view-dashboard"></i> Dashboard
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-account"></i> My Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-cog"></i> Settings
                    </a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item logout-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout"></i> Logout
                    </a>
                </div>
            </div>

        </div>

    </div>
</nav>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    /* Modern Navbar Base */
    .modern-navbar {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border-bottom: 2px solid #e5e7eb;
        padding: 0;
        box-shadow: 0 4px 16px rgba(10, 33, 79, 0.08);
        font-family: 'Nunito', sans-serif;
        z-index: 1000;
        height: 64px;
    }

    .navbar-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        height: 100%;
        gap: 20px;
    }

    /* Navbar Brand Section */
    .navbar-brand-section {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .brand-logo {
        height: 36px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .brand-logo:hover {
        transform: scale(1.05);
    }

    .navbar-toggler {
        display: none;
        background: none;
        border: none;
        padding: 8px;
        cursor: pointer;
        color: #0a214f;
        font-size: 20px;
        transition: color 0.2s ease;
    }

    .navbar-toggler:hover {
        color: #1872B5;
    }

    /* Search Section */
    .navbar-search-section {
        flex: 1;
        max-width: 400px;
    }

    .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background: #f3f4f6;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        padding: 0 12px;
        transition: all 0.2s ease;
    }

    .search-wrapper:focus-within {
        background: #ffffff;
        border-color: #1872B5;
        box-shadow: 0 0 0 3px rgba(24, 114, 181, 0.1);
    }

    .search-icon {
        font-size: 16px;
        color: #9ca3af;
        margin-right: 8px;
    }

    .search-input {
        background: none;
        border: none;
        outline: none;
        font-size: 12px;
        color: #374151;
        width: 100%;
        padding: 8px 0;
        font-family: 'Nunito', sans-serif;
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .search-shortcut {
        font-size: 10px;
        color: #9ca3af;
        background: #e5e7eb;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
    }

    /* Actions Section */
    .navbar-actions-section {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .navbar-action-item {
        position: relative;
    }

    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s ease;
        color: #374151;
        font-size: 18px;
    }

    .action-btn:hover {
        background: #f3f4f6;
        color: #1872B5;
    }

    .icon-badge {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge-dot {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        border: 2px solid white;
    }

    .badge-count {
        position: absolute;
        top: 0;
        right: 0;
        background: linear-gradient(135deg, #ef4444, #f87171);
        color: white;
        font-size: 10px;
        font-weight: 700;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
    }

    /* Dropdowns */
    .notification-dropdown,
    .message-dropdown,
    .profile-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        min-width: 320px;
        box-shadow: 0 12px 32px rgba(10, 33, 79, 0.12);
        margin-top: 8px;
        overflow: hidden;
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-header {
        padding: 12px 16px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-header h6 {
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #0a214f;
        margin: 0;
    }

    .dropdown-header .text-sm {
        font-size: 10px;
        color: #1872B5;
        text-decoration: none;
        transition: color 0.2s;
    }

    .dropdown-header .text-sm:hover {
        color: #0a214f;
    }

    /* Notifications */
    .notification-list {
        max-height: 280px;
        overflow-y: auto;
    }

    .notification-list::-webkit-scrollbar {
        width: 4px;
    }

    .notification-list::-webkit-scrollbar-track {
        background: transparent;
    }

    .notification-list::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 2px;
    }

    .notification-item {
        display: flex;
        gap: 12px;
        padding: 12px 16px;
        color: inherit;
        text-decoration: none;
        border-bottom: 1px solid #f9fafb;
        transition: background 0.2s ease;
    }

    .notification-item:hover {
        background: #f9fafb;
    }

    .notif-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        flex-shrink: 0;
    }

    .notif-content {
        flex: 1;
        min-width: 0;
    }

    .notif-title {
        font-size: 11px;
        font-weight: 700;
        color: #0a214f;
        margin: 0 0 2px;
    }

    .notif-time {
        font-size: 10px;
        color: #9ca3af;
        margin: 0;
    }

    /* Messages */
    .message-list {
        max-height: 240px;
        overflow-y: auto;
    }

    .message-item {
        display: flex;
        gap: 10px;
        padding: 12px 16px;
        border-bottom: 1px solid #f9fafb;
        text-decoration: none;
        color: inherit;
        transition: background 0.2s ease;
    }

    .message-item:hover {
        background: #f9fafb;
    }

    .message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .message-content {
        flex: 1;
        min-width: 0;
    }

    .message-sender {
        font-size: 11px;
        font-weight: 700;
        color: #0a214f;
        margin: 0 0 3px;
    }

    .message-text {
        font-size: 10px;
        color: #6b7280;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Divider */
    .navbar-divider {
        width: 1px;
        height: 24px;
        background: #e5e7eb;
        margin: 0 4px;
    }

    /* User Profile */
    .profile-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
    }

    .profile-avatar {
        position: relative;
        width: 36px;
        height: 36px;
        flex-shrink: 0;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    .avatar-status {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .avatar-status.online {
        background: #10b981;
    }

    .profile-info {
        text-align: left;
    }

    .profile-name {
        font-family: 'Sora', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #0a214f;
        margin: 0;
    }

    .profile-role {
        font-size: 9px;
        color: #9ca3af;
        margin: 0;
    }

    /* Profile Dropdown */
    .profile-dropdown {
        min-width: 240px;
    }

    .header-profile {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .header-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }

    .header-info {
        flex: 1;
    }

    .header-name {
        font-family: 'Sora', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #0a214f;
        margin: 0;
    }

    .header-email {
        font-size: 10px;
        color: #9ca3af;
        margin: 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        color: #374151;
        text-decoration: none;
        font-size: 12px;
        border-bottom: 1px solid #f9fafb;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: #f9fafb;
        color: #1872B5;
        padding-left: 20px;
    }

    .dropdown-item i {
        font-size: 16px;
    }

    .logout-item {
        color: #ef4444;
    }

    .logout-item:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .dropdown-divider {
        margin: 8px 0;
        border: none;
        border-top: 1px solid #f3f4f6;
    }

    .dropdown-footer {
        padding: 10px 16px;
        text-align: center;
        border-top: 1px solid #f3f4f6;
        background: #f9fafb;
    }

    .dropdown-footer a {
        font-size: 10px;
        color: #1872B5;
        text-decoration: none;
        transition: color 0.2s;
    }

    .dropdown-footer a:hover {
        color: #0a214f;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .navbar-search-section {
            max-width: 300px;
        }

        .search-shortcut {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .navbar-wrapper {
            padding: 0 12px;
            gap: 12px;
        }

        .navbar-toggler {
            display: block;
        }

        .navbar-search-section {
            display: none !important;
        }

        .brand-logo {
            height: 32px;
        }

        .profile-info {
            display: none !important;
        }

        .profile-btn {
            padding: 6px;
        }

        .navbar-divider {
            display: none;
        }

        .notification-dropdown,
        .message-dropdown,
        .profile-dropdown {
            left: -160px;
            right: auto;
        }
    }

    /* Fullscreen Script Styling */
    body.fullscreen-mode .modern-navbar {
        display: none;
    }
</style>

<script>
    // Fullscreen Toggle
    document.getElementById('fullscreen-btn')?.addEventListener('click', function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.log('Fullscreen request failed:', err);
            });
        } else {
            document.exitFullscreen();
        }
    });

    // Search Keyboard Shortcut
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            document.querySelector('.search-input')?.focus();
        }
    });

    // Close Dropdowns on Outside Click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-action-item')) {
            document.querySelectorAll('.notification-dropdown, .message-dropdown, .profile-dropdown').forEach(dropdown => {
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            });
        }
    });
</script>
