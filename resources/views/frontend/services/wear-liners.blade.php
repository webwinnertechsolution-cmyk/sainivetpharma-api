@extends('frontend.layouts.layout')

@section('title', 'Wear Liners - Red-Labs')

@push('styles')
<style>
/* Page Specific Styles */
.feature-list {
    list-style: none;
    padding: 0;
    margin: 30px 0;
}
.feature-list li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 25px;
    font-size: 16px;
    line-height: 1.6;
    color: #666;
}
.feature-list li svg {
    width: 20px;
    height: 20px;
    margin-right: 15px;
    fill: #DA200B;
    flex-shrink: 0;
    margin-top: 5px;
}
.feature-list li b {
    color: #000;
}

.technical-table {
    width: 100%;
    margin-bottom: 30px;
    border-collapse: collapse;
    font-size: 15px;
    background: #fff;
}
.technical-table th, .technical-table td {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    text-align: left;
}
.technical-table th {
    background-color: #dbeafe; /* Light blue matching user text */
    font-weight: 700;
    color: #000;
    border-top: none;
}
.technical-table tr:nth-child(even) {
    background-color: #f8fafc;
}
.technical-table tr:hover {
    background-color: #f1f5f9;
}

.application-list {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 20px 0;
}
.application-list li {
    width: 50%;
    margin-bottom: 12px;
    position: relative;
    padding-left: 25px;
    font-size: 16px;
    color: #555;
    font-weight: 500;
}
.application-list li svg {
    position: absolute;
    left: 0;
    top: 5px;
    width: 16px;
    height: 16px;
    fill: #DA200B;
}

/* Fancy Image Styles */
.master-fancy-image {
    position: relative;
    display: inline-block;
    width: fit-content;
}

.master-fancy-image-inner {
    position: relative;
    display: inline-block;
}

.master-fancy-image-bg {
    content: "";
    position: absolute;
    top: 20px;
    left: 20px;
    right: -20px;
    bottom: -20px;
    background-color: #DA200B;
    z-index: 0;
}

.master-fancy-image-holder {
    position: relative;
    z-index: 1;
}

.master-fancy-image.bg-top.bg-left {
    margin: 0 20px 20px 0;
}

.master-fancy-image img {
    display: block;
    max-width: 100%;
    height: auto;
}

/* Desktop: Show red background and limit image height */
@media (min-width: 1025px) {
    .master-fancy-image-bg {
        display: block !important;
    }
    
    .master-fancy-image img {
        max-height: 500px !important;
        object-fit: cover !important;
    }
    
    .master-fancy-image-holder {
        max-height: 500px !important;
    }
}

/* Tablet range: Show red background but limit image size */
@media (min-width: 769px) and (max-width: 1024px) {
    .master-fancy-image-bg {
        display: block !important;
    }
    
    .master-fancy-image img {
        max-height: 800px !important;
        width: auto !important;
        height: auto !important;
        object-fit: contain !important;
    }
    
    .master-fancy-image-holder {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }
}

/* Mobile: Hide red background */
@media (max-width: 768px) {
    .master-fancy-image-bg {
        display: block !important;
    }
    
    .master-fancy-image img {
        width: 100%;
        height: auto;
    }
}

@media (max-width: 1024px) {
    .application-list li { width: 100%; }
    
    /* Make Application section columns stack */
    .builder-col-33 {
        width: 100% !important;
        margin-bottom: 30px;
    }
    .builder-col-33:last-child {
        margin-bottom: 0;
    }
    
    /* Remove the spacer margin on mobile */
    .builder-col-33 .application-list[style*="margin-top: 86px"] {
        margin-top: 0 !important;
    }
}

/* Intro Section Styling */
.intro-text-center {
    text-align: center;
    max-width: 900px;
    margin: 0 auto 50px;
}
.intro-text-center h1 {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 20px;
    color: #000;
    line-height: 1.2;
}
.intro-text-center p {
    font-size: 18px;
    color: #555;
    line-height: 1.6;
}
</style>
@endpush

@section('content')
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content">
                
                {{-- Intro & Features Section --}}
                <div class="service-section" style="padding-top:160px; padding-bottom:80px;">
                    <div class="builder-container">
                        
                        <div class="intro-text-center">
                            <h1><span style="color:#DA200B">RED-</span>LABS UHWMPE Wear Liners</h1>
                            <p>RED-LABS UHWMPE Wear Liners are a premium grade wear resistant, flow promoting polyethylene plastic liner.</p>
                        </div>

                        <div class="builder-row" style="display: flex; flex-wrap: wrap; margin: 0 -15px;">
                            {{-- Features Column --}}
                            <div class="builder-col-50" style="padding: 0 15px;">
                                <h2 class="main-heading" style="font-size: 28px; margin-bottom: 20px;">FEATURES</h2>
                                <ul class="feature-list">
                                    <li>
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                        <span><span style="color: #DA200B;font-weight: bold">RED-</span><b>LABS </b>Liners are made from a premium Ultra High Molecular Weight Polyethylene plastic and will display good resistance to fine particle and sliding abrasion.</span>
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                        <span><span style="color: #DA200B;font-weight: bold">RED-</span><b>LABS UHMWPE </b> has a very low friction coefficient which results in excellent anti-stick properties which increases material flow and reduces the build-up of sticky materials.</span>
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                        <span><span style="color: #DA200B;font-weight: bold">RED-</span><b>LABS UHMWPE </b> is designed to be installed by mechanical fastening. It can be supplied as full sheets or cut liners as a custom engineered wear protection plastic lining system for your equipment.</span>
                                    </li>
                                </ul>
                                <a href="{{ route('contact') }}" class="master-button btn-accent medium" style="margin-top: 10px;">Request A Quote From Us</a>
                            </div>
                            
                            {{-- Image Column (Fancy Image Style) --}}
                            <div class="builder-col-50" style="padding: 10px 15px;">
                                <div class="master-fancy-image bg-top bg-left">
                                    <div class="master-fancy-image-inner">
                                        <span class="master-fancy-image-bg"></span>
                                        <div class="master-fancy-image-holder">
                                            <img src="{{ asset('public/images/wear-liners/wear-liners.png') }}" class="img-fluid" alt="Red-Labs UHMWPE Wear Liners">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Applications Section --}}
                <div class="service-section" style="padding: 60px 0;">
                    <div class="builder-container">
                        <div style="background-color: #DA200B; color: #ffffff; border-radius: 15px; padding: 50px; box-shadow: 0 10px 30px rgba(218, 32, 11, 0.15);">
                            <div class="builder-row" style="display: flex; flex-wrap: wrap; margin: 0 -15px;">
                                
                                {{-- Col 1: Heading & Intro --}}
                                <div class="builder-col-33" style="width: 33.333%; padding: 0 15px; box-sizing: border-box;">
                                    <h2 class="main-heading" style="font-size: 36px; margin-bottom: 20px; color: #ffffff; text-align: left;">APPLICATIONS</h2>
                                    <p style="margin-bottom: 20px; font-weight: 700; font-size: 18px; line-height: 1.4;">Red-Labs EDGE FINISHES have been designed primarily for use as a flow promotion plastic lining system.</p>
                                    <p style="line-height: 1.6; opacity: 0.9;">They are installed into equipment to reduce material build up and to protect steel surfaces from abrasion.</p>
                                </div>
                                
                                {{-- Col 2: Usage & List Part 1 --}}
                                <div class="builder-col-33" style="width: 33.333%; padding: 0 15px; box-sizing: border-box;">
                                    <p style="margin-bottom: 25px; line-height: 1.6; opacity: 0.9;">They are predominantly used in the Mining, Quarrying and Mineral processing industries, typically on the following equipment:</p>
                                    <ul class="application-list" style="display: block; width: 100%;">
                                        <li style="width: 100%; color: #fff; border-bottom: none; margin-bottom: 10px; padding-left: 20px;">
                                            <svg viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; width: 10px; height: 10px; top: 8px;"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg> Chutes
                                        </li>
                                        <li style="width: 100%; color: #fff; border-bottom: none; margin-bottom: 10px; padding-left: 20px;">
                                            <svg viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; width: 10px; height: 10px; top: 8px;"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg> Screens
                                        </li>
                                        <li style="width: 100%; color: #fff; border-bottom: none; margin-bottom: 10px; padding-left: 20px;">
                                            <svg viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; width: 10px; height: 10px; top: 8px;"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg> Hoppers and bins
                                        </li>
                                        <li style="width: 100%; color: #fff; border-bottom: none; margin-bottom: 10px; padding-left: 20px;">
                                            <svg viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; width: 10px; height: 10px; top: 8px;"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg> Feeders
                                        </li>
                                        <li style="width: 100%; color: #fff; border-bottom: none; margin-bottom: 10px; padding-left: 20px;">
                                            <svg viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; width: 10px; height: 10px; top: 8px;"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg> Spill Trays
                                        </li>
                                        <li style="width: 100%; color: #fff; border-bottom: none; margin-bottom: 10px; padding-left: 20px;">
                                            <svg viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; width: 10px; height: 10px; top: 8px;"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg> Hungry Board
                                        </li>
                                    </ul>
                                </div>

                                {{-- Col 3: List Part 2 & Footer --}}
                                <div class="builder-col-33" style="width: 33.333%; padding: 0 15px; box-sizing: border-box;">
                                    <ul class="application-list" style="display: block; width: 100%; margin-top: 86px;"> {{-- Spacer to align with list in col 2 --}}
                                        <li style="width: 100%; color: #fff; border-bottom: none; margin-bottom: 10px; padding-left: 20px;">
                                            <svg viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; width: 10px; height: 10px; top: 8px;"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg> Conveyor Hoods
                                        </li>
                                        <li style="width: 100%; color: #fff; border-bottom: none; margin-bottom: 10px; padding-left: 20px;">
                                            <svg viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; width: 10px; height: 10px; top: 8px;"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg> Dump truck bodies
                                        </li>
                                    </ul>
                                    <p style="margin-top: 20px; line-height: 1.6; opacity: 0.9;">Red-Labs UHMWPE can also be used for any application which requires an anti-stick and abrasion resistant plastic.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Technical Information Section --}}
                <div class="service-section" style="padding: 60px 0;">
                    <div class="builder-container">
                        <h2 class="main-heading" style="font-size: 28px; margin-bottom: 30px; text-align: left;">TECHNICAL INFORMATION</h2>
                        
                        <div class="builder-row">
                            <div class="builder-col-100" style="width: 100%;">
                                <table class="technical-table">
                                    <thead>
                                        <tr>
                                            <th>Polymer</th>
                                            <th>UHMWPE</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Colour</td><td>Blue</td><td></td></tr>
                                        <tr><td>Specific Gravity</td><td>0.93</td><td>ISO 1183</td></tr>
                                        <tr><td>Hardness</td><td>61° Shore D</td><td>ISO 868</td></tr>
                                        <tr><td>Tensile Strength</td><td>20 MPa (min)</td><td>ISO 527-1</td></tr>
                                        <tr><td>Breaking Strength</td><td>40 MPa (min)</td><td>ISO 527-1</td></tr>
                                        <tr><td>Elongation @ Break</td><td>350%</td><td>ISO 527-1</td></tr>
                                        <tr><td>Temperature Range</td><td>-20°C to +80°C</td><td></td></tr>
                                    </tbody>
                                </table>

                                <table class="technical-table" style="margin-top: 30px;">
                                    <thead>
                                        <tr>
                                            <th>Property</th>
                                            <th>Value</th>
                                            <th>Standard</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Coefficient of friction (Dry vs Steel) Static</td><td>0.15</td><td></td></tr>
                                        <tr><td>Notches Impact Strength</td><td>0.8mJ/mm²</td><td>ISO 179</td></tr>
                                        <tr><td>Impact Strength with 15° V-Notch</td><td>>100 mJ/mm²</td><td>ISO 179</td></tr>
                                        <tr><td>Thermal Conductivity</td><td>0.41 W /m-k</td><td>DIN 52612</td></tr>
                                        <tr><td>Flammability</td><td>HB</td><td>UL94</td></tr>
                                        <tr><td>Insulation Resistance</td><td>>1014 Ω cm</td><td>DIN VDE 0303</td></tr>
                                        <tr><td>Surface Resistance</td><td>>1015 Ω</td><td>DIN VDE 0303</td></tr>
                                        <tr><td>Dielectric Strength</td><td>45 kV/mm</td><td>DIN VDE 0303</td></tr>
                                        <tr><td>Arc Resistance</td><td>L4 Degree</td><td>VDE 0303</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </article>
        </div>
    </div>
</div></div>
@endsection
