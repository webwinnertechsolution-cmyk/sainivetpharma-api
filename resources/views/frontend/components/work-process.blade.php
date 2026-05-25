@php
    $main = $workProcessMain ?? null;
    $processes = $workProcesses ?? collect();
@endphp

@if($main)
<!-- Work Process Heading Section -->
<section class="builder-section builder-top-section builder-element builder-element-0d5b238 builder-section-stretched builder-section-full_width builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" data-id="0d5b238" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}" style="">
    <div class="builder-container builder-column-gap-default">
        <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-2e0bee7" data-id="2e0bee7" data-element_type="column">
            <div class="builder-widget-wrap builder-element-populated">
                <div class="builder-element builder-element-931e016 builder-widget builder-widget-spacer" data-id="931e016" data-element_type="widget" data-widget_type="spacer.default">
                    <div class="builder-widget-container">
                        <div class="builder-spacer">
                            <div class="builder-spacer-inner"></div>
                        </div>
                    </div>
                </div>
                <section class="builder-section builder-inner-section builder-element builder-element-53a8cdd builder-section-content-bottom builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" data-id="53a8cdd" data-element_type="section">
                    <div class="builder-container builder-column-gap-default">
                        <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-8331688" data-id="8331688" data-element_type="column">
                            <div class="builder-widget-wrap builder-element-populated">
                                <div class="builder-element builder-element-059e95a align-left builder-widget builder-widget-mae-headings" data-id="059e95a" data-element_type="widget" data-widget_type="mae-headings.default">
                                    <div class="builder-widget-container">
                                        <div class="master-heading">
                                            <h2 class="main-heading">{!! $main->heading1 ?? 'Our <span style="color:#DA200B">Work Process</span>' !!}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-e2656ec" data-id="e2656ec" data-element_type="column">
                            <div class="builder-widget-wrap builder-element-populated">
                                <div class="builder-element builder-element-97fc44e align-right align--mobileleft builder-widget builder-widget-mae-button" data-id="97fc44e" data-element_type="widget" data-widget_type="mae-button.default">
                                    <div class="builder-widget-container">
                                        @if($main->button_url)
                                        <a class="master-button btn-accent icon-right medium" href="{{ $main->button_url }}">
                                            <span>{{ $main->button_text ?? 'Get a Quote' }}</span>
                                            <span class="icon fa fa-arrow-right"></span>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="builder-element builder-element-3c34b49 builder-widget builder-widget-spacer" data-id="3c34b49" data-element_type="widget" data-widget_type="spacer.default">
                    <div class="builder-widget-container">
                        <div class="builder-spacer">
                            <div class="builder-spacer-inner"></div>
                        </div>
                    </div>
                </div>
                <div class="builder-element builder-element-25217d1 builder-widget builder-widget-spacer" data-id="25217d1" data-element_type="widget" data-widget_type="spacer.default">
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
@endif

<!-- Work Process Carousel Section -->
<section class="builder-section builder-top-section builder-element builder-element-2bce09c builder-section-stretched builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" data-id="2bce09c" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
    <div class="builder-container builder-column-gap-default">
        <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-24d950d" data-id="24d950d" data-element_type="column">
            <div class="builder-widget-wrap builder-element-populated">
                <div class="builder-element builder-element-b158617 hover-effect-none builder-widget builder-widget-mae-service-carousel" data-id="b158617" data-element_type="widget" id="work-process-link" data-widget_type="mae-service-carousel.default">
                    <div class="builder-widget-container">
                        <div class="master-carousel-box mlr-924924590" data-config='{"column":"3","gap":"30px","arrowPosition":"middle","arrowMiddleOffset":"60px","arrowTopOffset":null,"dotOffset":null,"fullRight":false,"autoPlay":true,"prevNextButtons":true,"pageDots":false}'>
                            
                            @if(isset($processes) && $processes->count() > 0)
                                @foreach($processes as $process)
                                <div class="master-service item-carousel sep-before">
                                    @if($process->link_url)
                                    <a href="{{ $process->link_url }}" style="text-decoration: none; color: inherit; display: block;">
                                    @endif
                                    
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
                                    
                                    @if($process->link_url)
                                    </a>
                                    @endif
                                </div>
                                @endforeach
                            @else
                                <!-- Static Fallback if no dynamic content -->
                                <div class="master-service item-carousel sep-before">
                                    <div class="thumb">
                                        <img decoding="async" src="/wp-content/uploads/2024/08/upload-file.jpg" alt="Image" />
                                    </div>
                                    <div class="content-wrap">
                                        <h3 class="headline-2">Upload CAD file</h3>
                                        <div class="sep"></div>
                                        <div class="desc">
                                            <p><a href="{{ route('upload-file') }}">Upload Your File</a><br />( e.g. Step: Dxf: Obj)</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
