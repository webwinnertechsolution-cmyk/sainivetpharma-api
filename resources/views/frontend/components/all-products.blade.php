{{--
    File: resources/views/frontend/components/all-products.blade.php
    Sticky sidebar: ap-wrap top pe aaye tab sidebar fix hota hai
    + Agriculture animated background
--}}

@php
    $apAllProducts = \App\Models\Product::with(['categories','variants'])
        ->where('status','published')
        ->latest('published_at')
        ->get();

    $apCategories = \App\Models\ProductCategory::withCount([
        'products' => fn($q) => $q->where('status','published')
    ])->orderBy('name')->get();

    $apTotal = $apAllProducts->count();
@endphp

@if($apAllProducts->count() > 0)

<style>
/* ─── AGRICULTURE ANIMATED BACKGROUND ─── */
.ap-agriculture-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}

.ap-crop {
    position: absolute;
    font-size: 2.5rem;
    opacity: 0;
    animation: apFloatCrop 10s ease-in-out infinite;
    filter: drop-shadow(2px 2px 6px rgba(0,0,0,0.15));
}

@keyframes apFloatCrop {
    0% {
        bottom: -10%;
        opacity: 0;
        transform: translateX(0) rotate(0deg) scale(0.8);
    }
    10% {
        opacity: 0.6;
    }
    50% {
        opacity: 0.7;
        transform: translateX(30px) rotate(180deg) scale(1);
    }
    90% {
        opacity: 0.4;
    }
    100% {
        bottom: 110%;
        opacity: 0;
        transform: translateX(-30px) rotate(360deg) scale(0.8);
    }
}

/* Different animation speeds & delays */
.ap-crop-wheat { animation-duration: 11s; }
.ap-crop-corn { animation-duration: 13s; }
.ap-crop-cotton { animation-duration: 9.5s; }
.ap-crop-sugarcane { animation-duration: 12s; }
.ap-crop-mango { animation-duration: 14s; }
.ap-crop-banana { animation-duration: 10.5s; }
.ap-crop-coconut { animation-duration: 15s; }
.ap-crop-moong { animation-duration: 9s; }
.ap-crop-mustard { animation-duration: 8.5s; }

/* ─── ALL PRODUCTS COMPONENT ─── */

.ap-wrap {
    padding: 42px 0 50px;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 50%, #a5d6a7 100%);
    overflow: visible !important;
    position: relative;
}

.ap-inner {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 0px;
    overflow: visible !important;
    position: relative;
    z-index: 1;
}

.ap-heading {
    font-size: 24px;
    font-weight: 500;
    color: #222;
    margin: 0 0 22px;
}

/* ── LAYOUT ── */
.ap-layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 22px;
    align-items: start;
    position: relative;
    overflow: visible !important;
}

/* ── SIDEBAR ── */
.ap-sidebar {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #e5e7eb;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    z-index: 10;
    width: 240px;
}

.ap-sb-head {
    background: #1a5c2e;
    padding: 13px 18px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    border-radius: 12px 12px 0 0;
    position: sticky;
    top: 0;
    z-index: 1;
}

.ap-sb-toggle {
    width: 100%;
    padding: 11px 18px;
    background: none;
    border: none;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: .06em;
}
.ap-sb-toggle:hover { background: #f9fafb; }
.ap-sb-toggle .ap-arrow {
    width: 18px; height: 18px;
    background: #e8f5ec; color: #1a5c2e;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 9px;
    transition: transform .25s;
    flex-shrink: 0;
}
.ap-sb-toggle.ap-open .ap-arrow { transform: rotate(180deg); }
.ap-sb-body { padding: 4px 18px 12px; }
.ap-sb-body.ap-hidden { display: none; }

.ap-cat-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 0;
    font-size: 12.5px;
    color: #374151;
    cursor: pointer;
    border-bottom: 1px solid #f9fafb;
    text-decoration: none;
    transition: color .15s;
    background: none;
    border-left: none;
    border-right: none;
    border-top: none;
    width: 100%;
    text-align: left;
    font-family: inherit;
}
.ap-cat-link:last-child { border-bottom: none; }
.ap-cat-link:hover,
.ap-cat-link.ap-active {
    color: #1a5c2e;
    font-weight: 700;
}
.ap-cat-count {
    font-size: 10.5px;
    background: #e8f5ec;
    color: #1a5c2e;
    padding: 1px 7px;
    border-radius: 10px;
    font-weight: 700;
    flex-shrink: 0;
}
.ap-cat-link.ap-active .ap-cat-count {
    background: #1a5c2e;
    color: #fff;
}

/* ── MOBILE FILTER BUTTON ── */
.ap-mob-btn {
    display: none;
    align-items: center;
    gap: 8px;
    background: #1a5c2e;
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
}

/* ── MOBILE OVERLAY ── */
.ap-mob-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    z-index: 998;
}
.ap-mob-overlay.ap-show { display: block; }

/* ── TOP BAR ── */
.ap-topbar {
    background: #fff;
    border-radius: 10px;
    border: 1.5px solid #e5e7eb;
    padding: 10px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    font-size: 13px;
    color: #6b7280;
    flex-wrap: wrap;
    gap: 8px;
}
.ap-topbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.ap-sort-sel {
    padding: 5px 10px;
    border: 1.5px solid #e5e7eb;
    border-radius: 7px;
    font-size: 12px;
    color: #1c1c1c;
    outline: none;
    cursor: pointer;
    height: 32px;
    margin: 0;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='5'%3E%3Cpath d='M0 0l4 5 4-5z' fill='%236b7280'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none;
    padding-right: 26px;
    font-family: inherit;
}
.ap-sort-sel:focus { border-color: #1a5c2e; }

/* ── PRODUCT GRID ── */
.ap-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}

/* ── PRODUCT CARD ── */
.ap-card {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #e5e7eb;
    overflow: hidden;
    transition: all .22s ease;
    position: relative;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}
.ap-card:hover {
    border-color: #1a5c2e;
    box-shadow: 0 8px 28px rgba(26,92,46,.18);
    transform: translateY(-2px);
}

.ap-img {
    aspect-ratio: 1;
    background: #f9fafb;
    display: flex; align-items: center; justify-content: center;
    padding: 0px; overflow: hidden;
}
.ap-img img {
    max-width: 100%; max-height: 100%;
    object-fit: contain;
    transition: transform .35s ease;
}
.ap-card:hover .ap-img img { transform: scale(1.07); }
.ap-img-placeholder { color: #d1d5db; }

.ap-body {
    padding: 11px 13px 13px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.ap-cat-pill {
    font-size: 10px;
    background: #e8f5ec;
    color: #1a5c2e;
    padding: 2px 8px;
    border-radius: 10px;
    display: inline-block;
    font-weight: 600;
    margin-bottom: 6px;
    align-self: flex-start;
}

.ap-title {
    font-size: 13px; font-weight: 700; color: #1c1c1c;
    line-height: 1.4; margin-bottom: 5px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.ap-card:hover .ap-title { color: #1a5c2e; }

.ap-overview {
    font-size: 11.5px;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.ap-stock {
    font-size: 10.5px; font-weight: 700;
    padding: 2px 8px; border-radius: 5px;
    display: none;
    align-items: center; gap: 4px;
    margin-top: auto;
    align-self: flex-start;
}
.ap-stock.out { display: inline-flex; background: #fee2e2; color: #dc2626; }
.ap-sdot { width: 5px; height: 5px; border-radius: 50%; }
.ap-stock.out .ap-sdot { background: #dc2626; }

.ap-size-row {
    display: flex; align-items: center; gap: 6px;
    margin-top: 8px; font-size: 11.5px;
}
.ap-size-label { font-weight: 700; color: #6b7280; flex-shrink: 0; }
select.ap-size-sel {
    flex: 1;
    height: 31px;
    padding: 3px 8px;
    border: 1.5px solid #e5e7eb; border-radius: 6px;
    font-size: 11px; outline: none; color: #1c1c1c; cursor: pointer;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='5'%3E%3Cpath d='M0 0l4 5 4-5z' fill='%236b7280'/%3E%3C/svg%3E") no-repeat right 6px center;
    appearance: none;
    margin: 0;
    font-family: inherit;
}
select.ap-size-sel:focus { border-color: #1a5c2e; }

/* ── LOAD MORE ── */
.ap-load-wrap {
    text-align: center;
    margin-top: 24px;
}
.ap-load-btn {
    padding: 12px 32px;
    background: #1a5c2e;
    color: #fff;
    border: none;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: inherit;
}
.ap-load-btn:hover { background: #145224; transform: translateY(-1px); }
.ap-load-btn.ap-hidden { display: none; }
.ap-load-count {
    font-size: 12.5px;
    color: #6b7280;
    margin-top: 8px;
}

.ap-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px 20px;
    color: #9ca3af;
    font-size: 14px;
}

/* ── RESPONSIVE ── */
@media (max-width: 960px) {
    .ap-layout {
        grid-template-columns: 1fr;
    }
    .ap-sidebar {
        position: fixed !important;
        top: 0 !important;
        left: -270px !important;
        width: 260px !important;
        height: 100% !important;
        max-height: 100% !important;
        z-index: 999 !important;
        border-radius: 0 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        transition: left .32s cubic-bezier(.4,0,.2,1) !important;
    }
    .ap-sidebar.ap-mob-open {
        left: 0 !important;
        box-shadow: 4px 0 28px rgba(0,0,0,.22) !important;
    }
    .ap-mob-btn { display: flex; }
    .ap-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    
    .ap-crop {
        font-size: 2rem;
    }
}

.ap-grid { grid-template-columns: 1fr 1fr 1fr 1fr; } 

@media screen and (min-device-width: 768px) and (max-device-width: 2400px) { 

.yhaaddkro div#apRightCol {
    width: 908px;
    margin-left: 260px;
}
.yhaaddkro div#apRightCol {
    width: 900px;
    margin-left: 260px;
}
div#apWrap {
    padding-inline: 20px;
}
.ap-mob-btn {
    display: none;
    align-items: center;
    gap: 8px;
    background: #1a5c2e;
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 8px 16px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
}

}

div#apWrap {
    padding-inline: 15px;
    padding-top: 18px;
}
.ap-topbar-left {
    font-size: 10px;
}
span.ap-cat-pill {
    display: none;
}
.ap-cat-link:hover, .ap-cat-link.ap-active {
    color: #1a5c2e!important;
    font-weight: 700;
    background-color: #ff000000;
}
.ap-cat-link.ap-active .ap-cat-count {
    background: #1a5c2e00;
    color: #1a5c2e;
}
.ap-heading {
    font-size: 24px;
    font-weight: 500;
    color: #222;
    margin: 0 0 22px;
    text-align: center;
    padding-top: 31px;
    padding-bottom: 21px;
}
.ap-wrap {
    padding: 42px 0 50px;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c99c 50%, #a5d6a782 100%);
    overflow: visible !important;
    position: relative;
}
@media (max-width: 767px) {
    .ap-grid {
        grid-template-columns: 1fr 1fr;
    }
}
</style>

{{-- Mobile Overlay --}}
<div class="ap-mob-overlay" id="apMobOverlay" onclick="apCloseSidebar()"></div>

<div class="ap-wrap yhaaddkro" id="apWrap">
    
    {{-- ═══ AGRICULTURE ANIMATED BACKGROUND ═══ --}}
    <div class="ap-agriculture-bg">
        {{-- Wheat --}}
        <div class="ap-crop ap-crop-wheat" style="left: 8%; animation-delay: 0s;">🌾</div>
        <div class="ap-crop ap-crop-wheat" style="left: 88%; animation-delay: 2.5s;">🌾</div>
        <div class="ap-crop ap-crop-wheat" style="left: 45%; animation-delay: 5s;">🌾</div>
        
        {{-- Corn --}}
        <div class="ap-crop ap-crop-corn" style="left: 22%; animation-delay: 1s;">🌽</div>
        <div class="ap-crop ap-crop-corn" style="left: 72%; animation-delay: 3.8s;">🌽</div>
        
        {{-- Cotton --}}
        <div class="ap-crop ap-crop-cotton" style="left: 38%; animation-delay: 1.8s;">🌸</div>
        <div class="ap-crop ap-crop-cotton" style="left: 92%; animation-delay: 4.5s;">🌸</div>
        
        {{-- Sugarcane --}}
        <div class="ap-crop ap-crop-sugarcane" style="left: 58%; animation-delay: 2.2s;">🎋</div>
        <div class="ap-crop ap-crop-sugarcane" style="left: 12%; animation-delay: 6s;">🎋</div>
        
        {{-- Mango --}}
        <div class="ap-crop ap-crop-mango" style="left: 18%; animation-delay: 0.8s;">🥭</div>
        <div class="ap-crop ap-crop-mango" style="left: 78%; animation-delay: 4.2s;">🥭</div>
        
        {{-- Banana --}}
        <div class="ap-crop ap-crop-banana" style="left: 32%; animation-delay: 2s;">🍌</div>
        <div class="ap-crop ap-crop-banana" style="left: 82%; animation-delay: 5.5s;">🍌</div>
        
        {{-- Coconut --}}
        <div class="ap-crop ap-crop-coconut" style="left: 25%; animation-delay: 3s;">🥥</div>
        <div class="ap-crop ap-crop-coconut" style="left: 95%; animation-delay: 1.5s;">🥥</div>
        
        {{-- Moong/Pulses --}}
        <div class="ap-crop ap-crop-moong" style="left: 52%; animation-delay: 3.5s;">🫘</div>
        <div class="ap-crop ap-crop-moong" style="left: 68%; animation-delay: 1.2s;">🫘</div>
        <div class="ap-crop ap-crop-moong" style="left: 5%; animation-delay: 4.8s;">🫘</div>
        
        {{-- Mustard/Leaves --}}
        <div class="ap-crop ap-crop-mustard" style="left: 42%; animation-delay: 2.8s;">🌿</div>
        <div class="ap-crop ap-crop-mustard" style="left: 15%; animation-delay: 5.2s;">🌿</div>
        <div class="ap-crop ap-crop-mustard" style="left: 85%; animation-delay: 0.5s;">🌿</div>
    </div>

    <div class="ap-inner">

        <h2 class="ap-heading">Our Products ✨</h2>

        <div class="ap-layout" id="apLayout">

            {{-- ═══ SIDEBAR ═══ --}}
            <aside class="ap-sidebar" id="apSidebar">
                <div class="ap-sb-head">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="4" y1="6" x2="20" y2="6"/>
                        <line x1="4" y1="12" x2="16" y2="12"/>
                        <line x1="4" y1="18" x2="12" y2="18"/>
                    </svg>
                    Filters
                    <button
                        onclick="apCloseSidebar()"
                        id="apSbClose"
                        style="margin-left:auto;background:rgba(255,255,255,.2);border:none;color:#fff;width:26px;height:26px;border-radius:50%;cursor:pointer;display:none;align-items:center;justify-content:center;font-size:14px;">
                        ×
                    </button>
                </div>

                <button class="ap-sb-toggle ap-open" onclick="apSbToggle(this)">
                    Categories
                    <span class="ap-arrow">▼</span>
                </button>

                <div class="ap-sb-body" id="apCatBody">
                    <button class="ap-cat-link ap-active" onclick="apFilter('all', this)">
                        All Products
                        <span class="ap-cat-count">{{ $apTotal }}</span>
                    </button>
                    @foreach($apCategories as $apCat)
                        @if($apCat->products_count > 0)
                        <button class="ap-cat-link" onclick="apFilter('{{ $apCat->id }}', this)">
                            {{ $apCat->name }}
                            <span class="ap-cat-count">{{ $apCat->products_count }}</span>
                        </button>
                        @endif
                    @endforeach
                </div>
            </aside>

            {{-- ═══ RIGHT COLUMN ═══ --}}
            <div id="apRightCol">

                {{-- Top Bar --}}
                <div class="ap-topbar">
                    <div class="ap-topbar-left">
                        <button class="ap-mob-btn" onclick="apOpenSidebar()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="4" y1="6" x2="20" y2="6"/>
                                <line x1="4" y1="12" x2="16" y2="12"/>
                                <line x1="4" y1="18" x2="12" y2="18"/>
                            </svg>
                            Filters
                        </button>
                        <span id="apCountText">{{ $apTotal }} products</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        Sort:
                        <select class="ap-sort-sel" onchange="apSort(this.value)">
                            <option value="latest">Latest</option>
                            <option value="name_asc">Name A–Z</option>
                            <option value="featured">Featured First</option>
                        </select>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="ap-grid" id="apGrid">
                    @foreach($apAllProducts as $idx => $p)
                    @php
                        $apHasVar  = $p->variants && $p->variants->count() > 0;
                        $apInStock = $p->stock_quantity > 0;
                        $apImg     = $p->featured_image ? asset('uploads/products/'.$p->featured_image) : null;
                        $apCatName = $p->categories->first()->name ?? '';
                        $apCatId   = $p->categories->first()->id ?? '';
                        $apUrl     = route('product.detail', $p->slug);
                    @endphp

                    <div class="ap-card"
                         data-idx="{{ $idx }}"
                         data-cat="{{ $apCatId }}"
                         data-name="{{ strtolower($p->title) }}"
                         data-featured="{{ $p->is_featured ? '1' : '0' }}"
                         onclick="window.location.href='{{ $apUrl }}'">

                        <div class="ap-img">
                            @if($apImg)
                                <img src="{{ $apImg }}"
                                     alt="{{ $p->featured_image_alt ?: $p->title }}"
                                     loading="{{ $idx < 8 ? 'eager' : 'lazy' }}">
                            @else
                                <div class="ap-img-placeholder">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <path d="M21 15l-5-5L5 21"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="ap-body">
                            @if($apCatName)
                            <span class="ap-cat-pill">{{ $apCatName }}</span>
                            @endif

                            <div class="ap-title">{{ $p->title }}</div>

                            @if($p->overview)
                            <div class="ap-overview">{{ $p->overview }}</div>
                            @endif

                            <div class="ap-stock {{ $apInStock ? 'in' : 'out' }}">
                                <span class="ap-sdot"></span>
                                {{ $apInStock ? 'In Stock' : 'Out of Stock' }}
                            </div>

                            @if($apHasVar)
                            <div class="ap-size-row"
                                onclick="event.stopPropagation();"
                                onmousedown="event.stopPropagation();">
                                <span class="ap-size-label">Size</span>
                                <select class="ap-size-sel"
                                    onclick="event.stopPropagation();"
                                    onmousedown="event.stopPropagation();"
                                    onfocus="event.stopPropagation();"
                                    onchange="event.stopPropagation();">
                                    @foreach($p->variants as $v)
                                    <option value="{{ $v->name }}">{{ $v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Load More --}}
                <div class="ap-load-wrap" id="apLoadWrap">
                    <button class="ap-load-btn" id="apLoadBtn" onclick="apLoadMore()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                        Load More Products
                    </button>
                    <div class="ap-load-count" id="apLoadCount">
                        Showing 8 of {{ $apTotal }} products
                    </div>
                </div>

            </div>{{-- end right col --}}
        </div>{{-- end layout --}}

    </div>{{-- end inner --}}
</div>{{-- end wrap --}}

<script>
(function () {

    /* ══════════════════════════════════════════
       CONSTANTS
    ══════════════════════════════════════════ */
    var INITIAL_ROWS   = 2;
    var LOAD_ROWS      = 2;
    var STICKY_TOP     = 20;
    var RELEASE_BOTTOM = 50;

    var currentCat   = 'all';
    var visibleCount = 0;

    /* ══════════════════════════════════════════
       HELPERS
    ══════════════════════════════════════════ */
    function cols() {
        return window.innerWidth <= 960 ? 2 : 4;
    }

    /* ══════════════════════════════════════════
       SIDEBAR TOGGLE (accordion)
    ══════════════════════════════════════════ */
    window.apSbToggle = function (btn) {
        var body = document.getElementById('apCatBody');
        btn.classList.toggle('ap-open');
        body.classList.toggle('ap-hidden');
    };

    /* ══════════════════════════════════════════
       MOBILE SIDEBAR OPEN / CLOSE
    ══════════════════════════════════════════ */
    window.apOpenSidebar = function () {
        var sb = document.getElementById('apSidebar');
        var ov = document.getElementById('apMobOverlay');
        var cl = document.getElementById('apSbClose');
        sb.classList.add('ap-mob-open');
        ov.classList.add('ap-show');
        document.body.style.overflow = 'hidden';
        if (cl) cl.style.display = 'flex';
    };

    window.apCloseSidebar = function () {
        var sb = document.getElementById('apSidebar');
        var ov = document.getElementById('apMobOverlay');
        var cl = document.getElementById('apSbClose');
        sb.classList.remove('ap-mob-open');
        ov.classList.remove('ap-show');
        document.body.style.overflow = '';
        if (cl) cl.style.display = 'none';
    };

    /* ══════════════════════════════════════════
       CATEGORY FILTER
    ══════════════════════════════════════════ */
    window.apFilter = function (catId, btn) {
        currentCat   = catId;
        visibleCount = cols() * INITIAL_ROWS;
        document.querySelectorAll('.ap-cat-link').forEach(function (el) {
            el.classList.remove('ap-active');
        });
        btn.classList.add('ap-active');
        apRender();
        apCloseSidebar();
    };

    /* ══════════════════════════════════════════
       SORT
    ══════════════════════════════════════════ */
    window.apSort = function (val) {
        var grid  = document.getElementById('apGrid');
        var cards = Array.from(grid.querySelectorAll('.ap-card'));
        cards.sort(function (a, b) {
            if (val === 'name_asc') return a.dataset.name.localeCompare(b.dataset.name);
            if (val === 'featured') return parseInt(b.dataset.featured) - parseInt(a.dataset.featured);
            return parseInt(a.dataset.idx) - parseInt(b.dataset.idx);
        });
        cards.forEach(function (c) { grid.appendChild(c); });
        apRender();
    };

    /* ══════════════════════════════════════════
       LOAD MORE
    ══════════════════════════════════════════ */
    window.apLoadMore = function () {
        visibleCount += cols() * LOAD_ROWS;
        apRender();
    };

    /* ══════════════════════════════════════════
       CORE RENDER  (filter + pagination)
    ══════════════════════════════════════════ */
    function apRender() {
        var grid  = document.getElementById('apGrid');
        var cards = Array.from(grid.querySelectorAll('.ap-card'));

        var matching = cards.filter(function (c) {
            return currentCat === 'all' || c.dataset.cat == currentCat;
        });
        var others = cards.filter(function (c) {
            return currentCat !== 'all' && c.dataset.cat != currentCat;
        });

        others.forEach(function (c) { c.style.display = 'none'; });

        var shown = 0;
        matching.forEach(function (c) {
            if (shown < visibleCount) { c.style.display = ''; shown++; }
            else { c.style.display = 'none'; }
        });

        var ct = document.getElementById('apCountText');
        if (ct) ct.textContent = matching.length + ' products';

        var btn   = document.getElementById('apLoadBtn');
        var count = document.getElementById('apLoadCount');
        var wrap  = document.getElementById('apLoadWrap');

        if (shown < matching.length) {
            if (btn)   btn.classList.remove('ap-hidden');
            if (count) count.textContent = 'Showing ' + shown + ' of ' + matching.length + ' products';
            if (wrap)  wrap.style.display = '';
        } else {
            if (btn) btn.classList.add('ap-hidden');
            if (matching.length > 0) {
                if (count) count.textContent = 'All ' + matching.length + ' products shown';
                if (wrap)  wrap.style.display = '';
            } else {
                if (wrap) wrap.style.display = 'none';
            }
        }
    }

    /* ══════════════════════════════════════════
       STICKY SIDEBAR
    ══════════════════════════════════════════ */
    var sidebarLeft  = null;
    var sidebarWidth = null;

    function captureMetrics() {
        if (window.innerWidth <= 960) return;

        var sidebar = document.getElementById('apSidebar');
        if (!sidebar) return;

        sidebar.style.position = '';
        sidebar.style.top      = '';
        sidebar.style.left     = '';
        sidebar.style.width    = '';

        var rect     = sidebar.getBoundingClientRect();
        sidebarLeft  = rect.left;
        sidebarWidth = rect.width;
    }

    function onScroll() {
        if (window.innerWidth <= 960) return;

        var sidebar  = document.getElementById('apSidebar');
        var wrap     = document.getElementById('apWrap');
        var rightCol = document.getElementById('apRightCol');

        if (!sidebar || !wrap || !rightCol || sidebarLeft === null) return;

        var wrapRect  = wrap.getBoundingClientRect();
        var sidebarH  = sidebar.offsetHeight;
        var rightColH = rightCol.offsetHeight;

        if (wrapRect.top > STICKY_TOP) {
            sidebar.style.position = '';
            sidebar.style.top      = '';
            sidebar.style.left     = '';
            sidebar.style.width    = '';
            wrap.classList.remove('yhaaddkro');
            return;
        }

        if (wrapRect.bottom <= sidebarH + STICKY_TOP + RELEASE_BOTTOM) {
            sidebar.style.position = 'absolute';
            sidebar.style.top      = (rightColH - sidebarH) + 'px';
            sidebar.style.left     = '0';
            sidebar.style.width    = sidebarWidth + 'px';
            wrap.classList.add('yhaaddkro');
            return;
        }

        sidebar.style.position = 'fixed';
        sidebar.style.top      = STICKY_TOP + 'px';
        sidebar.style.left     = sidebarLeft + 'px';
        sidebar.style.width    = sidebarWidth + 'px';
        wrap.classList.add('yhaaddkro');
    }

    function initSticky() {
        if (window.innerWidth <= 960) return;

        var layout = document.getElementById('apLayout');
        if (layout) layout.style.position = 'relative';

        captureMetrics();
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    /* ══════════════════════════════════════════
       INIT
    ══════════════════════════════════════════ */
    function init() {
        visibleCount = cols() * INITIAL_ROWS;
        apRender();
        initSticky();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') apCloseSidebar();
    });

    window.addEventListener('resize', function () {
        var sidebar = document.getElementById('apSidebar');

        if (window.innerWidth <= 960) {
            if (sidebar) {
                sidebar.style.position = '';
                sidebar.style.top      = '';
                sidebar.style.left     = '';
                sidebar.style.width    = '';
            }
        } else {
            if (sidebar) {
                sidebar.style.position = '';
                sidebar.style.top      = '';
                sidebar.style.left     = '';
                sidebar.style.width    = '';
            }
            captureMetrics();
            onScroll();
        }
    });

})();
</script>

@endif