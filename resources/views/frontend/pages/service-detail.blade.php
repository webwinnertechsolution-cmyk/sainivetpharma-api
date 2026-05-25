@extends('frontend.layouts.layout')

@section('title', $title ?? $service->meta_title ?? $service->heading . ' - Red Labs Service')
@section('meta_description', $meta_description ?? $service->meta_description ?? Str::limit(strip_tags($service->description), 160))
@section('meta_keywords', $service->meta_keywords)
@section('og_title', $og_title ?? $service->og_title ?? $service->meta_title ?? $service->heading)
@section('og_description', $og_description ?? $service->og_description ?? $service->meta_description ?? Str::limit(strip_tags($service->description), 160))
@section('og_image', $og_image ?? ($service->og_image ? asset('uploads/ourservice/og/' . $service->og_image) : ($service->image ? asset('uploads/ourservice/' . $service->image) : asset('public/backend/assets/images/favicon.png'))))



@push('styles')
<style>
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
	/* .builder-column-gap-extended > .builder-column {
		padding: 0 15px;
	} */
	
	.builder-col-50 {
		width: 50%;
		float: left;
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
	}
	
	.builder-icon-list-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
	}
	
	.builder-icon-list-icon svg {
		width: 8px !important;
		height: 8px !important;
		fill: currentColor;
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
	
	.master-fancy-image.is-in-view.bg-top .master-fancy-image-bg {
		-webkit-transform: translate(-20px, -20px);
		transform: translate(-20px, -20px);
	}
	
	.master-fancy-image.is-in-view.bg-top .master-fancy-image-holder {
		-webkit-transform: translate(20px, 20px);
		transform: translate(20px, 20px);
	}
	
	.master-fancy-image.bg-right { 
		margin: 0 0 20px 20px; 
	}
	
	.master-fancy-image.is-in-view.bg-right .master-fancy-image-bg {
		-webkit-transform: translate(20px, -20px);
		transform: translate(20px, -20px);
	}
	
	.master-fancy-image.is-in-view.bg-right .master-fancy-image-holder {
		-webkit-transform: translate(-20px, 20px);
		transform: translate(-20px, 20px);
	}
	
	.master-fancy-image.bg-bottom { 
		margin: 20px 0 0 20px; 
	}
	
	.master-fancy-image.is-in-view.bg-bottom .master-fancy-image-bg {
		-webkit-transform: translate(20px, 20px);
		transform: translate(20px, 20px);
	}
	
	.master-fancy-image.is-in-view.bg-bottom .master-fancy-image-holder {
		-webkit-transform: translate(-20px, -20px);
		transform: translate(-20px, -20px);
	}
	
	/* Specific positioning for 3D scan image */
	.three-d-scan-img-bck .master-fancy-image-bg {
		top: 15px;
		left: -15px;
		right: 20px;
		bottom: 20px;
	}
	
	/* Section Padding */
	.builder-element-6a9a6be {
		padding: 0% 5% 0% 5%;
	}
	
	.builder-element-6696ef7 {
		padding: 0% 5% 0% 5%;
	}
	
	/* Headings */
	.builder-element-de72cfc .master-heading .main-heading {
		margin-bottom: 20px;
	}
	
	.builder-element-de72cfc .master-heading .sub-heading {
		margin-bottom: 0px;
	}
	
	.builder-element-0c877aa .master-heading .main-heading {
		color: #FFFFFF;
		margin-bottom: 10px;
	}
	
	.builder-element-0c877aa .master-heading .sub-heading {
		color: #FFFFFF;
		margin-bottom: 0px;
		max-width: 1140px;
	}
	
	/* Spacers */
	.builder-element-6e27285 {
		--spacer-size: 30px;
	}
	
	.builder-element-87bbeae {
		--spacer-size: 30px;
	}
	
	.builder-element-d68c2a3 {
		--spacer-size: 50px;
	}
	
	.builder-element-e413487 {
		--spacer-size: 30px;
	}
	
	.builder-element-74b5048 {
		--spacer-size: 30px;
	}
	
	.builder-element-21e50c0 {
		--spacer-size: 50px;
	}
	
	/* Icon List */
	.builder-element-5b34fa7 .builder-icon-list-items:not(.builder-inline-items) .builder-icon-list-item:not(:last-child) {
		padding-block-end: calc(12px/2);
	}
	
	.builder-element-5b34fa7 .builder-icon-list-items:not(.builder-inline-items) .builder-icon-list-item:not(:first-child) {
		margin-block-start: calc(12px/2);
	}
	
	.builder-element-5b34fa7 {
		--e-icon-list-icon-size: 8px;
		--e-icon-list-icon-align: center;
		--icon-vertical-align: center;
	}
	
	.builder-element-5b34fa7 .builder-icon-list-icon {
		padding-inline-end: 3px;
	}
	
	/* Image Boxes */
	.builder-widget-image-box .builder-image-box-wrapper {
		display: block;
	}
	
	.builder-element-1e2284c > .builder-widget-container,
	.builder-element-7675724 > .builder-widget-container,
	.builder-element-c8c2b63 > .builder-widget-container,
	.builder-element-61ff07a > .builder-widget-container,
	.builder-element-a5652bb > .builder-widget-container,
	.builder-element-4b01db7 > .builder-widget-container {
		background-color: #F9F9F9;
		padding: 10px 10px 10px 10px;
	}
	
	.builder-element-1e2284c.builder-position-top .builder-image-box-img,
	.builder-element-7675724.builder-position-top .builder-image-box-img,
	.builder-element-c8c2b63.builder-position-top .builder-image-box-img,
	.builder-element-61ff07a.builder-position-top .builder-image-box-img,
	.builder-element-a5652bb.builder-position-top .builder-image-box-img,
	.builder-element-4b01db7.builder-position-top .builder-image-box-img {
		margin-bottom: 10px;
	}
	
	.builder-element-1e2284c .builder-image-box-title,
	.builder-element-7675724 .builder-image-box-title,
	.builder-element-c8c2b63 .builder-image-box-title,
	.builder-element-61ff07a .builder-image-box-title,
	.builder-element-a5652bb .builder-image-box-title,
	.builder-element-4b01db7 .builder-image-box-title {
		margin-bottom: 10px;
		font-size: 20px;
		font-weight: 500;
	}
	
	.builder-element-1e2284c .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-7675724 .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-c8c2b63 .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-61ff07a .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-a5652bb .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-4b01db7 .builder-image-box-wrapper .builder-image-box-img {
		width: 30%;
	}
	
	.builder-image-box-img img {
		max-width: 512px;
		width: 100%;
		height: auto;
		transition-duration: 0.3s;
	}
	
	/* Background Section */
	.builder-element-6696ef7:not(.builder-motion-effects-element-type-background),
	.builder-element-6696ef7 > .builder-motion-effects-container > .builder-motion-effects-layer {
		background-image: url('{{ asset("uploads/backgrounds/scanning-bg.jpg") }}');
		background-position: center center;
		background-repeat: no-repeat;
		background-size: cover;
	}
	
	.builder-element-6696ef7 > .builder-background-overlay {
		background-color: #000000;
		opacity: 0.55;
		transition: background 0.3s, border-radius 0.3s, opacity 0.3s;
	}
	
	.builder-element-6696ef7 {
		transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
	}
	
	/* Responsive */
	@media(max-width:1024px) {
		.builder-element-d68c2a3,
		.builder-element-e413487,
		.builder-element-74b5048 {
			--spacer-size: 80px;
		}
	}
	
	@media(max-width:1024px) {
		.builder-element-6e27285,
		.builder-element-87bbeae {
			--spacer-size: 40px;
		}
		
		.builder-element-d68c2a3,
		.builder-element-e413487,
		.builder-element-74b5048 {
			--spacer-size: 60px;
		}
		
		.builder-element-1e2284c .builder-image-box-img,
		.builder-element-7675724 .builder-image-box-img,
		.builder-element-c8c2b63 .builder-image-box-img,
		.builder-element-61ff07a .builder-image-box-img,
		.builder-element-a5652bb .builder-image-box-img,
		.builder-element-4b01db7 .builder-image-box-img {
			margin-bottom: 10px;
		}
	}

	
	.builder-element-1e2284c > .builder-widget-container,
	.builder-element-7675724 > .builder-widget-container,
	.builder-element-c8c2b63 > .builder-widget-container,
	.builder-element-61ff07a > .builder-widget-container,
	.builder-element-a5652bb > .builder-widget-container,
	.builder-element-4b01db7 > .builder-widget-container {
		background-color: #F9F9F9;
		padding: 10px 10px 10px 10px;
	}
	
	.builder-element-1e2284c.builder-position-top .builder-image-box-img,
	.builder-element-7675724.builder-position-top .builder-image-box-img,
	.builder-element-c8c2b63.builder-position-top .builder-image-box-img,
	.builder-element-61ff07a.builder-position-top .builder-image-box-img,
	.builder-element-a5652bb.builder-position-top .builder-image-box-img,
	.builder-element-4b01db7.builder-position-top .builder-image-box-img {
		margin-bottom: 10px;
	}
	
	.builder-element-1e2284c .builder-image-box-title,
	.builder-element-7675724 .builder-image-box-title,
	.builder-element-c8c2b63 .builder-image-box-title,
	.builder-element-61ff07a .builder-image-box-title,
	.builder-element-a5652bb .builder-image-box-title,
	.builder-element-4b01db7 .builder-image-box-title {
		margin-bottom: 10px;
		font-size: 20px;
		font-weight: 500;
	}
	
	.builder-element-1e2284c .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-7675724 .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-c8c2b63 .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-61ff07a .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-a5652bb .builder-image-box-wrapper .builder-image-box-img,
	.builder-element-4b01db7 .builder-image-box-wrapper .builder-image-box-img {
		width: 30%;
	}
	
	.builder-image-box-img img {
		max-width: 512px;
		width: 100%;
		height: auto;
		transition-duration: 0.3s;
	}
	
	/* Background Section */
	.builder-element-6696ef7:not(.builder-motion-effects-element-type-background),
	.builder-element-6696ef7 > .builder-motion-effects-container > .builder-motion-effects-layer {
		background-image: url('{{ asset("uploads/backgrounds/scanning-bg.jpg") }}');
		background-position: center center;
		background-repeat: no-repeat;
		background-size: cover;
	}
	
	.builder-element-6696ef7 > .builder-background-overlay {
		background-color: #000000;
		opacity: 0.55;
		transition: background 0.3s, border-radius 0.3s, opacity 0.3s;
	}
	
	.builder-element-6696ef7 {
		transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
	}
	
	/* Responsive */
	@media(max-width:1024px) {
		.builder-element-d68c2a3,
		.builder-element-e413487,
		.builder-element-74b5048 {
			--spacer-size: 80px;
		}
	}
	
	@media(max-width:1024px) {
		.builder-element-6e27285,
		.builder-element-87bbeae {
			--spacer-size: 40px;
		}
		
		.builder-element-d68c2a3,
		.builder-element-e413487,
		.builder-element-74b5048 {
			--spacer-size: 60px;
		}
		
		.builder-element-1e2284c .builder-image-box-img,
		.builder-element-7675724 .builder-image-box-img,
		.builder-element-c8c2b63 .builder-image-box-img,
		.builder-element-61ff07a .builder-image-box-img,
		.builder-element-a5652bb .builder-image-box-img,
		.builder-element-4b01db7 .builder-image-box-img {
			margin-bottom: 10px;
		}
	}
</style>
@endpush

@section('content')
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content post-2868 page type-page status-publish hentry">
                <div data-builder-type="wp-page" data-builder-id="2868" class="builder builder-2868" data-builder-post-type="page">
                    
                    {{-- Hero Section with Two Columns --}}
                    <section class="builder-section builder-top-section builder-element builder-element-6a9a6be builder-section-stretched builder-section-full_width builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" 
                        data-id="6a9a6be" data-element_type="section" data-settings='{"stretch_section":"section-stretched"}'>
                        <div class="builder-container builder-column-gap-default">
                            <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-b43fa20" data-id="b43fa20" data-element_type="column">
                                <div class="builder-widget-wrap builder-element-populated">
                                    <section class="builder-section builder-inner-section builder-element builder-element-a6770ef builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" 
                                        data-id="a6770ef" data-element_type="section">
                                        <div class="builder-container builder-column-gap-extended">
                                            {{-- Left Column - Content --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-98a9c51" data-id="98a9c51" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    {{-- Main Heading --}}
                                                    <div class="builder-element builder-element-de72cfc align-left builder-widget builder-widget-mae-headings" data-id="de72cfc" data-element_type="widget" data-widget_type="mae-headings.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-heading">
                                                                <h2 class="main-heading">{!! $service->heading !!}</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Spacer --}}
                                                    <div class="builder-element builder-element-6e27285 builder-widget builder-widget-spacer" data-id="6e27285" data-element_type="widget" data-widget_type="spacer.default">
                                                        <div class="builder-widget-container">
                                                            <div class="builder-spacer">
                                                                <div class="builder-spacer-inner"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Description Text --}}
                                                    <div class="builder-element builder-element-da8ea9c builder-widget builder-widget-text-editor" data-id="da8ea9c" data-element_type="widget" data-widget_type="text-editor.default">
                                                        <div class="builder-widget-container">
                                                            <p>{!! $service->description !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{-- Right Column - Image --}}
                                            <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-5b32532" data-id="5b32532" data-element_type="column">
                                                <div class="builder-widget-wrap builder-element-populated">
                                                    <div class="builder-element builder-element-fc8f780 three-d-scan-img-bck builder-widget builder-widget-mae-fancy-image" data-id="fc8f780" data-element_type="widget" data-widget_type="mae-fancy-image.default">
                                                        <div class="builder-widget-container">
                                                            <div class="master-fancy-image bg-top bg-right" data-in-viewport="true">
                                                                <div class="master-fancy-image-inner">
                                                                    <span class="master-fancy-image-bg"></span>
                                                                    <div class="master-fancy-image-holder">
                                                                        @if($service->image && file_exists(public_path('uploads/ourservice/'.$service->image)))
                                                                        <img fetchpriority="high" decoding="async" width="581" height="552"
                                                                             src="{{ asset('uploads/ourservice/'.$service->image) }}" 
                                                                             class="attachment-full size-full" alt="{{ strip_tags($service->heading) }}" />
                                                                        @endif
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
                                    <div class="builder-element builder-element-d68c2a3 builder-widget builder-widget-spacer" data-id="d68c2a3" data-element_type="widget" data-widget_type="spacer.default">
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
