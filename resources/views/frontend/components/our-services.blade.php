@if(isset($ourServices) && $ourServices->count() > 0)
    <section class="builder-section builder-top-section builder-section-content-middle builder-section-boxed builder-section-height-default our-services-section" style="padding: 60px 0 90px 0px; background-color: #E5E5EA; background-image: url('{{ asset('public/frontend/images/bg-image-33.png') }}'); background-repeat: no-repeat; background-position: center center; background-size: cover; ">
        <div class="builder-container builder-column-gap-extended" style="flex-direction: column;">
            
            {{-- Heading --}}
            <div class="builder-widget-wrap align-center">
                <div class="builder-element builder-widget builder-widget-mae-headings">
                    <div class="builder-widget-container">
                        <div class="master-heading">
                            <h2 class="main-heading">
                                <span style="color:#000">Our <span style="color:var(--e-global-color-primary)">Services<span class="cstm-wdth"></span></span></span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Services Slider --}}
            <div class="start-services-slider rl-services-slider" style="width: 100%; overflow: hidden;">
                @foreach($ourServices as $service)
                    <div class="service-slide-item">
                        @php
                            $bgImage = !empty($service->image) ? asset('uploads/ourservice/' . $service->image) : '';
                        @endphp
                        
                        {{-- Dynamic Style for this Service Item --}}
                        <style>
                            .mlr-{{ $service->id }} {
                                background-color: #FFFFFF;
                                padding: 20px 16px 9px 16px !important;
                                border-radius: 0px 0px 0px 0px;
                                box-shadow: blue;
                                border: 1px solid #e7e7e7;
                                transition: all 0.3s;
                                position: relative;
                                overflow: hidden;
                                display: flex;
                                flex-direction: column;
                            }
                            
                            /* Min-height only for desktop screens */
                            @media (min-width: 1025px) {
                                .mlr-{{ $service->id }} {
                                    min-height: 320px;
                                }
                            }
                            
                            .mlr-{{ $service->id }}:hover {
                                background-image: url('{{ $bgImage }}') !important;
                                background-color: transparent !important;
                                background-size: cover !important;
                                background-position: center !important;
                                background-repeat: no-repeat !important;
                                z-index: 1 !important;
                            }
                            /* Add an overlay on hover to ensure text readability if needed, or rely on image darkness */
                            .mlr-{{ $service->id }}:hover:before {
                                content: '';
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                z-index: -1;
                            }
                            /* Ensure content sits above overlay (z-index fix) */
                            .mlr-{{ $service->id }} .icon-wrap,
                            .mlr-{{ $service->id }} .text-wrap {
                                position: relative;
                                z-index: 2;
                            }
                            
                            .mlr-{{ $service->id }}:hover .headline-2,
                            .mlr-{{ $service->id }}:hover .desc,
                            .mlr-{{ $service->id }}:hover .master-icon i,
                            .mlr-{{ $service->id }}:hover .master-link,
                            .mlr-{{ $service->id }}:hover .master-link span,
                            .mlr-{{ $service->id }}:hover .master-link i {
                                color: #ffffff !important;
                            }
                            
                            /* Mobile responsive - stack vertically on screens < 1024px */
                            @media (max-width: 1024px) {
                                .start-services-slider {
                                    display: flex !important;
                                    flex-direction: column !important;
                                    gap: 20px !important;
                                    width: 100% !important;
                                }
                                .service-slide-item {
                                    width: 100% !important;
                                    margin: 0 !important;
                                    padding: 0 !important;
                                }
                                .mlr-{{ $service->id }} {
                                    margin: 0 !important;
                                    width: 100% !important;
                                    max-width: none !important;
                                }
                                .builder-element.align-center {
                                    margin: 0 !important;
                                }
                            }
                        </style>

                        <div class="builder-element align-center hover-effect-style-1 icon-position-top builder-widget builder-widget-mae-icon-box" style="margin: 0 25px;">
                            <div class="builder-widget-container">
                                <div class="master-icon-box mlr-{{ $service->id }}" style="text-align: center;">
                                    <div class="icon-wrap" style="text-align: center;">
                                        <div class="master-icon" style="font-size: 50px; color: var(--e-global-color-primary); margin-bottom: 20px; display: flex; justify-content: center; align-items: center;">
                                            @if(!empty($service->icon_class))
                                                <i class="{{ $service->icon_class }}"></i>
                                            @elseif(!empty($service->icon))
                                                <img src="{{ asset('uploads/ourservice/icons/' . $service->icon) }}" alt="Icon" style="width: 50px; height: 50px; object-fit: contain;">
                                            @else
                                                <i class="fas fa-cogs"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-wrap" style="text-align: center; flex: 1; display: flex; flex-direction: column;">
                                        <h3 class="headline-2" style="font-size: 20px; font-weight: 700; margin-bottom: 15px; color: #000; transition: color 0.3s;">{!! $service->heading !!}</h3>
                                        <div class="desc" style="color: #666; font-size: 15px; line-height: 1.6; margin-bottom: 20px; transition: color 0.3s;">
                                            {!! Str::limit(strip_tags($service->description), 100) !!}
                                        </div>
                                        <div class="url-wrap" style="margin-top: auto;">
                                            <a class="master-link icon-right" href="{{ $service->button_url ?? '#' }}" style="color: #000; font-weight: 600; font-size: 14px; text-transform: uppercase; transition: color 0.3s;">
                                                <span>{{ $service->button_text ?? 'Know More' }}</span>
                                                <i class="fas fa-arrow-right" style="margin-left: 5px; color: var(--e-global-color-primary);"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <style>
        /* Custom Width underline/shape placeholder */
        .cstm-wdth {
            display: inline-block;
        }
        
        /* Desktop slider styles */
        @media (min-width: 1025px) {
            .start-services-slider .slick-slide {
                padding: 0 19px;
                max-width: 270px;
            }
            .start-services-slider .slick-list {
                margin: 0 0px;
                padding-right: 10px;
                padding-left: 10px;
            }
        }
        
        /* Mobile/Tablet responsive - disable slider, stack vertically */
        @media (max-width: 1024px) {
            /* Override any slider-generated styles */
            .start-services-slider,
            .start-services-slider.slick-initialized {
                display: flex !important;
                flex-direction: column !important;
                gap: 20px !important;
                width: 100% !important;
                overflow: visible !important;
            }
            
            .start-services-slider .slick-slider {
                display: flex !important;
                flex-direction: column !important;
            }
            
            .start-services-slider .slick-track {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                transform: none !important;
                margin: 0 !important;
                padding: 0 !important;
                position: relative !important;
                left: auto !important;
            }
            
            .start-services-slider .slick-list {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }
            
            .start-services-slider .slick-slide {
                width: 100% !important;
                max-width: none !important;
                padding: 0 !important;
                margin-bottom: 20px !important;
                float: none !important;
                position: relative !important;
                left: auto !important;
                transform: none !important;
                display: flex !important;
            }
            
            /* Hide slider navigation */
            .start-services-slider .slick-dots,
            .start-services-slider .slick-arrows,
            .start-services-slider .slick-prev,
            .start-services-slider .slick-next {
                display: none !important;
            }
            
            /* Ensure no duplicates by hiding cloned slides */
            .start-services-slider .slick-slide.slick-cloned {
                display: none !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initServicesSlider() {
                const slider = document.querySelector('.start-services-slider');
                if (!slider) return;

                // Check screen width
                if (window.innerWidth >= 1025) {
                    // Initialize slider for desktop
                    if (typeof $ !== 'undefined' && $.fn.slick && !slider.classList.contains('slick-initialized')) {
                        $(slider).slick({
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            autoplay: true,
                            autoplaySpeed: 3000,
                            dots: true,
                            arrows: false,
                            responsive: [
                                {
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 3,
                                    }
                                }
                            ]
                        });
                    }
                } else {
                    // Destroy slider for mobile/tablet
                    if (typeof $ !== 'undefined' && $.fn.slick && slider.classList.contains('slick-initialized')) {
                        $(slider).slick('unslick');
                    }
                }
            }

            // Initialize on load
            initServicesSlider();

            // Re-initialize on window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(initServicesSlider, 250);
            });
        });
    </script>
@endif
