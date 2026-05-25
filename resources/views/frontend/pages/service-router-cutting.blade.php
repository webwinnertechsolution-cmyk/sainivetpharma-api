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
    margin: 20px 20px 0 0; /* Space for the red background */
}
.master-fancy-image-inner {
    position: relative;
    display: block;
    z-index: 1;
}
/*.master-fancy-image-holder {*/
/*    position: relative;*/
/*    z-index: 2;*/
/*    overflow: hidden;*/
/*}*/
.master-fancy-image img {
    display: block;
    max-width: 100%;
    height: auto;
    opacity: 1;
    position: relative;
    z-index: 2;
}
.master-fancy-image-bg {
    content: "";
    position: absolute;
    top: -20px;
    left: -20px;
    width: 100%;
    height: 100%;
    background-color: #DA200B;
    z-index: 1;
    transition: transform 0.5s ease;
}
.master-fancy-image:hover .master-fancy-image-bg {
    transform: translate(-10px, -10px);
}

/* Service Section Padding */
.service-section {
    padding: 110px 0  80px  0px;
}



.bg-scanning .sub-heading, 
.bg-scanning p, 
.bg-scanning .builder-icon-list-text {
    color: #ffffff;
}

/* Background Section for Router which was missing */
.bg-router {
    background-image: url({{ asset('uploads/backgrounds/bg-image-41.png') }});
    background-position: center bottom;
    background-repeat: no-repeat;
    background-size: cover;

}




/* Icon List */
.builder-icon-list-items {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}
.builder-icon-list-item {
    display: flex;
    align-items: flex-start; /* Changed to start for multi-line text */
    margin-bottom: 10px;
    font-size: 15px;
}
.builder-icon-list-icon {
    margin-right: 10px;
    color: #DA200B;
    min-width: 20px; /* Ensure icon has space */
}

/* Inline List */
.builder-inline-items {
    display: flex;
    flex-wrap: wrap;
}
.builder-inline-item {
    width: 48%; /* Creates a 2-column list */
    margin-right: 2%;
}
@media (max-width: 1024px) {
    .builder-inline-item {
        width: 100%;
        margin-right: 0;
    }
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

/* Spacing Helpers */
.mb-20 { margin-bottom: 20px; }
.mb-30 { margin-bottom: 30px; }
.mt-20 { margin-top: 20px; }
</style>
@endpush

@section('content')
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content page type-page status-publish hentry">

                {{-- Hero Section --}}
                <section class="service-section">
                    <div class="builder-container" style="padding-top:20px;">
                        {{-- Left Column: Text Content --}}
                        <div class="builder-column builder-col-50">
                            <div class="master-heading">
                                <h1 class="main-heading">Advanced <span style="color:#DA200B">Router Cutting</span> Services at RED-LABS</h1>
                                <div class="divider"></div>
                                <div class="sub-heading">
                                    <b><span style="color:#DA200B">RED-</span>LABS</b> provides in-house router cutting services for a variety of custom projects, including letters, stencils, area guards, conveyor guards and signage. We work with a wide range of materials such as acrylic, HDPE, timber and other composite materials.
                                    <br><br>
                                    Our experienced team leverages advanced technology to ensure every cut meets the highest standards of precision and quality. Using our cutting-edge flatbed router machine, we deliver precise and cost-effective solutions tailored to your needs.
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Image --}}
                        <div class="builder-column builder-col-50">
                            <div style="padding: 10px;">
                                <div class="master-fancy-image">
                                    <div class="master-fancy-image-inner">
                                        <span class="master-fancy-image-bg"></span>
                                        <div class="master-fancy-image-holder">
                                            @if(isset($service) && $service->image && file_exists(public_path('uploads/ourservice/'.$service->image)))
                                                <img src="{{ asset('uploads/ourservice/'.$service->image) }}" alt="Router Cutting" />
                                            @else
                                                <img src="{{ asset('uploads/ourservice/cnc-plastics-2a-types.jpg') }}" alt="Router Cutting" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Secondary Section (Dark Background) --}}
                <section class="service-section bg-router">
                    <div class="builder-container">
                        {{-- Left Column: Secondary Image --}}
                        <div class="builder-column builder-col-50">
                            <div style="padding: 10px;">
                                <div class="master-fancy-image">
                                    <div class="master-fancy-image-inner">
                                        <span class="master-fancy-image-bg"></span>
                                        <div class="">
                                            <img src="{{ asset('uploads/ourservice/router-cutting.jpg') }}" alt="CNC Router Cutting" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Text & List --}}
                        <div class="builder-column builder-col-50">
                            <div>
                                <p class="sub-heading">Our commitment to precision and innovation is reflected in our advanced equipment, which offers:</p>
                                
                                <ul class="builder-icon-list-items builder-inline-items">
                                    <li class="builder-icon-list-item builder-inline-item">
                                        <span class="builder-icon-list-icon"><i class="fas fa-check"></i></span>
                                        <span class="builder-icon-list-text">Precision and Quality</span>
                                    </li>
                                    <li class="builder-icon-list-item builder-inline-item">
                                        <span class="builder-icon-list-icon"><i class="fas fa-check"></i></span>
                                        <span class="builder-icon-list-text">Advanced Technology</span>
                                    </li>
                                    <li class="builder-icon-list-item builder-inline-item">
                                        <span class="builder-icon-list-icon"><i class="fas fa-check"></i></span>
                                        <span class="builder-icon-list-text">Efficient and Timely</span>
                                    </li>
                                    <li class="builder-icon-list-item builder-inline-item">
                                        <span class="builder-icon-list-icon"><i class="fas fa-check"></i></span>
                                        <span class="builder-icon-list-text">Personalized Approach</span>
                                    </li>
                                    <li class="builder-icon-list-item builder-inline-item">
                                        <span class="builder-icon-list-icon"><i class="fas fa-check"></i></span>
                                        <span class="builder-icon-list-text">Competitive Pricing</span>
                                    </li>
                                    <li class="builder-icon-list-item builder-inline-item">
                                        <span class="builder-icon-list-icon"><i class="fas fa-check"></i></span>
                                        <span class="builder-icon-list-text">Versatile Materials</span>
                                    </li>
                                </ul>

                                <div class="sub-heading mb-20">
                                    <p>At <b><span style="color: #da200b;">RED-</span>LABS</b>, you can expect professional results and exceptional quality. Let's connect and explore how we can support your next project!</p>
                                </div>
                                
                                <div class="sub-heading">
                                    <p>Sending us files for Router Cutting</p>
                                    <p><strong>We cut a variety of materials on our CNC router ranges from 1mm – 50mm.</strong></p>
                                    <p>ABS, Rubber, HDPE, Polycarbonate, Ply Wood, UHWMPE & Acrylic.</p>
                                </div>

                                <a href="{{ route('upload-file') }}" class="builder-button">Instant Quotes</a>
                            </div>
                        </div>
                    </div>
                </section>

            </article>
        </div>
    </div>
</div></div>
@endsection
