@php
    $main = $workProcessMain ?? null;
    $processes = $workProcesses ?? collect();
@endphp

@if($main)
    {{-- SECTION 1: Heading and Button with Background --}}
    <section class="builder-section builder-section-stretched builder-section-full-width" style="
        background-image: url('{{ asset('public/frontend/images/bg-image-24.jpg') }}'); 
        background-repeat: no-repeat; 
        background-size: cover; 
        background-position: center;
        padding: 0% 5% 0% 5%;
        position: relative;
        z-index: 1;">
        
        <div class="builder-container" style="flex-direction: column; width: 100%;">
            
            <div class="builder-column builder-col-100" style="width: 100%;">
                <div class="builder-widget-wrap">
                    
                    {{-- Spacer 1: 40px --}}
                    <div class="builder-element-spacer" style="height: 40px;"></div>

                    {{-- Inner Content Section --}}
                    <div class="builder-section-inner builder-section-boxed" style="width: 100%;">
                        <div class="builder-container builder-inner-container" style="display: flex; justify-content: space-between; align-items: flex-end; max-width: 1250px; margin: 0 auto; flex-wrap: wrap;">
                            
                            {{-- Column 1: Heading --}}
                            <div class="builder-column builder-col-50 align-left" style="flex: 1 1 50%; padding: 15px;">
                                <div class="builder-widget builder-widget-mae-headings">
                                    <div class="master-heading" style="margin-bottom: 0;">
                                        <h2 class="main-heading" style="margin: 0; font-size: 36px; font-weight: 700; color: #fff;">
                                            {!! $main->heading1 ?? 'Our <span style="color:#DA200B">Work Process</span>' !!}
                                        </h2>
                                    </div>
                                </div>
                            </div>

                            {{-- Column 2: Button --}}
                            <div class="builder-column builder-col-50 align-right" style="flex: 1 1 50%; padding: 15px; text-align: right;">
                                <div class="builder-widget builder-widget-mae-button">
                                    @if($main->button_url)
                                    <a class="master-button btn-accent icon-right medium" href="{{ $main->button_url }}" style="background-color: rgba(255,255,255,0.2); color: #fff; border: 1px solid #fff; display: inline-flex; align-items: center;">
                                        <span>{{ $main->button_text ?? 'Get a Quote' }}</span>
                                        <i class="icon fa fa-arrow-right" style="margin-left: 10px;"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>


                    {{-- Spacer 3: 210px (Space for overlap) --}}
                    <div class="builder-element-spacer" style="height: 210px;"></div>

                </div>
            </div>

        </div>
    </section>

    {{-- SECTION 2: Carousel with Overlap --}}
    <section class="builder-section builder-section-boxed builder-section-height-default" style="padding-bottom: 0px; margin-top: -292px; position: relative; z-index: 2;">
        <div class=" builder-column-gap-default">
            
            <div class="builder-column builder-col-100">
                <div class="builder-widget-wrap">
                    <div class="builder-widget builder-widget-mae-service-carousel">
                        <div class="builder-widget-container">
                            
                            {{-- Slider Container --}}
                            <div class="rl-work-process-slider" style="width: 100%; max-width: 1154px; margin: 0 auto;">
                                @foreach($processes as $process)
                                    <div class="process-slide-item" style="padding: 0 15px;">
                                        {{-- Service Item --}}
                                        <div class="master-service item-carousel sep-before hover-effect-style-1">
                                            
                                            <a href="{{ $process->link_url ?? '#' }}">
                                                <div class="thumb">
                                                    <img decoding="async" src="{{ asset('uploads/our-work-process/' . $process->image) }}" alt="{{ $process->heading }}" />
                                                </div>

                                                <div class="content-wrap">
                                                    <h3 class="headline-2">{{ $process->heading }}</h3>
                                                    
                                                    <div class="sep"></div>
                                                    
                                                    <div class="desc">
                                                        {!! $process->description !!}
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <style>
        /* Mobile alignment fix - vertical stack */
        @media (max-width: 1024px) {
            .builder-inner-container {
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                text-align: center !important;
            }
            .builder-col-50 { 
                flex: 1 1 100% !important; 
                max-width: 100% !important; 
                padding: 10px !important;
            }
            .align-left, .align-right { 
                text-align: center !important; 
            }
            .master-button { 
                display: inline-flex !important;
                width: auto !important;
                justify-content: center !important;
            }
            /* Reduce heading font size on mobile */
            .main-heading {
                font-size: 24px !important;
                margin-bottom: 15px !important;
            }
            section[style*="margin-top: -211px"] {
                margin-top: -100px !important; /* Adjust overlap for mobile */
            }
        }
        
        /* STRICT CSS COMPLIANCE */
        .master-service {
            position: relative;
            transition: box-shadow 0.3s, transform 0.3s !important;
            border: 1px solid #e7e7e7;
            background: #fff;
            border-radius: 0px 0px 0px 0px;
            cursor: pointer;
            height: 100%;
        }
        
        .item-carousel {
            width: 100%;
            /* transition: 0s !important;  -- Conflict with hover effect, handled by master-service */
        }

        .master-service a {
            text-decoration: none; 
            color: inherit; 
            display: block; 
            height: 100%;
        }

        .master-service .thumb {
            overflow: hidden;
        }

        .master-service .thumb img {
            width: 100%;
            height: 200px;
            transition: 0.5s;
            object-fit: cover;
        }

        .master-service .content-wrap {
            padding: 33px 33px 0 33px;
            transition: 0.5s;
            min-height: 220px;
            text-align: center;
            border-top: 1px solid #e7e7e7;
            background: #fff;
        }

        .master-service .headline-2 {
            font-size: 24px; 
            margin-bottom: 34px; 
            font-weight: 700; 
            transition: 0.3s; 
            color: var(--e-global-color-secondary);
        }

        .master-service .sep {
            height: 1px; 
            width: 100%; 
            background-color: #e1e6ee; 
            margin-bottom: 25px;
        }

        .master-service .desc {
            font-size: 15px; 
            line-height: 1.6; 
            color: var(--e-global-color-secondary); 
            margin-bottom: 30px; 
            transition: 0.3s;
        }
        
        /* HOVER EFFECTS */
        .master-service:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateY(-5px) !important;
        }
        .master-service:hover .thumb img {
            transform: scale(1.1);
        }
        
        /* Hover Effect Style 1 */
        .master-service.hover-effect-style-1:after {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background-color: var(--e-global-color-primary);
            transition: 0.3s;
            content: '';
            z-index: 1;
        }
        .master-service.hover-effect-style-1:hover:after {
            height: 7px;
        }
        
        /* Headline Hover */
        .master-service:hover .headline-2 {
            color: var(--e-global-color-primary) !important;
        }

        /* Description Link Coloring */
        .master-service .desc a {
            color: var(--e-global-color-primary) !important;
            font-weight: 700;
            text-decoration: none;
        }

        /* Slick Arrow Styling */
        .rl-work-process-slider .slick-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 45px !important;
            height: 45px !important;
            min-width: 45px !important;
            min-height: 45px !important;
            padding: 0 !important;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #e7e7e7;
            color: #666;
            z-index: 10;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .rl-work-process-slider .slick-arrow:hover {
            color: var(--e-global-color-primary);
            border-color: var(--e-global-color-primary);
        }
        .rl-work-process-slider .slick-prev {
            left: -50px;
        }
        .rl-work-process-slider .slick-next {
            right: -50px;
        }
        
        /* Adjust slider container to allow visible arrows */
        .rl-work-process-slider {
            position: relative;
            padding: 0 0px; /* Increased padding to prevent arrow cutoff */
        }
        
        .main-heading {
             text-transform: none !important;
        }

        .builder-widget-mae-button .master-button span {
            text-transform: none !important;
        }
        
        @media (max-width: 1300px) {
            .rl-work-process-slider { padding: 0 0px; }
            .rl-work-process-slider .slick-prev { left: -10px; }
            .rl-work-process-slider .slick-next { right: -10px; }
        }
    </style>
@endif
