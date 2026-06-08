{{--
    File: resources/views/frontend/components/brands.blade.php
    
    home.blade.php mein include karo:
    @include('frontend.components.brands')
    
    FrontendController index() mein add karo:
    $brandSection = \App\Models\HomeBrandSection::first();
    $brands = \App\Models\HomeBrand::where('is_active', 1)->orderBy('sort_order')->get();
    
    compact() mein add karo: 'brandSection', 'brands'
--}}

@if(isset($brandSection) && $brandSection->is_active && isset($brands) && $brands->count() > 0)

{{-- Owl Carousel CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<style>
.brands-section {
    padding: 36px 0 40px;
    background: #f0f4f0;
    border-top: 1px solid #e5e7eb;
}
.brands-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.brands-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
}
.brands-header h2 {
    font-size: 1.4rem;
    font-weight: 800;
    color: #1c1c1c;
    margin: 0;
}
.brands-view-all {
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: color .2s;
}
.brands-view-all:hover { color: #1a5c2e; }

/* Brand Card */
.brand-card {
        flex: 0 0 calc((100% - 84px) / 7);
    min-width: 0;
    /* background: #fff; */
    /* border-radius: 12px; */
    border: 1.5px solid #e5e7eb;
    /* padding: 10px; */
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .22s ease;
    text-decoration: none;
    cursor: pointer;
    pointer-events: auto;
}
.brand-card:hover {
    border-color: #1a5c2e;
    box-shadow: 0 4px 18px rgba(26,92,46,.15);
    transform: translateY(-2px);
}
.br-card img {
    max-width: 100%;
    width: 150px !important;
    height: 80px !important;
    max-height: 90px;
    object-fit: cover;
    filter: grayscale(30%);
    opacity: 0.85;
    transition: all .22s ease;
    user-select: none;
    -webkit-user-drag: none;
}

.brand-card:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

/* Owl nav arrows */
.brands-owl .owl-nav button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 34px;
    height: 34px;
    background: #fff !important;
    border: 1.5px solid #e5e7eb !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center;
    justify-content: center;
    font-size: 16px !important;
    color: #374151 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    transition: all .2s;
    z-index: 10;
}
.brands-owl .owl-nav button:hover {
    background: #1a5c2e !important;
    color: #fff !important;
    border-color: #1a5c2e !important;
}
.brands-owl .owl-nav button.owl-prev { left: -19px; }
.brands-owl .owl-nav button.owl-next { right: -19px; }
.brands-owl .owl-nav button span { line-height: 1; margin-top: -2px; }
.brands-owl { position: relative; padding: 0 10px; }
.brands-owl .owl-dots { display: none; }

.brands-section {
    padding: 36px 0 40px;
    background: #88A73B;
    border-top: 1px solid #e5e7eb;
}
.brands-header h2 {
    font-size: 1.4rem;
    font-weight: 800;
    color: #1c1c1c;
    margin: 0;
    font-size: 24px !important;
    font-weight: 500 !important;
    color: #fff;
}
</style>

<div class="brands-section">
    <div class="brands-inner">

        {{-- Header --}}
        <div class="brands-header">
            <h2>{{ $brandSection->heading ?? 'Brands' }}</h2>
			
            @if($brandSection->view_all_url)
            <a href="{{ $brandSection->view_all_url }}" class="brands-view-all">
                {{ $brandSection->view_all_text ?? 'View All' }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            @endif
        </div>

        {{-- Owl Carousel --}}
        <div class="brands-owl owl-carousel owl-theme" id="brandsOwl">
            @foreach($brands as $brand)
                @if($brand->url)
                <a class="brand-card" href="{{ $brand->url }}" target="_blank" rel="noopener">
                @else
                <div class="brand-card">
                @endif

                    @if($brand->image)
                        <img src="{{ asset('uploads/brands/' . $brand->image) }}"
                            alt="{{ $brand->alt_tag ?: 'Brand' }}"
                            loading="lazy">
                    @endif

                @if($brand->url)
                </a>
                @else
                </div>
                @endif
            @endforeach
        </div>

    </div>
</div>

{{-- Owl Carousel JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function(){
    $("#brandsOwl").owlCarousel({
        loop        : true,
        margin      : 0,
        nav         : true,
        dots        : false,
        autoplay    : true,
        autoplayTimeout : 3000,
        autoplayHoverPause : true,
        navText     : ['&#8249;', '&#8250;'],
        responsive  : {
            0   : { items: 2 },
            480 : { items: 3 },
            768 : { items: 5 },
            1024: { items: 7 },
            1280: { items: 8 }
        }
    });
});
</script>

@endif
