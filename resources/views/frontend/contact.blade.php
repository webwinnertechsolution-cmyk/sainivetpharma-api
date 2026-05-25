@extends('frontend.layouts.layout')

@section('body_class', 'header-style-1 header-fixed footer- builder-default builder-kit-18')
@section('title', $title ?? 'Contact Us - Red-Labs')

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
    gap: 85px;
}

  /* Responsive Form */
    @media (max-width: 768px) {
        .input-wrap p {
            flex-direction: column;
            gap: 20px;
        }
		.desc-cnt {
			display: flex;
			gap: 10px;
		}
		.desc-phn {
			display: flex;
			gap: 10px;
			flex-wrap: wrap;
		}
    }
</style>
@endpush

@section('content')
<div class="blog-banner">
    <div class="blog-banner-content">
        <h1>Contact Us</h1>
    </div>
</div>
<div id="main-content" class="site-main clearfix">
    <div id="content-wrap" class="" style="padding:0px 10px 0px 10px">
        <div id="site-content" class="site-content clearfix">
            <div id="inner-content" class="inner-content-wrap">
                <article class="page-content page">
                    <div class="builder builder-1169">
                        
                        {{-- Contact Info Section --}}
                        <section class="contact-info-section">
                            <div class="contact-container">
                                <div class="contact-grid-row">
                                    {{-- Left Column: Contact Details --}}
                                    <div class="contact-details-column">
                                        <div class="contact-headings-wrapper">
                                            <div class="master-heading">
                                                <div class="pre-heading">GET IN TOUCH</div>
                                                <h2 class="main-heading">Contact Details</h2>
                                                <div class="divider"></div>
                                                <div class="sub-heading">Have a question or need assistance? Contact us now. We're here to support you and we look forward to hearing from you soon!</div>
                                            </div>
                                        </div>

                                        {{-- Icon Box: Phone --}}
                                        <div class="contact-icon-box">
                                            <div class="master-icon-box">
                                                <div class="icon-wrap"><div class="master-icon"><i class="fas fa-phone-alt"></i></div></div>
                                                <div class="text-wrap">
                                                    <h3 class="headline-2">Call Us 24x7</h3>
													<div class="desc-phn">
                                                    <div class="desc"><a href="tel:01724014524" class="cont-anchor"> 01724014524</a><br></div> 
													</div>
                                                </div>
                                            </div>
                                        </div>



                                         
                                        {{-- Icon Box: Email --}}
									<div class="desc-cnt">									
                                        <div class="contact-icon-box">
                                            <div class="master-icon-box">
                                                <div class="icon-wrap"><div class="master-icon"><i class="fas fa-envelope"></i></div></div>
                                                <div class="text-wrap">
                                                    <h3 class="headline-2">Mail Us</h3>
                                                    <div class="desc"><a href="mailto:Dllpl@gmail.com" class="cont-anchor">Dllpl@gmail.com</a><br></div>
                                                </div>
                                            </div>
                                        </div>

                                      </div>

                                        {{-- Icon Box: Mackay Address --}}
                                        <div class="contact-icon-box">
										   <div class="desc-add">
                                            <div class="master-icon-box">
                                                <div class="icon-wrap"><div class="master-icon"><i class="fas fa-map-marker-alt"></i></div></div>
                                                <div class="text-wrap">
												    <h3 class="headline-2">Address 1</h3>
                                                    <div class="desc">57, Block B, South Ex. Part II, New Delhi PIN - 110049</div>
                                                </div>
                                            </div>
										
										  </div>	
                                        </div>
										
										
										

                                      
                                    </div>

                                    {{-- Right Column: Image --}}
                                    <div class="contact-image-column">
                                        <div class="contact-main-image">
                                            <img fetchpriority="high" decoding="async" width="570" height="400" src="{{ asset('uploads/contac-570x400.png') }}" class="attachment-mae-std2 size-mae-std2 wp-image-3135" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        {{-- Contact Form Section --}}
                        <div class="contact-section-wrapper">
                            <div class="contact-card-inner">
                                <div class="contact-spacer-top"></div>
                                <div class="contact-content-row">
                                    <div class="contact-info-column">
                                        <div class="contact-image-wrapper">
                                            <img decoding="async" width="800" height="504" src="{{ asset('/public/uploads/aaaa.png') }}" class="attachment-large size-large contact-main-img" alt="">
                                        </div>
                                       <!-- <div class="contact-details-wrapper">
                                            <p><strong>Head Office:</strong> A04/216 Harbour Road, Mackay Harbour, QLD, 4740</p>
                                        </div>-->
                                    </div>
                                    <div class="contact-form-column">
                                        <div class="contact-heading-wrapper">
                                            <div class="master-heading">
                                                <h2 class="main-heading">Ready to Get Started?</h2>
                                                <div class="divider"></div>
                                            </div>
                                        </div>
                                        <div class="contact-form-wrapper cf7-style-2">
                                            <div class="byron-contact-form">
                                                <div class="contact-form js" id="contact-form-f586" lang="en-US" dir="ltr">
                                                    
                                                    {{-- Alerts --}}
                                                    @if (session('success'))
                                                        <div class="alert alert-success">
                                                            {{ session('success') }}
                                                        </div>
                                                    @endif
                                                    @if (session('error'))
                                                        <div class="alert alert-danger">
                                                            {{ session('error') }}
                                                        </div>
                                                    @endif

                                                    <form action="{{ route('contact.submit') }}" method="post" class="contact-form init" aria-label="Contact form" data-status="init">
                                                        @csrf
                                                        <div class="input-wrap">
                                                            <p>
                                                                <span class="form-control-wrap" data-name="your-name"><input size="40" maxlength="400" class="form-control" aria-required="true" aria-invalid="false" placeholder="Your Name" value="{{ old('name') }}" type="text" name="name" required=""></span>
                                                                <span class="form-control-wrap" data-name="tel-131"><input size="40" maxlength="400" class="form-control" aria-invalid="false" placeholder="Your Phone" value="{{ old('phone') }}" type="tel" name="phone" required=""></span>
                                                            </p>
                                                        </div>
                                                        <div class="input-wrap">
                                                            <p>
                                                                <span class="form-control-wrap" data-name="your-email"><input size="40" maxlength="400" class="form-control" aria-required="true" aria-invalid="false" placeholder="Your Email" value="{{ old('email') }}" type="email" name="email" required=""></span>
                                                                <span class="form-control-wrap" data-name="your-address"><input size="40" maxlength="400" class="form-control" aria-invalid="false" placeholder="Your Address" value="{{ old('address') }}" type="text" name="address"></span>
                                                            </p>
                                                        </div>
                                                        <!-- <div class="cont-cstm-style">
                                                            <p>
                                                                <span class="form-control-wrap" data-name="text-377"><input size="40" maxlength="400" class="form-control" aria-invalid="false" placeholder="Product Name" value="{{ request('product_name', request('product')) ?? old('product_name') }}" type="text" name="product_name"></span>
                                                            </p>
                                                        </div>
														-->
														<div class="cont-cstm-style">
    <p>
        <span class="form-control-wrap">
            <textarea name="message" class="form-control" placeholder="Your Message" rows="5" maxlength="2000">{{ old('message') }}</textarea>
        </span>
    </p>
</div>

                                                        <p><button type="submit" class="form-submit">Submit</button></p>
                                                        <div class="form-response-output" aria-hidden="true"></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="contact-spacer-bottom"></div>
                            </div>
                        </div>

                        {{-- Maps Section --}}
                        <section class="maps-section">
                            <div class="maps-container">
                                <div class="maps-grid">
                                    {{-- Map 1: Brisbane --}}
                                    <div class="map-column">
                                        <div class="map-wrapper">
                                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3429.284030498649!2d76.74175827503781!3d30.73852228535384!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390feddd5852b84f%3A0x6d29896da10b7609!2s3178%2C%2037D%2C%20Sector%2037%2C%20Chandigarh%2C%20160036!5e0!3m2!1sen!2sin!4v1773830257659!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>

                                 
                                </div>
                            </div>
                        </section>

                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
@endsection