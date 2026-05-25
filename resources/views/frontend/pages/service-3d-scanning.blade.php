@extends('frontend.layouts.layout')

@section('title', $title ?? $service->meta_title ?? $service->heading . ' - Red Labs Service')
@section('meta_description', $meta_description ?? $service->meta_description ?? Str::limit(strip_tags($service->description), 160))
@section('meta_keywords', $service->meta_keywords)
@section('og_title', $og_title ?? $service->og_title ?? $service->meta_title ?? $service->heading)
@section('og_description', $og_description ?? $service->og_description ?? $service->meta_description ?? Str::limit(strip_tags($service->description), 160))
@section('og_image', $og_image ?? ($service->og_image ? asset('uploads/ourservice/og/' . $service->og_image) : ($service->image ? asset('uploads/ourservice/' . $service->image) : asset('public/backend/assets/images/favicon.png'))))



@push('styles')
<style>
/* Container Flex Layout */
.builder-container {
    display: flex;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Full Width Column */
.builder-col-100 {
    width: 100%;
    flex: 0 0 100%;
}

/* Base Column Styles */
.builder-column {
    display: flex;
    flex-direction: column;
    padding: 0 15px;
    box-sizing: border-box;
}

/* Text Alignment */
.align-center {
    text-align: center;
}

/* Features Grid Specific */
.features-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0;
}

/* Feature Box Updates */
.feature-box {
    background-color: #FFFFFF;
    padding: 16px 15px;
    margin: 0;
    height: 100%;
    transition: transform 0.3s ease;
    box-sizing: border-box;
    text-align: center;
}

.feature-box img {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    display: block;
}

.feature-box h3 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #DA200B;
}

.feature-box p {
    font-size: 15px;
    line-height: 1.6;
    color: #333333;
    margin: 0;
}

    /* Image Display Fix */
    .master-fancy-image img {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        max-width: 100% !important;
        height: auto !important;
    }
    .master-fancy-image-holder {
        display: block !important;
        position: relative;
    }
    .master-fancy-image {
        display: block !important;
        position: relative;
    }
    
    /* Standard Section Spacing */
    .service-section {
        padding: 80px 0;
    }
    
    @media (max-width: 1024px) {
        .service-section {
            padding: 40px 0;
        }
    }

    /* Responsive Typography */
    .main-heading {
        font-size: 36px !important;
        line-height: 1.2 !important;
        margin-bottom: 20px !important;
    }
    .sub-heading {
        font-size: 18px !important;
        line-height: 1.6 !important;
    }
    
    @media (max-width: 991px) {
        .main-heading {
            font-size: 32px !important;
        }
    }
    
    @media (max-width: 1024px) {
        .main-heading {
            font-size: 28px !important;
        }
        .service-section {
            padding: 50px 0 !important;
        }
    }

    /* Container & Column alignment utilities */
    .builder-container {
        display: flex !important;
        flex-wrap: wrap !important;
        width: 100% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }
    
    .builder-section-boxed > .builder-container {
        max-width: 1320px !important;
    }

    .builder-col-25, .col-25 {
        width: 25% !important;
        flex: 0 0 25% !important;
    }
    .builder-col-33, .col-33 {
        width: 33.33% !important;
        flex: 0 0 33.33% !important;
    }
    .builder-col-50 {
        width: 50% !important;
        flex: 0 0 50% !important;
    }
    .builder-col-100 {
        width: 100% !important;
        flex: 0 0 100% !important;
    }
    
    @media (max-width: 1024px) {
        .builder-col-25, .col-25, .builder-col-33, .col-33 {
            width: 50% !important;
            flex: 0 0 50% !important;
        }
        .builder-section-boxed > .builder-container {
            max-width: 95% !important;
        }
    }
    
    @media (max-width: 1024px) {
        .builder-col-25, .col-25, .builder-col-33, .col-33, .builder-col-50, .builder-inner-column {
            width: 100% !important;
            flex: 0 0 100% !important;
            margin-bottom: 30px;
        }
        
        .builder-inner-column:last-child {
            margin-bottom: 0;
        }
        .builder-container {
            flex-direction: column !important;
        }
    }

    /* Master Fancy Image Background & Holder */
    .master-fancy-image-bg {
        display: inline-block;
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        bottom: 20px;
        z-index: 0;
        background-color: #DA200B;
        width: 100%;
        height: 100%;
        transition: transform 1.5s 0.25s cubic-bezier(0.23, 1, 0.32, 1), opacity 1s 0s ease;
        opacity: 0;
    }
    
    .master-fancy-image.is-in-view .master-fancy-image-bg {
        opacity: 1;
    }

    .master-fancy-image.bg-top.bg-right.is-in-view .master-fancy-image-bg {
        transform: translate(20px, -20px);
    }
    
    .master-fancy-image.is-in-view .master-fancy-image-holder {
        transform: translate(-10px, 10px);
        transition: transform 1.5s 0.25s cubic-bezier(0.23, 1, 0.32, 1);
    }

    /* Icon List */
    .builder-icon-list-items {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }
    .builder-icon-list-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 16px;
    }
    .builder-icon-list-icon {
        margin-right: 15px;
        color: #DA200B;
    }

    /* Feature Box Styling */
    .feature-box {
        background-color: #ffffff;
        padding: 16px 15px;
        margin: 15px;
        height: calc(100% - 30px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 5px;
        color: #333333;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
		.builderss-background-overlay{
		    background-color: #000000 !important;
    opacity: 0.55 !important;
    transition: background 0.3s, border-radius 0.3s, opacity 0.3s !important;
}
    .feature-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    .feature-box img {
        width: 60px !important;
        height: auto;
        margin-bottom: 25px;
    }
    .feature-box h3 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #DA200B;
    }

	
    .feature-box p {
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
    }

    /* Background Section */
    .bg-scanning {
        background-image: linear-gradient(rgba(3, 15, 39, 0.55), rgba(3, 15, 39, 0.55)), url({{ asset('uploads/backgrounds/scanning-bg.jpg') }});
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        color: #ffffff;
    }
    
    .align-center {
        text-align: center;
    }
    .master-heading.align-center {
        margin-left: auto;
        margin-right: auto;
        max-width: 1100px;
    }
</style>
@endpush

@section('content')
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content post-2868 page type-page status-publish hentry">
                <div data-builder-type="wp-page" data-builder-id="2868" class="builder builder-2868" data-builder-post-type="page">
                    
                    {{-- Hero Section --}}
                    <section class="builder-section builder-section-boxed service-section">
                        <div class="builder-container" style="padding-top:60px;">
                            {{-- Left Column - Content --}}
                            <div class="builder-column builder-col-50">
                                <div class="builder-widget-wrap" >
                                    <div class="master-heading">
                                        <h2 class="main-heading">{!! $service->main_heading ?? 'RED-LABS Transform with <span style="color:#DA200B">Scanning</span>' !!}</h2>
                                        <div class="sub-heading">{!! $service->description !!}</div>
                                    </div>
                                    
                                    <ul class="builder-icon-list-items">
                                        <li class="builder-icon-list-item">
                                            <span class="builder-icon-list-icon"><i class="fas fa-check-circle"></i></span>
                                            <span class="builder-icon-list-text">Accelerating product design</span>
                                        </li>
                                        <li class="builder-icon-list-item">
                                            <span class="builder-icon-list-icon"><i class="fas fa-check-circle"></i></span>
                                            <span class="builder-icon-list-text">Simplifying reverse engineering</span>
                                        </li>
                                        <li class="builder-icon-list-item">
                                            <span class="builder-icon-list-icon"><i class="fas fa-check-circle"></i></span>
                                            <span class="builder-icon-list-text">Ensuring robust quality control</span>
                                        </li>
                                        <li class="builder-icon-list-item">
                                            <span class="builder-icon-list-icon"><i class="fas fa-check-circle"></i></span>
                                            <span class="builder-icon-list-text">Detecting flaws early in the process</span>
                                        </li>
                                    </ul>
                                    
                                    <div class="builder-text-editor">
                                        <p>Explore how <b><span style="color: #da200b;">RED-</span>LABS</b> cutting-edge 3D scanning can revolutionise your operations and drive innovation.</p>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Right Column - Image --}}
                            <div class="builder-column builder-col-50">
                                <div class="builder-widget-wrap" style="padding: 20px; display: flex; align-items: center; justify-content: center;">
                                    <div class="master-fancy-image bg-top bg-right">
                                        <div class="master-fancy-image-inner">
                                            <span class="master-fancy-image-bg"></span>
                                            <div class="master-fancy-image-holder">
                                                @if($service->image && file_exists(public_path('uploads/ourservice/'.$service->image)))
                                                    <img src="{{ asset('uploads/ourservice/'.$service->image) }}" alt="{{ strip_tags($service->heading) }}" />
                                                @else
                                                    <img src="{{ asset('uploads/ourservice/scanningpage.jpg') }}" alt="{{ strip_tags($service->heading) }}" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- How It Works Section --}}
{{-- How It Works Section --}}
<section class="builder-section builder-section-boxed bg-scanning service-section">
    <div class="builder-container">
        {{-- Heading --}}
        <div class="builder-column builder-col-100">
            <div class="master-heading align-center" style="margin-bottom: 50px;">
                <h2 class="main-heading" style="color: #ffffff;"><span style="color:#DA200B">How 3D Scanning</span> Revolutionises Your Projects</h2>
                <div class="sub-heading" style="color: #ffffff;">3D scanning with <b><span style="color:#DA200B">RED-</span>LABS</b> delivers unmatched precision and efficiency. It enhances creativity, accelerates development and improves quality control. Transform your projects with our advanced solutions - contact us to explore your specific needs.</div>
            </div>
        </div>
        
        {{-- Features Grid --}}
        <div class="builder-container features-grid">
            {{-- Feature 1 --}}
            <div class="builder-column builder-col-33">
                <div class="feature-box">
                    <img src="{{ asset('uploads/icons/benchmark.png') }}" alt="Detail" />
                    <h3>Capture Every Detail</h3>
                    <p><b><span style="color:#DA200B">RED-</span>LABS</b> metrology-grade scanners offer 10μm resolution and 0.020 mm accuracy for capturing the finest details.</p>
                </div>
            </div>
            
            {{-- Feature 2 --}}
            <div class="builder-column builder-col-33">
                <div class="feature-box">
                    <img src="{{ asset('uploads/icons/truck.png') }}" alt="Service" />
                    <h3>Choose Preferred Service Option</h3>
                    <p><b><span style="color:#DA200B">RED-</span>LABS</b> offers both mail-in and on-site scanning service for convenience and flexibility.</p>
                </div>
            </div>
            
            {{-- Feature 3 --}}
            <div class="builder-column builder-col-33">
                <div class="feature-box">
                    <img src="{{ asset('uploads/icons/workflow.png') }}" alt="Accelerate" />
                    <h3>Accelerate Your Projects</h3>
                    <p><b><span style="color:#DA200B">RED-</span>LABS</b> ensures faster turnaround and a streamlined workflow for your projects with efficient 3D scanning services.</p>
                </div>
            </div>
            
            {{-- Feature 4 --}}
            <div class="builder-column builder-col-33">
                <div class="feature-box">
                    <img src="{{ asset('uploads/icons/shield.png') }}" alt="IP Protection" />
                    <h3>Protect Your Intellectual Property</h3>
                    <p><b><span style="color:#DA200B">RED-</span>LABS</b> safeguards your designs with Integrity, ensuring your IP is maintained securely and reliably.</p>
                </div>
            </div>
            
            {{-- Feature 5 --}}
            <div class="builder-column builder-col-33">
                <div class="feature-box">
                    <img src="{{ asset('uploads/icons/rating.png') }}" alt="Expertise" />
                    <h3>Benefit from Our Expertise</h3>
                    <p>You'll get personalised recommendations based on your specific project requirements.</p>
                </div>
            </div>
            
            {{-- Feature 6 --}}
            <div class="builder-column builder-col-33">
                <div class="feature-box">
                    <img src="{{ asset('uploads/icons/rate.png') }}" alt="Large Scale" />
                    <h3>Large-Scale Scanning Needs</h3>
                    <p>For large-scale scanning of buildings, landscapes and industrial projects, visit us for expert solutions from <a href="https://redengineers.com.au/" target="_blank" style="color: #DA200B;">Red Engineer</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

                </div>
            </article>
        </div>
    </div>
</div></div>

<script>
	// Trigger fancy image animation on load and scroll
	document.addEventListener('DOMContentLoaded', function() {
		const fancyImages = document.querySelectorAll('.master-fancy-image');
		
		const observerOptions = {
			root: null,
			rootMargin: '0px',
			threshold: 0.1
		};
		
		const observer = new IntersectionObserver(function(entries) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-in-view');
				}
			});
		}, observerOptions);
		
		fancyImages.forEach(function(img) {
			observer.observe(img);
		});
		
		// Immediately add is-in-view to elements already in viewport
		fancyImages.forEach(function(img) {
			const rect = img.getBoundingClientRect();
			if (rect.top < window.innerHeight && rect.bottom > 0) {
				img.classList.add('is-in-view');
			}
		});
	});
</script>
@endsection
