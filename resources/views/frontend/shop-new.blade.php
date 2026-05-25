@extends('frontend.layouts.layout')

@section('title', $title ?? 'Shop - Coming Soon')

@section('content')
@push('styles')
<style>
    /* Outer wrapper with padding */
    .coming-soon-wrapper {
        padding: 160px 80px;
        background-color: #f5f5f5; /* Light background outside container */
    }

    /* Main container with black background */
    .coming-soon-container {
        max-width: 1200px;
        margin: 0 auto;
        background-color: #000000;
        border-radius: 0; /* Sharp corners like in image */
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .coming-soon-middle {
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: #fff;
        padding: 80px 40px;
        position: relative;
        overflow: hidden;
    }

    /* Background Clock GIF */
    .coming-soon-bg-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.3;
        z-index: 0;
        pointer-events: none;
    }

    .coming-soon-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Logo and gear graphic container */
    .coming-soon-logo-container {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .coming-soon-logo {
        max-width: 320px;
        width: 100%;
        height: auto;
        margin-bottom: 0;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.5));
    }

    /* Coming Soon Title */
    .coming-soon-title {
        font-family: 'Inter', 'Arial', sans-serif;
        font-size: 72px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 10px;
        margin: 0;
        line-height: 1;
        color: #FFFFFF;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .coming-soon-middle {
            padding: 60px 30px;
        }
        .coming-soon-title {
            font-size: 56px;
            letter-spacing: 8px;
        }
        .coming-soon-logo {
            max-width: 280px;
        }
        .coming-soon-logo-container {
            margin-bottom: 18px;
        }
        .coming-soon-bg-image {
            opacity: 0.25;
        }
    }

    @media (max-width: 1024px) {
        .coming-soon-wrapper {
            padding: 20px 15px;
        }
        .coming-soon-middle {
            min-height: 50vh;
            padding: 50px 25px;
        }
        .coming-soon-title {
            font-size: 44px;
            letter-spacing: 6px;
        }
        .coming-soon-logo {
            max-width: 240px;
        }
        .coming-soon-logo-container {
            margin-bottom: 15px;
        }
        .coming-soon-bg-image {
            opacity: 0.2;
        }
    }

    @media (max-width: 480px) {
        .coming-soon-wrapper {
            padding: 15px 10px;
        }
        .coming-soon-middle {
            min-height: 45vh;
            padding: 40px 20px;
        }
        .coming-soon-title {
            font-size: 32px;
            letter-spacing: 4px;
        }
        .coming-soon-logo {
            max-width: 200px;
        }
        .coming-soon-logo-container {
            margin-bottom: 12px;
        }
        .coming-soon-bg-image {
            opacity: 0.15;
        }
    }
</style>
@endpush

<div class="coming-soon-wrapper">
    <div class="coming-soon-container">
        <div class="coming-soon-middle">
            <!-- Animated Clock GIF Background -->
            <img src="{{ asset('public/images/shop-new/clock.gif') }}" class="coming-soon-bg-image" alt="Background">

            <div class="coming-soon-content">
                <!-- Logo with gear graphic -->
                <div class="coming-soon-logo-container">
                    <img src="{{ asset('public/images/shop-new/coming-soon-banner.png') }}" 
                         class="coming-soon-logo" 
                         alt="Red-Labs Manufacturing | 3D Scanning | 3D Printing">
                </div>
                
                <!-- Coming Soon Title -->
                <h1 class="coming-soon-title">COMING SOON</h1>
            </div>
        </div>
    </div>
</div>
@endsection