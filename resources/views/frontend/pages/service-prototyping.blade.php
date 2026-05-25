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
    max-width: 500px; /* Constrain image width */
    margin: 0 auto; /* Center if smaller than column */
}
.master-fancy-image img {
    display: block;
    max-width: 100%;
    height: auto;
    opacity: 1;
}
.master-fancy-image-bg {
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    bottom: 20px;
    background-color: #DA200B;
    z-index: -1;
    transition: transform 0.5s ease;
}
.master-fancy-image:hover .master-fancy-image-bg {
    transform: translate(-10px, -10px);
}

/* Service Section Padding */
.service-section {
    padding: 110px 0;
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
                                <h1 class="main-heading">Prototyping <span style="color:#DA200B"></span></h1>
                                <div class="divider"></div>
                                <div class="sub-heading">
                                    We collaborate with you to design and build prototypes, ensuring that all potential flaws are identified and your product is manufactured within your budget requirements.
                                    <br><br>
                                    Creating a model of your invention will demonstrate its functionality and provide a clear understanding of the steps needed to bring your product to market.
                                </div>
                                
                                <a href="{{ route('upload-file') }}" class="builder-button">Instant Quotes</a>
                            </div>
                        </div>

                        {{-- Right Column: Image --}}
                        <div class="builder-column builder-col-50">
                            <div style="padding: 10px;">
                                <div class="master-fancy-image">
                                    <span class="master-fancy-image-bg"></span>
                                    {{-- Trying the original image, with a fallback --}}
                                    @if(isset($service) && $service->image && file_exists(public_path('uploads/ourservice/'.$service->image)))
                                         <img src="{{ asset('uploads/ourservice/'.$service->image) }}" alt="Prototyping" />
                                    @elseif(file_exists(public_path('uploads/ourservice/model-pic.jpg')))
                                         <img src="{{ asset('uploads/ourservice/model-pic.jpg') }}" alt="Prototyping" />
                                    @else
                                         {{-- Fallback image --}}
                                         <img src="{{ asset('uploads/ourservice/scanningpage.jpg') }}" alt="Prototyping" />
                                    @endif
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
