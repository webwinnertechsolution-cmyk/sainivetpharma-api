    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">

        <!-- Google Analytics (GA4) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=GT-5DHDGNWL"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GT-5DHDGNWL', {
            'send_page_view': true
        });
        </script>
        <!-- End Google Analytics -->
        <link rel="icon" href="{{ asset('public/favicon.ico') }}?v=2" sizes="any">
        <link rel="icon" type="image/png" href="{{ asset('public/backend/assets/images/favicon2.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('public/backend/assets/images/favicon2.png') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>

        <link rel="profile" href="https://gmpg.org/xfn/11">
    
        <title>@yield('title', $title ?? 'Home - Red-Labs')</title>
        <meta name="description" content="@yield('meta_description', $meta_description ?? 'WELCOME TO RED-LABS Innovative engineered materials featuring high performance plastics and advanced manufacturing GET A QUOTE RED-LABS In stock and supply cut to size sheets for Acrylic, Nylons, Polyurethane HDPE, UHMWPE GET A QUOTE RED-LABS OPTIMAL MACHINE GUARDING SOLUTIONS COMPLYING WITH INDUSTRY STANDARDS GET A QUOTE RED-LABS POWERED BY RED ENGINEERS PRODUCT DESIGN, 3D SCANNING')" />
        <meta name="keywords" content="@yield('meta_keywords', $meta_keywords ?? 'Red-Labs, Engineering, Plastics')" />
        <meta name="robots" content="max-image-preview:large" /> 
        <link rel="canonical" href="{{ url()->current() }}" />

        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}' };</script>
		 <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Framework: Laravel -->
        
       

	 <meta name="generator" content="Laravel" />
            <meta property="og:locale" content="en_US" />
            <meta property="og:site_name" content="Red-Labs" />
            <meta property="og:type" content="website" />
            <meta property="og:title" content="@yield('og_title', $og_title ?? $title ?? 'Home - Red-Labs')" />
            <meta property="og:description" content="@yield('og_description', $og_description ?? $meta_description ?? 'WELCOME TO RED-LABS Innovative engineered materials featuring high performance plastics and advanced manufacturing GET A QUOTE RED-LABS In stock and supply cut to size sheets for Acrylic, Nylons, Polyurethane HDPE, UHMWPE GET A QUOTE RED-LABS OPTIMAL MACHINE GUARDING SOLUTIONS COMPLYING WITH INDUSTRY STANDARDS GET A QUOTE RED-LABS POWERED BY RED ENGINEERS PRODUCT DESIGN, 3D SCANNING')" />
            <meta property="og:url" content="{{ url()->current() }}" />
            <meta property="og:image" content="@yield('og_image', $og_image ?? asset('public/backend/assets/images/favicon2.png'))" />
            <meta name="twitter:card" content="summary_large_image" /> 
            <meta name="twitter:title" content="@yield('og_title', $og_title ?? $title ?? 'Home - Red-Labs')" />
            <meta name="twitter:description" content="@yield('og_description', $og_description ?? $meta_description ?? 'WELCOME TO RED-LABS Innovative engineered materials featuring high performance plastics and advanced manufacturing GET A QUOTE RED-LABS In stock and supply cut to size sheets for Acrylic, Nylons, Polyurethane HDPE, UHMWPE GET A QUOTE RED-LABS OPTIMAL MACHINE GUARDING SOLUTIONS COMPLYING WITH INDUSTRY STANDARDS GET A QUOTE RED-LABS POWERED BY RED ENGINEERS PRODUCT DESIGN, 3D SCANNING')" />
      <script>// FAQ accordion logic: only one open at a time, always opens on click
    jQuery(function($) {
        $('.faq-question').on('click', function() {
            var $this = $(this);
            var $answer = $this.next('.faq-answer');
            if ($answer.is(':visible')) {
                $answer.slideUp();
                $this.removeClass('active');
            } else {
                $('.faq-answer:visible').slideUp();
                $('.faq-question.active').removeClass('active');
                $answer.slideDown();
                $this.addClass('active');
            }
        });
    });

    </script>




        


    <link rel='stylesheet' id='byron-icons-css' href="{{ asset('public/frontend/css/byron-icons.css') }}" type='text/css' media='all' />

    <!-- <link rel='stylesheet' id='xoo-aff-style-css' href="{{ asset('public/wp-content/plugins/easy-login-woocommerce/xoo-form-fields-fw/assets/css/xoo-aff-style3c94.css?ver=2.1.0') }}" type='text/css' media='all' /> -->
    <style id='xoo-aff-style-inline-css' type='text/css'>

    .xoo-aff-input-group .xoo-aff-input-icon{
        background-color:  #eee;
        color: #555;
        max-width: 40px;
        min-width: 40px;
        border-color: #cccccc;
        border-width: 1px;
        font-size: 14px;
    }
    .xoo-aff-group{
        margin-bottom: 30px;
    }

    .xoo-aff-group input[type="text"], .xoo-aff-group input[type="password"], .xoo-aff-group input[type="email"], .xoo-aff-group input[type="number"], .xoo-aff-group select, .xoo-aff-group select + .select2, .xoo-aff-group input[type="tel"], .xoo-aff-group input[type="file"]{
        background-color: #fff;
        color: #777;
        border-width: 1px;
        border-color: #cccccc;
        height: 50px;
    }


    .xoo-aff-group input[type="file"]{
        line-height: calc(50px - 13px);
    }



    .xoo-aff-group input[type="text"]::placeholder, .xoo-aff-group input[type="password"]::placeholder, .xoo-aff-group input[type="email"]::placeholder, .xoo-aff-group input[type="number"]::placeholder, .xoo-aff-group select::placeholder, .xoo-aff-group input[type="tel"]::placeholder, .xoo-aff-group .select2-selection__rendered, .xoo-aff-group .select2-container--default .select2-selection--single .select2-selection__rendered, .xoo-aff-group input[type="file"]::placeholder, .xoo-aff-group input::file-selector-button{
        color: #777;
    }

    .xoo-aff-group input[type="text"]:focus, .xoo-aff-group input[type="password"]:focus, .xoo-aff-group input[type="email"]:focus, .xoo-aff-group input[type="number"]:focus, .xoo-aff-group select:focus, .xoo-aff-group select + .select2:focus, .xoo-aff-group input[type="tel"]:focus, .xoo-aff-group input[type="file"]:focus{
        background-color: #ededed;
        color: #000;
    }

    [placeholder]:focus::-webkit-input-placeholder{
        color: #000!important;
    }


    .xoo-aff-input-icon + input[type="text"], .xoo-aff-input-icon + input[type="password"], .xoo-aff-input-icon + input[type="email"], .xoo-aff-input-icon + input[type="number"], .xoo-aff-input-icon + select, .xoo-aff-input-icon + select + .select2,  .xoo-aff-input-icon + input[type="tel"], .xoo-aff-input-icon + input[type="file"]{
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
    }

    </style>



    </style>




    </style>
    <link rel='stylesheet' id='byron-google-font-inter-css' href='http://fonts.googleapis.com/css?family=Inter%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900&amp;subset=latin&amp;ver=600e8061deccd15670cc4fa9304d2177' type='text/css' media='all' />


        <meta name="generator" content="Laravel Framework">
                <style>
                    .e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload),
                    .e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload) * {
                        background-image: none !important;
                    }
                    @@media screen and (max-height: 1024px) {
                        .e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload),
                        .e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload) * {
                            background-image: none !important;
                        }
                    }
                    @@media screen and (max-height: 640px) {
                        .e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload),
                        .e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload) * {
                            background-image: none !important;
                        }
                    }
                </style>

        <!-- Preloader Styles -->
        <style>
            #video-preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #ffffff; /* White background to match site */
                z-index: 2147483647; /* Maximum Z-Index */
                display: flex;
                justify-content: center;
                align-items: center;
                transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
            }
            #video-preloader.hidden {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }
            #video-preloader video {
                width: 1200px; /* Increased size significantly */
                height: auto;
                max-width: 100%;
                object-fit: contain;
            }
        </style>
        
        <!-- Preloader Script 
        <script>
            window.addEventListener('load', function() {
                const preloader = document.getElementById('video-preloader');
                if (preloader) {
                    // Keep it visible for at least a moment to show the branding, or just hide on load
                    setTimeout(() => {
                        preloader.classList.add('hidden');
                    }, 3000); // 3s delay to ensure video plays a bit
                }
            });
        </script>-->
        
        <!-- Core Theme Styles -->
        <link rel="stylesheet" href="{{ asset('public/frontend/css/theme.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('public/frontend/css/builder-global.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('public/frontend/css/builder-frontend.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('public/frontend/css/custom.css') }}?v={{ time() }}">
        
        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('public/frontend/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/frontend/css/coreicons.css') }}">
        <link rel="stylesheet" href="{{ asset('public/frontend/css/eleganticons.css') }}">
        <link rel="stylesheet" href="{{ asset('public/frontend/css/pe-icon-7-stroke.css') }}">

        <!-- Animsition CSS -->
        <link rel="stylesheet" href="{{ asset('public/frontend/css/animsition.css') }}">

        <!-- Slick CSS -->
        <link rel="stylesheet" href="{{ asset('public/frontend/css/slick.css') }}">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="{{ asset('public/frontend/css/animate.css') }}">

        <!-- Submenu Overflow & Arrow Flip Fixes -->
        <style>
        @media (min-width: 992px) {
            #main-nav ul li { position: relative; }
            
            /* Level 3+ Submenu Positioning */
            #main-nav .sub-menu .sub-menu {
                left: 100%;
                top: 0;
                margin-top: 0;
            }
            
            /* Flip sub-submenus for the last 3 items to prevent overflow */
            #main-nav > ul > li:nth-last-child(-n+3) .sub-menu .sub-menu {
                left: auto !important;
                right: 100% !important;
            }

            /* Direct sub-menu alignment for last 2 items */
            #main-nav > ul > li:nth-last-child(-n+2) > .sub-menu {
                left: auto !important;
                right: 0 !important;
            }

            /* Flip indicators for submenus opening left */
            #main-nav > ul > li:nth-last-child(-n+3) .sub-menu li.menu-item-has-children > a:after {
                content: "\e686" !important;
            }
        }

        /* Mobile Menu Close Button */
        @media (max-width: 991px) {
            .btn-menu-close {
                position: absolute;
                top: 15px;
                right: 15px;
                width: 40px;
                height: 40px;
                line-height: 40px;
                text-align: center;
                background-color: #da200b; /* Red accent color */
                color: #fff;
                border-radius: 5px;
                cursor: pointer;
                z-index: 99999;
                transition: all 0.3s ease;
            }
            .btn-menu-close:hover {
                background-color: #000;
            }
            .btn-menu-close:before {
                content: "\e680";
                font-family: "Pe-icon-7-stroke";
                font-size: 28px;
                display: block;
            }
        }

        /* Global Variables - Elementor Kit 18 */
        :root {
            --e-global-color-primary: #DA200B;
            --e-global-color-secondary: #000000;
            --e-global-color-text: #000000;
            --e-global-color-accent: #dd200b;
            --e-global-typography-primary-font-family: "Inter", sans-serif;
            --e-global-typography-secondary-font-family: "Inter", sans-serif;
            --e-global-typography-text-font-family: "Inter", sans-serif;
            --e-global-typography-accent-font-family: "Inter", sans-serif;
        }

        /* Header Styles */
        #site-header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            /* background-color: rgba(0, 0, 0, 0.5); Default: Semi-transparent dark overlay for subpages */
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Fixed/Sticky Header Style (Overrides Transparency) */
        #site-header.fixed-show {
            background-color: #030F27 !important; /* Custom Brand Dark Blue */
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            transition: background-color 0.3s ease;
            position: fixed !important; /* Ensure it sticks */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }
        
        /* Ensure transparency on home ONLY when NOT sticky */
        .home-page #site-header:not(.fixed-show) {
            background-color: transparent !important;
            border-bottom: none;
        }

        /* Homepage Slider Custom CSS */
        .rl-slider-section {
            position: relative;
            overflow: hidden;
            width: 100%;
        }
        .rl-slide-item {
            min-height: 99vh; /* Reduced height as requested */
            position: relative;
            display: flex !important; /* Slick sets display: block */
            align-items: center;
            justify-content: flex-start;
            outline: none;
            z-index: 1; /* Establish stacking context */
            background-color: #000; /* Fallback */
        }
        .rl-slide-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
        }
        .rl-bg-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Overlay */
        .rl-slide-item:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(0 0 0 / 7%);
    z-index: 1;
}
        .byron-container {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 15px;
            position: relative;
            z-index: 2;
        
        }
        .rl-slide-content {
            max-width: 800px;
            color: #fff;
            padding-top: 80px;
            text-align: left;
        }
        .rl-slide-sub-title {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 20px;
            color: #fff;
            display: block;
        }
        .rl-slide-title {
            font-size: 70px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 25px;
            color: #fff;
        }
        .rl-slide-desc {
            font-size: 18px;
            font-weight: 400;
            line-height: 1.7;
            margin-bottom: 40px;
            color: #f1f1f1;
            max-width: 650px;
        }
        .rl-slide-desc p {
            margin-bottom: 0;
        }
        /* Button */
        .rl-slide-btn-wrapper {
            margin-top: 30px;
        }
        .rl-slide-btn {
            display: inline-block;
            background-color: #da200b;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 18px 38px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .rl-slide-btn:hover {
            background-color: #fff;
            color: #000;
        }
        .rl-slide-btn i {
            margin-left: 8px;
        }

        /* Slider Navigation Arrows */
        .rl-slick-arrow {
            display: none !important;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .rl-slide-item {
                min-height: 600px;
            }
            .rl-slide-title {
                font-size: 50px;
            }
        }
        /* Builder Layout Engine (Replacements for Elementor) */
        .builder-section {
            position: relative;
            width: 100%;
            padding: 60px 0;
            box-sizing: border-box;
        }
        
        /* Make sections stretch full viewport width - works inside any container */
        .builder-section.builder-section-stretched {
            width: 100vw;
            max-width: none;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            padding-left: 0;
            padding-right: 0;
        }
        
        /* Prevent horizontal scrollbar from full-width sections */
        #wrapper, #page, #main-content, .site-main {
            overflow-x: clip;
        }
        
        /* Container inside stretched section */
        .builder-section-stretched > .builder-container {
            max-width: 1400px;
            margin: 0 auto;
            padding-left: 30px;
            padding-right: 30px;
        }
        .builder-section-full_width > .builder-container,
        .builder-section-full-width > .builder-container {
            max-width: 100% !important;
            width: 100% !important;
            padding-left: 30px;
            padding-right: 30px;
        }
        .builder-section-content-middle .builder-container {
            align-items: center;
        }
        .builder-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1400px; /* Widened layout as requested */
            margin: 0 auto;
            position: relative;
            padding-left: 40px;
            padding-right: 40px;
        }
        .builder-column {
            position: relative;
            min-height: 1px;
            display: flex;
            padding: 30px; /* Increased spacing between columns */
        }
        .builder-col-50 {
            width: 50%;
        }
        .builder-widget-wrap {
            display: flex;
            flex-direction: column;
            width: 100%;
            position: relative;
        }
        .builder-widget {
            margin-bottom: 20px;
            width: 100%;
            position: relative;
        }
        .align-left { text-align: left; }
        .align-right { text-align: right; }
        .align-center { text-align: center; }

        /* Component: Fancy Image */
        .master-fancy-image {
            position: relative;
        }
        /* Component: Fancy Image */
        .master-fancy-image {
            position: relative;
        }
        
        .master-fancy-image-inner {
            position: relative;
            display: block;
            z-index: 1;
        }
        
        .master-fancy-image .master-fancy-image-holder,
        .master-fancy-image .master-fancy-image-bg {
            transition: opacity 1s 0s cubic-bezier(0.23, 1, 0.32, 1), transform 1.5s 0.25s cubic-bezier(0.23, 1, 0.32, 1);
            transform: translate(0, 0);
            opacity: 0;
        }
        .master-fancy-image-bg {
            content: "";
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            width: 100%;
            height: 100%;
            background-color: var(--e-global-color-primary); /* Use global primary color */
            z-index: -1;
        }
        
        /* Hide red decorative background on mobile/tablet */
        /*@media (max-width: 1024px) {*/
        /*    .master-fancy-image-bg {*/
        /*        display: none !important;*/
        /*    }*/
        /*}*/
        .master-fancy-image-holder {
            position: relative;
            z-index: 2;
            overflow: hidden;
        }
        .master-fancy-image img {
            display: block;
            max-width: 100%;
            height: auto;
        }
        
        /* Desktop only: Full width/height image fill */
        @media screen and (min-width: 769px) {
            .master-fancy-image {
                width: 100%;
                height: 100%;
            }
            
            /*.builder-col-50 .master-fancy-image {*/
            /*    min-height: 500px;*/
            /*}*/
            
            .master-fancy-image-inner {
                width: 100%;
                height: 100%;
            }
            
            .master-fancy-image-holder {
                width: 100%;
                height: 100%;
                min-height: 400px;
            }
            
            .master-fancy-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        /* Animation States */
        .master-fancy-image.bg-top { margin: 0 20px 20px 0; }
        
        .master-fancy-image.is-in-view .master-fancy-image-bg,
        .master-fancy-image.is-in-view .master-fancy-image-holder {
            opacity: 1;
        }

        .master-fancy-image.is-in-view.bg-top .master-fancy-image-bg {
            transform: translate(-20px, -20px);
        }
        .master-fancy-image.is-in-view.bg-top .master-fancy-image-holder {
            transform: translate(20px, 20px);
        }
        
        /* Mobile: Reset image fill behavior */
        @media screen and (max-width: 768px) {
            .builder-col-50 .master-fancy-image {
                min-height: auto;
            }
            .master-fancy-image-holder {
                min-height: auto;
            }
        }

        /* Component: Headings */
        .master-heading {
            margin-bottom: 20px;
        }
        .master-heading .main-heading {
            font-family: var(--e-global-typography-primary-font-family);
            font-size: 36px;
            font-weight: 700;
            color: var(--e-global-color-secondary);
            margin-bottom: 15px;
            text-transform: uppercase;
            line-height: 1.2;
        }
        .master-heading .main-heading span {
            color: var(--e-global-color-primary);
        }
        .master-heading .sub-heading {
            font-family: var(--e-global-typography-text-font-family);
            font-size: 18px;
            line-height: 27px;
            color: var(--e-global-color-text);
        }
        .master-heading .sub-heading p {
            margin-bottom: 15px;
        }

        /* Component: Buttons */
        .master-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--e-global-color-primary);
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            border-radius: 3px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .master-button:hover {
            background-color: #333;
            color: #fff;
        }

        /* Slick Slider Dots */
        .slick-dots {
            position: absolute;
            bottom: -40px;
            display: block;
            width: 100%;
            padding: 0;
            margin: 0;
            list-style: none;
            text-align: center;
        }
        .slick-dots li {
            position: relative;
            display: inline-block;
            width: 10px;
            height: 10px;
            margin: 0 5px;
            padding: 0;
            cursor: pointer;
        }
        .slick-dots li button {
            font-size: 0;
            line-height: 0;
            display: block;
            width: 10px;
            height: 10px;
            padding: 5px;
            cursor: pointer;
            color: transparent;
            border: 0;
            outline: none;
            background: #ccc; /* Inactive color */
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .slick-dots li.slick-active button {
            background: var(--e-global-color-primary); /* Active color */
            transform: scale(1.2);
        }
        .master-button.extra-small {
            font-size: 12px;
            padding: 10px 25px;
        }

        /* Responsive Builder */
        @media (max-width: 1024px) {
            .builder-col-50:not(.footer-cstm-colmns) {
                width: 100%;
            }
            .builder-container:not(.footer-cstm-container) {
                flex-direction: column;
            }
            .builder-column:not(.footer-cstm-colmns) {
                padding: 10px 20px 20px;
            }
            /* Restored Slider Styles */
            .rl-slide-item {
                min-height: 500px;
            }
            .rl-slide-title {
                font-size: 36px;
            }
            .rl-slide-desc {
                font-size: 16px;
            }
        }
        </style>
            <style type="text/css" id="wp-custom-css">
                .nav-top-cart-wrapper {
        display: none;
    }
    .center-data .master-icon-box {
        align-items: center;
        border-radius: 0px 0px 0px 0px;
    }

    .bdt-prime-slider-skin-crelly .bdt-slider-excerpt-content .bdt-slider-excerpt {
        column-count: 1 !important;
        margin: 15px 0 !important;
        line-height: 28px !important;
        width: 45% !important;
    }

    .main-logo img {
        padding-top: 0px;
        width: 150px;
        max-width: 400px !important;
    }

    .byron-container {
        width: 1070px !important;
        margin: 0 auto;
    }

    .master-service .thumb img {
        width: 100%;
        height: 200px;
        transition: 0.5s;
        object-fit: cover;
    }
    #site-header {
        height: 90px !important;
        padding-top: 0px !important;
    }

    .site-header-inner {
        height: 120px !important;
        display: flex !important;
        align-items: center !important;
    }
    @media only screen and (max-width: 991px) {
        .site-header-inner {
            position: relative;
            height: 80px !important;
        }
    }

    #main-nav > ul > li > a {
        color: #fff !important;
        line-height: 120px !important;
    }

    @@media only screen and (max-width: 600px) {
        
        .main-logo img {
            height:90px !important;
                width: 140px;
                max-width: 400px !important;
        }
        #site-header {
        height: 100px !important;
        padding-top: 13px !important;
        padding-bottom:90px !important;
    }
        #site-logo-inner a img {
        padding-bottom: 5px !important;
    }
        
        /* Slider responsive styles */
        .bdt-prime-slider-skin-crelly .bdt-prime-slider-wrapper {
            display: flex !important;
            flex-direction: column !important;
            align-items: start !important;
            width: 100% !important;
            max-width: 100% !important;
            padding-right: 0px !important;
            padding-left: 20px !important;
            margin: 0 auto !important;
        }
        
        .bdt-prime-slider-skin-crelly .bdt-ps-sub-title {
            font-size: 14px !important;
            line-height: 1.3 !important;
        }
        
        .bdt-prime-slider-skin-crelly .bdt-title-tag {
            font-size: 24px !important;
            line-height: 1.2 !important;
            margin-bottom: 10px !important;
        }
        
        .bdt-prime-slider-skin-crelly .bdt-slider-excerpt-content .bdt-slider-excerpt {
            width: 100% !important;
            font-size: 14px !important;
            line-height: 1.5 !important;
            margin: 10px 0 !important;
        }
        
        .bdt-prime-slider-skin-crelly .bdt-ps-slide-img {
            background-size: cover !important;
            background-position: center !important;
        }
        
        .bdt-prime-slider-skin-crelly .bdt-slideshow-item {
            padding: 0 !important;
        }
        
    }





    .home-about .sub-heading {
        text-align: left !important;
    }


    [class*="bdt-position-center-left"] {
        display: flex !important;
        flex-direction: row !important;
        align-items: end !important;
        transform: translate(500px, -30px)!important;
        bottom: 0!important;
    }


    #slider-home-page{
        padding:0 !important;
    }



    .builder-page-5720 #site-header {
        border-bottom: 1px solid #FFFFFF80;
        /* background-color: #0000004f !important; */
    }


    .builder-page-5720 #site-header.fixed-hide{
        border-bottom: 1px solid #FFFFFF80;
        background-color: #030F27 !important;
    }

    /* Desktop slider styles */
    @@media only screen and (min-width: 601px) {
        .bdt-prime-slider-skin-crelly .bdt-prime-slider-wrapper {
            margin: 0 auto;
            display: flex;
            width: 80%;
            flex-direction: column;
            /* padding-right: 200px !important; */
            align-items: start;
            /* padding-left: 50px !important; */
        }
    }


    /* hdpe*/

    .hdpe-form p {
        display: flex;
    row-gap: normal;
        align-items: center;
    }

    .hdpe-form input[type="text"],
    .hdpe-form input[type="email"]{	
        font-family: "Inter", sans-serif;
        padding: 15px 10px !important;
        box-sizing: border-box;
        height: 48px !important;
        border: 0;
        box-shadow: inset 0px 2px 3px rgba(0, 0, 0, 0.4) !important;
        font-size: 16px!important;
        margin:0;
        width:90%;
    }


    .hdpe-form input[type="submit"] {
        padding: 15px 60px !important;
        font-family: "Inter", sans-serif;
        font-size: 20px;
        line-height:26px;
        color: #fff !important;
        background-color: #333333 !important;
        font-weight: 500;
        border:none;
    }

    @@media (max-width:400px){
        .hdpe-form p {
        flex-direction: column;
            align-items: start;
    }
    }


    .woo-single-post-class .summary h1 {
        margin: 0 !important;
        padding-bottom:20px;
    }

    .woo-single-post-class .summary .price {
    
        margin: 0 !important;
    }

    .hdpe-section p {
        font-size: 18px;
        line-height: 30px;
        color: #000;
        font-family: 'Inter';
        margin: 0 !important;
        padding-bottom: 20px !important;
    }

    .hdpe-section ul {
        color: #000;
        font-size: 18px !important;
    }

    ul.tabs.wc-tabs {
        display: none;
    }

    .woo-single-post-class .woocommerce-tabs {
        padding-top: 0 
    }
    .table-section thead {
        color: white;
        background-color: #FD0100;
        border: 1px solid #FD0100;
    }

    table.dataTable thead th, table.dataTable thead td {
        border-bottom: 0 !important;
    }

    .table-section tbody {
        color: #000000;
    }

    .table-section td.product_title a {
        color: #000 !important;
    }

    .table-section .dataTables_scrollBody {
        overflow: hidden !important;
    }

    .woo-single-post-class .woocommerce-tabs .panel {
            clear: none;
        padding: 0;
        border-bottom: 0;
    }

    table.dataTable.cell-border tbody td {

        border: 1px solid #ddd !important;
    }

    table.dataTable.cell-border tbody tr td:first-child {
        border-left: 1px solid #ddd;
    }

    @@media(max-width:400px){
        .woo-single-post-class .summary h1 {
        text-align: center;
        font-size: 27px;
    }
        
        .hdpe-section p {
        text-align: justify;
    }
    }


    .our-product .eael-woo-product-carousel-container.preset-1 .product-details-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
    }


    #main-content {
        padding: 0  !important;
    }

    .product-wrap.clearfix {
        padding-top: 70px;
    }

    .table-section {
        padding-top: 120px;
    }

    .woo-single-post-class .images {
        width: 40.727%!important;
    }

    .woo-single-post-class .summary {
        width: 51.727% !important;
    
    }

    @@media (max-width:400px){
        .woo-single-post-class .images {
        width: 100%!important;
    }
        
        .woo-single-post-class .summary {
        width: 100%!important;
    }
        .sp-easy-accordion .sp-ea-single .ea-header a {
        font-size: 16px;
        line-height: 28px;
    }
        .hdpe-section ul {
        font-size: 15px !important;
    }

    }

    @@media (max-width:1024px){
        .woo-single-post-class .images {
        width: 100%!important;
    }
        
        .woo-single-post-class .summary {
        width: 100%!important;
    }
        
        .table-section {
        padding-top: 0;
    }
    }


        .table-section {
        padding-top: 0;
    }




            </style>
            <style id="wpr_lightbox_styles">
                    .lg-backdrop {
                        background-color: rgba(0,0,0,0.6) !important;
                    }
                    .lg-toolbar,
                    .lg-dropdown {
                        background-color: rgba(0,0,0,0.8) !important;
                    }
                    .lg-dropdown:after {
                        border-bottom-color: rgba(0,0,0,0.8) !important;
                    }
                    .lg-sub-html {
                        background-color: rgba(0,0,0,0.8) !important;
                    }
                    .lg-thumb-outer,
                    .lg-progress-bar {
                        background-color: #444444 !important;
                    }
                    .lg-progress {
                        background-color: #a90707 !important;
                    }
                    .lg-icon {
                        color: #efefef !important;
                        font-size: 20px !important;
                    }
                    .lg-icon.lg-toogle-thumb {
                        font-size: 24px !important;
                    }
                    .lg-icon:hover,
                    .lg-dropdown-text:hover {
                        color: #ffffff !important;
                    }
                    .lg-sub-html,
                    .lg-dropdown-text {
                        color: #efefef !important;
                        font-size: 14px !important;
                    }
                    #lg-counter {
                        color: #efefef !important;
                        font-size: 14px !important;
                    }
                    .lg-prev,
                    .lg-next {
                        font-size: 35px !important;
                    }

                    /* Defaults */
                    .lg-icon {
                    background-color: transparent !important;
                    }

                    #lg-counter {
                    opacity: 0.9;
                    }

                    .lg-thumb-outer {
                    padding: 0 10px;
                    }

                    .lg-thumb-item {
                    border-radius: 0 !important;
                    border: none !important;
                    opacity: 0.5;
                    }

                    .lg-thumb-item.active {
                        opacity: 1;
                    }
                </style>
                <style>
                    /* Hide royal preloader and show video preloader */
                    #royal_preloader { display: none !important; }
                    .preloader { 
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: #000;
                        z-index: 9999;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .preloader video {
                    
                        width: 100%;
                    }
					.home-page #site-header {
    display: none;
}
div#site-header-wrap {
    display: none;
}

.rl-slider.slick-initialized.slick-slider {
    height: 550px!important;
}


.rl-slide-item.slick-slide {
    height: 550px!important;
}
.rl-slide-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 550px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 0;
}

section.builder-section.footer-cstm {
    DISPLAY: NONE;
}
div#bottom {
    DISPLAY: NONE;
}
                </style>
                <script>
                    window.addEventListener('load', function() {
                        var preloader = document.querySelector('.preloader');
                        if (preloader) {
                            preloader.style.opacity = '0';
                            preloader.style.transition = 'opacity 0.5s';
                            setTimeout(function() {
                                preloader.style.display = 'none';
                            }, 500);
                        }
                    });
                </script>	
        
        @stack('styles')
        <!-- Local Business Schema -->
        <script type="application/ld+json">
        {
        "@@context": "https://schema.org",
        "@@type": "LocalBusiness",
        "@@id": "https://www.red-labs.com.au/#localbusiness",
        "name": "Red Labs",
        "url": "https://www.red-labs.com.au/",
        "logo": "https://www.red-labs.com.au/images/logo.png",
        "image": "https://www.red-labs.com.au/images/logo.png",
        "telephone": "+61 423 454 930",
        "email": "m.bajwa@mackaydraft.com.au",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "A04/216 Harbour Road",
            "addressLocality": "Mackay Harbour",
            "addressRegion": "QLD",
            "postalCode": "4740",
            "addressCountry": "AU"
        },
        "areaServed": {
            "@@type": "Country",
            "name": "Australia"
        },
        "priceRange": "$$"
        }
        </script>

        <!-- Organization Schema -->
        <script type="application/ld+json">
        {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "@@id": "https://www.red-labs.com.au/#organization",
        "name": "Red Labs",
        "url": "https://www.red-labs.com.au/",
        "logo": "https://www.red-labs.com.au/images/logo.png",
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "+61 423 454 930",
            "contactType": "customer support",
            "areaServed": "AU",
            "availableLanguage": ["English"]
        },
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "A04/216 Harbour Road",
            "addressLocality": "Mackay Harbour",
            "addressRegion": "QLD",
            "postalCode": "4740",
            "addressCountry": "AU"
        },
        "email": "m.bajwa@mackaydraft.com.au"
        }
        </script>

        <!-- Website Schema -->
        <script type="application/ld+json">
        {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "@@id": "https://www.red-labs.com.au/#website",
        "url": "https://www.red-labs.com.au/",
        "name": "Red Labs",
        "publisher": {
            "@@id": "https://www.red-labs.com.au/#organization"
        }
        }
        </script>
    </head>
    <body class="@yield('body_class', 'site-layout-full-width header-fixed')">
        <!-- Video Preloader 
        <div id="video-preloader">
            <video autoplay loop muted playsinline>
                <source src="{{ asset('public/frontend/videos/loader.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        -->
        <div id="wrapper">
            <div id="page" class="clearfix">
                <div id="site-header-wrap">
                    @include('frontend.layouts.header')
                </div>

                <!-- Content Placeholder -->
                @yield('content')
                
                @include('frontend.layouts.footer')
            </div>
        </div>

        @stack('scripts')
        @include('frontend.partials.bottom_scripts')
    </body>
    </html>
