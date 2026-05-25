@extends('frontend.layouts.layout')

@section('title', $title ?? $service->meta_title ?? $service->heading . ' - Red Labs Service')
@section('meta_description', $meta_description ?? $service->meta_description ?? Str::limit(strip_tags($service->description), 160))
@section('meta_keywords', $service->meta_keywords)
@section('og_title', $og_title ?? $service->og_title ?? $service->meta_title ?? $service->heading)
@section('og_description', $og_description ?? $service->og_description ?? $service->meta_description ?? Str::limit(strip_tags($service->description), 160))
@section('og_image', $og_image ?? ($service->og_image ? asset('uploads/ourservice/og/' . $service->og_image) : ($service->image ? asset('uploads/ourservice/' . $service->image) : asset('public/backend/assets/images/favicon.png'))))



@push('styles')
<style>
@media (min-width: 1025px) {
		.master-fancy-image img {
			max-height: 400px !important;
			object-fit: cover !important;
		}
		
		.master-fancy-image-holder {
			max-height: 400px !important;
		}
	}
	
	 .builder-container {
        display: flex !important;
        flex-wrap: wrap !important;
       
        margin: 0 auto !important;
        position: relative !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
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
	.builder-column-gap-extended > .builder-column {
		padding: 0 15px;
	}
	
	.builder-col-50 {
		width: 50%;
		float: left;
	}
	
	/* Responsive: Stack columns at 1024px and below */
	@media (max-width: 1024px) {
		.builder-col-50,
		.builder-col-33,
		.builder-inner-column {
			width: 100% !important;
			float: none;
			margin-bottom: 30px;
		}
		
		.builder-inner-column:last-child {
			margin-bottom: 0;
		}
	}
	
	/* Icon List Styling - Checkmarks */
	.builder-icon-list-items {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	
	.builder-icon-list-item {
		display: flex;
		align-items: center;
	}
	
	.builder-icon-list-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
	}
	
	.builder-icon-list-icon svg {
		width: 14px !important;
		height: 14px !important;
		fill: #DA200B;
	}
	
	.builder-icon-list-text {
		flex: 1;
	}
	
	/* Clear floats */
	.builder-container:after,
	.builder-widget-wrap:after {
		content: "";
		display: table;
		clear: both;
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
	
	.master-fancy-image.bg-left {
		margin: 0 20px 20px 0;
	}
	
	.master-fancy-image.is-in-view.bg-top.bg-left .master-fancy-image-bg {
		-webkit-transform: translate(-20px, -20px);
		transform: translate(-20px, -20px);
	}
	
	.master-fancy-image.is-in-view.bg-top.bg-left .master-fancy-image-holder {
		-webkit-transform: translate(20px, 20px);
		transform: translate(20px, 20px);
	}
	
	/* Specific positioning for additive manufacturing image */
	.additive-mnft-bck-img .master-fancy-image-bg {
		top: 15px;
		left: -15px;
		right: 20px;
		bottom: 20px;
	}
	
	/* Divider */
	.master-heading .divider {
		width: 50px;
		height: 2px;
		background-color: #DA200B;
		margin: 15px 0;
	}
	
	/* Section Padding */
	.builder-element-63ffdac {
		padding: 0% 5% 0% 5%;
	}
	
	/* Headings */
	.builder-element-8830caa .master-heading .main-heading {
		margin-bottom: 0px;
	}
	
	.builder-element-8830caa .master-heading .sub-heading {
		margin-bottom: 0px;
	}
	
	/* Spacers */
	.builder-element-7d3cb31 {
		--spacer-size: 30px;
	}
	
	.builder-element-4e6284f {
		--spacer-size: 30px;
	}
	
	.builder-element-48d8bd5 {
		--spacer-size: 50px;
	}
	
	/* Icon List */
	.builder-element-260a6f1 .builder-icon-list-items:not(.builder-inline-items) .builder-icon-list-item:not(:last-child) {
		padding-block-end: calc(12px/2);
	}
	
	.builder-element-260a6f1 .builder-icon-list-items:not(.builder-inline-items) .builder-icon-list-item:not(:first-child) {
		margin-block-start: calc(12px/2);
	}
	
	.builder-element-260a6f1 {
		--e-icon-list-icon-size: 14px;
		--e-icon-list-icon-align: center;
		--icon-vertical-align: center;
	}
	
	.builder-element-260a6f1 .builder-icon-list-icon {
		padding-inline-end: 8px;
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
	
	/* Dark Background Section with Image */
	.builder-element-6696ef7:not(.builder-motion-effects-element-type-background),
	.builder-element-6696ef7 > .builder-motion-effects-container > .builder-motion-effects-layer {
		background-image: linear-gradient(rgba(3, 15, 39, 0.55), rgba(3, 15, 39, 0.55)), url({{ asset('uploads/backgrounds/scanning-bg.jpg') }});
		background-position: center center;
		background-repeat: no-repeat;
		background-size: cover;
	}
	
	.builder-element-6696ef7 {
		transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
		padding: 0% 5% 0% 5%;
		position: relative;
	}
	
	.builder-element-6696ef7 > .builder-background-overlay {
		background-color: #000000;
		opacity: 0.55;
		transition: background 0.3s, border-radius 0.3s, opacity 0.3s;
	}
	
	/* Section Headings - White Text */
	.builder-element-0c877aa .master-heading .main-heading {
		color: #FFFFFF;
		text-align: center;
		margin-bottom: 10px;
	}
	
	.builder-element-0c877aa .master-heading .sub-heading {
		color: #FFFFFF;
		text-align: center;
		margin-bottom: 0px;
		max-width: 800px;
		margin-left: auto;
		margin-right: auto;
	}
	
	/* Pricing Table Cards */
	.wpr-pricing-table {
		background-color: #ffffff;
		border-color: #E8E8E8;
		transition-duration: 0.1s;
		padding: 0px 0px 0px 0px;
		border-style: none;
		height: 100%;
	}
	
	.wpr-pricing-table-heading {
		background-color: #f9f9f9;
		padding: 25px 10px 10px 10px;
	}
	
	.builder-widget-wpr-pricing-table > .builder-widget-container {
		box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
	}
	
	.wpr-pricing-table-animation-slide {
		-webkit-transition-duration: 0.2s;
		transition-duration: 0.2s;
	}
	
	.wpr-pricing-table-icon img {
		max-width: 70px;
		height: auto;
		margin: 0 auto;
	}
	
	.wpr-pricing-table-heading-center .wpr-pricing-table-icon {
		margin-bottom: 10px;
	}
	
	.wpr-pricing-table-title {
		color: var(--e-global-color-secondary, #000000);
		font-size: 24px;
		font-weight: 700;
		margin: 0 0 10px;
	}
	
	.wpr-pricing-table-sub-title {
		color: var(--e-global-color-text, #666666);
		font-size: 18px;
		font-weight: 400;
		letter-spacing: -0.3px;
		display: block;
		margin-bottom: 20px;
	}
	
	.wpr-pricing-table section {
		background-color: #f9f9f9;
	}
	
	.wpr-pricing-table-feature {
		border-bottom: none;
		padding: 0;
	}
	
	.wpr-pricing-table-feature:first-of-type {
		padding-top: 0px;
	}
	
	.wpr-pricing-table-feature:last-of-type {
		padding-bottom: 15px;
	}
	
	.wpr-pricing-table-feature:after {
		content: "";
		border-bottom-color: #d6d6d6;
		border-bottom-style: dashed;
		border-bottom-width: 1px;
		max-width: 90%;
		display: block;
	}
	
	.wpr-pricing-table-feature-inner {
		display: flex;
		align-items: center;
		text-align: left;
		padding: 15px 15px 15px 15px;
		justify-content: flex-start;
		max-width: 370px;
		margin: 0 auto;
	}
	
	.wpr-pricing-table-feature-icon {
		color: var(--e-global-color-primary, #DA200B);
		font-size: 14px;
		margin-right: 10px;
		flex-shrink: 0;
	}
	
	.wpr-pricing-table-feature-text {
		flex: 1;
		font-size: 14px;
		color: var(--e-global-color-text, #333333);
	}
	
	.wpr-pricing-table-feature span > span {
		color: var(--e-global-color-text, #333333);
	}
	
	/* Three Column Layout */
	.builder-col-33 {
		width: 33.333%;
		float: left;
		padding: 0 15px;
		box-sizing: border-box;
	}
	
	.builder-inner-section .builder-container {
		clearfix: both;
		overflow: hidden;
	}
	
	.builder-section-boxed .builder-container {
		max-width: 1140px;
		margin: 0 auto;
	}
	
	/* Spacers for this section */
	.builder-element-e413487 {
		--spacer-size: 30px;
		height: 30px;
	}
	
	.builder-element-74b5048 {
		--spacer-size: 50px;
		height: 50px;
	}
	
	.builder-element-21e50c0 {
		--spacer-size: 50px;
		height: 50px;
	}
	
	/* Ensure cards display */
	.builder-widget-wpr-pricing-table {
		display: block;
	}
	
	.wpr-pricing-table-heading-center .wpr-pricing-table-headding-inner {
		text-align: center;
	}
	
	/* Responsive */
	@media(max-width:1024px) {
		.builder-element-48d8bd5 {
			--spacer-size: 80px;
		}
	}
	
	@media(max-width:1024px) {
		.builder-element-7d3cb31,
		.builder-element-4e6284f {
			--spacer-size: 40px;
		}
		
		.builder-element-48d8bd5 {
			--spacer-size: 60px;
		}
		
		.builder-col-50,
		.builder-col-33 {
			width: 100%;
			float: none;
			margin-bottom: 30px;
		}
	}
</style>
@endpush

@section('content')
<div id="content-wrap" >
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content post-2778 page type-page status-publish hentry">
                <div class="builder-container" data-builder-type="wp-page" data-builder-id="2778" class="builder builder-2778" data-builder-post-type="page">
                    
                    {{-- Hero Section with Two Columns --}}
                    <section class="" 
                        data-id="63ffdac" data-element_type="section" data-settings='{"stretch_section":"section-stretched"}'>
                        <div>
                            <div data-id="2f344d1" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated" >
                                    <section class="builder-section builder-inner-section builder-element builder-element-a36611d builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" 
                                        data-id="a36611d" data-element_type="section">
                                        <div class="" style="padding-top:60px;">
                                            {{-- Left Column - Content --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-7ce1b5e" data-id="7ce1b5e" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    {{-- Main Heading --}}
                                                    <div class="builder-element builder-element-8830caa align-left builder-widget builder-widget-mae-headings" data-id="8830caa" data-element_type="widget" data-widget_type="mae-headings.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-heading">
                                                                <h2 class="main-heading">Additive <span style="color:#DA200B">Manufacturing</span></h2>
                                                                <div class="divider"></div>
                                                                <div class="sub-heading">Additive manufacturing enables us to produce highly customised, complex designs with minimal waste, faster prototyping and reduced costs, all while enabling on-demand and localised manufacturing</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Spacer --}}
                                                    <div class="builder-element builder-element-7d3cb31 builder-widget builder-widget-spacer" data-id="7d3cb31" data-element_type="widget" data-widget_type="spacer.default">
                                                        <div class="builder-widget-container">
                                                            <div class="builder-spacer">
                                                                <div class="builder-spacer-inner"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Icon List with Checkmarks --}}
                                                    <div class="builder-element builder-element-260a6f1 builder-list-item-link-inline builder-align-start builder-icon-list--layout-traditional builder-widget builder-widget-icon-list" data-id="260a6f1" data-element_type="widget" data-widget_type="icon-list.default">
                                                        <div class="builder-widget-container">
                                                            <ul class="builder-icon-list-items">
                                                                <li class="builder-icon-list-item">
                                                                    <span class="builder-icon-list-icon">
                                                                        <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                                                    </span>
                                                                    <span class="builder-icon-list-text">Shorter lead time</span>
                                                                </li>
                                                                <li class="builder-icon-list-item">
                                                                    <span class="builder-icon-list-icon">
                                                                        <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                                                    </span>
                                                                    <span class="builder-icon-list-text">1-1,000+ parts</span>
                                                                </li>
                                                                <li class="builder-icon-list-item">
                                                                    <span class="builder-icon-list-icon">
                                                                        <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                                                    </span>
                                                                    <span class="builder-icon-list-text">A wide array of applications</span>
                                                                </li>
                                                                <li class="builder-icon-list-item">
                                                                    <span class="builder-icon-list-icon">
                                                                        <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                                                    </span>
                                                                    <span class="builder-icon-list-text">Effortless design inspection</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Spacer --}}
                                                    <div class="builder-element builder-element-4e6284f builder-widget builder-widget-spacer" data-id="4e6284f" data-element_type="widget" data-widget_type="spacer.default">
                                                        <div class="builder-widget-container">
                                                            <div class="builder-spacer">
                                                                <div class="builder-spacer-inner"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Button --}}
                                                    <div class="builder-element builder-element-35c6082 builder-widget__width-auto align-left builder-widget builder-widget-mae-button" data-id="35c6082" data-element_type="widget" data-widget_type="mae-button.default">
                                                        <div class="builder-widget-container">
                                                            <a class="master-button btn-accent icon-none medium" href="{{ url('/upload-file') }}">
                                                                <span>INSTANT QUOTES</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{-- Right Column - Image --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-f20c039" data-id="f20c039" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-dbfbb4d additive-mnft-bck-img builder-widget builder-widget-mae-fancy-image" data-id="dbfbb4d" data-element_type="widget" data-widget_type="mae-fancy-image.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-fancy-image bg-top bg-left is-in-view" data-in-viewport="true">
                                                                <div class="master-fancy-image-inner">
                                                                    <span class="master-fancy-image-bg"></span>
                                                                    <div class="master-fancy-image-holder">
                                                                        <img fetchpriority="high" decoding="async" width="616" height="506"
                                                                             src="{{ asset('uploads/ourservice/qoute.png') }}" 
                                                                             class="attachment-full size-full" alt="3D Printing Quote" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    
                                    {{-- Bottom Spacer --}}
                                    <div class="builder-element builder-element-48d8bd5 builder-widget builder-widget-spacer" data-id="48d8bd5" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="builder-widget-container">
                                            <div class="builder-spacer">
                                                <div class="builder-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Additive Manufacturing on Demand Section --}}
                    <section class="builder-section builder-top-section builder-element builder-element-6696ef7 builder-section-stretched builder-section-full_width builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" 
                        data-id="6696ef7" data-element_type="section" data-settings='{"stretch_section":"section-stretched","background_background":"classic"}'>
                        <div class="builder-background-overlay"></div>
                        <div class="builder-container builder-column-gap-default">
                            <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-b945e7a" style="padding-top:50px;" data-id="b945e7a" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated">
                                   
                                    
                                    {{-- Section Heading --}}
                                    <div class="builder-element builder-element-0c877aa align-center builder-widget builder-widget-mae-headings" data-id="0c877aa" data-element_type="widget" data-widget_type="mae-headings.default">
                                        <div class="builder-widget-container">
                                            <div class="master-heading">
                                                <h2 class="main-heading">Additive Manufacturing on <span style="color:#DA200B">Demand</span></h2>
                                                <div class="sub-heading">No matter the scale of your project, our 3D printing services offer a versatile alternative to injection moulding for plastic part production.</div>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    
                                    {{-- Three Column Cards --}}
                                    <section class="builder-section builder-inner-section builder-element builder-element-e92bda0 builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" 
                                        data-id="e92bda0" data-element_type="section">
                                        <div class="">
                                            {{-- Card 1: Rapid Prototyping --}}
                                            <div class="builder-column builder-col-33 builder-inner-column builder-element builder-element-45e29d4" data-id="45e29d4" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-05350fa 3d-demand wpr-pricing-table-animation-none wpr-pricing-table-heading-center builder-widget builder-widget-wpr-pricing-table" 
                                                        data-id="05350fa" data-element_type="widget" data-widget_type="wpr-pricing-table.default">
                                                        <div class="builder-widget-container">
                                                            <div class="wpr-pricing-table">
                                                                <div class="builder-repeater-item-305d435 wpr-pricing-table-item wpr-pricing-table-heading wpr-pricing-table-item-first">
                                                                    <div class="wpr-pricing-table-headding-inner">
                                                                        <div class="wpr-pricing-table-icon">
                                                                            <img decoding="async" src="{{ asset('uploads/ourservice/prototype.png') }}" alt="Rapid Prototyping">
                                                                        </div>
                                                                        <div class="wpr-pricing-table-title-wrap">
                                                                            <h3 class="wpr-pricing-table-title">Rapid Prototyping</h3>
                                                                            <span class="wpr-pricing-table-sub-title">Quickly bring your digital concepts into the physical world.</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <section class="builder-repeater-item-d7bffaf wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>No minimum order quantity</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-c7d35ad wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Flexible product development</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-070d629 wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Models for potential investors</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-d7e1e62 wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Easily move into production</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-6002736 wpr-pricing-table-item wpr-pricing-table-feature wpr-pricing-table-item-last">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Non-disclosure agreements</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{-- Card 2: Batch Production --}}
                                            <div class="builder-column builder-col-33 builder-inner-column builder-element builder-element-f5a7968" data-id="f5a7968" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-748184a 3d-demand wpr-pricing-table-animation-none wpr-pricing-table-heading-center builder-widget builder-widget-wpr-pricing-table" 
                                                        data-id="748184a" data-element_type="widget" data-widget_type="wpr-pricing-table.default">
                                                        <div class="builder-widget-container">
                                                            <div class="wpr-pricing-table">
                                                                <div class="builder-repeater-item-305d435 wpr-pricing-table-item wpr-pricing-table-heading wpr-pricing-table-item-first">
                                                                    <div class="wpr-pricing-table-headding-inner">
                                                                        <div class="wpr-pricing-table-icon">
                                                                            <img decoding="async" src="{{ asset('uploads/ourservice/3d-scanning-1.png') }}" alt="Batch Production">
                                                                        </div>
                                                                        <div class="wpr-pricing-table-title-wrap">
                                                                            <h3 class="wpr-pricing-table-title">Batch production</h3>
                                                                            <span class="wpr-pricing-table-sub-title">Industrial quality end-use components at a lower cost per unit.</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <section class="builder-repeater-item-d7bffaf wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Substantial volume discounts</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-c7d35ad wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Eliminate tooling & mould costs</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-070d629 wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Minimise production lead times</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-d7e1e62 wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Update your designs as needed</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-6002736 wpr-pricing-table-item wpr-pricing-table-feature wpr-pricing-table-item-last">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Complex geometries</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{-- Card 3: Bespoke One-Offs --}}
                                            <div class="builder-column builder-col-33 builder-inner-column builder-element builder-element-4f24959" data-id="4f24959" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-d860dac 3d-demand wpr-pricing-table-animation-none wpr-pricing-table-heading-center builder-widget builder-widget-wpr-pricing-table" 
                                                        data-id="d860dac" data-element_type="widget" data-widget_type="wpr-pricing-table.default">
                                                        <div class="builder-widget-container">
                                                            <div class="wpr-pricing-table">
                                                                <div class="builder-repeater-item-305d435 wpr-pricing-table-item wpr-pricing-table-heading wpr-pricing-table-item-first">
                                                                    <div class="wpr-pricing-table-headding-inner">
                                                                        <div class="wpr-pricing-table-icon">
                                                                            <img decoding="async" src="{{ asset('uploads/ourservice/sewing.png') }}" alt="Bespoke One-Offs">
                                                                        </div>
                                                                        <div class="wpr-pricing-table-title-wrap">
                                                                            <h3 class="wpr-pricing-table-title">Bespoke One-Offs</h3>
                                                                            <span class="wpr-pricing-table-sub-title">Custom prints made to your personal requirements, ready for any application.</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <section class="builder-repeater-item-d7bffaf wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Replacements for legacy parts</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-c7d35ad wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Marketing visuals</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-070d629 wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Oversized replicas & props</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-d7e1e62 wpr-pricing-table-item wpr-pricing-table-feature">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Art pieces & gifts</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
                                                                <section class="builder-repeater-item-5cf3fd1 wpr-pricing-table-item wpr-pricing-table-feature wpr-pricing-table-item-last">
                                                                    <div class="wpr-pricing-table-feature-inner">
                                                                        <i class="wpr-pricing-table-feature-icon fas fa-check"></i>
                                                                        <span class="wpr-pricing-table-feature-text wpr-pricing-table-ftext-line-">
                                                                            <span>Working prototypes</span>
                                                                        </span>
                                                                    </div>
                                                                </section>
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
