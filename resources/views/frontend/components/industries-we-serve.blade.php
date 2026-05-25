<!-- @if($industries->isNotEmpty())
    {{-- Industries We Serve Section --}}
    <section class=" builder-section-stretched builder-section-full-width home-our-services" style="
    
        background-image: url('{{ asset('public/frontend/images/bg-image-2.png') }}'); 
        background-repeat: no-repeat; 
        background-size: cover; 
        position: relative; 
        z-index: 1;">
        
        <div >
            <div class="builder-column builder-col-100">
                <div class="builder-widget-wrap">
                    
                    {{-- Heading --}}
                    <div class="builder-widget builder-widget-mae-headings">
                        <div class="master-heading">
                            <h2 class="main-heading text-center" style="margin-bottom: 30px;">
                               Exclusive Offers
                            </h2>
                        </div>
                    </div>

                    {{-- Spacer --}}
                    <div class="builder-element-spacer" style="height: 35px;"></div>

                    {{-- Slider Container --}}
                    <div class="builder-widget builder-widget-mae-project-carousel home-industry-serv">
                        <div class="builder-widget-container">
                            <div class="rl-industries-slider"> 
                                @foreach($industries as $industry)
                                    <div class="industry-slide-item" style="padding: 0 15px;">
                                        <div class="master-project item-carousel sep-before style-1" style="position: relative; overflow: hidden;">
                                            {{-- Thumbnail --}}
                                            <div class="thumb">
                                                <img src="{{ asset('uploads/industries/' . $industry->image) }}" alt="{{ $industry->heading }}" style="width: 100%; height: auto; display: block;">
                                            </div>

                                            {{-- Content Overlay --}}
                                            <div class="content-wrap">
                                                <div class="text-wrap">
                                                    <h3 class="headline-2">
                                                        <a href="#">{{ $industry->heading }}</a>
                                                    </h3>
                                                    <div class="sep"></div>
                                                    <div class="desc">
                                                        <div class="inner">
                                                            {!! Str::limit(strip_tags($industry->description), 120) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="overlay-link" style="position: absolute; top:0; left:0; width: 100%; height: 100%; z-index: 5;"></a>
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
        /* Slider Adjustments */
        .home-industry-serv, 
        .builder-widget-container {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .rl-industries-slider {
            width: 100%;
          
            margin: 0 auto;
            overflow: hidden; 
            display: block;
            opacity: 0; /* Hide before init */
            transition: opacity 0.5s;
        }
        
        .rl-industries-slider.slick-initialized {
            opacity: 1;
        }

        .rl-industries-slider .slick-slide {
            height: auto; 
            margin-bottom: 30px; 
        }
        
        /* Master Project Base Rules */
        .master-project { position: relative; transition: box-shadow 0.3s, transform 0.3s !important; }
        .master-project .thumb img { width: 100%; height: auto; }
        
        /* Style 1: Overlay Design */
        .master-project.style-1 .content-wrap { 
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%;
            display: flex; 
            flex-direction: column; 
            justify-content: flex-end;
            padding: 30px; /* Reduced padding */
            background-image: linear-gradient( to top, rgba(3, 15, 39, 0.7), transparent); 
            transition: 0.3s;
        }
        
        .master-project.style-1 .headline-2 { 
            color: #fff; 
            margin-bottom: 10px; /* Reduced margin */
            font-size: 20px;
            font-weight: 700;
        }
        .master-project.style-1 .headline-2 a { color: inherit; text-decoration: none; }
        
        .master-project.style-1 .desc { 
            color: #fff; 
            opacity: 0; 
            transition: 0s; 
            font-size: 15px;
            line-height: 1.6;
        }
        
        .master-project.style-1 .sep { 
            height: 0px; /* Hidden initially */
            width: 50px; 
            background-color: rgba(225,230,238,0.4); 
            margin-bottom: 0px; /* Hidden initially */
            transition: all 0.3s ease-out;
            overflow: hidden;
        }
        
        .master-project.style-1 .text-wrap { 
            /* No transform needed for alignment */
            transition: 0.3s; 
        }

        .master-project.style-1 .desc { 
            color: #fff; 
            opacity: 0; 
            max-height: 0; /* Collapsed */
            margin-top: 0;
            overflow: hidden; /* Important for clean cut */
            transition: all 0.5s ease-out; /* Smooth expansion */
            font-size: 15px;
            line-height: 1.6;
        }

        /* Hover Effects */
        .master-project.style-1:hover .content-wrap { 
            background-image: linear-gradient( to top, rgba(3, 15, 39, 1), transparent); 
        }
        
        .master-project.style-1:hover .sep {
            height: 1px;
            margin-bottom: 15px;
        }

        .master-project.style-1:hover .desc { 
            opacity: 1; 
            max-height: 150px; /* Expand to show content */
            margin-top: 10px;
        }

        /* Slick Arrow Styling for Industries */
        .rl-industries-slider .slick-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 45px !important;
            height: 45px !important;
            min-width: 45px !important;
            min-height: 45px !important;
            padding: 0 !important;
            line-height: 45px !important;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #e7e7e7;
            color: #666;
            z-index: 10;
            cursor: pointer;
            display: flex !important;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .rl-industries-slider .slick-arrow:hover {
            color: var(--e-global-color-primary);
            border-color: var(--e-global-color-primary);
        }
        .rl-industries-slider .slick-prev {
            left: -20px;
        }
        .rl-industries-slider .slick-next {
            right: -20px;
        }
.content-wrap {
    display: none!important;
}
.builder-column.builder-col-100 {
    width: 1200px;
    margin: 0 auto;
}
h2.main-heading.text-center {
    align-items: center;
    gap: 8px;
    font-size: 24px !important;
    font-weight: 500 !important;
    color: #222;
    text-transform: capitalize;
    margin-bottom: -51px!important;
}
.industry-slide-item {
    padding-inline: 6px!important;
    margin-bottom: 0!important;
}
        /* Responsive Arrow Adjustments */
        @media (max-width: 1400px) {
            .rl-industries-slider .slick-prev { left: 10px; }
            .rl-industries-slider .slick-next { right: 10px; }
        }
    </style>
@endif
-->


@if($industries->isNotEmpty())
    {{-- Industries We Serve Section --}}
    <section class="builder-section-stretched builder-section-full-width home-our-services" style="
        background-image: url('{{ asset('public/frontend/images/bg-image-2.png') }}'); 
        background-repeat: no-repeat; 
        background-size: cover; 
        position: relative; 
        z-index: 1;">
        
        <div>
            <div class="builder-column builder-col-100">
                <div class="builder-widget-wrap">
                    
                    {{-- Heading --}}
                    <div class="builder-widget builder-widget-mae-headings">
                        <div class="master-heading">
                            <h2 class="main-heading text-center">
                               Exclusive Offers
                            </h2>
                        </div>
                    </div>

                    {{-- Spacer --}}
                    <div class="builder-element-spacer" style="height: 35px;"></div>

                    {{-- Grid Container --}}
                    <div class="industries-grid-wrapper">
                        @foreach($industries as $industry)
                            <div class="industry-grid-item">
                                <div class="master-project item-carousel sep-before style-1" style="position: relative; overflow: hidden;">
                                    {{-- Thumbnail --}}
                                    <div class="thumb">
                                        <img src="{{ asset('uploads/industries/' . $industry->image) }}" alt="{{ $industry->heading }}" style="width: 100%; height: auto; display: block;">
                                    </div>

                                    {{-- Content Overlay --}}
                                    <div class="content-wrap">
                                        <div class="text-wrap">
                                            <h3 class="headline-2">
                                                <a href="#">{{ $industry->heading }}</a>
                                            </h3>
                                            <div class="sep"></div>
                                            <div class="desc">
                                                <div class="inner">
                                                    {!! Str::limit(strip_tags($industry->description), 120) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="overlay-link" style="position: absolute; top:0; left:0; width: 100%; height: 100%; z-index: 5;"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>

    <style>
        .builder-column.builder-col-100 {
            width: 1200px;
            margin: 0 auto;
        }

        h2.main-heading.text-center {
            font-size: 24px !important;
            font-weight: 500 !important;
            color: #222;
            text-transform: capitalize;
            margin-bottom: 0 !important;
            text-align: center;
        }

        /* Grid Layout */
        .industries-grid-wrapper {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            width: 100%;
        }

        .industry-grid-item {
            width: 100%;
        }

        /* Master Project Base Rules */
        .master-project {
            position: relative;
            transition: box-shadow 0.3s, transform 0.3s !important;
            border-radius: 8px;
            overflow: hidden;
        }

        .master-project .thumb img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        /* Style 1: Overlay Design */
        .master-project.style-1 .content-wrap {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex !important;
            flex-direction: column;
            justify-content: flex-end;
            padding: 20px;
            background-image: linear-gradient(to top, rgba(3, 15, 39, 0.7), transparent);
            transition: 0.3s;
        }

        .master-project.style-1 .headline-2 {
            color: #fff;
            margin-bottom: 6px;
            font-size: 16px;
            font-weight: 700;
        }

        .master-project.style-1 .headline-2 a {
            color: inherit;
            text-decoration: none;
        }

        .master-project.style-1 .sep {
            height: 0px;
            width: 50px;
            background-color: rgba(225,230,238,0.4);
            margin-bottom: 0px;
            transition: all 0.3s ease-out;
            overflow: hidden;
        }

        .master-project.style-1 .desc {
            color: #fff;
            opacity: 0;
            max-height: 0;
            margin-top: 0;
            overflow: hidden;
            transition: all 0.5s ease-out;
            font-size: 13px;
            line-height: 1.6;
        }

        /* Hover Effects */
        .master-project.style-1:hover .content-wrap {
            background-image: linear-gradient(to top, rgba(3, 15, 39, 1), transparent);
        }

        .master-project.style-1:hover .sep {
            height: 1px;
            margin-bottom: 12px;
        }

        .master-project.style-1:hover .desc {
            opacity: 1;
            max-height: 150px;
            margin-top: 8px;
        }
.master-project.style-1 .content-wrap {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex !important;
    flex-direction: column;
    justify-content: flex-end;
    padding: 20px;
    background-image: linear-gradient(to top, rgba(3, 15, 39, 0.7), transparent);
    transition: 0.3s;
    display: none!important;
}
.master-heading {
    margin-bottom: -41px;
}
.builder-column {
    position: relative;
    min-height: 1px;
    display: flex;
    padding: 30px;
    padding-bottom: 40px;
}
.builder-column {
    position: relative;
    min-height: 1px;
    display: flex;
    padding: 30px;
    padding-bottom: 56px;
    padding-top: 47px;
}

        /* Tablet: 2 columns */
        @media (max-width: 1024px) {
            .builder-column.builder-col-100 {
                width: 100%;
                padding: 0 15px;
            }
            .industries-grid-wrapper {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Mobile: 2 columns */
        @media (max-width: 767px) {
            .industries-grid-wrapper {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .master-project .thumb img {
                height: 160px;
            }

            .master-project.style-1 .content-wrap {
                padding: 12px;
            }

            .master-project.style-1 .headline-2 {
                font-size: 13px;
            }
			.builder-column {
    position: relative;
    min-height: 1px;
    display: flex;
    padding: 30px;
    padding-bottom: 56px!important;
    padding-top: 41px!important;
}
.builder-column.builder-col-100 {
    padding-inline: 20px;
}
        }

        /* Very small mobile: still 2 columns */
        @media (max-width: 400px) {
            .industries-grid-wrapper {
                grid-template-columns: repeat(2, 1fr);
                gap: 6px;
            }

            
        }
    </style>
@endif