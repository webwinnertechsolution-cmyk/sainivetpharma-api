@extends('frontend.layouts.layout')

@section('title', 'Our Services - Red-Labs')
@section('description', 'Discover our comprehensive range of services including 3D Printing, 3D Scanning, Reverse Engineering, Plastic Fabrication, and more.')

@section('content')
<div id="content-wrap" class="byron-container">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content post-services page type-page status-publish hentry">
                <div data-builder-type="wp-page" data-builder-id="services" class="builder builder-services" data-builder-post-type="page">
                    
                    {{-- Services Hero Section --}}
                    @if($ourServiceMain)
                    <section class="builder-section builder-top-section builder-element builder-section-stretched builder-section-full_width builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no"
                        data-element_type="section" data-settings='{"stretch_section":"section-stretched","background_background":"classic"}'
                        style="width: 100%; background-image: url({{ asset('uploads/ourservicemain/'.$ourServiceMain->image1) }}); background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 100px 5% 100px 5%;">
                        <div class="builder-background-overlay" style="background-color: #000000; opacity: 0.6"></div>
                        <div class="builder-container builder-column-gap-default">
                            <div class="builder-column builder-col-100 builder-top-column builder-element" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated">
                                    <div class="builder-element align-center builder-widget builder-widget-mae-headings" data-element_type="widget" data-widget_type="mae-headings.default">
                                        <div class="builder-widget-container">
                                            <div class="master-heading">
                                                <h1 class="main-heading" style="color: #ffffff; font-size: 48px; margin-bottom: 20px;">{{ $ourServiceMain->heading1 }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif

                    {{-- Services Grid Section --}}
                    @if($ourServices && $ourServices->count() > 0)
                    <section class="builder-section builder-top-section builder-element builder-section-stretched builder-section-boxed builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" 
                        data-element_type="section" data-settings='{"stretch_section":"section-stretched","background_background":"classic"}'
                        style="padding: 80px 5% 80px 5%;">
                        <div class="builder-container builder-column-gap-default">
                            <div class="builder-column builder-col-100 builder-top-column builder-element" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated">
                                    <div class="builder-element align-center builder-widget builder-widget-mae-headings" data-element_type="widget" data-widget_type="mae-headings.default" style="margin-bottom: 50px;">
                                        <div class="builder-widget-container">
                                            <div class="master-heading">
                                                <h2 class="main-heading"><span style="color:#000">Our <span style="color:#DA200B">Services</span></span></h2>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <section class="builder-section builder-inner-section builder-element wpr-sticky-section-no wpr-particle-no wpr-jarallax-no wpr-parallax-no" 
                                        data-element_type="section">
                                        <div class="builder-container builder-column-gap-narrow" style="display: flex; flex-wrap: wrap; justify-content: center;">
                                            @php
                                                $serviceIcons = [
                                                    'fas fa-cube',           // 3D Printing
                                                    'fas fa-camera',         // 3D Scanning  
                                                    'fas fa-cogs',           // Reverse Engineering
                                                    'fas fa-industry',       // Plastic Fabrication
                                                    'fas fa-drafting-compass', // Prototyping
                                                    'fas fa-cut',            // Router Cutting
                                                    'fas fa-tools',          // General Services
                                                    'fas fa-shield-alt'      // Safety Guards
                                                ];
                                            @endphp
                                            @foreach($ourServices as $index => $service)
                                            @php
                                                $iconClass = $serviceIcons[$index % count($serviceIcons)];
                                            @endphp
                                            <div class="builder-column builder-col-20 builder-inner-column builder-element service-card" data-element_type="column" 
                                                style="width: 20%; min-width: 280px; margin-bottom: 30px; padding: 0 15px;">
                                                <div class="builder-widget-wrap builder-element-populated" style="height: 100%;">
                                                    <div class="builder-element align-center hover-effect-style-1 icon-position-top builder-widget builder-widget-mae-icon-box" 
                                                        data-element_type="widget" data-widget_type="mae-icon-box.default"
                                                        style="height: 100%; background: #f8f9fa; padding: 30px 20px; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                                        <div class="builder-widget-container" style="height: 100%; display: flex; flex-direction: column;">
                                                            <div class="master-icon-box" style="height: 100%; display: flex; flex-direction: column;">
                                                                <div class="icon-wrap" style="margin-bottom: 20px;">
                                                                    <div class="master-icon" style="font-size: 48px; color: #DA200B;">
                                                                        @if($service->icon && file_exists(public_path('uploads/ourservice/'.$service->icon)))
                                                                            <img src="{{ asset('uploads/ourservice/'.$service->icon) }}" alt="{{ $service->heading }}" style="width: 64px; height: 64px; object-fit: contain;">
                                                                        @else
                                                                            <i class="{{ $iconClass }}"></i>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="text-wrap" style="flex: 1; display: flex; flex-direction: column;">
                                                                    <h3 class="headline-2" style="font-size: 22px; margin-bottom: 15px; color: #030f27;">{!! $service->heading !!}</h3>
                                                                    <div class="desc" style="color: #666; font-size: 15px; line-height: 1.6; margin-bottom: 20px; flex: 1;">{!! $service->description !!}</div>
                                                                    @if($service->button_url && $service->button_url !== '#')
                                                                    <div class="url-wrap" style="margin-top: auto;">
                                                                        <a class="master-link icon-right" href="{{ $service->button_url }}" 
                                                                            style="color: #DA200B; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                                                            <span>{{ $service->button_text ?? 'READ MORE' }}</span>
                                                                            <span class="icon fa fa-arrow-right"></span>
                                                                        </a>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif

                    {{-- CTA Section --}}
                    <section class="builder-section builder-top-section builder-element builder-section-stretched builder-section-full_width builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no"
                        data-element_type="section" data-settings='{"stretch_section":"section-stretched","background_background":"classic"}'
                        style="background-color: #DA200B; padding: 60px 5% 60px 5%;">
                        <div class="builder-container builder-column-gap-default">
                            <div class="builder-column builder-col-100 builder-top-column builder-element" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated">
                                    <div class="row align-items-center">
                                        <div class="col-lg-8">
                                            <h2 style="font-size: 36px; font-weight: 700; margin-bottom: 15px; color: #fff;">Ready to Bring Your Ideas to Life?</h2>
                                            <p style="font-size: 18px; opacity: 0.9; color: #fff;">Contact us today to discuss your project requirements and get a free quote</p>
                                        </div>
                                        <div class="col-lg-4 text-lg-end text-center mt-4 mt-lg-0">
                                            <a href="{{ route('contact') }}" class="btn btn-light btn-lg" 
                                                style="padding: 15px 40px; font-size: 16px; font-weight: 600; border-radius: 50px; background: #fff; color: #DA200B; text-decoration: none;">
                                                Get In Touch
                                            </a>
                                        </div>
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

<style>
    .service-card .builder-element:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    
    .service-card .master-link:hover {
        color: #b01808;
    }
    
    @media (max-width: 1024px) {
        .service-card {
            width: 100% !important;
            min-width: auto !important;
        }
        
        section h1 {
            font-size: 32px !important;
        }
        
        section h2 {
            font-size: 28px !important;
        }
    }
</style>
@endsection
