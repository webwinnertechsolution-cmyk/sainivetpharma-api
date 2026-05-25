@extends('frontend.layouts.layout')

@section('title', $title ?? $service->meta_title ?? $service->heading . ' - Red Labs Service')
@section('meta_description', $meta_description ?? $service->meta_description ?? Str::limit(strip_tags($service->description), 160))
@section('meta_keywords', $service->meta_keywords)
@section('og_title', $og_title ?? $service->og_title ?? $service->meta_title ?? $service->heading)
@section('og_description', $og_description ?? $service->og_description ?? $service->meta_description ?? Str::limit(strip_tags($service->description), 160))
@section('og_image', $og_image ?? ($service->og_image ? asset('uploads/ourservice/og/' . $service->og_image) : ($service->image ? asset('uploads/ourservice/' . $service->image) : asset('public/backend/assets/images/favicon.png'))))



@push('styles')
<style>
/* Specific Plastic Fabrication Styles matching WordPress post-4108e4e2.css structure */
.builder-4108 .builder-element.builder-element-63ffdac{padding:0% 5% 0% 5%;}
.builder-4108 .builder-element.builder-element-8830caa .master-heading .main-heading{color:var( --e-global-color-secondary );margin-bottom:20px;}
.builder-4108 .builder-element.builder-element-8830caa .master-heading h2{font-family:var( --e-global-typography-primary-font-family ), Sans-serif;}
.builder-4108 .builder-element.builder-element-8830caa .master-heading .sub-heading{color:var( --e-global-color-text );font-family:var( --e-global-typography-text-font-family ), Sans-serif;font-weight:var( --e-global-typography-text-font-weight );margin-bottom:0px;}
.builder-4108 .builder-element.builder-element-8830caa .master-heading .divider{margin-bottom:20px;}

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
}
.master-fancy-image {
    display: block !important;
}

/* Two Column Layout */
.builder-col-50 {
    width: 50%;
    float: left;
    padding: 0 15px;
    box-sizing: border-box;
}

/* Five Column Layout */
.builder-col-20 {
    width: 20%;
    float: left;
    padding: 0 12px;
    box-sizing: border-box;
    position: relative;
    max-width: 20%;
}

@media (max-width: 991px) {
    .builder-col-20 {
        width: 33.33%;
        max-width: 33.33%;
        margin-bottom: 30px;
    }
}

@media (max-width: 1024px) {
    .builder-col-50,
    .builder-col-20,
    .builder-inner-column {
        width: 100% !important;
        max-width: 100% !important;
        float: none;
        margin-bottom: 30px;
    }
    
    .builder-col-50 {
        padding: 0;
    }
    
    .builder-inner-column:last-child {
        margin-bottom: 0;
    }
}

/* Container */
.builder-container {
    max-width: 1250px !important;
    margin: 0 auto;
    padding: 0 0px;
    position: relative;
    z-index: 1;
}

.builder-container:after {
    content: "";
    display: table;
    clear: both;
}

/* Section Padding & BG */
.builder-top-section {
    padding: 80px 0 80px 0;
    background: #f7f7f7;
    width: 100%;
    position: relative;
}

/* Icon List Styling */
.builder-icon-list-items {
    list-style: none;
    padding: 0;
    margin: 0;
}

.builder-icon-list-item {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.builder-icon-list-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
}

.builder-icon-list-icon svg {
    width: 14px !important;
    height: 14px !important;
    fill: #DA200B;
}

.builder-icon-list-text {
    flex: 1;
    color: #000000;
    font-size: 16px;
}

/* Master Fancy Image Background & Holder */
.master-fancy-image-holder,
.master-fancy-image-bg {
    -webkit-transition: opacity 1s 0s cubic-bezier(0.23, 1, 0.32, 1), -webkit-transform 1.5s 0.25s cubic-bezier(0.23, 1, 0.32, 1);
    transition: opacity 1s 0s cubic-bezier(0.23, 1, 0.32, 1), -webkit-transform 1.5s 0.25s cubic-bezier(0.23, 1, 0.32, 1);
    transition: opacity 1s 0s cubic-bezier(0.23, 1, 0.32, 1), transform 1.5s 0.25s cubic-bezier(0.23, 1, 0.32, 1);
    transition: opacity 1s 0s cubic-bezier(0.23, 1, 0.32, 1), transform 1.5s 0.25s cubic-bezier(0.23, 1, 0.32, 1), -webkit-transform 1.5s 0.25s cubic-bezier(0.23, 1, 0.32, 1);
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0);
    opacity: 0;
}

.master-fancy-image-bg {
    display: inline-block;
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    bottom: 20px;
    z-index: 0;
    background-color: #f5ad0d;
    width: 100%;
    height: 100%;
}

.master-fancy-image-holder,
.master-fancy-image {
    position: relative;
}

.master-fancy-image.is-in-view .master-fancy-image-bg,
.master-fancy-image.is-in-view .master-fancy-image-holder {
    opacity: 1;
}

/* Background position variants */
.master-fancy-image.bg-top { 
    margin: 0 20px 20px 0; 
}

.master-fancy-image.is-in-view.bg-top .master-fancy-image-bg {
    -webkit-transform: translate(-20px, -20px);
    transform: translate(-20px, -20px);
}

.master-fancy-image.is-in-view.bg-top .master-fancy-image-holder {
    -webkit-transform: translate(20px, 20px);
    transform: translate(20px, 20px);
}

.master-fancy-image.bg-left { 
    margin: 0 20px 20px 0; 
}

.master-fancy-image.is-in-view.bg-left .master-fancy-image-bg {
    -webkit-transform: translate(-20px, -20px);
    transform: translate(-20px, -20px);
}

.master-fancy-image.is-in-view.bg-left .master-fancy-image-holder {
    -webkit-transform: translate(20px, 20px);
    transform: translate(20px, 20px);
}

/* Icon Box Styling */
.master-icon-box {
    text-align: center;
    padding: 32px 24px 32px 24px;
    background: #fff;
    border-radius: 0;
    box-shadow: 0 8px 32px 0 rgba(0,0,0,0.10), 0 1.5px 4px 0 rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    margin-bottom: 30px;
    border: 1px solid #f0f0f0;
}

.master-icon-box:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 16px 40px 0 rgba(218,32,11,0.18), 0 2px 8px 0 rgba(0,0,0,0.10);
    border-color: #DA200B;
}

.master-icon-box .icon-wrap {
    margin-bottom: 15px;
}

.master-icon-box .headline-2 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #000000;
}

.master-icon-box .desc {
    font-size: 14px;
    color: #666666;
    line-height: 1.6;
}

/* Heading Styles */
.master-heading .main-heading {
    font-size: 42px;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 20px;
    color: #000000;
}

.master-heading .sub-heading {
    font-size: 18px;
    line-height: 1.6;
    color: #666666;
    margin-bottom: 20px;
}

/* Red divider */
.master-heading .divider {
    width: 60px;
    height: 4px;
    background-color: #DA200B;
    margin: 20px 0;
}

/* Button Styling */
.master-button {
    display: inline-block;
    padding: 15px 30px;
    background-color: #DA200B;
    color: #ffffff !important;
    text-decoration: none;
    font-weight: 600;
    border-radius: 0;
    transition: all 0.3s;
}

.master-button:hover {
    background-color: #b01808;
}

/* Icon Box Section Background Image */
.builder-element-a0e4264 {
    background: #f7f7f7 url('{{ asset('uploads/ourservice/plastic-fab-bg.jpg') }}') center center/cover no-repeat !important;
    position: relative;
}

/* Section 3 - Image + Details with background */
.builder-element-5d35c48:not(.builder-motion-effects-element-type-background),
.builder-element-5d35c48 > .builder-motion-effects-container > .builder-motion-effects-layer {
    background-color: #ffffff;
}
.builder-element-5d35c48 {
    transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
    padding: 0% 5% 0% 5%;
}

/* Capabilities Section Background */
.builder-element-6696ef7:not(.builder-motion-effects-element-type-background),
.builder-element-6696ef7 > .builder-motion-effects-container > .builder-motion-effects-layer {
    background-image: url('{{ asset('uploads/backgrounds/bg-image-41.png') }}');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
}
.builder-element-6696ef7 {
    transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
}

.builder-element-6696ef7 > .builder-background-overlay {
    background-color: rgba(0,0,0,0.5);
    opacity: 0.5;
    transition: background 0.3s, border-radius 0.3s, opacity 0.3s;
}

/* Pricing Table Styling */
.wpr-pricing-table {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 8px 32px 0 rgba(0,0,0,0.10);
    overflow: hidden;
}

.wpr-pricing-table-heading {
    padding: 30px;
    text-align: center;
}

.wpr-pricing-table-title {
    font-size: 24px;
    font-weight: 700;
    color: #000;
    margin-bottom: 10px;
}

.wpr-pricing-table-sub-title {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
}

/* Spacers */
.builder-widget-spacer .builder-spacer {
    height: var(--spacer-size, 50px);
}

.builder-element-945af35 { --spacer-size: 50px; }
.builder-element-62b68f7 { --spacer-size: 20px; }
.builder-element-02cec96 { --spacer-size: 30px; }
.builder-element-b616542 { --spacer-size: 50px; }
.builder-element-e413487 { --spacer-size: 50px; }
.builder-element-74b5048 { --spacer-size: 30px; }
.builder-element-39a993d { --spacer-size: 30px; }
.builder-element-cd49a07 { --spacer-size: 20px; }
.builder-element-21e50c0 { --spacer-size: 50px; }

/* Responsive */
@media(max-width:1024px) {
    .builder-col-20 {
        width: 33.333%;
        margin-bottom: 30px;
    }
}

@media(max-width:1024px) {
    .builder-col-50,
    .builder-col-20 {
        width: 100%;
        float: none;
        margin-bottom: 30px;
    }
    
    .master-heading .main-heading {
        font-size: 28px;
    }
}

/* Footer custom styles */
.footer-cstm {
    background: #1a1a1a;
    padding: 40px 0;
}
.footer-cstm-container {
    display: flex;
    flex-wrap: wrap;
}
.footer-cstm-colmns {
    padding: 20px;
}
.footer-cstm-colmns.border-rght {
    border-right: 1px solid rgba(255,255,255,0.1);
}
.footer-cstm-cont {
    display: flex;
    align-items: flex-start;
}
.footer-cstm-icn {
    color: #DA200B;
    font-size: 20px;
    margin-right: 15px;
    margin-top: 3px;
}
.footer-cstm-txt {
    color: #fff;
    font-size: 14px;
    line-height: 1.6;
    margin: 0;
}
</style>
@endpush

@section('content')
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content post-4108 page type-page status-publish hentry">
                <div data-builder-type="wp-page" data-builder-id="4108" class="builder builder-4108" data-builder-post-type="page">
                    
                    {{-- Section 1: Hero Section with Title + Image (Two Columns) --}}
                    <section class="builder-section builder-top-section builder-element builder-element-63ffdac builder-section-stretched builder-section-full_width builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" style="background-color:#fff;" data-id="63ffdac" data-element_type="section" data-settings='{"stretch_section":"section-stretched"}'>
                        <div class="builder-container builder-column-gap-default">
                            <div class="" style="padding-top:60px;" data-id="2f344d1" data-element_type="column">
                                <div class="">
                                    <section class="builder-section builder-inner-section builder-element builder-element-a36611d builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" style="padding-top:90px;"   data-id="a36611d" data-element_type="section">
                                        <div class="builder-container builder-column-gap-extended">
                                            {{-- Left Column - Content --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-7ce1b5e" data-id="7ce1b5e" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-8830caa align-left builder-widget builder-widget-mae-headings" data-id="8830caa" data-element_type="widget" data-widget_type="mae-headings.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-heading">
                                                                <h2 class="main-heading">Plastic <span style="color:#DA200B">Fabrication</span> / Plastic <span style="color:#DA200B">Processing  </span> </h2>
                                                                <div class="divider"></div>
                                                                <div class="sub-heading">At <b><span style="color:#DA200B">RED-</span>LABS</b>, we take pride in delivering top-notch plastic fabrication and processing solutions tailored to meet diverse industrial and commercial needs. Leveraging advanced technology and engineering expertise, we transform raw materials into high-quality products that align with your specific requirements.</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="builder-element builder-element-70544f6 builder-hidden-desktop builder-hidden-tablet builder-hidden-mobile builder-widget builder-widget-text-editor" data-id="70544f6" data-element_type="widget" data-widget_type="text-editor.default">
                                                        <div class="builder-widget-container">
                                                            <ul><li><strong>Custom Cutting</strong>: Precision cutting of sheet materials to any shape or size.</li><li><strong>Prototype Development</strong>: Partnering with clients to create effective prototypes.</li><li><strong>Professional Edge Finishing</strong>: Distinct methods to ensure a perfect edge finish on clear acrylic.</li><li><strong>Sign Fabrication</strong>: Custom signs in a variety of materials, fonts, sizes, shapes, and colors.</li><li><strong>Advanced Joining Techniques</strong>: Mastery in various gluing and joining methods.</li><li><strong>High-End Welding</strong>: Specializing in welding high-density products, such as chemical and portable tanks.</li><li><strong>2D &amp; 3D Engraving</strong>: Detailed and precise engraving and etching.</li></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Right Column - Image --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-f20c039" data-id="f20c039" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-dbfbb4d plt-fab-img-bck builder-widget builder-widget-mae-fancy-image" data-id="dbfbb4d" data-element_type="widget" data-widget_type="mae-fancy-image.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-fancy-image bg-top bg-left" data-in-viewport="true">
                                                                <div class="master-fancy-image-inner">
                                                                    <span class="master-fancy-image-bg"></span>
                                                                    <div class="master-fancy-image-holder">
                                                                        <img fetchpriority="high" decoding="async" width="1600" height="1200" src="{{ asset('/uploads/ourservice/cnc-plastics-2a-types.jpg') }}" class="attachment-full size-full wp-image-4142" alt="Plastic Fabrication" />
                                                                    </div>
                                                                </div>
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

                    {{-- Section 2: Services Icon Boxes (5 Column Layout) --}}
                    <section class="builder-section builder-top-section builder-element  builder-section-stretched builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" style="padding:0px;" data-id="a0e4264" data-element_type="section" data-settings='{"stretch_section":"section-stretched","background_background":"classic"}'>
                        <div class=" builder-column-gap-default">
                            <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-bd1ef88" style="padding-top:56px; padding-bottom:0px;" data-id="bd1ef88" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated">
                                    <section class="builder-section builder-inner-section builder-element builder-element-e41ee36 builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" style="padding:0px;" data-id="e41ee36" data-element_type="section">
                                        <div class="builder-container builder-column-gap-narrow" style="max-width:1255px !important;">
                                            {{-- Icon Box 1: Custom Cutting --}}
                                            <div class="builder-column builder-col-20 builder-inner-column builder-element builder-element-c36aead" data-id="c36aead" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-6dc28a9 align-center hover-effect-style-1 icon-position-top builder-widget builder-widget-mae-icon-box" data-id="6dc28a9" data-element_type="widget" data-widget_type="mae-icon-box.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-icon-box">
                                                                <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                                                <div class="text-wrap">
                                                                    <h3 class="headline-2">Custom<br>Cutting</h3><div class="desc">Precision cutting of sheet materials to any shape or size</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Icon Box 2: Prototype Development --}}
                                            <div class="builder-column builder-col-20 builder-inner-column builder-element builder-element-517d142" data-id="517d142" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-b9c579e align-center hover-effect-style-1 icon-position-top builder-widget builder-widget-mae-icon-box" data-id="b9c579e" data-element_type="widget" data-widget_type="mae-icon-box.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-icon-box">
                                                                <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                                                <div class="text-wrap">
                                                                    <h3 class="headline-2">Prototype<br>Development</h3><div class="desc">Partnering with clients to create effective prototypes</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Icon Box 3: Professional Edge Finishing --}}
                                            <div class="builder-column builder-col-20 builder-inner-column builder-element builder-element-c832961" data-id="c832961" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-c18beae align-center hover-effect-style-1 icon-position-top builder-widget builder-widget-mae-icon-box" data-id="c18beae" data-element_type="widget" data-widget_type="mae-icon-box.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-icon-box">
                                                                <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                                                <div class="text-wrap">
                                                                    <h3 class="headline-2">Professional<br>Edge Finishing</h3><div class="desc">Distinct methods to ensure a perfect edge finish on clear acrylic</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Icon Box 4: Sign Fabrication --}}
                                            <div class="builder-column builder-col-20 builder-inner-column builder-element builder-element-1fec722" data-id="1fec722" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-af6200f align-center hover-effect-style-1 icon-position-top builder-widget builder-widget-mae-icon-box" data-id="af6200f" data-element_type="widget" data-widget_type="mae-icon-box.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-icon-box">
                                                                <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                                                <div class="text-wrap">
                                                                    <h3 class="headline-2">Sign<br>Fabrication</h3><div class="desc">Custom signs in a variety of materials, fonts, sizes, shapes and colors</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Icon Box 5: 2D & 3D Engraving --}}
                                            <div class="builder-column builder-col-20 builder-inner-column builder-element builder-element-871dd8c" data-id="871dd8c" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-cab0200 align-center hover-effect-style-1 icon-position-top builder-widget builder-widget-mae-icon-box" data-id="cab0200" data-element_type="widget" data-widget_type="mae-icon-box.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-icon-box">
                                                                <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                                                <div class="text-wrap">
                                                                    <h3 class="headline-2">2D &amp; 3D<br>Engraving</h3><div class="desc">Detailed and precise engraving and etching for fine details</div>
                                                                </div>
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

                    {{-- Section 3: Image + Details Section (Two Columns - Image Left, Content Right) --}}
                    <section class="builder-section builder-top-section builder-element builder-element-5d35c48 builder-section-stretched builder-section-full_width builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" data-id="5d35c48" data-element_type="section" data-settings='{"stretch_section":"section-stretched"}'>
                        <div class="builder-container builder-column-gap-default">
                            <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-e88ddb4" data-id="e88ddb4" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated">
                                    <section class="builder-section builder-inner-section builder-element builder-element-7b20b79 builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" style="padding-bottom:20px;" data-id="7b20b79" data-element_type="section">
                                        <div class="builder-container builder-column-gap-extended">
                                            {{-- Left Column: Secondary Image --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-8795422" data-id="8795422" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-272ba38 plt-fab2-img-bck builder-widget builder-widget-mae-fancy-image" data-id="272ba38" data-element_type="widget" data-widget_type="mae-fancy-image.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-fancy-image bg-top bg-left" data-in-viewport="true">
                                                                <div class="master-fancy-image-inner">
                                                                    <span class="master-fancy-image-bg"></span>
                                                                    <div class="master-fancy-image-holder">
                                                                        <img decoding="async" width="1200" height="801" src="{{ asset('uploads/ourservice/cnc-plastics-2a-types.jpg') }}" class="attachment-full size-full wp-image-6034" alt="CNC Plastics" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Right Column: Features and Text --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-59c6739" data-id="59c6739" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    {{-- Intro Text --}}
                                                    <div class="builder-element builder-element-b188074 builder-widget builder-widget-text-editor" data-id="b188074" data-element_type="widget" data-widget_type="text-editor.default">
                                                        <div class="builder-widget-container">
                                                            <p>Our team is dedicated to providing exceptional plastic fabrication services with a commitment to quality and innovation. Let's connect and discuss how we can support your next project!</p>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Secondary Text --}}
                                                    <div class="builder-element builder-element-0f3c777 builder-widget builder-widget-text-editor" data-id="0f3c777" data-element_type="widget" data-widget_type="text-editor.default">
                                                        <div class="builder-widget-container">
                                                            <p>Our highly skilled team members offer professional advice with</p>
                                                        </div>
                                                    </div>
                                                    {{-- Icon List --}}
                                                    <div class="builder-element builder-element-5ee50df builder-list-item-link-inline builder-align-start builder-icon-list--layout-traditional builder-widget builder-widget-icon-list" data-id="5ee50df" data-element_type="widget" data-widget_type="icon-list.default">
                                                        <div class="builder-widget-container">
                                                            <ul class="builder-icon-list-items">
                                                                <li class="builder-icon-list-item">
                                                                    <span class="builder-icon-list-icon">
                                                                        <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                                                    </span>
                                                                    <span class="builder-icon-list-text">Choosing the right material</span>
                                                                </li>
                                                                <li class="builder-icon-list-item">
                                                                    <span class="builder-icon-list-icon">
                                                                        <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                                                    </span>
                                                                    <span class="builder-icon-list-text">Project Management and Design</span>
                                                                </li>
                                                                <li class="builder-icon-list-item">
                                                                    <span class="builder-icon-list-icon">
                                                                        <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                                                    </span>
                                                                    <span class="builder-icon-list-text">Prototyping</span>
                                                                </li>
                                                                <li class="builder-icon-list-item">
                                                                    <span class="builder-icon-list-icon">
                                                                        <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                                                    </span>
                                                                    <span class="builder-icon-list-text">All quotes processed by an experienced engineers</span>
                                                                </li>
                                                            </ul>
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

                    {{-- Section 4: Capabilities Section with Pricing Tables --}}
                    <section class="builder-section builder-top-section builder-element builder-element-6696ef7 builder-section-stretched builder-section-full_width builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" style="padding-bottom:0px;" data-id="6696ef7" data-element_type="section" data-settings='{"stretch_section":"section-stretched","background_background":"classic"}'>
                        <div class="builder-background-overlay"></div>
                        <div class="builder-container builder-column-gap-default">
                            <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-b945e7a" data-id="b945e7a" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated">
                                    
                                    {{-- Capabilities Heading --}}
                                    <div class="builder-element builder-element-0c877aa align-center builder-widget builder-widget-mae-headings" data-id="0c877aa" data-element_type="widget" data-widget_type="mae-headings.default">
                                        <div class="builder-widget-container">
                                            <div class="master-heading" style="text-align: center;">
                                                <h2 class="main-heading" style="color:#fff;"><span style="color:#DA200B">Capabilities </span></h2>
                                                <div class="sub-heading" style="color:#fff;">At RED-LABS, we leverage the latest equipment and cutting-edge technology to transform your ideas into tangible results.<br>
Our CNC router cutter, equipped with state-of-the-art vision system technology, ensures each project is executed with utmost precision and cost-efficiency.<br>
<b>Our specialties include:</b></div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    {{-- Two Column Pricing Tables --}}
                                    <section class="builder-section builder-inner-section builder-element builder-element-e92bda0 builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" style="padding:0px;" data-id="e92bda0" data-element_type="section">
                                        <div class="builder-container builder-column-gap-extended">
                                            {{-- Plastic Fabrication Card --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-45e29d4" data-id="45e29d4" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-05350fa 3d-demand wpr-pricing-table-animation-none wpr-pricing-table-heading-center builder-widget builder-widget-wpr-pricing-table" data-id="05350fa" data-element_type="widget" data-widget_type="wpr-pricing-table.default">
                                                        <div class="builder-widget-container">
                                                            <div class="wpr-pricing-table">
                                                                <div class="builder-repeater-item-305d435 wpr-pricing-table-item wpr-pricing-table-heading wpr-pricing-table-item-first">
                                                                    <div class="wpr-pricing-table-headding-inner">
                                                                        <div class="wpr-pricing-table-title-wrap">
                                                                            <h3 class="wpr-pricing-table-title">Plastic Fabrication</h3>
                                                                            <span class="">Transforming your designs into tangible masterpieces through meticulous attention to detail</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Plastic Engineering Card --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-609df36" data-id="609df36" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-9af239c 3d-demand wpr-pricing-table-animation-none wpr-pricing-table-heading-center builder-widget builder-widget-wpr-pricing-table" data-id="9af239c" data-element_type="widget" data-widget_type="wpr-pricing-table.default">
                                                        <div class="builder-widget-container">
                                                            <div class="wpr-pricing-table">
                                                                <div class="builder-repeater-item-305d435 wpr-pricing-table-item wpr-pricing-table-heading wpr-pricing-table-item-first">
                                                                    <div class="wpr-pricing-table-headding-inner">
                                                                        <div class="wpr-pricing-table-title-wrap">
                                                                            <h3 class="wpr-pricing-table-title">Plastic Engineering</h3>
                                                                            <span class="">Applying advanced techniques to meet all your engineering requirements</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    {{-- Spacer --}}
                                    <div class="builder-element builder-element-39a993d builder-widget builder-widget-spacer" data-id="39a993d" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="builder-widget-container">
                                            <div class="builder-spacer"><div class="builder-spacer-inner"></div></div>
                                        </div>
                                    </div>
                                    {{-- Requirements Text --}}
                                    <div class="builder-element builder-element-8e494e3 align-center builder-widget builder-widget-mae-headings" data-id="8e494e3" data-element_type="widget" data-widget_type="mae-headings.default">
                                        <div class="builder-widget-container">
                                            <div class="master-heading" style="text-align: center;">
                                                <div class="sub-heading" style="color:#fff;">Experience the pinnacle of plastic fabrication with RED-LABS Plastic. Connect with us to explore how we can support your next project.
<br>
<b>Requirements:</b>
We receive files as attachment on email or drop box as a .dxf , .ipt, .stl, .prt. & other also
</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Spacer --}}
                                    <div class="builder-element builder-element-cd49a07 builder-widget builder-widget-spacer" data-id="cd49a07" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="builder-widget-container">
                                            <div class="builder-spacer"><div class="builder-spacer-inner"></div></div>
                                        </div>
                                    </div>
                                    {{-- Request Quote Button --}}
                                    <div class="builder-element builder-element-15046d6 builder-widget__width-inherit align-center builder-widget builder-widget-mae-button" data-id="15046d6" data-element_type="widget" data-widget_type="mae-button.default">
                                        <div class="builder-widget-container" style="text-align: center;">
                                            <a class="master-button btn-accent icon-none medium" href="{{ url('upload-file') }}">
                                                <span>Request A Quote From Us</span>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- Spacer --}}
                                    <div class="builder-element builder-element-21e50c0 builder-widget builder-widget-spacer" data-id="21e50c0" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="builder-widget-container">
                                            <div class="builder-spacer"><div class="builder-spacer-inner"></div></div>
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
