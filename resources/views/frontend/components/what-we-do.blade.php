@if(isset($whatWeDos) && $whatWeDos->count() > 0)
    <style>
        /* What We Do Responsive Styles */
        @media screen and (max-width: 1024px) {
            .builder-section .builder-col-50 {
                width: 100% !important;
                flex: 0 0 100% !important;
            }
        }
        
        /* Ensure images are always visible */
        .master-fancy-image-holder img {
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
        }
        
        .master-fancy-image-inner {
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .master-fancy-image {
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
    @foreach($whatWeDos as $index => $item)
        <section class="builder-section builder-top-section builder-element builder-section-content-middle builder-section-stretched builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" data-settings='{"stretch_section":"section-stretched"}' style="width: 100vw; position: relative; left: 50%; margin-left: -50vw; max-width: none; padding-bottom:0px;">
            <div class="builder-container builder-column-gap-extended" style="max-width: 1400px; margin: 0 auto; width: 100%; display: flex; flex-wrap: wrap;">
                @if($index % 2 == 0)
                    {{-- Image Left, Text Right --}}
                    <div class="builder-column builder-col-50 builder-top-column builder-element" data-element_type="column" style="width: 100%; flex: 0 0 50%;">
                        <div class="builder-widget-wrap builder-element-populated">
                            <div class="builder-element builder-widget builder-widget-mae-fancy-image" data-element_type="widget" data-widget_type="mae-fancy-image.default">
                                <div class="builder-widget-container">
                                    <div class="master-fancy-image bg-top bg-top align-right" data-in-viewport="true" style="width: 100%;">
                                        <div class="master-fancy-image-inner" style="width: 100%; display: block;">
                                            <span class="master-fancy-image-bg"></span>
                                            <div class="master-fancy-image-holder" style="width: 100%;">
                                                <img decoding="async" src="{{ asset('uploads/whatwedo/' . $item->image) }}" alt="{{ $item->alt_tag ?? 'What We Do' }}" loading="eager" style="width: 100%; height: auto; display: block; opacity: 1;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="builder-column builder-col-50 builder-top-column builder-element" data-element_type="column" style="width: 100%; flex: 0 0 50%;">
                        <div class="builder-widget-wrap builder-element-populated">
                            <div class="builder-element home-about builder-widget__width-inherit align-left builder-widget builder-widget-mae-headings" data-element_type="widget" data-widget_type="mae-headings.default">
                                <div class="builder-widget-container">
                                    <div class="master-heading">
                                        <h2 class="main-heading" style="text-align: left;">{!! $item->heading !!}</h2>
                                        <div class="sub-heading">{!! $item->description !!}</div>
                                    </div>
                                </div>
                            </div>
                            @if($item->button_text && $item->button_url)
                                <div class="builder-element builder-widget__width-auto align-left builder-widget builder-widget-mae-button" data-element_type="widget" data-widget_type="mae-button.default" style="text-align: left;">
                                    <div class="builder-widget-container" style="text-align: left;">
                                        <a class="master-button btn-accent icon-none extra-small"  href="{{ $item->button_url }}" style="width: 150px; display: inline-block; text-align: center;">
                                            <span>{{ $item->button_text }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- Text Left, Image Right --}}
                    <div class="builder-column builder-col-50 builder-top-column builder-element" data-element_type="column" style="width: 50%; flex: 0 0 50%;">
                        <div class="builder-widget-wrap builder-element-populated">
                            <div class="builder-element home-about builder-widget__width-inherit align-left builder-widget builder-widget-mae-headings" data-element_type="widget" data-widget_type="mae-headings.default">
                                <div class="builder-widget-container">
                                    <div class="master-heading">
                                        <h2 class="main-heading" style="text-align: left;">{!! $item->heading !!}</h2>
                                        <div class="sub-heading">{!! $item->description !!}</div>
                                    </div>
                                </div>
                            </div>
                            @if($item->button_text && $item->button_url)
                                <div class="builder-element builder-widget__width-auto align-left builder-widget builder-widget-mae-button" data-element_type="widget" data-widget_type="mae-button.default" style="text-align: left;">
                                    <div class="builder-widget-container">
                                        <a class="master-button btn-accent icon-none extra-small" href="{{ $item->button_url }}" style="width: 150px; display: inline-block; text-align: center;">
                                            <span>{{ $item->button_text }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="builder-column builder-col-50 builder-top-column builder-element" data-element_type="column" style="width: 50%; flex: 0 0 50%;">
                        <div class="builder-widget-wrap builder-element-populated">
                            <div class="builder-element builder-widget builder-widget-mae-fancy-image" data-element_type="widget" data-widget_type="mae-fancy-image.default">
                                <div class="builder-widget-container">
                                    <div class="master-fancy-image bg-top bg-top align-right" data-in-viewport="true" style="width: 100%;">
                                        <div class="master-fancy-image-inner" style="width: 100%; display: block;">
                                            <span class="master-fancy-image-bg"></span>
                                            <div class="master-fancy-image-holder" style="width: 100%;">
                                                <img decoding="async" src="{{ asset('uploads/whatwedo/' . $item->image) }}" alt="{{ $item->alt_tag ?? 'What We Do' }}" loading="eager" style="width: 100%; height: auto; display: block; opacity: 1;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endforeach
@endif
