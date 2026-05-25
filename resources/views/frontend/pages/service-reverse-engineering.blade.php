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

/* Base Column Styles */
.builder-column {
    display: flex;
    flex-direction: column;
    padding: 0 15px;
    box-sizing: border-box;
    justify-content: center; /* Center content vertically */
}

.builder-col-50 {
    width: 50%;
    flex: 0 0 50%;
}

.builder-col-100 {
    width: 100%;
    flex: 0 0 100%;
}

@media (max-width: 1024px) {
    .builder-col-50,
    .builder-inner-column {
        width: 100% !important;
        flex: 0 0 100% !important;
        margin-bottom: 30px;
    }
    
    .builder-inner-column:last-child {
        margin-bottom: 0;
    }
}

/* Typography & Alignment */
.align-center { text-align: center; }
.main-heading {
    font-size: 36px;
    line-height: 1.2;
    margin-bottom: 20px;
    font-weight: 700;
}
.sub-heading {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 15px;
    color: #333;
}
.divider {
    height: 3px;
    width: 60px;
    background-color: #DA200B;
    margin-bottom: 20px;
}

/* Image Styles */
.master-fancy-image {
    position: relative;
    display: block;
}
.master-fancy-image img {
    display: block;
    max-width: 100%;
    height: auto;
    opacity: 1;
}
.master-fancy-image-bg {
    display: none !important;
}

/* Service Section Padding */
.service-section {
    padding: 110px 0;
}

/* Background Colors */
.bg-light {
    background-color: #f7f7f7;
}

/* Button */
.builder-button {
    display: inline-block;
    text-decoration: none;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 12px 24px;
    background-color: #DA200B;
    color: #fff !important;
    border-radius: 0;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    margin-top: 20px;
}
.builder-button:hover {
    background-color: #000000;
    color: #fff !important;
}
   @media screen and (min-width: 1025px) {
            .master-fancy-image {
                width: 100%;
                height: 100%;
            }
            
            .builder-col-50 .master-fancy-image {
                min-height: auto;
            }
            
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
</style>
@endpush

@section('content')
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content page type-page status-publish hentry">
                
                {{-- Section 1: Hero (White BG) - Text Left, Image Right --}}
                <section class="service-section">
                    <div class="builder-container" style="padding-top:20px;">
                        {{-- Left Column: Text Content --}}
                        <div class="builder-column builder-col-50">
                            <div class="master-heading">
                                <h1 class="main-heading">Reverse Engineering <span style="color:#DA200B">Services</span></h1>
                                <div class="divider"></div>
                                <div class="sub-heading">
                                    <b><span style="color:#DA200B">RED-</span>LABS</b> offers advanced reverse engineering services to refine product designs and revitalise equipment. Our expert team delivers precise CAD models and tailored solutions, helping you push boundaries and stay ahead. Transform your ideas into excellence with <b><span style="color:#DA200B">RED-</span>LABS</b>.
                                </div>
                                <a href="{{ route('upload-file') }}" class="builder-button">Instant Quotes</a>
                            </div>
                        </div>

                        {{-- Right Column: Image --}}
                        <div class="builder-column builder-col-50">
                            <div style="padding: 10px;">
                                <div class="master-fancy-image">
                                    <span class="master-fancy-image-bg"></span>
                                    <img src="{{ asset('uploads/ourservice/rev1.png') }}" alt="Reverse Engineering" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section 2: Accurate CAD Models (Grey BG) - Image Left, Text Right --}}
                <section class="service-section bg-light">
                    <div class="builder-container">
                        {{-- Left Column: Image --}}
                        <div class="builder-column builder-col-50">
                            <div style="padding: 10px;">
                                <div class="master-fancy-image">
                                    <span class="master-fancy-image-bg"></span>
                                    <img src="{{ asset('uploads/ourservice/rev4.png') }}" alt="CAD Models" />
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Text Content --}}
                        <div class="builder-column builder-col-50">
                            <div class="master-heading">
                                <h2 class="main-heading">Accurate CAD <span style="color:#DA200B">Models</span></h2>
                                <div class="sub-heading">
                                    <b><span style="color:#DA200B">RED-</span>LABS</b> team of skilled engineers utilises cutting-edge technology and advanced software to transform physical objects into highly accurate CAD models. Whether you need to recreate existing products or make enhancements, our reliable CAD models provide a solid foundation for design, manufacturing and customisation.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section 3: Comprehensive Product Analysis (White BG) - Text Left, Image Right --}}
                <section class="service-section">
                    <div class="builder-container">
                        {{-- Left Column: Text Content --}}
                        <div class="builder-column builder-col-50">
                            <div class="master-heading">
                                <h2 class="main-heading">Comprehensive Product <span style="color:#DA200B">Analysis</span></h2>
                                <div class="sub-heading">
                                    Beyond CAD models, <b><span style="color:#DA200B">RED-</span>LABS</b> offers a thorough analysis of your product's functionality, performance and structure. Utilising advanced tools, we identify areas for improvement and ensure your product meets specific requirements. This empowers you to make informed decisions and enhance your product's overall performance.
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Image --}}
                        <div class="builder-column builder-col-50">
                            <div style="padding: 10px;">
                                <div class="master-fancy-image">
                                    <span class="master-fancy-image-bg"></span>
                                    <img src="{{ asset('uploads/ourservice/rev3.png') }}" alt="Product Analysis" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section 4: Innovative Solutions (Grey BG) - Image Left, Text Right --}}
                <section class="service-section bg-light">
                    <div class="builder-container">
                        {{-- Left Column: Image --}}
                        <div class="builder-column builder-col-50">
                            <div style="padding: 10px;">
                                <div class="master-fancy-image">
                                    <span class="master-fancy-image-bg"></span>
                                    <img src="{{ asset('uploads/ourservice/rev2.png') }}" alt="Innovative Solutions" />
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Text Content --}}
                        <div class="builder-column builder-col-50">
                            <div class="master-heading">
                                <h2 class="main-heading">Innovative <span style="color:#DA200B">Solutions</span></h2>
                                <div class="sub-heading">
                                    <b><span style="color:#DA200B">RED-</span>LABS</b> brings you cutting-edge reverse engineering solutions that redefine product development. We blend expert analysis with advanced technology to reveal opportunities for enhancement, performance elevation and optimisation of your manufacturing processes and elevate performance. Our tailored strategies help you reduce costs and stay ahead of evolving customer demands.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </article>
        </div>
    </div>
</div></div>
@endsection
