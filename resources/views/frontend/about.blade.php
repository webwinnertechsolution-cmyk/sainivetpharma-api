@extends('frontend.layouts.layout')

@section('title', 'About Us - Red-Labs')
@section('description', 'Offering an Innovative, Sustainable and Environmental Friendly Solution is Our Goal. RED-LABS a specialised division of Red Engineers, offers innovative, sustainable and environment friendly solutions.')

@section('content')
<style>
    .byron-container {
        display: flex !important;
        flex-wrap: wrap !important;
        max-width: 1302px !important;
        margin: 0 auto !important;
        position: relative !important;
        padding-left: 10px !important;
        padding-right: 8px !important;
    }
</style>
<div class="page-content">
    {{-- About Us Hero Section --}}
    <section class="about-hero-section" style="background-color: #f8f9fa; padding: 80px 0;">
        <div class="byron-container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h1 class="main-heading" style="font-size: 42px; line-height: 1.3; margin-bottom: 30px;">
                            Offering an Innovative, Sustainable and Environmental 
                            <span style="color:#DA200B">Friendly Solution</span> is Our Goal
                        </h1>
                        <div class="sub-heading" style="font-size: 18px; line-height: 1.8; color: #555;">
                            <p><strong><span style="color:#DA200B">RED-</span>LABS</strong> a specialised division of Red Engineers, offers innovative, sustainable and environment friendly solutions. Our focus lies in providing advanced CNC cutting, scanning, reverse engineering, 3D printing and custom design services. By harnessing cutting-edge technology and utilising engineering-grade materials, we bring your concepts to fruition with precision and efficiency.</p>
                            <p>Our products are meticulously crafted to meet Australian standards, ensuring they can withstand high loads, extreme temperatures, harsh environments, chemicals, rust and more, all while maintaining mechanical integrity over time.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="{{ asset('uploads/about/about-us-main.jpg') }}" 
                             alt="Red Labs Engineering" 
                             class="img-fluid" 
                             style="border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Values Section --}}
    <section class="core-values-section" style="background: linear-gradient(135deg, #030f27 0%, #1a2a4d 100%); padding: 80px 0; color: #fff;">
        <div class="byron-container">
            <div class="text-center mb-5">
                <h2 class="section-title" style="font-size: 42px; font-weight: 700; margin-bottom: 50px;">Core Values</h2>
            </div>
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-box" style="padding: 30px; background: rgba(255,255,255,0.05); border-radius: 10px; height: 100%;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-balance-scale-left" style="font-size: 48px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 24px; font-weight: 600;">Integrity</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-box" style="padding: 30px; background: rgba(255,255,255,0.05); border-radius: 10px; height: 100%;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-lightbulb" style="font-size: 48px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 24px; font-weight: 600;">Innovation</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-box" style="padding: 30px; background: rgba(255,255,255,0.05); border-radius: 10px; height: 100%;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-award" style="font-size: 48px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 24px; font-weight: 600;">Quality</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-box" style="padding: 30px; background: rgba(255,255,255,0.05); border-radius: 10px; height: 100%;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-leaf" style="font-size: 48px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 24px; font-weight: 600;">Sustainability</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Choose Us Section --}}
    <section class="why-choose-section" style="background-color: #fff; padding: 80px 0;">
        <div class="byron-container">
            <div class="text-center mb-5">
                <h2 class="section-title" style="font-size: 42px; font-weight: 700; color: #030f27; margin-bottom: 20px;">Why Choose RED-LABS?</h2>
                <p style="font-size: 18px; color: #666; max-width: 800px; margin: 0 auto;">We combine cutting-edge technology with engineering excellence to deliver superior solutions</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box" style="padding: 30px; border: 1px solid #e0e0e0; border-radius: 10px; height: 100%; transition: all 0.3s;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-cogs" style="font-size: 40px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #030f27; margin-bottom: 15px;">Advanced Technology</h3>
                        <p style="color: #666; line-height: 1.8;">State-of-the-art CNC cutting, 3D scanning, and printing equipment for precision manufacturing.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box" style="padding: 30px; border: 1px solid #e0e0e0; border-radius: 10px; height: 100%; transition: all 0.3s;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-certificate" style="font-size: 40px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #030f27; margin-bottom: 15px;">Australian Standards</h3>
                        <p style="color: #666; line-height: 1.8;">All products meet rigorous Australian standards for quality, safety, and durability.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box" style="padding: 30px; border: 1px solid #e0e0e0; border-radius: 10px; height: 100%; transition: all 0.3s;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-users" style="font-size: 40px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #030f27; margin-bottom: 15px;">Expert Team</h3>
                        <p style="color: #666; line-height: 1.8;">Experienced engineers and technicians dedicated to bringing your vision to life.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box" style="padding: 30px; border: 1px solid #e0e0e0; border-radius: 10px; height: 100%; transition: all 0.3s;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-recycle" style="font-size: 40px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #030f27; margin-bottom: 15px;">Eco-Friendly</h3>
                        <p style="color: #666; line-height: 1.8;">Sustainable practices and environmentally friendly materials in all our processes.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box" style="padding: 30px; border: 1px solid #e0e0e0; border-radius: 10px; height: 100%; transition: all 0.3s;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-clock" style="font-size: 40px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #030f27; margin-bottom: 15px;">Fast Turnaround</h3>
                        <p style="color: #666; line-height: 1.8;">Efficient processes ensure quick delivery without compromising quality.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box" style="padding: 30px; border: 1px solid #e0e0e0; border-radius: 10px; height: 100%; transition: all 0.3s;">
                        <div class="icon-wrap mb-3">
                            <i class="fas fa-handshake" style="font-size: 40px; color: #DA200B;"></i>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #030f27; margin-bottom: 15px;">Custom Solutions</h3>
                        <p style="color: #666; line-height: 1.8;">Tailored services to meet your specific project requirements and specifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="cta-section" style="background-color: #DA200B; padding: 60px 0; color: #fff;">
        <div class="byron-container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 style="font-size: 36px; font-weight: 700; margin-bottom: 15px;">Ready to Start Your Project?</h2>
                    <p style="font-size: 18px; opacity: 0.9;">Contact us today to discuss how we can help bring your ideas to reality</p>
                </div>
                <div class="col-lg-4 text-lg-end text-center mt-4 mt-lg-0">
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg" style="padding: 15px 40px; font-size: 16px; font-weight: 600; border-radius: 50px;">Get In Touch</a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-color: #DA200B;
    }
    
    @@media (max-width: 1024px) {
        .about-hero-section h1 {
            font-size: 28px !important;
        }
        .about-hero-section .sub-heading {
            font-size: 16px !important;
        }
        .section-title {
            font-size: 32px !important;
        }
        .about-hero-section, 
        .core-values-section, 
        .why-choose-section {
            padding: 50px 0 !important;
        }
    }
</style>
@endsection
