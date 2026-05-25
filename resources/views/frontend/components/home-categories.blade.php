@if(isset($homeCategories) && $homeCategories->count() > 0)
<section class="home-categories-section" style="padding: 5px 0; background: #fff;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

        {{-- Section Heading --}}
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
            <div style="text-align: left;">
                <h2 style="font-size: 24px; font-weight: 500; color: #222; margin-bottom: 0;">Categories 🌱</h2>
                <p>Explore Every Product Now</p>
            </div>
          <a href="#" class="ps-view-all">
    View All
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"></path></svg>
</a>
        </div>

        {{-- Category Grid --}}
        <div class="home-cat-grid" style="
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 30px 20px;
        ">
            @foreach($homeCategories as $cat)
            <div class="home-cat-item" style="text-align: center;">
                @if($cat->url)
                    <a href="{{ $cat->url }}" style="text-decoration: none; color: inherit;">
                @endif
                       <div class="home-cat-circle" style="
									width: 200px;
									height: 200px;
									overflow: hidden;
									margin: 0 auto 12px;
									background: #f0f4f8;
									display: flex;
									align-items: center;
									justify-content: center;
									transition: transform 0.3s ease, box-shadow 0.3s ease;
									box-shadow: 0 2px 10px rgba(0,0,0,0.08);
									border-radius:10px;
								">
                            @if($cat->image)
                                <img src="{{ asset('uploads/home-categories/' . $cat->image) }}"
                                    alt="{{ $cat->alt_tag ?: $cat->title }}"
                                    style="width: 100%; height: 100%; object-fit: cover;"
                                    loading="lazy">
                            @endif
                        </div>
                        <p style="
                            font-size: 0.9rem;
                            font-weight: 600;
                            color: #333;
                            margin: 0;
                            line-height: 1.3;
                        ">{{ $cat->title }}</p>
                @if($cat->url)
                    </a>
                @endif
            </div>
            @endforeach
        </div>

    </div>
</section>

<style>
.home-cat-item a:hover .home-cat-circle {
    transform: translateY(-6px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15) !important;
}
.home-cat-item a:hover p {
    color: #e63946;
}
.home-categories-section p {
    font-size: 14px;
    margin-top: 8px;
}
.home-cat-item p {
    font-size: 14px!important;
}
.home-categories-section .container {
    padding-bottom: 41px!important;
}
    font-size: 14px;
    margin-top: 8px;
    margin-bottom: 0;
/* Responsive */
@media (max-width: 1024px) {
    .home-cat-grid {
        grid-template-columns: repeat(4, 1fr) !important;
    }
}
<!-- @media (max-width: 640px) {
    .home-cat-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 20px 12px !important;
    }
    .home-cat-circle {
        width: 90px !important;
        height: 90px !important;
    }
} -->
.home-cat-grid {
    display: flex!important;
    flex-wrap: wrap;
}
.home-cat-item {
    width: 15.2%;
}
.home-cat-circle {
    width: 100%!important;
    height: 170px!important;
    background-size: cover!important;
}
@media (max-width: 767px) {
    .home-cat-grid {
        grid-template-columns: repeat(3, 1fr) !important;
    }
	.home-categories-section h2 {
    font-size: 18px!important;
}
.home-categories-section p {
    font-size: 14px;
    margin-top: 5px;
    margin-bottom: 15px;
}
.ps-view-all {
    font-size: 12px!important;
    font-weight: 700;
    color: #374151;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    transition: color .2s;
}
.home-cat-item p {
    font-size: 13px!important;
    text-align: center;
}
.home-cat-circle {
    width: 100%!important;
    height: auto!important;
}
.home-cat-item {
    width: 31%;
}
}

</style>
@endif