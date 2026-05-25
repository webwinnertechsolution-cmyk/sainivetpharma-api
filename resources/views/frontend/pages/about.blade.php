@extends('frontend.layouts.layout')

@section('title', $title ?? 'About Us - Red-Labs')
@section('description', 'Offering an Innovative, Sustainable and Environmental Friendly Solution is Our Goal')

@section('content')
<style>

    .builder-container {
        display: flex !important;
        flex-wrap: wrap !important;
        max-width: 1200px !important;
        margin: 0 auto !important;
        position: relative !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

    .master-fancy-image img {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        max-width: 87% !important;
        height: auto !important;
    }
    .master-fancy-image-holder {
        display: block !important;
    }
    .master-fancy-image {
        display: block !important;
    }
    
    /* Standard Section Spacing */
    .about-section {
        padding: 80px 0;
    }
    
    @media (max-width: 1024px) {
        .about-section {
            padding: 40px 0;
        }
    }

    /* Responsive Typography */
    .main-heading {
        font-size: 42px !important;
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
        .about-section {
            padding: 50px 0 !important;
        }
    }
    
    
    .master-fancy-image-bg {
    content: "";
    position: absolute !important;
    top: 20px !important;
    left: 20px !important;
    right: 20px !important;
    bottom: 20px !important;
    width: 88% !important;
    height: 93% !important;
    background-color: var(--e-global-color-primary);
    z-index: -1;
}

    /* Core Values Refinement */
    .core-values-section .master-icon {
        width: 100px;
        height: 100px;
        background-color: #DA200B;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: transform 0.3s ease;
    }
    .core-values-section .master-icon:hover {
        transform: scale(1.1);
    }
    .core-values-section .master-icon i {
        color: #ffffff !important;
        font-size: 40px !important;
    }
    .core-values-section .master-icon img {
        max-height: 50px;
        filter: brightness(0) invert(1); /* Make images white if they are icons */
    }
    .core-values-section .headline-2 {
        font-weight: 700 !important;
        letter-spacing: 0.5px;
        text-transform: capitalize;
        text-align: center;
    }

    /* Column alignment utilities */
    .builder-col-25, .col-25 {
        width: 25% !important;
    }
    .builder-col-50 {
        width: 50% !important;
    }
    
    @media (max-width: 1024px) {
        .builder-col-25, .col-25 {
            width: 50% !important;
            flex: 0 0 50% !important;
        }
    }
    
    @media (max-width: 1024px) {
        .builder-col-25, .col-25, .builder-col-50 {
            width: 100% !important;
            flex: 0 0 100% !important;
        }
        .builder-container {
            flex-direction: column !important;
        }
    }
    
      .sub-heading {
        font-size: 18px !important;
        line-height: 1.6 !important;
        text-align: justify !important;
    }

    /* Optional: Better word spacing for justify */
    .sub-heading p {
        text-align: justify !important;
        text-justify: inter-word;
    }
	h2.main-heading {
    font-size: 20px!important;
    color: #30674d!important;
}
.master-heading .sub-heading p {
    margin-bottom: 15px;
    text-align: left!important;
    font-size: 14px;
}
.master-fancy-image-bg {
    content: "";
    position: absolute !important;
    top: 20px !important;
    left: 20px !important;
    right: 20px !important;
    bottom: 20px !important;
    width: 88% !important;
    height: 93% !important;
    background-color: var(--e-global-color-primary);
    z-index: -1;
    display: none;
}
.builder-container {
    display: flex !important;
    flex-wrap: unset !important;
    max-width: 1200px !important;
    margin: 0 auto !important;
    position: relative !important;
    padding-left: 0px !important;
    padding-right: 0px !important;
    align-items: top;
}
.builder-column.builder-col-50 {
    padding: 0;
}
.master-fancy-image img {
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
    max-width: 100% !important;
    height: auto !important;
    border-radius: 10px;
}
.builder-container.builder-column-gap-extended {
    gap: 20px;
}
.about-section {
    padding: 47px 0;
}
.core-values-section .master-icon {
    width: 94px;
    height: 94px;
    background-color: #30674d;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    transition: transform 0.3s ease;
}
.core-values-section .headline-2 {
    font-weight: 600 !important;
    letter-spacing: 0.5px;
    text-transform: capitalize;
    text-align: center;
    color: #000000!important;
    font-size: 16px!important;
}
.builder-container {
    align-items: top!important;
}
.master-heading.align-center {
    margin-bottom: 2px!important;
}
.builder-container {
    display: flex !important;
    flex-wrap: unset !important;
    max-width: 1200px !important;
    margin: 0 auto !important;
    position: relative !important;
    padding-left: 0px !important;
    padding-right: 0px !important;
    align-items: top!important;
}
.pre-heading {
    display: none;
}
.builder-column {
    width: 50%;
}
.power-tabs-content {
    margin-top: 0!important;
}
.power-tabs-content p {
    font-size: 14px!important;
    color: black;
    line-height: 21px;
    margin-bottom: 6px;
}
.power-tabs-content li {
    font-size: 14px!important;
    color: black;
    line-height: 21px;
    margin-bottom: 6px;
}
.builder-column {
    padding: 0;
}
.builder-container.builder-column-gap-extended {
    gap: 20px;
    align-items: center;
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
div#site-content {
    padding-top: 0!important;
}
section.builder-section.about-section.offering-section.builder-section-boxed {
    padding-top: 10px;
}
.builder-column.builder-col-25.col-25 {
    margin-bottom: 5px!important;
}
.builder-container.builder-column-gap-default {
    padding-top: 18px;
}

.master-icon-box.align-center.icon-position-top {
    padding-inline: 26px;
}
  
    @media (max-width: 767px) {
section.builder-section.about-section.offering-section.builder-section-boxed {
    padding-inline: 20px!important;
}
.master-heading {
    margin-bottom: 0;
}
section.builder-section.about-section.offering-section.builder-section-boxed {
    padding-top: 0!important;
}
.sgdsgdgdfgdfg  .builder-container.builder-column-gap-default {
    flex-direction: row!important;
    flex-wrap: wrap!important;
}
.sgdsgdgdfgdfg .builder-container.builder-column-gap-default .builder-column.builder-col-25.col-25 {
    width: 50%!important;
    flex: 0 0 50% !important;
}
section.builder-section.about-section.core-values-section.builder-section-boxed.sgdsgdgdfgdfg {
    padding-bottom: 30px!important;
}
section.builder-section.about-section.power-section.builder-section-boxed {
    padding-inline: 20px!important;
}
.builder-column {
    width: 100%;
    padding: 0!important;
}
section.builder-section.about-section.core-values-section.builder-section-boxed.sgdsgdgdfgdfg {
    padding-bottom: 46px!important;
}
	}
</style>
<div class="blog-banner">
    <div class="blog-banner-content">
        <h1>About Us</h1>
    </div>
</div>
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix" style="width: 100%; padding-top:50px;">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content">
                <div class="builder">
                    
                    {{-- Offering Section --}}
                    @if($offering)
                    <section class="builder-section about-section offering-section builder-section-boxed">
                        <div class="container">
                            <div class="builder-container builder-column-gap-extended" style="flex-wrap: wrap;align-items: top!important;">
                                <div class="builder-column builder-col-50">
                                    <div class="builder-widget-wrap">
                                        <div class="master-heading">
                                            <h2 class="main-heading">{!! $offering->heading !!}</h2>
                                            <div class="sub-heading">{!! $offering->description !!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="builder-column builder-col-50">
                                    <div class="builder-widget-wrap">
                                        <div class="master-fancy-image about-us-img-bck">
                                            <div class="master-fancy-image-inner">
                                                <span class="master-fancy-image-bg"></span>
                                                <div class="master-fancy-image-holder">
                                                    <img fetchpriority="high" decoding="async" width="514" height="514"
                                                        src="{{ asset('uploads/offering/' . $offering->image) }}"
                                                        alt="{{ $offering->alt_tag }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif

                    {{-- Core Values Section --}}
                    @if($coreValueMain && $coreValues->count() > 0)
                    <section class="builder-section about-section core-values-section builder-section-boxed sgdsgdgdfgdfg"
                        style=" background-position: center center; background-repeat: no-repeat; background-size: cover; position: relative;">
                        <div class="builder-background-overlay" style="background-color:#f0f4f0; opacity: 0.65; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></div>
                        
                        <div class="container" style="position: relative; z-index: 2;">
                            <div class="master-heading align-center" style="margin-bottom: 50px;">
                                <h2 class="main-heading" style="color: #ffffff">{{ $coreValueMain->heading1 }}</h2>
                            </div>
                            
                            {{-- Core Values Grid --}}
                            <div class="builder-container builder-column-gap-default" style="flex-wrap: wrap; justify-content: center;">
                                @foreach($coreValues as $coreValue)
                                <div class="builder-column builder-col-25 col-25" style="margin-bottom: 30px; display: flex; justify-content: center;">
                                    <div class="master-icon-box align-center icon-position-top" style="width: 100%;">
                                        <div class="icon-wrap" style="margin-bottom: 20px;">
                                            <div class="master-icon">
                                                @if(Str::contains($coreValue->image, ['.png', '.jpg', '.jpeg', '.webp', '.gif', '.svg']))
                                                    <img src="{{ asset('uploads/corevalues/' . $coreValue->image) }}" alt="{{ $coreValue->heading }}">
                                                @else
                                                    @php
                                                        $iconClass = $coreValue->image;
                                                        // Map missing 'fe' icons to FontAwesome equivalents
                                                        if (Str::startsWith($iconClass, 'fe ')) {
                                                            $iconClass = str_replace(['fe fe-user-check', 'fe fe-life-buoy'], ['fas fa-user-check', 'fas fa-life-ring'], $iconClass);
                                                        }
                                                    @endphp
                                                    <i class="{{ $iconClass }}"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-wrap">
                                            <h3 class="headline-2" style="color: #ffffff; font-size: 22px; margin: 0;">{{ $coreValue->heading }}</h3>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    @endif

                    {{-- Experience the Power Section --}}
                    @if($experienceThePower)
                    <section class="builder-section about-section power-section builder-section-boxed">
                        <div class="container">
                            <div class="builder-container builder-column-gap-extended builder-section-content-middle" style="flex-wrap: wrap;">
                                <div class="builder-column builder-col-50">
                                    <div class="builder-widget-wrap">
                                        <div class="master-heading" style="margin-bottom:0px !important;">
                                            <div class="pre-heading" style="color: #DA200B; font-weight: 600; text-transform: uppercase; margin-bottom: 0px !important;">{{ $experienceThePower->sub_heading }}</div>
                                            <h2 class="main-heading">{!! $experienceThePower->heading !!}</h2>
                                        </div>
                                        <div class="power-tabs-content" style="margin-top: 25px;">
                                            {!! $experienceThePower->description !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="builder-column ">
                                    <div class="builder-widget-wrap">
                                        <div class="master-fancy-image">
                                            <div class="master-fancy-image-inner">
                                                <span class="master-fancy-image-bg"></span>
                                                <div class="master-fancy-image-holder">
                                                    <img decoding="async" width="420" height="533"
                                                        src="{{ asset('uploads/experience-the-power/' . $experienceThePower->image) }}"
                                                        alt="{{ $experienceThePower->alt_tag }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif

                </div>
            </article>
        </div>
    </div>
</div></div>
@endsection
