{{--
    File: resources/views/frontend/components/product-section.blade.php
    Usage in any blade file:
        {!! render_product_section(1) !!}
--}}
@if(isset($section) && $section->is_active && isset($products) && count($products) > 0)

<style>
/* ─── PRODUCT SECTION COMPONENT ─── */
.ps-wrap {
    padding: 42px 0 50px;
    background: #f0f4f0;
}
.ps-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.ps-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 26px;
}
.ps-header-left h2 {
    font-size: 24px !important;
    font-weight: 500 !important;
    color: #222;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.ps-header-left p {
    font-size: 13.5px;
    color: #6b7280;
    margin: 0;
}
.ps-view-all {
    font-size: 13.5px;
    font-weight: 700;
    color: #374151;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    transition: color .2s;
}
.ps-view-all:hover { color: #1a5c2e; }
.ps-view-all svg { transition: transform .2s; }
.ps-view-all:hover svg { transform: translateX(3px); }

/* Scrollable Grid */
.ps-grid {
    display: flex;
    gap: 14px;
    overflow-x: auto;
    padding-bottom: 8px;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: #d1d5db #f3f4f6;
}
.ps-grid::-webkit-scrollbar { height: 5px; }
.ps-grid::-webkit-scrollbar-track { background: #f3f4f6; border-radius: 3px; }
.ps-grid::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }

/* ── Product Card ── */
.ps-card {
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
    scroll-snap-align: start;
    flex-shrink: 0;
    width: 19% !important;
    cursor: pointer;
}
.ps-card:hover {
    border-color: #1a5c2e;
    box-shadow: 0 8px 28px rgba(26,92,46,.18);
    transform: translateY(1px);
}

/* Discount / Featured Badge */
.ps-badge {
    position: absolute;
    top: 9px; left: 9px;
    font-size: 10px; font-weight: 800;
    padding: 3px 9px; border-radius: 6px;
    z-index: 2; text-transform: uppercase; letter-spacing: .04em;
}
.ps-badge.off  { background: #f97316; color: #fff; }
.ps-badge.feat { background: #f59e0b; color: #fff; }
.ps-badge.hidden-badge { display: none; }

/* Image */
.ps-img {
    aspect-ratio: 1;
    background: #f9fafb;
    display: flex; align-items: center; justify-content: center;
    padding: 16px; overflow: hidden;
}
.ps-img img {
    max-width: 100%; max-height: 100%;
    object-fit: contain;
    transition: transform .35s ease;
}
.ps-card:hover .ps-img img { transform: scale(1.08); }
.ps-img-placeholder { font-size: 40px; color: #d1d5db; }

/* Body */
.ps-body {
    padding: 12px 14px 14px;
    flex: 1;
    display: flex;
    flex-direction: column;
    position: relative;
}

/* Title */
.ps-title {
    font-size: 13px; font-weight: 700; color: #1c1c1c;
    line-height: 1.4; margin-bottom: 3px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
    flex-shrink: 0;
}
.ps-card:hover .ps-title { color: #1a5c2e; }

/* Brand */
.ps-brand {
    font-size: 11.5px;
    color: #6b7280;
    margin-bottom: 9px;
    height: 18px;
    overflow: hidden;
    white-space: nowrap;
}

/* Size dropdown */
.ps-size-row {
    display: flex; align-items: center; gap: 6px;
    margin-bottom: 8px; font-size: 11.5px;
}
.ps-size-label { font-weight: 700; color: #6b7280; flex-shrink: 0; }
select.ps-size-sel {
    flex: 1;
    height: 33px;
    padding: 4px 8px;
    border: 1.5px solid #e5e7eb; border-radius: 6px;
    font-size: 11px; outline: none; color: #1c1c1c; cursor: pointer;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='5'%3E%3Cpath d='M0 0l4 5 4-5z' fill='%236b7280'/%3E%3C/svg%3E") no-repeat right 6px center;
    appearance: none;
    margin-bottom: 0;
    position: relative;
    z-index: 10;
}
select.ps-size-sel:focus { border-color: #1a5c2e; }

/* Price row */
.ps-price-row {
    display: flex;
    align-items: baseline;
    flex-wrap: nowrap;
    gap: 5px;
    margin-bottom: 5px;
    min-height: 20px;
}
.ps-price {
    font-size: 12px;
    font-weight: 800;
    color: #1c1c1c;
}
.ps-orig  { font-size: 12px; color: #9ca3af; text-decoration: line-through; }
.ps-save  {
    font-size: 9px; font-weight: 700; color: #1a5c2e;
    background: #e8f5ec; padding: 2px 7px; border-radius: 8px;
    display: flex; align-items: center; gap: 3px;
}
.ps-price-na { font-size: 12.5px; color: #9ca3af; font-style: italic; }

/* Stock */
.ps-stock {
    font-size: 10.5px; font-weight: 700;
    padding: 2px 8px; border-radius: 5px;
    display: none;
    align-items: center; gap: 4px;
    margin-bottom: 10px; align-self: flex-start;
}
.ps-stock.out { display: inline-flex; background: #fee2e2; color: #dc2626; }
.ps-sdot { width: 5px; height: 5px; border-radius: 50%; }
.ps-stock.in .ps-sdot  { background: #10b981; }
.ps-stock.out .ps-sdot { background: #dc2626; }

@media(max-width: 767px) {
    .ps-header {
        flex-direction: row !important;
        align-items: center !important;
        gap: 10px;
        padding-right: 20px;
        margin-bottom: 14px;
    }
    .ps-header h2 { font-size: 18px !important; }
    .ps-card { width: 250px !important; }
    .ps-title { font-size: 12px; }
    .ps-price { font-size: 15px; }
    .ps-inner { padding-right: 0; }
    .ps-brand {
        margin-bottom: 3px !important;
        margin-top: -3px;
    }
    .ps-grid {
        padding-bottom: 20px;
        padding-right: 20px;
    }
    .ps-wrap {
        padding-bottom: 29px !important;
    }
}
.ps-price-row {
	display:none !important;
}
.ps-badge {
    display: none !important;
}
</style>

<div class="ps-wrap">
    <div class="ps-inner">

        {{-- Header --}}
        <div class="ps-header">
            <div class="ps-header-left">
                <h2>{{ $section->heading }}</h2>
                @if($section->sub_heading)
                    <p>{{ $section->sub_heading }}</p>
                @endif
            </div>
            @if($section->view_all_url)
            <a href="{{ $section->view_all_url }}" class="ps-view-all">
                {{ $section->view_all_text ?: 'View All' }}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            @endif
        </div>

        {{-- Product Cards Grid --}}
        <div class="ps-grid">
            @foreach($products as $p)
            @php
                $hasVar    = $p->variants && $p->variants->count() > 0;
                $effPrice  = $p->sale_price ?: $p->price;
                $origPrice = $p->sale_price ? $p->price : null;

                // Pehle variant ki price default mein dikhao
                if ($hasVar) {
                    $firstV    = $p->variants->first();
                    $effPrice  = $firstV->price ?? $effPrice;
                    $origPrice = ($firstV->compare_price && $firstV->compare_price > 0)
                                 ? $firstV->compare_price : null;
                }

                $discPct   = ($origPrice && $origPrice > 0 && $effPrice)
                             ? round((($origPrice - $effPrice) / $origPrice) * 100) : 0;
                $inStock   = $p->stock_quantity > 0;
                $imgSrc    = $p->featured_image
                             ? asset('uploads/products/' . $p->featured_image) : null;
                $brand     = $p->categories->first()->name ?? '';
                $detailUrl = route('product.detail', $p->slug);
            @endphp

            <div class="ps-card" onclick="window.location.href='{{ $detailUrl }}'">

                {{-- Badge --}}
                @if($discPct >= 1)
                    <span class="ps-badge off" id="ps-badge-{{ $p->id }}">{{ $discPct }}% OFF</span>
                @elseif($p->is_featured)
                    <span class="ps-badge feat" id="ps-badge-{{ $p->id }}">⭐ Featured</span>
                @else
                    <span class="ps-badge off hidden-badge" id="ps-badge-{{ $p->id }}"></span>
                @endif

                {{-- Image --}}
                <div class="ps-img">
                    @if($imgSrc)
                        <img src="{{ $imgSrc }}" alt="{{ $p->featured_image_alt ?: $p->title }}" loading="lazy">
                    @else
                        <div class="ps-img-placeholder">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Body --}}
                <div class="ps-body">

                    {{-- Title --}}
                    <div class="ps-title">{{ $p->title }}</div>

                    {{-- Brand --}}
                    @if($brand)
                        <div class="ps-brand">{{ $brand }}</div>
                    @endif

                    {{-- Price Row — IDs for JS update --}}
                    <div class="ps-price-row">
                        @if($effPrice)
                            <span class="ps-price" id="ps-price-{{ $p->id }}">
                                ₹{{ number_format($effPrice, 0) }}
                            </span>
                            <span class="ps-orig" id="ps-orig-{{ $p->id }}"
                                  @if(!$origPrice) style="display:none;" @endif>
                                @if($origPrice) ₹{{ number_format($origPrice, 0) }} @endif
                            </span>
                            <span class="ps-save" id="ps-save-{{ $p->id }}"
                                  @if(!$origPrice) style="display:none;" @endif>
                                @if($origPrice)
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Save ₹{{ number_format($origPrice - $effPrice, 0) }}
                                @endif
                            </span>
                        @else
                            <span class="ps-price-na" id="ps-price-{{ $p->id }}">Price on request</span>
                            <span class="ps-orig" id="ps-orig-{{ $p->id }}" style="display:none;"></span>
                            <span class="ps-save" id="ps-save-{{ $p->id }}" style="display:none;"></span>
                        @endif
                    </div>

                    {{-- Stock --}}
                    <div class="ps-stock {{ $inStock ? 'in' : 'out' }}">
                        <span class="ps-sdot"></span>
                        {{ $inStock ? 'In Stock' : 'Out of Stock' }}
                    </div>

                    {{-- Variant Size Selector --}}
                    @if($hasVar)
                    <div class="ps-size-row"
                        onclick="event.stopPropagation();"
                        onmousedown="event.stopPropagation();">
                        <span class="ps-size-label">Size</span>
                        <select class="ps-size-sel"
                            onclick="event.stopPropagation();"
                            onmousedown="event.stopPropagation();"
                            onfocus="event.stopPropagation();"
                            onchange="psVariantChange(event, {{ $p->id }}); event.stopPropagation();">
                            @foreach($p->variants as $v)
                                <option
                                    value="{{ $v->name }}"
                                    data-price="{{ $v->price ?? '' }}"
                                    data-compare="{{ $v->compare_price ?? '' }}"
                                    data-stock="{{ $v->stock_quantity ?? 0 }}">
                                    {{ $v->name }}
                                 <!---   @if($v->price) — ₹{{ number_format($v->price, 0) }} @endif -->
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

<script>
/* ════════════════════════════════════════════
   PRODUCT SECTION — VARIANT PRICE UPDATE
   Jab size dropdown change ho, price + compare
   price card mein live update ho jata hai
   ════════════════════════════════════════════ */
function psVariantChange(e, productId) {
    e.stopPropagation();
    e.preventDefault();

    const opt     = e.target.options[e.target.selectedIndex];
    const price   = parseFloat(opt.getAttribute('data-price'))   || 0;
    const compare = parseFloat(opt.getAttribute('data-compare')) || 0;

    const priceEl = document.getElementById('ps-price-'  + productId);
    const origEl  = document.getElementById('ps-orig-'   + productId);
    const saveEl  = document.getElementById('ps-save-'   + productId);
    const badgeEl = document.getElementById('ps-badge-'  + productId);

    if (!priceEl) return;

    // ── Current / Sale Price ──
    if (price > 0) {
        priceEl.textContent = '₹' + Math.round(price).toLocaleString('en-IN');
        priceEl.className   = 'ps-price';
    } else {
        priceEl.textContent = 'Price on request';
        priceEl.className   = 'ps-price-na';
    }

    // ── Compare / Original Price ──
    if (compare > 0 && price > 0) {
        const saved   = compare - price;
        const discPct = Math.round((saved / compare) * 100);

        // Strikethrough original price dikhao
        if (origEl) {
            origEl.textContent   = '₹' + Math.round(compare).toLocaleString('en-IN');
            origEl.style.display = '';
        }

        // Save amount dikhao
        if (saveEl) {
            saveEl.innerHTML     = '<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Save ₹' + Math.round(saved).toLocaleString('en-IN');
            saveEl.style.display = 'flex';
        }

        // Discount badge update karo
        if (badgeEl) {
            badgeEl.textContent = discPct + '% OFF';
            badgeEl.className   = 'ps-badge off';
        }

    } else {
        // Compare price nahi hai — orig & save chhupao
        if (origEl) { origEl.textContent = ''; origEl.style.display = 'none'; }
        if (saveEl) { saveEl.innerHTML   = ''; saveEl.style.display = 'none'; }

        // Badge — agar OFF dikh raha tha to chhupao
        if (badgeEl && badgeEl.textContent.includes('OFF')) {
            badgeEl.textContent = '';
            badgeEl.className   = 'ps-badge off hidden-badge';
        }
    }
}
</script>

@endif