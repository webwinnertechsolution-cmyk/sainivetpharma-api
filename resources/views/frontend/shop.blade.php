{{-- Save as: resources/views/frontend/shop.blade.php --}}
@extends('frontend.layouts.layout')

@section('title', isset($currentCategory) ? $currentCategory->name . ' - Shop' : 'Shop - All Products')
@section('meta_description', isset($currentCategory) ? ($currentCategory->meta_description ?? '') : '')
@section('meta_keywords', isset($currentCategory) ? ($currentCategory->meta_keywords ?? '') : '')
@section('og_title', isset($currentCategory) ? ($currentCategory->og_title ?: $currentCategory->meta_title ?: $currentCategory->name) : 'Shop - All Products')
@section('og_description', isset($currentCategory) ? ($currentCategory->og_description ?: $currentCategory->meta_description ?? '') : '')
@section('og_image', isset($currentCategory) && $currentCategory->og_image ? asset('uploads/product-categories/og/' . $currentCategory->og_image) : asset('public/backend/assets/images/favicon.png'))

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Syne:wght@600;700;800&display=swap');

:root {
    --green: #1a5c2e;
    --green-light: #e8f5ec;
    --green-mid: #2d7a45;
    --acc: #f59e0b;
    --acc-light: #fef3c7;
    --red: #dc2626;
    --red-light: #fee2e2;
    --txt: #1c1c1c;
    --mut: #6b7280;
    --bdr: #e5e7eb;
    --bg: #f4f6f3;
    --white: #ffffff;
    --rad: 12px;
    --shadow: 0 2px 12px rgba(0,0,0,.08);
}

/* ── PAGE HEADER ── */
.shop-header {
    background: var(--green);
    padding: 22px 0;
    position: relative;
    overflow: hidden;
}
.shop-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
}
.shop-header::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 10%;
    width: 140px; height: 140px;
    background: rgba(255,255,255,.04);
    border-radius: 50%;
}
.shop-header-inner {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}
.shop-title { font-family: 'Syne', sans-serif; font-size: 24px; color: #fff; font-weight: 700; }
.shop-bc { display: flex; align-items: center; gap: 6px; font-size: 13px; }
.shop-bc a { color: rgba(255,255,255,.7); text-decoration: none; transition: color .2s; }
.shop-bc a:hover { color: #fff; }
.shop-bc span { color: rgba(255,255,255,.4); }
.shop-bc-cur { color: #fff; font-weight: 600; }

/* ── MAIN LAYOUT ── */
.shop-layout {
    max-width: 1300px;
    margin: 24px auto;
    padding: 0 24px 60px;
    display: grid;
    grid-template-columns: 265px 1fr;
    gap: 22px;
    align-items: start;
}
@media(max-width: 900px) {
    .shop-layout { grid-template-columns: 1fr; }
    .mob-filter-btn { display: flex !important; }
}

/* ── MOBILE OVERLAY ── */
.mob-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.48);
    z-index: 998;
    opacity: 0;
    transition: opacity .3s;
}
.mob-overlay.show { display: block; opacity: 1; }

/* ── SIDEBAR ── */
.sidebar {
    background: var(--white);
    border-radius: var(--rad);
    border: 1px solid var(--bdr);
    box-shadow: var(--shadow);
    overflow: hidden;
    position: relative;   /* sticky ki jagah relative */
    top: 0;
    will-change: transform;
}

@media(max-width: 900px) {
    .sidebar {
        display: block !important;
        position: fixed;
        top: 0; left: -290px;
        width: 280px; height: 100%;
        z-index: 999;
        border-radius: 0;
        overflow-y: auto;
        transition: left .32s cubic-bezier(.4,0,.2,1);
        box-shadow: none; border: none;
    }
    .sidebar.mob-open { left: 0; box-shadow: 4px 0 28px rgba(0,0,0,.22); }
}

.sidebar-head {
    background: var(--green);
    padding: 14px 18px;
    display: flex; align-items: center; justify-content: space-between;
}
.sidebar-head-title {
    font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 700; color: #fff;
    display: flex; align-items: center; gap: 8px;
}
.sidebar-head-title i { font-size: 14px; opacity: .8; }
.clear-all {
    font-size: 11.5px; color: rgba(255,255,255,.75); text-decoration: none;
    border: 1px solid rgba(255,255,255,.3); padding: 3px 10px; border-radius: 20px;
    cursor: pointer; transition: all .2s;
}
.clear-all:hover { background: rgba(255,255,255,.15); color: #fff; }
.mob-drawer-close {
    display: none; background: rgba(255,255,255,.15); border: none; color: #fff;
    width: 30px; height: 30px; border-radius: 50%;
    align-items: center; justify-content: center;
    cursor: pointer; font-size: 16px; transition: background .2s; flex-shrink: 0;
}
.mob-drawer-close:hover { background: rgba(255,255,255,.28); }
@media(max-width: 900px) { .mob-drawer-close { display: flex; } .clear-all { display: none; } }

.filter-sec { border-bottom: 1px solid var(--bdr); overflow: hidden; }
.filter-sec:last-child { border-bottom: none; }
.filter-toggle {
    width: 100%; padding: 13px 18px; background: none; border: none;
    display: flex; align-items: center; justify-content: space-between;
    font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 800; color: var(--txt);
    cursor: pointer; text-transform: uppercase; letter-spacing: .06em; transition: background .15s;
}
.filter-toggle:hover { background: var(--bg); color: black; }
.filter-toggle .arrow {
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--green-light); color: var(--green);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; transition: transform .25s; flex-shrink: 0;
}
.filter-toggle.open .arrow { transform: rotate(180deg); }
.filter-body { padding: 0 18px 14px; }
.filter-body.hidden { display: none; }

.cat-main {
    display: flex; align-items: center; justify-content: space-between;
    padding: 8px 0; cursor: pointer; font-size: 12px; font-weight: 600;
    color: var(--txt); text-decoration: none; border-bottom: 1px solid #f3f4f6;
}
.cat-main:hover { color: var(--green); }
.cat-main.active { color: var(--green); }
.cat-count {
    font-size: 11px; font-weight: 700;
    background: var(--green-light); color: var(--green);
    padding: 1px 7px; border-radius: 10px; min-width: 24px; text-align: center;
}
.cat-main.active .cat-count { background: var(--green); color: #fff; }

.chk-item {
    display: flex; align-items: center; gap: 9px; padding: 7px 0; cursor: pointer;
    font-size: 13.5px; color: #374151; transition: color .15s; border-bottom: 1px solid #f9fafb;
}
.chk-item:hover { color: var(--green); }
.chk-item input[type="checkbox"] { display: none; }
.custom-chk {
    width: 17px; height: 17px; border: 2px solid var(--bdr); border-radius: 4px; background: #fff;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all .15s;
}
.chk-item input:checked + .custom-chk { background: var(--green); border-color: var(--green); }
.chk-item input:checked + .custom-chk::after { content: '✓'; color: #fff; font-size: 10px; font-weight: 900; line-height: 1; }
.chk-label { flex: 1; }
.chk-cnt { font-size: 11px; color: var(--mut); margin-left: auto; }

.price-inputs { display: flex; align-items: center; gap: 8px; margin-top: 10px; }
.price-inp {
    flex: 1; padding: 5px; height: 33px; border: 1.5px solid var(--bdr); border-radius: 7px;
    font-family: 'Nunito', sans-serif; font-size: 12px; color: var(--txt);
    outline: none; transition: border-color .2s; width: 100%; margin: 0 !important;
}
.price-inp:focus { border-color: var(--green); }
.price-sep { font-size: 12px; color: var(--mut); flex-shrink: 0; }
.price-go {
    background: var(--green); color: #fff; border: none; border-radius: 7px;
    padding: 1px 11px; font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: background .2s; flex-shrink: 0; height: 34px;
    display: flex; align-items: center; justify-content: center;
}
.price-go:hover { background: var(--green-mid); }

.avail-row { display: flex; align-items: center; justify-content: space-between; padding: 8px 0; }
.toggle-switch { position: relative; width: 38px; height: 21px; cursor: pointer; }
.toggle-switch input { display: none; }
.toggle-track { position: absolute; inset: 0; background: var(--bdr); border-radius: 20px; transition: background .25s; }
.toggle-switch input:checked + .toggle-track { background: var(--green); }
.toggle-thumb {
    position: absolute; top: 3px; left: 3px; width: 15px; height: 15px; background: #fff;
    border-radius: 50%; transition: transform .25s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch input:checked + .toggle-track + .toggle-thumb,
.toggle-switch input:checked ~ .toggle-thumb { transform: translateX(17px); }
.avail-label { font-size: 13.5px; color: #374151; font-weight: 500; }

.apply-filter {
    display: block; width: calc(100% - 36px); margin: 10px 18px 16px; padding: 11px;
    background: var(--green); color: #fff; border: none; border-radius: 9px;
    font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700;
    cursor: pointer; text-align: center; text-decoration: none; transition: all .2s;
    box-shadow: 0 4px 12px rgba(26,92,46,.25);
}
.apply-filter:hover { background: var(--green-mid); transform: translateY(-1px); color: #fff; }

.top-bar {
    background: var(--white); border-radius: var(--rad); border: 1px solid var(--bdr);
    padding: 12px 18px; display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px; margin-bottom: 18px; box-shadow: var(--shadow);
}
.result-info { font-size: 14px; color: var(--mut); }
.result-info strong { color: var(--txt); font-weight: 700; }
.sort-wrap { display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: var(--mut); }
.sort-wrap span { width: 47%; }
.sort-select {
    padding: 7px 30px 7px 12px; border: 1.5px solid var(--bdr); border-radius: 8px;
    font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 600; color: var(--txt);
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7280'/%3E%3C/svg%3E") no-repeat right 10px center;
    appearance: none; outline: none; cursor: pointer; transition: border-color .2s; height: 38px; margin-bottom: 0;
}
.sort-select:focus { border-color: var(--green); }

.active-filters { display: flex; flex-wrap: wrap; gap: 7px; padding: 0 0 12px; }
.af-chip {
    display: flex; align-items: center; gap: 5px;
    background: var(--green-light); color: var(--green);
    border: 1px solid #b6dfc2; padding: 4px 10px; border-radius: 20px;
    font-size: 12px; font-weight: 700; text-decoration: none;
}
.af-chip .rm { font-size: 14px; cursor: pointer; opacity: .7; }
.af-chip .rm:hover { opacity: 1; }

.mob-filter-btn {
    display: none; align-items: center; gap: 8px;
    background: var(--green); color: #fff; border: none; border-radius: 9px; padding: 10px 16px;
    font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer;
}

/* ── PRODUCT GRID ── */
.product-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
@media(max-width: 1100px) { .product-grid { grid-template-columns: repeat(3, 1fr); } }
@media(max-width: 760px)  { .product-grid { grid-template-columns: repeat(2, 1fr); } }
@media(max-width: 400px)  { .product-grid { grid-template-columns: 1fr; } }

/* ── PRODUCT CARD ── */
.prod-card {
    background: var(--white); border-radius: var(--rad); border: 1.5px solid var(--bdr);
    overflow: hidden; transition: all .22s; cursor: pointer; position: relative;
    box-shadow: var(--shadow); display: flex; flex-direction: column;
    text-decoration: none; color: inherit;
}
.prod-card:hover { border-color: var(--green); box-shadow: 0 8px 28px rgba(26,92,46,.15); transform: translateY(-3px); }

.disc-badge {
    position: absolute; top: 10px; left: 10px; display:none; 
    background: var(--acc); color: #fff; font-size: 10.5px; font-weight: 800;
    padding: 3px 9px; border-radius: 6px; z-index: 2;
    letter-spacing: .03em; text-transform: uppercase;
    box-shadow: 0 2px 6px rgba(245,158,11,.35);
}
.disc-badge.sale { background: #f97316; box-shadow: 0 2px 6px rgba(220,38,38,.3); }

.card-img-wrap {
    aspect-ratio: 1; background: #f9fafb;
    display: flex; align-items: center; justify-content: center;
    padding: 0px; overflow: hidden;
}
.card-img-wrap img { max-width: 100%; max-height: 100%; object-fit: contain; transition: transform .35s; }
.prod-card:hover .card-img-wrap img { transform: scale(1.07); }
.no-img-ph { width: 60px; height: 60px; color: #d1d5db; font-size: 36px; display: flex; align-items: center; justify-content: center; }

.card-body { padding: 12px 14px; flex: 1; display: flex; flex-direction: column; }
.card-title {
    font-size: 13px; font-weight: 700; color: var(--txt); line-height: 1.4;
    margin-bottom: 5px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex: 1;
}
.prod-card:hover .card-title { color: var(--green); }
.card-brand {
	display: none; 
    font-size: 11.5px !important; color: var(--mut) !important;
    margin-bottom: 9px !important; height: 18px !important;
    text-transform: capitalize !important;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.card-price-row { display: none; align-items: baseline; flex-wrap: wrap; gap: 5px; margin-bottom: 7px; min-height: 20px; }
.price-sale { font-size: 12px; font-weight: 800; color: var(--txt); }
.price-orig { font-size: 12px; font-weight: 500; color: var(--mut); text-decoration: line-through; }
.price-save { font-size: 9px; font-weight: 700; color: var(--green); background: var(--green-light); padding: 1px 7px; border-radius: 10px; }
.price-na { font-size: 13px; color: var(--mut); font-style: italic; }

.stock-tag {
    font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 5px;
    display: none; align-items: center; gap: 4px; margin-bottom: 10px;
}
.stock-tag.out { display: inline-flex; background: var(--red-light); color: var(--red); }
.stock-dot { width: 6px; height: 6px; border-radius: 50%; }
.stock-tag.out .stock-dot { background: var(--red); }

.card-size-row { display: flex; align-items: center; gap: 6px; margin-bottom: 8px; font-size: 12px; }
.card-size-row label { font-weight: 700; color: var(--mut); }
select.card-size-sel {
    flex: 1; padding: 4px 8px; border: 1.5px solid #e5e7eb; border-radius: 6px;
    font-family: 'Nunito', sans-serif; font-size: 12px; outline: none; color: black;
    cursor: pointer;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='5'%3E%3Cpath d='M0 0l4 5 4-5z' fill='%236b7280'/%3E%3C/svg%3E") no-repeat right 7px center;
    appearance: none; margin: 0; height: 31px; transition: border-color .2s;
}
select.card-size-sel:focus { border-color: var(--green); }

/* ── EMPTY STATE ── */
.empty-state { grid-column: 1 / -1; text-align: center; padding: 60px 20px; }
.empty-state i { font-size: 56px; color: #d1d5db; margin-bottom: 16px; }
.empty-state h3 { font-family: 'Syne', sans-serif; font-size: 20px; color: #6b7280; margin-bottom: 8px; }
.empty-state p { font-size: 14px; color: #9ca3af; }
.empty-state a { display: inline-block; margin-top: 16px; padding: 10px 24px; background: var(--green); color: #fff; border-radius: 9px; text-decoration: none; font-weight: 700; font-size: 14px; }

/* ── PAGINATION ── */
.pagination-wrap { display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 28px; flex-wrap: wrap; }
.pag-btn {
    width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
    border-radius: 9px; border: 1.5px solid var(--bdr); background: #fff; color: var(--txt);
    font-size: 13px; font-weight: 700; font-family: 'Nunito', sans-serif;
    text-decoration: none; cursor: pointer; transition: all .18s;
}
.pag-btn:hover, .pag-btn.on { background: var(--green); color: #fff; border-color: var(--green); }
.pag-btn.dots { cursor: default; border-color: transparent; background: none; }
.pag-btn.disabled { opacity: .4; cursor: not-allowed; pointer-events: none; }

.shop-header {
    background: #1a5c2e1f!important;
}
.shop-title {
    font-family: 'Syne', sans-serif;
    font-size: 24px;
    color: #30674d;
    font-weight: 700;
}
.shop-bc a {
    color: #30674d;
}
.shop-bc span {
    color: #30674d;
}

@media (max-width: 767px) {
    .product-grid { gap: 12px; }
    .price-sale { font-size: 10px; font-weight: 800; color: var(--txt); }
    .price-orig { font-size: 10px; font-weight: 500; color: var(--mut); text-decoration: line-through; }
    .mob-filter-btn {
        display: none; align-items: center; gap: 8px; background: var(--green); color: #fff;
        border: none; border-radius: 9px; padding: 6px 16px;
        font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; height: 36px;
    }
    .mob-drawer-close { padding: 10px !important; }
    a.apply-filter { margin-top: 18px; }
    .shop-layout { margin: 24px auto; }
    .shop-title { font-family: 'Syne', sans-serif; font-size: 17px; color: #fff; font-weight: 700; }
    .dfdfsss { width: 100%; justify-content: space-between !important; }
	.shop-title {
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    color: #fff;
    font-weight: 700;
}
.shop-bc a {
    color: #30674d;
}
.shop-header {
    background: #1a5c2e1f!important;
}
.shop-title {
    color: #30674d;
}
.mob-filter-btn {
    display: flex !important;
    width: 31%;
}
.sort-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    color: var(--mut);
    width: 62%;
}
.product-grid {
    grid-template-columns: repeat(2, 1fr)!important;
}
.shop-layout {
    padding-inline: 15px!important;
}
}

.disc-badge sale { 
      display:none;
}
</style>

{{-- Mobile Overlay --}}
<div class="mob-overlay" id="mobOverlay" onclick="closeDrawer()"></div>

{{-- Shop Header --}}
<div class="shop-header">
    <div class="shop-header-inner">
        <div class="shop-title">
            <i class="fas fa-store" style="margin-right:10px;opacity:.8;"></i>
            @if(isset($currentCategory)) {{ $currentCategory->name }}
            @elseif(isset($currentTag)) # {{ $currentTag->name }}
            @else All Products
            @endif
        </div>
        <div class="shop-bc">
            <a href="{{ route('home') }}">Home</a>
            <span>›</span>
            <a href="{{ route('shop') }}">Shop</a>
            @if(isset($currentCategory))
                <span>›</span><span class="shop-bc-cur">{{ $currentCategory->name }}</span>
            @elseif(isset($currentTag))
                <span>›</span><span class="shop-bc-cur">{{ $currentTag->name }}</span>
            @endif
        </div>
    </div>
</div>

{{-- Main Layout --}}
<div class="shop-layout">

    {{-- LEFT SIDEBAR --}}
    <aside class="sidebar" id="filterSidebar">
        <div class="sidebar-head">
            <span class="sidebar-head-title"><i class="fas fa-sliders-h"></i> Filters</span>
            <a href="{{ route('shop') }}" class="clear-all"><i class="fas fa-times" style="margin-right:3px;"></i>Clear All</a>
            <button class="mob-drawer-close" onclick="closeDrawer()"><i class="fas fa-times"></i></button>
        </div>

        {{-- CATEGORIES --}}
       

	   <div class="filter-sec">
            <button class="filter-toggle open" onclick="toggleSec(this)">
                CATEGORIES <span class="arrow"><i class="fas fa-chevron-down"></i></span>
            </button>
            <div class="filter-body">
                <a href="{{ route('shop') }}"
                   class="cat-main {{ !isset($currentCategory) && !isset($currentTag) ? 'active' : '' }}">
                    All Products <span class="cat-count">{{ $totalProducts }}</span>
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('shop') }}?category={{ $cat->slug }}"
                   class="cat-main {{ (isset($currentCategory) && $currentCategory->id == $cat->id) ? 'active' : '' }}">
                    {{ $cat->name }} <span class="cat-count">{{ $cat->products_count ?? 0 }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- TAGS --}}
        @if($tags->count() > 0)
       <!-- <div class="filter-sec">
            <button class="filter-toggle" onclick="toggleSec(this)">
                TAGS <span class="arrow"><i class="fas fa-chevron-down"></i></span>
            </button>
            <div class="filter-body hidden">
                @foreach($tags as $tag)
                <label class="chk-item">
                    <input type="checkbox"
                           {{ (isset($currentTag) && $currentTag->id == $tag->id) ? 'checked' : '' }}
                           onchange="applyTag('{{ $tag->slug }}', this)">
                    <span class="custom-chk"></span>
                    <span class="chk-label">{{ $tag->name }}</span>
                    <span class="chk-cnt">{{ $tag->products_count ?? 0 }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endif
		
		-->

        {{-- PRICE --}}
        <!--  <div class="filter-sec">
            <button class="filter-toggle" onclick="toggleSec(this)">
                PRICE <span class="arrow"><i class="fas fa-chevron-down"></i></span>
            </button>
            <div class="filter-body hidden">
                <div class="price-inputs">
                    <input type="number" class="price-inp" id="minPrice" placeholder="₹ Min" value="{{ request('min_price') }}" min="0">
                    <span class="price-sep">—</span>
                    <input type="number" class="price-inp" id="maxPrice" placeholder="₹ Max" value="{{ request('max_price') }}" min="0">
                    <button class="price-go" onclick="applyPriceFilter()">Go</button>
                </div>
            </div>
        </div>
		-->

        {{-- AVAILABILITY --}}
    <!--     <div class="filter-sec">
            <button class="filter-toggle" onclick="toggleSec(this)">
                AVAILABILITY <span class="arrow"><i class="fas fa-chevron-down"></i></span>
            </button>
            <div class="filter-body hidden">
                <div class="avail-row">
                    <span class="avail-label">In Stock Only</span>
                    <label class="toggle-switch">
                        <input type="checkbox" id="inStockOnly" {{ request('in_stock') ? 'checked' : '' }} onchange="applyStockFilter(this)">
                        <span class="toggle-track"></span><span class="toggle-thumb"></span>
                    </label>
                </div>
                <div class="avail-row">
                    <span class="avail-label">On Sale</span>
                    <label class="toggle-switch">
                        <input type="checkbox" id="onSale" {{ request('on_sale') ? 'checked' : '' }} onchange="applySaleFilter(this)">
                        <span class="toggle-track"></span><span class="toggle-thumb"></span>
                    </label>
                </div>
            </div>
        </div>
		
		-->

        <a href="{{ route('shop') }}" class="apply-filter">
            <i class="fas fa-check" style="margin-right:7px;"></i>Apply Filters
        </a>
    </aside>

    {{-- RIGHT PRODUCTS --}}
    <div class="main-content">

        {{-- Top Bar --}}
        <div class="top-bar">
            <div class="result-info">
                Showing <strong>{{ $products->count() }}</strong> of
                <strong>{{ $products->total() }}</strong> products
                @if(isset($currentCategory)) in <strong>{{ $currentCategory->name }}</strong> @endif
            </div>
            <div class="dfdfsss" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <button class="mob-filter-btn" onclick="openDrawer()">
                    <i class="fas fa-sliders-h"></i> Filters
                </button>
                <div class="sort-wrap">
                    <span>Sort By :</span>
                    <select class="sort-select" onchange="applySort(this.value)">
                        <option value="latest"     {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>Latest</option>
                        <option value="oldest"     {{ request('sort') === 'oldest'     ? 'selected' : '' }}>Oldest</option>
                        <option value="price_low"  {{ request('sort') === 'price_low'  ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc"   {{ request('sort') === 'name_asc'   ? 'selected' : '' }}>Name: A–Z</option>
                        <option value="featured"   {{ request('sort') === 'featured'   ? 'selected' : '' }}>Featured First</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Active Filter Chips --}}
        @if(request()->hasAny(['category','tag','min_price','max_price','in_stock','on_sale','sort']))
        <div class="active-filters">
            @if(request('category'))
                <a href="{{ route('shop') }}" class="af-chip">
                    <i class="fas fa-tag" style="font-size:10px;"></i>
                    {{ $currentCategory->name ?? request('category') }}<span class="rm">×</span>
                </a>
            @endif
            @if(request('tag'))
                <a href="{{ route('shop') }}" class="af-chip">
                    # {{ $currentTag->name ?? request('tag') }}<span class="rm">×</span>
                </a>
            @endif
            @if(request('min_price') || request('max_price'))
                <a href="{{ route('shop') }}" class="af-chip">
                    Price: ₹{{ request('min_price',0) }} – ₹{{ request('max_price','∞') }}<span class="rm">×</span>
                </a>
            @endif
            @if(request('in_stock'))
                <a href="{{ route('shop') }}" class="af-chip">In Stock Only <span class="rm">×</span></a>
            @endif
            @if(request('on_sale'))
                <a href="{{ route('shop') }}" class="af-chip">On Sale <span class="rm">×</span></a>
            @endif
        </div>
        @endif

        {{-- ══════════════════════════════════════
             PRODUCT GRID
             ══════════════════════════════════════ --}}
        <div class="product-grid">
            @forelse($products as $product)
            @php
                $hasVariants = $product->variants && $product->variants->count() > 0;

                // Default: product level prices
                $effPrice  = $product->sale_price ?: $product->price;
                $origPrice = $product->sale_price ? $product->price : null;

                // Agar variants hain to pehle variant ki price dikhao by default
                if ($hasVariants) {
                    $firstV    = $product->variants->first();
                    $effPrice  = $firstV->price ?? $effPrice;
                    $origPrice = ($firstV->compare_price && $firstV->compare_price > 0)
                                 ? $firstV->compare_price : null;
                }

                $discPct    = ($origPrice && $origPrice > 0 && $effPrice)
                              ? round((($origPrice - $effPrice) / $origPrice) * 100) : 0;
                $inStock    = $product->stock_quantity > 0;
                $featuredImg = $product->featured_image
                              ? asset('uploads/products/'.$product->featured_image) : null;
                $catName    = $product->categories->first()->name ?? '';
            @endphp

            <a class="prod-card" href="{{ route('product.detail', $product->slug) }}">

                {{-- Discount / Featured Badge --}}
                @if($discPct >= 1)
                    <span class="disc-badge sale" id="badge-{{ $product->id }}">{{ $discPct }}% OFF</span>
                @elseif($product->is_featured)
                    <span class="disc-badge" id="badge-{{ $product->id }}">⭐ Featured</span>
                @else
                    <span class="disc-badge sale" id="badge-{{ $product->id }}" style="display:none;"></span>
                @endif

                {{-- Image --}}
                <div class="card-img-wrap">
                    @if($featuredImg)
                        <img src="{{ $featuredImg }}" alt="{{ $product->featured_image_alt ?: $product->title }}" loading="lazy">
                    @else
                        <div class="no-img-ph"><i class="fas fa-image"></i></div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="card-title">{{ $product->title }}</div>

                    @if($catName)
                    <div class="card-brand">{{ $catName }}</div>
                    @endif
                    
					@if($product->overview)
					<p class="card-overview">{{ Str::limit($product->overview, 70, '...') }}</p>
					@endif
					
					
                    {{-- Price Row — IDs zaruri hain JS update ke liye --}}
                    <div class="card-price-row">
                        @if($effPrice)
                            <span class="price-sale" id="price-sale-{{ $product->id }}">
                                ₹{{ number_format($effPrice, 0) }}
                            </span>
                            <span class="price-orig" id="price-orig-{{ $product->id }}"
                                  @if(!$origPrice) style="display:none;" @endif>
                                @if($origPrice) ₹{{ number_format($origPrice, 0) }} @endif
                            </span>
                            <span class="price-save" id="price-save-{{ $product->id }}"
                                  @if(!$origPrice) style="display:none;" @endif>
                                @if($origPrice) Save ₹{{ number_format($origPrice - $effPrice, 0) }} @endif
                            </span>
                        @else
                            <span class="price-na" id="price-sale-{{ $product->id }}">Price on request</span>
                            <span class="price-orig" id="price-orig-{{ $product->id }}" style="display:none;"></span>
                            <span class="price-save" id="price-save-{{ $product->id }}" style="display:none;"></span>
                        @endif
                    </div>

                    <div class="stock-tag {{ $inStock ? 'in' : 'out' }}">
                        <span class="stock-dot"></span>
                        {{ $inStock ? 'In Stock' : 'Out of Stock' }}
                    </div>

                    {{-- Variant Size Selector --}}
                    @if($hasVariants)
                    <div class="card-size-row" onclick="event.stopPropagation(); event.preventDefault();">
                        <label>Size</label>
                        <select class="card-size-sel"
                                onclick="event.stopPropagation(); event.preventDefault();"
                                onchange="onVariantChange(event, {{ $product->id }})">
                            @foreach($product->variants as $v)
                            <option
                                value="{{ $v->name }}"
                                data-price="{{ $v->price ?? '' }}"
                                data-compare="{{ $v->compare_price ?? '' }}"
                                data-stock="{{ $v->stock_quantity ?? 0 }}">
                                {{ $v->name }}
                              <!--  @if($v->price) — ₹{{ number_format($v->price, 0) }} @endif -->
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                </div>
            </a>
            @empty
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No products found</h3>
                <p>Try adjusting your filters or search terms.</p>
                <a href="{{ route('shop') }}">View All Products</a>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->lastPage() > 1)
        <div class="pagination-wrap">
            @if($products->currentPage() > 1)
                <a href="{{ $products->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="pag-btn">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @else
                <span class="pag-btn disabled"><i class="fas fa-chevron-left"></i></span>
            @endif

            @for($i = 1; $i <= $products->lastPage(); $i++)
                @if($i === 1 || $i === $products->lastPage() || abs($i - $products->currentPage()) <= 2)
                    <a href="{{ $products->url($i) }}&{{ http_build_query(request()->except('page')) }}"
                       class="pag-btn {{ $i === $products->currentPage() ? 'on' : '' }}">{{ $i }}</a>
                @elseif(abs($i - $products->currentPage()) === 3)
                    <span class="pag-btn dots">…</span>
                @endif
            @endfor

            @if($products->currentPage() < $products->lastPage())
                <a href="{{ $products->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="pag-btn">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="pag-btn disabled"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
        @endif

    </div>{{-- end main-content --}}
</div>{{-- end shop-layout --}}

<script>
/* ════════════════════════════════════════════════
   VARIANT PRICE + COMPARE PRICE UPDATE ON SIZE CHANGE
   Jab user size dropdown se koi variant select kare,
   grid card mein price aur compare price update ho jata hai
   ════════════════════════════════════════════════ */
function onVariantChange(e, productId) {
    e.stopPropagation();
    e.preventDefault();

    const opt     = e.target.options[e.target.selectedIndex];
    const price   = parseFloat(opt.getAttribute('data-price'))   || 0;
    const compare = parseFloat(opt.getAttribute('data-compare')) || 0;

    const saleEl  = document.getElementById('price-sale-' + productId);
    const origEl  = document.getElementById('price-orig-' + productId);
    const saveEl  = document.getElementById('price-save-' + productId);
    const badgeEl = document.getElementById('badge-'      + productId);

    if (!saleEl) return;

    // ── Sale/Current Price ──
    if (price > 0) {
        saleEl.textContent = '₹' + Math.round(price).toLocaleString('en-IN');
        saleEl.className   = 'price-sale';
    } else {
        saleEl.textContent = 'Price on request';
        saleEl.className   = 'price-na';
    }

    // ── Compare Price (MRP / Original) ──
    if (compare > 0 && price > 0) {
        const saved   = compare - price;
        const discPct = Math.round((saved / compare) * 100);

        // Show strikethrough original price
        if (origEl) {
            origEl.textContent   = '₹' + Math.round(compare).toLocaleString('en-IN');
            origEl.style.display = '';
        }

        // Show save amount
        if (saveEl) {
            saveEl.textContent   = 'Save ₹' + Math.round(saved).toLocaleString('en-IN');
            saveEl.style.display = '';
        }

        // Update discount badge
        if (badgeEl) {
            badgeEl.textContent   = discPct + '% OFF';
            badgeEl.className     = 'disc-badge sale';
            badgeEl.style.display = '';
        }

    } else {
        // No compare price — hide orig & save
        if (origEl) { origEl.textContent = ''; origEl.style.display = 'none'; }
        if (saveEl) { saveEl.textContent = ''; saveEl.style.display = 'none'; }

        // Hide discount badge only if it was showing OFF
        if (badgeEl && badgeEl.textContent.includes('OFF')) {
            badgeEl.style.display = 'none';
            badgeEl.textContent   = '';
        }
    }
}

/* ════════════════════════════════════════════════
   FILTER FUNCTIONS
   ════════════════════════════════════════════════ */
function toggleSec(btn) {
    const body = btn.nextElementSibling;
    btn.classList.toggle('open');
    body.classList.toggle('hidden');
}

function openDrawer() {
    document.getElementById('filterSidebar').classList.add('mob-open');
    document.getElementById('mobOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeDrawer() {
    document.getElementById('filterSidebar').classList.remove('mob-open');
    document.getElementById('mobOverlay').classList.remove('show');
    document.body.style.overflow = '';
}

function applySort(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', val);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function applyTag(slug, el) {
    const url = new URL(window.location.href);
    if (el.checked) url.searchParams.set('tag', slug);
    else url.searchParams.delete('tag');
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function applyPriceFilter() {
    const min = document.getElementById('minPrice').value;
    const max = document.getElementById('maxPrice').value;
    const url = new URL(window.location.href);
    if (min) url.searchParams.set('min_price', min);
    else url.searchParams.delete('min_price');
    if (max) url.searchParams.set('max_price', max);
    else url.searchParams.delete('max_price');
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function applyStockFilter(el) {
    const url = new URL(window.location.href);
    if (el.checked) url.searchParams.set('in_stock', '1');
    else url.searchParams.delete('in_stock');
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function applySaleFilter(el) {
    const url = new URL(window.location.href);
    if (el.checked) url.searchParams.set('on_sale', '1');
    else url.searchParams.delete('on_sale');
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

['minPrice', 'maxPrice'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('keydown', e => { if (e.key === 'Enter') applyPriceFilter(); });
});

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });






/* ══════════════════════════════════════════════════════
   STICKY SIDEBAR — JS BASED (same as product-detail.blade.php)
   
   Kaise kaam karta hai:
   - Scroll pe sidebar ka translateY calculate hota hai
   - Jab tak main-content chal raha hai, sidebar sticky rehta hai
   - Jab main-content khatam ho, sidebar ruk jaata hai
══════════════════════════════════════════════════════ */
(function () {
    var HEADER_H = 20;   // ✏️ Apne fixed header ki height yahan likhо (px mein)
    var TOP_GAP  = 2;   // Sidebar aur header ke beech gap

    var sidebar     = document.getElementById('filterSidebar');
    var mainContent = document.querySelector('.main-content');
    var shopLayout  = document.querySelector('.shop-layout');

    if (!sidebar || !mainContent || !shopLayout) return;

    var ticking = false;

    function update() {
        ticking = false;

        // Mobile / tablet pe JS sticky nahi — CSS drawer handle karega
        if (window.innerWidth <= 900) {
            sidebar.style.transform = 'translateY(0)';
            sidebar.style.position  = '';
            return;
        }

        var OFFSET      = HEADER_H + TOP_GAP;
        var layoutTop   = shopLayout.getBoundingClientRect().top;
        var sidebarH    = sidebar.offsetHeight;
        var mainH       = mainContent.offsetHeight;

        // Sidebar kitna neeche ja sakta hai maximum (main-content height - sidebar height)
        var maxMove = Math.max(0, mainH - sidebarH);

        var move = 0;

        if (layoutTop < OFFSET) {
            move = OFFSET - layoutTop;
            move = Math.min(move, maxMove);
            move = Math.max(move, 0);
        }

        sidebar.style.transform = 'translateY(' + move + 'px)';
    }

    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(update);
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', update,   { passive: true });
    document.addEventListener('DOMContentLoaded', update);
    update();
})();
</script>


<style>
.card-overview {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.4;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prod-card:hover .card-overview {
    color: #4b5563;
}

@media(max-width: 767px) {
    .card-overview {
        font-size: 11px;
        -webkit-line-clamp: 1;
        margin-bottom: 6px;
    }
}
</style>


@endsection
