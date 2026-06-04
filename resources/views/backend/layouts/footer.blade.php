@import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

<footer class="modern-footer">
    <div class="footer-container">
        
        {{-- Main Footer Content --}}
        <div class="footer-content">
            
            {{-- Footer Grid --}}
            <div class="footer-grid">

                {{-- Column 1: About --}}
                <div class="footer-column">
                    <div class="footer-logo">
                        <img src="{{ asset('public/backend/assets/images/logo2.webp') }}" alt="logo">
                    </div>
                    <p class="footer-desc">
                        Admin dashboard management system built with modern design patterns and best practices.
                    </p>
                    <div class="footer-socials">
                        <a href="#" class="social-link" title="Facebook">
                            <i class="mdi mdi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" title="Twitter">
                            <i class="mdi mdi-twitter"></i>
                        </a>
                        <a href="#" class="social-link" title="LinkedIn">
                            <i class="mdi mdi-linkedin"></i>
                        </a>
                        <a href="#" class="social-link" title="Instagram">
                            <i class="mdi mdi-instagram"></i>
                        </a>
                    </div>
                </div>

                {{-- Column 2: Quick Links --}}
                <div class="footer-column">
                    <h6 class="footer-title">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/product') }}">Products</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                    </ul>
                </div>

                {{-- Column 3: Resources --}}
                <div class="footer-column">
                    <h6 class="footer-title">Resources</h6>
                    <ul class="footer-links">
                        <li><a href="{{ url('/admin/privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ url('/admin/terms-of-service') }}">Terms & Services</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                {{-- Column 4: Contact Info --}}
                <div class="footer-column">
                    <h6 class="footer-title">Get In Touch</h6>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="mdi mdi-phone"></i>
                            <span>+1 234 567 8900</span>
                        </div>
                        <div class="contact-item">
                            <i class="mdi mdi-email"></i>
                            <span>info@example.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="mdi mdi-map-marker"></i>
                            <span>123 Main St, City</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- Footer Bottom --}}
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="footer-left">
                    <p class="copyright">© 2024 Admin Dashboard. All rights reserved.</p>
                </div>
                <div class="footer-right">
                    <div class="version-info">
                        <span class="version-badge">v1.0.0</span>
                        <span class="status-badge online"><span class="status-dot"></span> Live</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Scroll to Top Button --}}
    <button class="scroll-to-top" id="scrollToTop" title="Scroll to top">
        <i class="mdi mdi-chevron-up"></i>
    </button>
</footer>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    /* Modern Footer Base */
    .modern-footer {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        color: rgba(255, 255, 255, 0.9);
        font-family: 'Nunito', sans-serif;
        position: relative;
        margin-top: 60px;
        box-shadow: 0 -4px 16px rgba(10, 33, 79, 0.15);
    }

    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0;
    }

    /* Footer Content */
    .footer-content {
        padding: 48px 20px 32px;
    }

    /* Footer Grid */
    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 32px;
        margin-bottom: 32px;
    }

    /* Footer Column */
    .footer-column {
        display: flex;
        flex-direction: column;
    }

    {{-- Logo Column --}}
    .footer-logo {
        margin-bottom: 12px;
    }

    .footer-logo img {
        height: 40px;
        object-fit: contain;
        filter: brightness(1.3);
        transition: transform 0.3s ease;
    }

    .footer-logo img:hover {
        transform: scale(1.05);
    }

    .footer-desc {
        font-size: 12px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.8);
        margin: 0 0 16px;
        font-weight: 500;
    }

    {{-- Social Links --}}
    .footer-socials {
        display: flex;
        gap: 10px;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.15);
        border: 1.5px solid rgba(255, 255, 255, 0.2);
        border-radius: 6px;
        color: white;
        text-decoration: none;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    {{-- Footer Title --}}
    .footer-title {
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .footer-title::before {
        content: '';
        width: 3px;
        height: 16px;
        background: linear-gradient(135deg, #f59e0b, #ec4899);
        border-radius: 2px;
    }

    {{-- Footer Links --}}
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .footer-links li {
        margin: 0;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .footer-links a:before {
        content: '→';
        opacity: 0;
        transform: translateX(-4px);
        transition: all 0.2s ease;
    }

    .footer-links a:hover {
        color: #ffffff;
        padding-left: 4px;
    }

    .footer-links a:hover::before {
        opacity: 1;
        transform: translateX(0);
    }

    {{-- Contact Info --}}
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.85);
    }

    .contact-item i {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.7);
        width: 20px;
        text-align: center;
    }

    .contact-item span {
        transition: color 0.2s ease;
    }

    .contact-item:hover span {
        color: #ffffff;
    }

    {{-- Footer Bottom --}}
    .footer-bottom {
        background: rgba(0, 0, 0, 0.2);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 16px 20px;
    }

    .footer-bottom-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .footer-left {
        flex: 1;
    }

    .copyright {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-weight: 500;
    }

    .footer-right {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .version-info {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    {{-- Badges --}}
    .version-badge,
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 9px;
        font-weight: 700;
        font-family: 'Sora', sans-serif;
        padding: 3px 8px;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .version-badge {
        background: rgba(255, 255, 255, 0.15);
        color: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .status-badge {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(52, 211, 153, 0.2));
        color: #a7f3d0;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-badge.online .status-dot {
        background: #10b981;
        animation: pulse 2s infinite;
    }

    .status-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    {{-- Scroll to Top Button --}}
    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #1872B5, #2596e1);
        border: none;
        border-radius: 10px;
        color: white;
        font-size: 18px;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(24, 114, 181, 0.3);
        transition: all 0.3s ease;
        z-index: 999;
    }

    .scroll-to-top:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(24, 114, 181, 0.4);
    }

    .scroll-to-top.show {
        display: flex;
    }

    {{-- Responsive --}}
    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .footer-bottom-content {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }

        .footer-right {
            justify-content: center;
        }

        .scroll-to-top {
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .footer-content {
            padding: 32px 20px 24px;
        }

        .footer-bottom {
            padding: 12px 20px;
        }
    }

    @media (max-width: 480px) {
        .footer-socials {
            flex-wrap: wrap;
        }

        .social-link {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }

        .version-info {
            flex-direction: column;
            gap: 6px;
        }

        .footer-grid {
            gap: 16px;
        }

        .footer-content {
            padding: 24px 16px 20px;
        }
    }
</style>

<script>
    // Scroll to Top Functionality
    const scrollToTopBtn = document.getElementById('scrollToTop');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });

    scrollToTopBtn.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
