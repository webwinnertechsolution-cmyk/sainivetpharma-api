@extends('frontend.layouts.layout')

@section('title', $title ?? 'Industries - Red-Labs')

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
    padding: 130px 0 50px 0;
}

/* Background Colors */
.bg-light {
    background-color: #f7f7f7;
}

/* Button (if needed later) */
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
                
                @forelse($industries as $industry)
                    @php
                        // Create a slug-like ID from the heading if possible, otherwise generic
                        $sectionId = $industry->heading ? \Illuminate\Support\Str::slug(strip_tags($industry->heading)) : 'industry-' . $loop->iteration;
                    @endphp

                    {{-- Alternating Backgrounds: Odd = White, Even = Light Grey --}}
                    <section class="service-section {{ $loop->even ? 'bg-light' : '' }}" id="{{ $sectionId }}">
                        <div class="builder-container">
                            
                            @if($industry->layout == 'left') 
                                {{-- Layout: Image Left, Text Right --}}
                                
                                {{-- Image Column --}}
                                <div class="builder-column builder-col-50">
                                    <div style="padding: 10px;">
                                        <div class="master-fancy-image">
                                            <span class="master-fancy-image-bg"></span>
                                            @if($industry->image)
                                                <img src="{{ asset('uploads/industry/' . $industry->image) }}" 
                                                     alt="{{ $industry->alt_tag ?? strip_tags($industry->heading) ?? 'Industry Image' }}" />
                                            @else
                                                <img src="{{ asset('frontend/images/default-industry.jpg') }}" alt="Default Industry Image" />
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Text Column --}}
                                <div class="builder-column builder-col-50">
                                    <div class="master-heading">
                                        @if($industry->heading)
                                            <h2 class="main-heading">{!! $industry->heading !!}</h2>
                                        @endif
                                        
                                        @if($industry->description)
                                            <div class="sub-heading">{!! $industry->description !!}</div>
                                        @endif
                                    </div>
                                </div>

                            @else 
                                {{-- Layout: Text Left, Image Right --}}
                                
                                {{-- Text Column --}}
                                <div class="builder-column builder-col-50">
                                    <div class="master-heading">
                                        @if($industry->heading)
                                            <h2 class="main-heading">{!! $industry->heading !!}</h2>
                                        @endif
                                        
                                        @if($industry->description)
                                            <div class="sub-heading">{!! $industry->description !!}</div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Image Column --}}
                                <div class="builder-column builder-col-50">
                                    <div style="padding: 10px;">
                                        <div class="master-fancy-image">
                                            <span class="master-fancy-image-bg"></span>
                                            @if($industry->image)
                                                <img src="{{ asset('uploads/industry/' . $industry->image) }}" 
                                                     alt="{{ $industry->alt_tag ?? strip_tags($industry->heading) ?? 'Industry Image' }}" />
                                            @else
                                                <img src="{{ asset('frontend/images/default-industry.jpg') }}" alt="Default Industry Image" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </section>
                @empty
                    <div class="builder-container" style="padding: 100px 0; text-align: center;">
                        <p>No industries found.</p>
                    </div>
                @endforelse

            </article>
        </div>
    </div>
</div></div>
@endsection
