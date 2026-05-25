<div class="rl-slider-section">
    <div class="rl-slider">
        @if(isset($sliders) && $sliders->count() > 0)
            @foreach($sliders as $slider)
            <div class="rl-slide-item {{ ($slider->slide_type ?? 'image') === 'video' ? 'video-slide' : '' }}">

                {{-- IMAGE ya VIDEO background --}}
                @if(($slider->slide_type ?? 'image') === 'video' && $slider->video)
                    <div class="rl-slide-bg">
                        <video autoplay loop muted playsinline class="rl-bg-video">
                            <source src="{{ asset('uploads/slider/videos/' . $slider->video) }}" type="video/mp4">
                        </video>
                    </div>
                @else
                    <div class="rl-slide-bg" style="background-image: url('{{ asset('uploads/slider/' . $slider->image) }}')"></div>
                @endif

                <div class="byron-container">
                    <div class="rl-slide-content">
                        @if($slider->sub_heading)
                            <h4 class="rl-slide-sub-title animate__animated animate__fadeInUp">{{ $slider->sub_heading }}</h4>
                        @endif

                        <h1 class="rl-slide-title animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                            {!! $slider->heading !!}
                        </h1>

                        <div class="rl-slide-desc animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                            {!! $slider->description !!}
                        </div>

                        @if($slider->button_url)
                        <div class="rl-slide-btn-wrapper animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                            <a class="rl-slide-btn" href="{{ \Illuminate\Support\Str::startsWith($slider->button_url, ['http', '#']) ? $slider->button_url : url($slider->button_url) }}">
                                {{ $slider->button_text }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
	<style>
	.rl-slick-arrow {
    display: block!important;
    position: absolute;
    top: 36%;
}
.rl-slider-section button.slick-next.rl-slick-arrow.slick-arrow {
    display: block!important;
    position: absolute;
    top: 36%;
    right: 10px;
    padding: 13px!important;
    background-color: green!important;
	    padding-top: 10px !important;
}
.rl-slider-section .button, button, input[type="button"], input[type="reset"], input[type="submit"] {
    font-family: "Inter", sans-serif;
    font-size: 14px;
    color: #f5ad0d;
    background-color: transparent;
    display: inline-block;
    font-weight: 500;
    height: 34px;
    line-height: 0;
    padding: 0 50px;
    border-radius: 2px;
    border: 1px solid #f5ad0d;
    -webkit-appearance: none;
    transition: all ease 0.3s;
    white-space: nowrap;
    border-radius: 50px;
    border: none!important;
}
.rl-slider-section .accent-color, a, .header-info .content:before, .header-button a, .header-top-menu ul li:hover, .header-socials a:hover, #footer-widgets .widget.widget_socials .socials a:hover, #main-nav > ul > li:hover > a, .header-style-1 #main-nav > ul > li:hover > a, .header-style-4 #main-nav > ul > li:hover > a, #main-nav .sub-menu li a:hover, .button, button, input[type="button"], input[type="reset"], input[type="submit"], .widget.widget_archive ul li a:hover, .widget.widget_categories ul li a:hover, .widget.widget_meta ul li a:hover, .widget.widget_nav_menu ul li a:hover, .widget.widget_pages ul li a:hover, .widget.widget_recent_entries ul li a:hover, .widget.widget_recent_comments ul li a:hover, .widget.widget_rss ul li a:hover, .hentry .post-meta .item.post-by-author a, .hentry .post-meta .item.post-comment a, .hentry .post-meta .item.post-meta-categories a, .hentry .post-link a, .widget.widget_recent_posts h3 a:hover, #sidebar .widget.widget_text .text-wrap .btn:hover, .post-next-previous .link-wrap .link:hover, .logged-in-as a, #footer .widget.widget_information i, .products li .product-cat:hover, .products li h2:hover, .builder-element .master-link .icon, .builder-element .master-button.btn-outline, .builder-element .master-button.btn-white, .builder-element .master-heading .pre-heading, .builder-element .master-counter .icon-wrap, .builder-element .master-subscribe-form.style-2 button, .builder-element .master-project.style-1:hover .master-link, .builder-element .master-project.style-1:hover .master-link .icon, .builder-element .master-link:hover, .builder-element .master-subscribe-form button:hover, .builder-element .master-progress-bar .percent, .builder-element .master-icon, .builder-element .master-list .icon-wrap {
    color: #ffffff;
}
.rl-slider-section button.slick-prev.rl-slick-arrow.slick-arrow {
    display: block!important;
    top: 30%!important;
    left: 10px!important;
    position: absolute!important;
    z-index: 999!important;
	display: block!important;
    position: absolute!important;
    top: 36%!important;
   
    padding: 13px!important;
    background-color: green!important;
	    padding-top: 10px !important;
}



@media (max-width: 767px) {
.rl-slider.slick-initialized.slick-slider {
    height: 140px!important;
}
.rl-slide-item.slick-slide {
    height: 140px!important;
}
.rl-slide-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 140px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 0;
}
}
.card-header.bg-dark.text-white {
    background-color: #30674D !important;
}
.card-header.bg-dark.text-white {
    background-color: #30674D !important;
}
	</style>
</div>