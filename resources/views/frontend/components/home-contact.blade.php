@php
    $homeContact = $homeContact ?? null;
@endphp

@if($homeContact)
<section class="builder-section builder-section-stretched builder-section-full-width home-contact-section" style="
    background-image: url('/uploads/contact-bg-img.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    padding: 50px  20px !important;
    position: relative;
    z-index: 1;">
    <div class="builder-column-gap-no">
        <div class="builder-column builder-col-100 builder-top-column" style="padding: 0 !important;">
            <div class="builder-widget-wrap" style="padding: 0 !important;">
                <section class="builder-section builder-inner-section builder-section-boxed" style="padding: 0 !important; margin: 0 !important;">
                    <div class="builder-container builder-column-gap-no" style="padding: 0 !important;">





{{-- LEFT COLUMN --}}
<div class="builder-column builder-col-50 builder-inner-column">
    <div class="builder-widget-wrap" style="padding: 0 !important;">
        <div class="align-left builder-widget" style="margin-bottom: 0 !important;">
            <div class="builder-widget-container">
                <div class="master-heading" style="margin: 0 !important;">
                    <h2 class="main-heading" style="margin: 0 0 15px 0 !important; color:#fff; font-size: 28px; font-weight: 500;">
                        {!! $homeContact->heading ?? 'Please contact us and tell us more about your project' !!}
                    </h2>
                    
                    {{-- ✅ DESCRIPTION DISPLAY --}}
                    @if($homeContact->description)
                    <p style="color: rgba(255,255,255,0.9); margin: 10px 0 20px 0; font-size: 15px; line-height: 1.6; font-weight: 400;">
                       {!! $homeContact->description !!}

                    </p>
                    @endif
                </div>
            </div>
        </div>

        @if($homeContact->phone)
        <div class="align-left builder-widget" style="margin-bottom: 10px !important;">
            <div class="builder-widget-container">
                <a class="master-link icon-left" href="tel:{{ $homeContact->phone }}">
                    <span class="icon fas fa-phone-alt"></span>
                    <span>{{ $homeContact->phone }}</span>
                </a>
            </div>
        </div>
        @endif

        @if($homeContact->email)
        <div class="align-left builder-widget" style="margin-bottom: 0 !important;">
            <div class="builder-widget-container">
                <a class="master-link icon-left" href="mailto:{{ $homeContact->email }}" style="margin-bottom: 0 !important;">
                    <span class="icon fas fa-envelope"></span>
                    <span>{{ $homeContact->email }}</span>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
						
						
						
						
						

                        {{-- RIGHT COLUMN - FORM --}}
                        <div class="builder-column builder-col-50 builder-inner-column" style="padding: 10px !important;">
                            <div class="builder-widget-wrap" style="padding: 0 !important;">

                                <style>
                                    #homeContactForm, #homeContactForm * {
                                        box-sizing: border-box;
                                    }
                                    .custom-alert {
                                        margin-bottom: 25px;
                                        padding: 15px 25px;
                                        border-radius: 4px;
                                        font-weight: 500;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        text-align: center;
                                        width: 100%;
                                    }
                                    .custom-alert-success { background: #28a745; color: #fff; border: 1px solid rgba(255,255,255,0.2); }
                                    .custom-alert-error   { background: #dc3545; color: #fff; border: 1px solid rgba(255,255,255,0.2); }

                                    #homeContactForm .input-row {
                                        display: flex;
                                        gap: 20px;
                                        margin-bottom: 20px;
                                    }
                                    #homeContactForm .input-wrap {
                                        flex: 1;
                                    }
                                    #homeContactForm input {
                                        width: 100%;
                                        height: 60px;
                                        background: rgba(255, 255, 255, 0.1) !important;
                                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
                                        color: #000 !important;
                                        padding: 0 20px;
                                        font-size: 16px;
                                        border-radius: 4px;
                                        transition: all 0.3s ease;
                                        outline: none !important;
                                    }
                                    #homeContactForm input:focus {
                                        background: rgba(255, 255, 255, 0.2) !important;
                                        border-color: rgba(255, 255, 255, 0.4) !important;
                                    }
                                    #homeContactForm input::placeholder {
                                        color: #000;
                                    }
                                    #homeContactForm .full-width {
                                        margin-bottom: 20px;
                                    }
                                    .submit-container {
                                        display: flex;
                                        justify-content: flex-end;
                                        margin-top: 20px;
                                        padding-right: 2px;
                                    }
                                    .wpcf7-submit {
                                        background: transparent !important;
                                        border: 2px solid #DD200B !important;
                                        color: #DD200B !important;
                                        padding: 0 45px !important;
                                        height: 60px !important;
                                        line-height: 56px !important;
                                        text-transform: capitalize;
                                        font-size: 18px;
                                        font-weight: 600;
                                        transition: 0.3s;
                                        cursor: pointer;
                                        border-radius: 4px;
                                        white-space: nowrap;
                                    }
                                    .wpcf7-submit:hover {
                                        background: #DD200B !important;
                                        color: #fff !important;
                                    }
									#homeContactForm input {
    width: 100%;
    height: 47px;
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgb(0 0 0) !important;
    color: #000 !important;
    padding: 0 20px;
    font-size: 14px;
    border-radius: 4px;
    transition: all 0.3s ease;
    outline: none !important;
    margin-bottom: 0;
}
.submit-container {
    display: flex;
    justify-content: left;
    margin-top: 20px;
    padding-right: 2px;
    font-size: 10px!important;
}
.wpcf7-submit {
    background: transparent !important;
    border: 1px solid #000000 !important;
    color: #000000 !important;
    padding: 0 36px !important;
    height: 46px !important;
    line-height: 47px !important;
    text-transform: capitalize;
    font-size: 14px;
    font-weight: 500;
    transition: 0.3s;
    cursor: pointer;
    border-radius: 4px;
    white-space: nowrap;
}
.wpcf7-submit:hover {
    background: #dd200b00 !important;
    color: #030f27 !important;
}
.contact-details-column {
    padding-left: 0;
}
                                    @media (max-width: 768px) {
                                        #homeContactForm .input-row {
                                            flex-direction: column;
                                            gap: 20px;
                                        }
                                        .submit-container {
                                            justify-content: center;
                                        }
                                        .wpcf7-submit {
                                            width: 100%;
                                        }
                                    }
									
									
	.builder-column.builder-col-50.builder-inner-column {
    padding-left: 0px !important;
}
                                </style>

                                <div class="builder-element builder-widget" style="width: 100%;">
                                    <div class="builder-widget-container">
                                        <div class="wpcf7">

                                            @if(session('success'))
                                                <div class="custom-alert custom-alert-success">{{ session('success') }}</div>
                                            @endif
                                            @if(session('error'))
                                                <div class="custom-alert custom-alert-error">{{ session('error') }}</div>
                                            @endif

                                            <form action="{{ route('contact.submit') }}" method="POST" id="homeContactForm">
                                                @csrf

                                                <div class="input-row">
                                                    <div class="input-wrap">
                                                        <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                                                    </div>
                                                    <div class="input-wrap">
                                                        <input type="tel" name="phone" placeholder="Your Phone" value="{{ old('phone') }}" required>
                                                    </div>
                                                </div>

                                                <div class="input-row">
                                                    <div class="input-wrap">
                                                        <input type="email" name="email" placeholder="Your Email" value="{{ old('email') }}" required>
                                                    </div>
                                                    <div class="input-wrap">
                                                        <input type="text" name="address" placeholder="Your Address" value="{{ old('address') }}">
                                                    </div>
                                                </div>

                                          <!--      <div class="full-width">
                                                    <input type="text" name="product_name" placeholder="Product Name" value="{{ old('product_name') }}">
                                                </div>
-->
                                                <div class="full-width">
                                                    <textarea name="message" placeholder="Your Message" rows="4" style="width: 100%;background: rgba(255,255,255,0.1) !important;border: 1px solid #000 !important;color: #000000 !important;padding: 15px 20px;font-size: 13px;border-radius: 4px;outline: none !important;resize: vertical;font-family: Arial, sans-serif;height: 133px;margin-bottom: 0;">{{ old('message') }}</textarea>
                                                </div>

                                                <div class="submit-container">
                                                    <button type="submit" class="wpcf7-submit">Submit</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endif



@push('styles')
<link rel="stylesheet" href="{{ asset('public/frontend/css/original_elementor.css') }}">
<style>
    /* --- Clean Semantic Styles for Contact Page --- */

    /* Generic Container */
    .contact-container, .maps-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        width: 100%;
    }
    
	li#menu-item-6:hover {
     color: #fffff !important ;
    }
    /* Contact Info Section */
    .contact-info-section {
        padding: 0px 0;
        background-color: #fff;
    }
    .contact-grid-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }
    .contact-details-column, .contact-image-column {
        width: 50%; /* 2 Columns */
        padding: 0 15px;
        box-sizing: border-box;
    }
    .contact-icon-box {
        margin-bottom: 20px;
    }

    /* Maps Section */
    .maps-section {
        padding: 0 0 60px 0;
    }
    .maps-grid {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }
    .map-column {
        width: 50%;
    }
    .map-wrapper iframe {
        width: 100%;
        height: 400px;
        border: 0;
        display: block;
    }


    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .contact-details-column, .contact-image-column, .map-column {
            width: 100%;
            margin-bottom: 30px;
        }
        #content-wrap {
            padding-top: 120px !important;
        }
    }

    /* Fix Header Overlap */
    #content-wrap {
        padding-top: 180px !important;
    }

    /* Custom Accent Colors */
    .accent-color, .header-info .content:before, .header-button a, .header-top-menu ul li:hover, , #footer-widgets .widget.widget_socials .socials a:hover, #main-nav > ul > li:hover > a, .header-style-1 #main-nav > ul > li:hover > a, .header-style-4 #main-nav > ul > li:hover > a, #main-nav .sub-menu li a:hover, .button, button, input[type="button"], input[type="reset"], input[type="submit"], .widget.widget_archive ul li a:hover, .widget.widget_categories ul li a:hover, .widget.widget_meta ul li a:hover, .widget.widget_nav_menu ul li a:hover, .widget.widget_pages ul li a:hover, .widget.widget_recent_entries ul li a:hover, .widget.widget_recent_comments ul li a:hover, .widget.widget_rss ul li a:hover, .hentry .post-meta .item.post-by-author a, .hentry .post-meta .item.post-comment a, .hentry .post-meta .item.post-meta-categories a, .hentry .post-link a, .widget.widget_recent_posts h3 a:hover, #sidebar .widget.widget_text .text-wrap .btn:hover, .post-next-previous .link-wrap .link:hover, .logged-in-as a, #footer .widget.widget_information i, .products li .product-cat:hover, .products li h2:hover, .builder-element .master-link .icon, .builder-element .master-button.btn-outline, .builder-element .master-button.btn-white, .builder-element .master-heading .pre-heading, .builder-element .master-counter .icon-wrap, .builder-element .master-subscribe-form.style-2 button, .builder-element .master-project.style-1:hover .master-link, .builder-element .master-project.style-1:hover .master-link .icon, .builder-element .master-link:hover, .builder-element .master-subscribe-form button:hover, .builder-element .master-progress-bar .percent, .builder-element .master-icon, .builder-element .master-list .icon-wrap {
        color: #30674d !important;
    }

    /* Custom Contact Page Styles */
    .master-icon-box {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
        gap: 12px;
    }
    .master-icon-box .icon-wrap {
        flex-shrink: 0;
        margin-top: 3px;
    }
    .master-icon-box .master-icon {
        width: 32px;
        height: 32px;
        background-color: #30674d;
        color: #ffffff !important;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .master-icon-box .master-icon i {
         color: #ffffff !important;
    }
    .master-icon-box .text-wrap {
        flex-grow: 1;
    }
    .master-icon-box .headline-2 {
        font-size: 15px !important;
        font-weight: 700;
        margin: 0 0 2px 0;
        color: #000;
        line-height: 1.3;
    }
    .master-icon-box .desc {
        font-size: 14px;
        color: #555;
        line-height: 1.5;
    }
    .master-icon-box .desc a {
        color: #30674d !important;
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s;
    }
    .master-icon-box .desc a:hover {
        color: #333 !important;
    }

    /* Fix Layout Stacking for Contact Row */
    .contact-content-row {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: flex-start;
        gap: 40px;
    }
    .contact-content-row > div {
        width: 50% !important;
        flex-basis: 50% !important;
        max-width: 50% !important;
    }
    
    @media (max-width: 1024px) {
        .contact-content-row {
            flex-direction: column !important;
        }
        .contact-content-row > div {
            width: 100% !important;
            flex-basis: 100% !important;
            max-width: 100% !important;
        }
    }

    /* Card Style for Contact Section */
    .contact-card-inner {
        background-color: #ffffff;
        box-shadow: 0 15px 45px rgba(0,0,0,0.1);
        padding: 20px;
        border-radius: 8px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Image Styling */
    .contact-image-wrapper img {
        border-radius: 15px !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        display: block;
        width: 100%;
        height: auto;
    }

    /* Head Office Text */
    .contact-details-wrapper p {
        font-size: 16px;
        color: #333;
        margin-top: 20px;
        line-height: 1.6;
    }
    
    /* Contact Form Styles */
    .contact-form input, .contact-form textarea {
        width: 100%;
        background-color: #ffffff !important;
        border: 1px solid #eaeaea !important;
        padding: 18px 25px;
        margin-bottom: 0;
        font-size: 15px;
        color: #777;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    /* Side-by-Side Inputs */
    .input-wrap p {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }
    .input-wrap p > span {
        flex: 1;
        width: 100%;
    }
    
    /* Full Width Fields */
    .cont-cstm-style p {
        margin-bottom: 25px;
    }
    
  

    .contact-form input:focus, .contact-form textarea:focus {
        border-color: #30674d !important;
        box-shadow: 0 0 0 4px rgba(48, 103, 77, 0.05);
    }
    .contact-form input::placeholder, .contact-form textarea::placeholder {
        color: #999;
    }
    .contact-form textarea {
        height: 150px;
        resize: vertical;
    }
    .form-submit {
        background-color: #30674d !important;
        color: #ffffff !important;
        border: none;
        font-weight: 600;
        text-transform: capitalize; 
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        border-radius: 4px;
        float: right;
    }
    .form-submit:hover {
        background-color: #254d3a !important;
    }
    
    .contact-form p:last-child {
        overflow: hidden;
    }

    /* Divider Style */
    .master-heading .divider {
        width: 50px;
        height: 3px;
        background-color: #30674d;
        margin-top: 15px;
        margin-bottom: 30px;
    }

    /* Custom Alert Styles */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    .alert-danger {
        color: 721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    /* Heading Styles */
    .master-heading {
        margin-bottom: 20px;
    }
    .master-heading .pre-heading {
        color: #30674d;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
        display: block;
    }
    .master-heading .main-heading {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin: 0 0 8px 0;
        line-height: 1.2;
    }
    .master-heading .divider {
        width: 40px;
        height: 3px;
        background-color: #30674d;
        margin-bottom: 12px;
    }
    .master-heading .sub-heading {
        font-size: 14px;
        color: #555;
        line-height: 1.5;
        max-width: 90%;
    }
	.map-column {
    width: 100%;
}


/* Blog Banner */
.blog-banner {
    width: 100%;
    height: 200px;
    background: #30674d;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 40px;
}

.blog-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
    opacity: 0.3;
}

.blog-banner-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.blog-banner h1 {
    color: #fff;
    font-size: 48px;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.blog-banner h1 {
    color: #30674d;
    font-size: 30px;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.blog-banner {
    width: 100%;
    height: 107px;
    background: linear-gradient(135deg, #30674d 0%, #234a39 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 40px;
}
.blog-banner {
    width: 100%;
    height: 107px;
    background: #f0f4f0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 40px;
}
div#content-wrap {
    /* display: none; */
    padding-top: 20px!important;
}
.form-submit {
    background-color: #30674d !important;
    color: #ffffff !important;
    border: none;
    font-weight: 600;
    text-transform: capitalize;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    border-radius: 4px;
    float: left;
    padding: 20px;
    height: 31px;
    display: flex;
    align-items: anchor-center;
}
.contact-form textarea {
    height: 99px;
    resize: vertical;
}
.contact-form input, .contact-form textarea {
    width: 100%;
    background-color: #ffffff !important;
    border: 1px solid #000000 !important;
    padding: 18px 25px;
    margin-bottom: 0;
    font-size: 14px;
    color: #000000;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.contact-form input {
    width: 100%;
    background-color: #ffffff !important;
    border: 1px solid #000000 !important;
    padding: 16px 25px;
    margin-bottom: 0;
    font-size: 14px;
    color: #000000;
    border-radius: 6px;
    transition: all 0.3s ease;
    height: 40px;
}
.byron-contact-form p {
    margin-bottom: 10px!important;
    gap: 11px;
}
.cont-cstm-style {
    margin-bottom: 11px;
}
.master-heading .main-heading {
    font-size: 21px;
    font-weight: 700;
    color: #000;
    margin: 0 0 8px 0;
    line-height: 1.2;
}
.contact-card-inner {
    padding: 35px;
}
.desc-phn {
    display: flex;
    gap: 20px;
}
.desc-add {
    display: flex;
    gap: 20px;
}
.desc-cnt {
    display: flex;
    gap: 52px;
}
.contact-details-column {
    width: 100%;
}
section.builder-section.builder-section-stretched.builder-section-full-width.home-contact-section {
    background-image: none!important;
    background-color: #E3EBE6;
}
section.builder-section.builder-section-stretched.builder-section-full-width.home-contact-section {
    background-image: none!important;
    background-color: #e3ebe654;
}
h2.main-heading {
    color: #30674D!important;
}

.contact-icon-box.fgdfhdfh {
    width: 100%;
}
textarea::placeholder {
  color: #000;
}
/* Responsive Form */
    @media (max-width: 768px) {
        .input-wrap p {
            flex-direction: column;
            gap: 20px;
        }
		.desc-cnt {
			display: flex;
			gap: 35px;
		}
		.desc-phn {
    display: flex;
    gap: 10px;
    flex-wrap: nowrap;
}
.master-icon-box .desc a {
    color: #30674d !important;
    text-decoration: none;
    font-weight: 700;
    transition: color 0.3s;
    font-size: 12px;
}
.master-icon-box {
    display: flex;
    align-items: flex-start;
    margin-bottom: 12px;
    gap: 12px;
    width: 100%;
}
.desc-add {
    display: flex;
    gap: 0px !important;
    flex-direction: column !important;
}
    }
	
	
</style>
@endpush