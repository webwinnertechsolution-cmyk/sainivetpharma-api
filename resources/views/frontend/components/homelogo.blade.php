{{--
    File: resources/views/frontend/components/homelogo.blade.php

    FrontendController index() mein add karo:
    $homeLogos = \App\Models\HomeLogo::where('is_active', 1)->orderBy('sort_order')->get();

    compact() mein add karo: 'homeLogos'

    home.blade.php mein include karo:
    @include('frontend.components.homelogo')
--}}

@if(isset($homeLogos) && $homeLogos->count() > 0)

<style>
.homelogo-section {
    padding: 22px 0;
    background: #fff;
}
.homelogo-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.homelogo-grid {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 16px;
}
.homelogo-item {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 12px;
    padding: 14px 20px;
    width: 20%;
    height: auto;
    transition: all .22s ease;
    text-decoration: none;
}
.homelogo-item:hover {
    border-color: #1a5c2e;
    box-shadow: 0 4px 16px rgba(26,92,46,.12);
    transform: translateY(-2px);
}
.homelogo-item img {
    max-width: 100%;
    max-height: auto;
    object-fit: contain;
    filter: grayscale(20%);
    opacity: 0.85;
    transition: all .22s;
}
.homelogo-item:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

/* Responsive */
@media (max-width: 1200px) {
    .homelogo-item { width: calc(20% - 13px); }
}
@media (max-width: 992px) {
    .homelogo-item { width: calc(25% - 12px); }
}
@media (max-width: 768px) {
    .homelogo-item { width: calc(33.333% - 11px); height: 70px; }
	.homelogo-section {
    padding-top: 38px;
    padding-bottom: 34px;
}
}
@media (max-width: 480px) {
    .homelogo-item { width: calc(50% - 8px); height: 65px; }
}
</style>

<div class="homelogo-section">
    <div class="homelogo-inner">
        <div class="homelogo-grid">
            @foreach($homeLogos as $logo)
                @if($logo->url)
                <a class="homelogo-item" href="{{ $logo->url }}" target="_blank" rel="noopener">
                @else
                <div class="homelogo-item">
                @endif

                    @if($logo->image)
                        <img src="{{ asset('uploads/homelogos/' . $logo->image) }}"
                            alt="{{ $logo->alt_tag ?: 'Logo' }}"
                            loading="lazy">
                    @endif

                @if($logo->url)
                </a>
                @else
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

@endif