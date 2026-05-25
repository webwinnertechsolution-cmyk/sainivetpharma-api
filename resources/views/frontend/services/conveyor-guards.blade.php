@extends('frontend.layouts.layout')

@section('title', 'Conveyor Guards - Red-Labs')

@push('styles')
<style>
    /* Icon Box Component Pattern */
    .feature-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 40px -10px;
    }
    .feature-col {
        width: 20%; /* 5 columns */
        padding: 0 10px;
        box-sizing: border-box;
        margin-bottom: 20px;
    }
    .master-icon-box {
        text-align: center;
        background-color: #fff;
        padding: 40px 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
        border-top: 4px solid transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-radius: 4px;
    }
    .master-icon-box:hover {
        transform: translateY(-5px);
        border-top-color: #DA200B;
        box-shadow: 0 15px 50px rgba(0,0,0,0.12);
    }
    .master-icon-box .headline-2 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.3;
        color: #000;
    }
    .master-icon-box .desc {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .builder-col-50 {
            width: 100% !important;
            margin-bottom: 30px;
        }
        .builder-col-50:last-child {
            margin-bottom: 0;
        }
    }
    @media (max-width: 1024px) {
        .feature-col { 
            width: 100% !important;
        }
    }
    /* Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    
    }
    .gallery-item {
        text-align: center;
    }
    .gallery-item img {
       
        height: 300px; /* Fixed height */
        object-fit: cover;
        border-radius: 8px;
        margin: 0 auto 15px; /* Center image */
        display: block;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .gallery-item h3 {
        font-size: 18px;
        font-weight: 700;
        color: #333;
    }
    /* Responsive Gallery */
    @media (max-width: 992px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content">
                
                {{-- Intro Section --}}
                <div class="service-section" style="padding-top:160px; padding-bottom:60px;">
                    <div class="builder-container">
                        <div class="builder-row" style="display: flex; flex-wrap: wrap; margin: 0 -15px;">
                            {{-- Text Column --}}
                            <div class="builder-col-50" style="padding: 0 15px;">
                                <div class="pre-heading" style="color: #DA200B; font-weight: 700; margin-bottom: 10px;">RED-LABS GUARDS</div>
                                <h2 class="main-heading" style="font-size: 32px; margin-bottom: 25px;">Benefits of <span style="color:#DA200B">RED-LABS</span> HDPE Guards Over Conventional Steel Guards</h2>
                                <p style="font-size: 16px; line-height: 1.8; color: #555;">
                                    At <b><span style="color:#DA200B">RED-LABS</span></b>, we specialise in providing innovative HDPE Guards designed to outperform conventional steel guards. Our cutting-edge solutions prioritise safety, efficiency and sustainability while meeting Australian standards for durability and reliability.
                                </p>
                            </div>

                            {{-- Image Column --}}
                            <div class="builder-col-50" style="padding: 0 15px;">
                                <div class="master-fancy-image">
                                    <div class="master-fancy-image-holder">
                                        <img src="{{ asset('public/images/conveyor-guards/guard-main.png') }}" class="img-fluid" alt="Red-Labs HDPE Guards" style="border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Features Grid (Updated to match User Request) --}}
                        <div class="feature-grid">
                            {{-- Item 1 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Lightweight<br>Design</h3>
                                        <div class="desc">Up to 40% lighter than steel, reducing lifting risks and easing handling</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 2 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Easy<br>Installation</h3>
                                        <div class="desc">Simple adjustments with basic tools (No hot work permits required)</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 3 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Rust<br>Free</h3>
                                        <div class="desc">Fully resistant to rust and corrosion, ensuring long-term durability</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 4 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Chemical<br>Resistant</h3>
                                        <div class="desc">Withstands harsh chemicals like sulfuric acid and caustic soda</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 5 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Metal Detector<br>Friendly</h3>
                                        <div class="desc">Non-metallic material ensures optimal detector calibration</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 6 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Durable and<br>Strong</h3>
                                        <div class="desc">Patented “X” design enhances strength and reduces deflection</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 7 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Quick<br>Access</h3>
                                        <div class="desc">Simple fastening allows for easy removal and reinstallation in minutes</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 8 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Fully<br>Customisable</h3>
                                        <div class="desc">Tailored to site-specific needs, with options for platforms, cabling and more</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 9 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">No Repainting<br>Needed</h3>
                                        <div class="desc">Made in Safety Yellow, eliminating costly and time-consuming repainting</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Item 10 --}}
                            <div class="feature-col">
                                <div class="master-icon-box">
                                    <div class="icon-wrap"><div class="master-icon"><i class=""></i></div></div>
                                    <div class="text-wrap">
                                        <h3 class="headline-2">Fast<br>Production</h3>
                                        <div class="desc">Australian-made with short lead times, avoiding international delays</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Gallery Grid --}}
                <div class="service-section" style="background-color: #f9f9f9; padding: 60px 0;">
                    <div class="builder-container">
                        <div class="gallery-grid">
                            {{-- Pump Guard --}}
                            <div class="gallery-item">
                                <div style="width: 140px; margin: 0 auto; text-align: left;">
                                    <img src="{{ asset('public/images/conveyor-guards/pump-guard.jpg') }}" alt="Pump Guard">
                                    <h3><span style="color:#da200b">Pump Guard</span></h3>
                                </div>
                            </div>
                            {{-- Pulley Guard --}}
                            <div class="gallery-item">
                                <div style="width: 343px; margin: 0 auto; text-align: left;">
                                    <img src="{{ asset('public/images/conveyor-guards/pulley-guard.jpg') }}" alt="Pulley Guards">
                                    <h3><span style="color:#DA200B">Pulley </span> Guards</h3>
                                </div>
                            </div>
                            {{-- Return Idler Guard --}}
                            <div class="gallery-item">
                                <div style="width: 240px; margin: 0 auto; text-align: left;">
                                    <img src="{{ asset('public/images/conveyor-guards/return-idler-guard.png') }}" alt="Return Idler Guards">
                                    <h3><span style="color:#DA200B">Return Idler</span> Guards</h3>
                                </div>
                            </div>
                            {{-- Area Guard --}}
                            <div class="gallery-item">
                                <div style="width: 262px; margin: 0 auto; text-align: left;">
                                    <img src="{{ asset('public/images/conveyor-guards/area-guard.jpg') }}" alt="Area Guards">
                                    <h3>Area Guards</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	

                {{-- Outro Section --}}
                <div class="service-section" style="padding: 80px 0; text-align: center;">
                    <div class="">
                        <h2 class="main-heading" style="margin-bottom: 20px;">We guide you to the most <span style="color:#DA200B">Adequate Guarding System</span></h2>
                        <div class="divider" style="width: 50px; height: 3px; background: #DA200B; margin: 0 auto 30px;"></div>
                        <div class="sub-heading" style="max-width: 900px; margin: 0 auto 30px; font-size: 16px; line-height: 1.8; color: #555;">
                            <b>How We Do It?</b><br>
                            With a team of highly experienced professionals, we provide top-tier safety guarding solutions tailored to your needs and offer expert answers to your technical inquiries. By partnering with <b><span style="color:#DA200B">RED-</span>LABS</b>, you can establish a Safety Guarding Policy that fully complies with Australian guarding regulations.<br>
                            Choosing <b><span style="color:#DA200B">RED-</span>LABS</b> for your Safety Guarding project ensures not only superior guarding solutions but also minimises the risk of significant financial losses. Your investment in safety today secures your financial stability tomorrow.<br><br>
                            <a href="{{ route('contact') }}" style="color: #DA200B; text-decoration: none; font-weight: 700;">Contact us</a> now and let us help you to save more lives and prevent other losses.
                        </div>
                    </div>
                </div>

            </article>
        </div>
    </div>
</div>	</div>	
@endsection
