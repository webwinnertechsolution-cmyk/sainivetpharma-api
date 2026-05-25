@php
    $industries = $industries ?? collect();
@endphp

<section class="builder-section builder-top-section builder-element builder-element-0a8fac2 builder-section-stretched builder-section-full_width home-our-services builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no" data-id="0a8fac2" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}" style="padding-top:50px; padding-bottom:50px;">
    <div class="builder-container builder-column-gap-no">
        <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-65ee4cc" data-id="65ee4cc" data-element_type="column">
            <div class="builder-widget-wrap builder-element-populated">
                <div class="builder-element builder-element-1ee43b0 align-center builder-widget builder-widget-mae-headings" data-id="1ee43b0" data-element_type="widget" data-widget_type="mae-headings.default">
                    <div class="builder-widget-container">
                        <div class="master-heading">
                            <h2 class="main-heading text-center">
                                <span style="color: #da200b">Industries</span> We Serve
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="builder-element builder-element-3e52edb builder-widget builder-widget-spacer" data-id="3e52edb" data-element_type="widget" data-widget_type="spacer.default">
                    <div class="builder-widget-container">
                        <div class="builder-spacer">
                            <div class="builder-spacer-inner"></div>
                        </div>
                    </div>
                </div>
                <div class="builder-element builder-element-9ad6bf7 home-industry-serv builder-widget builder-widget-mae-project-carousel" data-id="9ad6bf7" data-element_type="widget" data-widget_type="mae-project-carousel.default">
                    <div class="builder-widget-container">
                        <div class="master-carousel-box column-4-gap-30px gap-30px arrow-style-4-gap-30px arrow-position-middle" 
                             data-config="{&quot;column&quot;:&quot;4&quot;,&quot;gap&quot;:&quot;30px&quot;,&quot;arrowPosition&quot;:&quot;middle&quot;,&quot;arrowMiddleOffset&quot;:&quot;60px&quot;,&quot;arrowTopOffset&quot;:null,&quot;dotOffset&quot;:null,&quot;fullRight&quot;:false,&quot;autoPlay&quot;:true,&quot;prevNextButtons&quot;:true,&quot;pageDots&quot;:false}">
                            
                            @forelse($industries as $industry)
                            <div class="master-project mlr-{{ $industry->id }} item-carousel sep-before style-1">
                                <div class="thumb">
                                    @if($industry->image)
                                        <img src="{{ asset('uploads/industries/' . $industry->image) }}" alt="{{ $industry->heading }}" class="attachment-full size-full wp-post-image">
                                    @else
                                        <!-- Fallback image if needed, or keep empty -->
                                        <img src="{{ asset('placeholder.jpg') }}" alt="Placeholder" class="attachment-full size-full wp-post-image"> 
                                    @endif
                                </div>
                                <div class="content-wrap">
                                    <div class="text-wrap">
                                        <h3 class="headline-2">
                                            <a href="{{ $industry->link_url ?? '#' }}">{!! $industry->heading !!}</a>
                                        </h3>
                                        <div class="sep"></div>
                                        <div class="desc">
                                            <div class="inner">
                                                {{ Str::limit(strip_tags($industry->description), 120) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <p class="text-muted">No industries available at the moment.</p>
                            </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
