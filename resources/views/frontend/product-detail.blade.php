{{-- Save as: resources/views/frontend/product-detail.blade.php --}}
@extends('frontend.layouts.layout')

@section('title', $product->meta_title ?: $product->title)
@section('meta_description', $product->meta_description ?? '')
@section('meta_keywords', $product->meta_keywords ?? '')
@section('og_title', $product->og_title ?: $product->meta_title ?: $product->title)
@section('og_description', $product->og_description ?: $product->meta_description ?? '')
@section('og_image', $product->og_image
    ? asset('uploads/products/og/' . $product->og_image)
    : ($product->featured_image
        ? asset('uploads/products/' . $product->featured_image)
        : asset('public/backend/assets/images/favicon.png')))

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap');
:root{
    --p:#1a5c2e; --pl:#e8f5ec; --acc:#f59e0b; --red:#dc2626;
    --txt:#1c1c1c; --mut:#6b7280; --bdr:#e5e7eb; --bg:#f9fafb; --rad:14px;
}
*{box-sizing:border-box;}
body{font-family:'DM Sans',sans-serif;color:var(--txt);background:var(--bg);margin:0;}

/* ── Breadcrumb ── */
.bc{background:#fff;border-bottom:1px solid var(--bdr);padding:11px 0;font-size:13px;color:var(--mut);}
.bc a{color:var(--mut);text-decoration:none;}.bc a:hover{color:var(--p);}
.bc span{margin:0 5px;opacity:.5;}
.bc-inner{max-width:1240px;margin:0 auto;padding:0 20px;}

/* ── MAIN GRID ── */
.pd-grid{
    max-width:1240px;margin:0 auto;padding:36px 20px 60px;
    display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;
}
@media(max-width:980px){.pd-grid{grid-template-columns:1fr;gap:28px;padding:20px 16px 48px;}}

/* ══════════════════════════════
   LEFT — GALLERY
   position:relative rakho — JS se sticky handle hoga
   (CSS sticky parent ke overflow:hidden se break ho jata hai)
══════════════════════════════ */
.gallery{
    position: relative;
    top: 0;
    will-change: transform;
}

.slider-wrap{
    position:relative;background:#fff;
    border:1px solid var(--bdr);border-radius:var(--rad);
    overflow:hidden;aspect-ratio:1;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 4px 24px rgba(0,0,0,.07);
}
.slider-track{
    display:flex;width:100%;height:100%;
    transition:transform .4s cubic-bezier(.4,0,.2,1);
}
.slide{
    min-width:100%;height:100%;display:flex;
    align-items:center;justify-content:center;
    padding:20px;flex-shrink:0;
}

.slide img{max-width:100%;max-height:100%;object-fit:contain;transition:transform .4s;}
.slider-wrap:hover .slide img{transform:scale(1.04);}
.arrow-btn{
    position:absolute;top:50%;transform:translateY(-50%);
    width:20px;height:20px;padding:15px;border-radius:50%;
    background:rgba(255,255,255,.92);border:1px solid var(--bdr);
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;z-index:10;font-size:16px;color:#444;
    box-shadow:0 2px 8px rgba(0,0,0,.12);transition:all .2s;
}
.arrow-btn:hover{background:var(--p);color:#fff;border-color:var(--p);}
.arrow-prev{left:12px;}.arrow-next{right:12px;}
.slide-badges{position:absolute;top:12px;left:12px;display:flex;flex-direction:column;gap:6px;z-index:5;}
.badge-tag{display:inline-block;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;letter-spacing:.04em;text-transform:uppercase;}
.badge-sale{background:var(--red);color:#fff;display:none;}
.badge-feat{background:var(--acc);color:#fff;}
/* ── THUMBNAIL CAROUSEL ── */
.thumbs-wrap{
    position:relative;margin-top:11px;
    padding:0 32px; /* Arrow space */
}
.thumbs{
    display:flex;
    gap:8px;
    overflow-x:auto;
    overflow-y:hidden;
    scroll-behavior:smooth;
    
    /* Hide scrollbar */
    -ms-overflow-style: none;
    scrollbar-width: none;
    
    /* Constrain to 5 items visible */
    width:100%;
    max-width:calc((66px + 8px) * 8);
}
.thumbs::-webkit-scrollbar {
    display: none;
}
.thumb{
    width:66px;
    height:66px;
    border:2px solid var(--bdr);
    border-radius:8px;
    overflow:hidden;
    cursor:pointer;
    background:#fff;
    flex-shrink:0;
    transition:border-color .2s,transform .15s;
}
.thumb img{width:100%;height:100%;object-fit:contain;padding:4px;}
.thumb:hover,.thumb.on{border-color:var(--p);transform:translateY(0px);}

/* Thumb carousel arrows */
.thumb-arrow{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:28px;
    height:28px;
    padding:6px;
    border-radius:50%;
    background:rgba(255,255,255,.95);
    border:1px solid var(--bdr);
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    z-index:5;
    font-size:12px;
    color:#444;
    box-shadow:0 2px 6px rgba(0,0,0,.1);
    transition:all .2s;
}
.thumb-arrow:hover:not(:disabled){background:var(--p);color:#fff;border-color:var(--p);}
.thumb-arrow:disabled{opacity:.4;cursor:not-allowed;background:rgba(255,255,255,.6);}
.thumb-arrow.prev{left:0;}
.thumb-arrow.next{right:0;}
.no-img{width:100%;aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#f3f4f6;color:#d1d5db;font-size:64px;border-radius:var(--rad);}

/* ══════════════════════════════
   RIGHT — PRODUCT INFO
══════════════════════════════ */
.prod-tab-content{color:#171717 !important ;}
.pd-title{font-size:26px;line-height:1.25;margin:0 0 12px;font-weight:600;}
@media(max-width:600px){.pd-title{font-size:20px;}}
.pd-sku{font-size:12.5px;color:var(--mut);margin-bottom:14px;}
.pd-sku b{color:var(--txt);}
.price-box{
    background:transparent;border-left:none;border-radius:0;
    padding:0;margin-bottom:16px;
    display:flex;align-items:center;flex-wrap:wrap;gap:10px;width:100%!important;
}
.price-main{font-size:16px;font-weight:700;color:var(--p);line-height:1;}
.price-orig{font-size:16px;color:var(--mut);text-decoration:line-through;}
.disc-tag{background:var(--red);color:#fff;font-size:10px;font-weight:700;padding:1px 8px;border-radius:20px;}
.price-na{font-size:17px;color:var(--mut);font-style:italic;}
.stock-pill{display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;padding:5px 13px;border-radius:20px;margin-bottom:16px;}
.stock-pill.in{background:#d1fae5;color:#065f46;display:none!important;}
.stock-pill.out{background:#fee2e2;color:#991b1b;}
.sdot{width:8px;height:8px;border-radius:50%;}
.stock-pill.in .sdot{background:#10b981;animation:pulse 1.5s infinite;}
.stock-pill.out .sdot{background:#ef4444;}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.3)}}
.overview-box{font-size:14.5px;color:#374151;line-height:1.75;margin-bottom:20px;padding:13px 16px;background:#fff;border-radius:var(--rad);border:1px solid var(--bdr);}
.divider{border:none;border-top:1px solid var(--bdr);margin:18px 0;}

/* ── Variant Cards ── */
.vg-section{margin-bottom:20px;}
.vg-section-label{font-size:12px;font-weight:700;color:var(--mut);text-transform:uppercase;letter-spacing:.07em;margin-bottom:16px;}
span#vg-label-text{font-size:14px;font-weight:800;color:black;letter-spacing:normal;}
.variant-cards{display:flex;flex-wrap:wrap;gap:12px;row-gap:21px;}
.variant-card{
    position:relative;min-width:110px;background:#fff;
    border:2px solid var(--bdr);border-radius:12px;
    padding:9px 0px;text-align:center;cursor:pointer;
    transition:all .18s;box-shadow:0 1px 4px rgba(0,0,0,.05);
    flex:1;max-width:120px;
}
.variant-card:hover{border-color:var(--p);box-shadow:0 4px 14px rgba(26,92,46,.15);}
.variant-card.on{border-color:var(--p);background:var(--pl);box-shadow:0 4px 18px rgba(26,92,46,.22);}
.vc-off{
    position:absolute;top:-10px;left:50%;transform:translateX(-50%);
    background:var(--acc);color:#fff;font-size:9.5px;font-weight:700;
    padding:2px 8px;border-radius:20px;white-space:nowrap;letter-spacing:.03em;
}
.vc-name{font-size:15px;font-weight:600;color:var(--txt);margin-bottom:3px;line-height:1.2;}
.vc-ddfdddd{display:flex;align-items:center;gap:5px;justify-content:center;}
.vc-price{font-size:14px;font-weight:700;color:var(--p);line-height:1;}
.vc-orig{font-size:12.5px;color:var(--mut);text-decoration:line-through;margin-top:0;}
.vc-stock-out{font-size:11px;color:var(--red);font-weight:600;margin-top:4px;}

/* ── CTA Buttons ── */
.cta-row{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;}
.cta-btn{flex:1;min-width:150px;padding:13px 18px;border-radius:9px;font-size:15px;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;border:none;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;transition:all .18s;}
.cta-primary{background:var(--p);color:#fff;box-shadow:0 4px 14px rgba(26,92,46,.28);}
.cta-primary:hover{background:#145224;transform:translateY(-1px);color:#fff;}
.cta-outline{background:#fff;color:var(--p);border:2px solid var(--p);}
.cta-outline:hover{background:var(--pl);transform:translateY(-1px);color:var(--p);}

/* ── Meta Table ── */
.meta-tbl{width:100%;border-collapse:collapse;margin-bottom:18px;background:#fff;border-radius:var(--rad);overflow:hidden;border:1px solid var(--bdr);font-size:13.5px;}
.meta-tbl tr{border-bottom:1px solid var(--bdr);}
.meta-tbl tr:last-child{border-bottom:none;}
.meta-tbl td{padding:10px 16px;vertical-align:middle;}
.meta-tbl td:first-child{font-weight:600;color:var(--mut);width:38%;background:#f9fafb;border-right:1px solid var(--bdr);}

/* ── Chips ── */
.chip-cat{background:var(--pl);color:var(--p);border:1px solid #b6dfc2;border-radius:20px;padding:3px 11px;font-size:12.5px;font-weight:500;text-decoration:none;}
.chip-cat:hover{background:#c8ecd4;color:var(--p);}

/* ── Description box ── */
.desc-box{background:#fff;border:1px solid var(--bdr);border-radius:var(--rad);overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.05);}
.desc-head{padding:13px 20px;background:var(--p);color:#fff;font-size:17px;font-weight:400;}
.desc-head i{margin-right:9px;opacity:.8;}
.desc-body{padding:20px 22px;font-size:14.5px;line-height:1.8;color:#374151;}
.desc-body img{max-width:100%;border-radius:8px;margin:12px 0;}
.desc-body h2,.desc-body h3{color:var(--p);}
.desc-body ul{padding-left:20px;}.desc-body ul li{margin-bottom:6px;}

/* ══════════════════════════════
   ENQUIRY POPUP MODAL
══════════════════════════════ */
.enq-overlay{
    position:fixed;inset:0;z-index:99999;
    background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);
    display:flex;align-items:center;justify-content:center;padding:20px;
    opacity:0;visibility:hidden;transition:all .3s ease;
}
.enq-overlay.open{opacity:1;visibility:visible;}
.enq-modal{
    background:#fff;border-radius:20px;width:100%;max-width:540px;
    max-height:90vh;overflow-y:auto;position:relative;
    transform:translateY(30px) scale(0.97);
    transition:transform .3s cubic-bezier(.34,1.56,.64,1);
    box-shadow:0 25px 60px rgba(0,0,0,.25);
}
.enq-overlay.open .enq-modal{transform:translateY(0) scale(1);}
.enq-header{
    background:linear-gradient(135deg,#1a5c2e 0%,#2d7a47 100%);
    padding:28px 30px 22px;border-radius:20px 20px 0 0;position:relative;
}
.enq-header-icon{width:46px;height:46px;background:rgba(255,255,255,.15);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;margin-bottom:12px;}
.enq-header h3{font-size:20px;font-weight:400;color:#fff;margin:0 0 5px;}
.enq-header p{font-size:13px;color:rgba(255,255,255,.75);margin:0;line-height:1.5;}
.enq-close{
    position:absolute;top:16px;right:16px;
    width:34px;height:34px;border-radius:50%;
    background:rgba(255,255,255,.15);border:none;color:#fff;font-size:18px;
    cursor:pointer;display:flex;align-items:center;justify-content:center;
    transition:background .2s;padding:14px!important;
}
.enq-close:hover{background:rgba(255,255,255,.3);}
.enq-product-tag{
    margin:18px 20px 0;background:#e8f5ec;border:1px solid #b6dfc2;
    border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:10px;font-size:13px;
}
.enq-product-tag i{color:#1a5c2e;flex-shrink:0;}
.enq-product-tag span{font-weight:600;color:#1a5c2e;line-height:1.3;}
.enq-body{padding:20px 28px 28px;}
.enq-form-row{display:flex;gap:14px;margin-bottom:-5px;}
.enq-form-row .enq-field{flex:1;}
.enq-field{margin-bottom:16px;}
.enq-field label{display:block;font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;}
.enq-field input,.enq-field textarea{
    width:100%;padding:9px 15px;border:1.5px solid #e5e7eb;border-radius:9px;
    font-size:14px;color:#1c1c1c;font-family:'DM Sans',sans-serif;
    background:#f9fafb;transition:all .2s;outline:none;
    height:35px;margin:0!important;
}
.enq-field input:focus,.enq-field textarea:focus{border-color:#1a5c2e;background:#fff;box-shadow:0 0 0 3px rgba(26,92,46,.1);}
.enq-field textarea{height:76px;resize:vertical;}
.enq-submit{
    width:100%;padding:14px;background:linear-gradient(135deg,#1a5c2e,#2d7a47);
    color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;
    font-family:'DM Sans',sans-serif;cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:8px;
    transition:all .2s;box-shadow:0 4px 14px rgba(26,92,46,.3);margin-top:4px;
}
.enq-submit:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(26,92,46,.4);}
.enq-success{padding:30px 28px;text-align:center;display:none;}
.enq-success-icon{width:64px;height:64px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;color:#065f46;margin:0 auto 16px;}
.enq-success h4{font-size:22px;margin:0 0 8px;color:#1c1c1c;}
.enq-success p{font-size:14px;color:#6b7280;margin:0;}
.enq-alert{padding:11px 16px;border-radius:8px;font-size:13.5px;font-weight:500;margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.enq-alert-success{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;}
.enq-alert-error{background:#fee2e2;color:#991b1b;border:1px solid #fecaca;}

@media(max-width:767px){
    .enq-form-row{flex-direction:column;gap:0;}
    .enq-body{padding:16px 18px 22px;}
    .enq-header{padding:22px 18px 18px;}
    .variant-cards{row-gap:21px;}
    .variant-card{min-width:25%;max-width:32%;}
    .vc-name{font-size:14px;}
    .vc-price{font-size:13px;}
    .vc-orig{font-size:12px;margin-top:0;}
    .divider{margin:10px 0;}
}

.sim-price-row{display:none!important;}
div#dyn-price-box{display:none!important;}
.vc-ddfdddd{display:none!important;}
.d-none-all{display:none;}
.sim-badge.sale{display:none;}
span.vc-off{display:none;}

/* ══════════════════════════════════════
   SIMILAR PRODUCTS SECTION
══════════════════════════════════════ */
.similar-section{max-width:1240px;margin:0 auto;padding:0 20px 60px;}
.similar-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;padding-bottom:14px;border-bottom:2px solid var(--bdr);}
.similar-title{font-size:24px;font-weight:400;color:var(--txt);display:flex;align-items:center;gap:10px;}
.similar-title::before{content:'';display:inline-block;width:4px;height:26px;background:var(--p);border-radius:2px;}
.similar-view-all{font-size:13px;font-weight:700;color:var(--p);text-decoration:none;display:flex;align-items:center;gap:5px;padding:7px 16px;border:1.5px solid var(--p);border-radius:8px;transition:all .2s;}
.similar-view-all:hover{background:var(--p);color:#fff;}

/* ── DESKTOP: Grid Layout ── */
.similar-grid-wrap{position:relative;}
.similar-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;}
@media(max-width:1100px){.similar-grid{grid-template-columns:repeat(4,1fr);}}

/* ── MOBILE/TABLET: Carousel Layout ── */
@media(max-width:860px){
    .similar-section{padding-right:0;}
    .similar-head{padding-right:18px;}
    .similar-grid-wrap{position:relative;overflow:hidden;padding:0 40px;}
    .similar-grid{display:flex !important;gap:14px;padding-bottom:12px;}
    .similar-grid-track{display:flex;gap:14px;width:100%;transition:transform .4s cubic-bezier(.4,0,.2,1);}
    
    /* Carousel Arrows */
    .similar-carousel-arrow{
        position:absolute;top:50%;transform:translateY(-50%);
        width:36px;height:36px;border-radius:50%;
        background:rgba(255,255,255,.92);border:1.5px solid var(--bdr);
        display:flex;align-items:center;justify-content:center;
        cursor:pointer;z-index:10;color:#444;font-size:16px;
        box-shadow:0 2px 8px rgba(0,0,0,.12);transition:all .2s;
    }
    .similar-carousel-arrow:hover{background:var(--p);color:#fff;border-color:var(--p);}
    .similar-carousel-arrow.prev{left:8px;}
    .similar-carousel-arrow.next{right:8px;}
    .similar-carousel-arrow:disabled{opacity:.4;cursor:not-allowed;}
    .similar-carousel-arrow:disabled:hover{background:rgba(255,255,255,.92);color:#444;border-color:var(--bdr);}
	

}

{ custom mobile css } 
 
 
@media (max-width: 767px) {
  .thumbs-wrap {
    position: relative;
    margin-top: 11px;
    padding: 0 16px;
    width: 100%;
    box-sizing: border-box;
  }

  #pdGallery {
    width: 100%;
    max-width: 410px;
    margin: 0 auto;
  }

  .pd-grid {
    max-width: 410px;
    margin: 0 auto;
    padding: 24px 16px 40px;
    display: flex;
    flex-direction: column;
    gap: 24px;
    align-items: stretch;
  }
  .slide img{max-width:100%;max-height:100%;object-fit:contain;transition:transform .4s;}

}

.sim-card{background:#fff;border-radius:12px;border:1.5px solid var(--bdr);overflow:hidden;transition:all .22s;position:relative;box-shadow:0 2px 12px rgba(0,0,0,.08);display:flex;flex-direction:column;text-decoration:none;color:inherit;}
@media(max-width:860px){
    .sim-card{width:250px;flex-shrink:0;}
}
.sim-card:hover{border-color:var(--p);box-shadow:0 8px 28px rgba(26,92,46,.15);transform:translateY(-3px);}
.sim-badge{position:absolute;top:9px;left:9px;font-size:10px;font-weight:800;padding:2px 8px;border-radius:6px;z-index:2;letter-spacing:.03em;text-transform:uppercase;}
.sim-badge.sale{background:#dc2626;color:#fff;}
.sim-badge.feat{background:#f59e0b;color:#fff;}
.sim-img-wrap{aspect-ratio:1;background:#f9fafb;display:flex;align-items:center;justify-content:center;padding:14px;overflow:hidden;text-decoration:none;color:inherit;}
.sim-img-wrap img{max-width:100%;max-height:100%;object-fit:contain;transition:transform .35s;}
.sim-card:hover .sim-img-wrap img{transform:scale(1.07);}
.sim-no-img{font-size:32px;color:#d1d5db;}
.sim-body{padding:11px 13px;flex:1;display:flex;flex-direction:column;}
.sim-title{font-size:13px;font-weight:700;color:var(--txt);line-height:1.4;margin-bottom:4px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;flex:1;text-decoration:none;}
.sim-title:hover{color:var(--p);}
.sim-brand{font-size:11px;color:var(--mut);margin-bottom:2px;}
.sim-size-row{display:flex;align-items:center;gap:5px;margin-bottom:7px;font-size:11px;}
.sim-size-row label{font-weight:700;color:var(--mut);}
select.sim-size-sel{
    flex:1;height:33px;padding:3px 6px;
    border:1.5px solid var(--bdr);border-radius:5px;
    font-size:11px;outline:none;color:var(--txt);cursor:pointer;
    background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='5'%3E%3Cpath d='M0 0l4 5 4-5z' fill='%236b7280'/%3E%3C/svg%3E") no-repeat right 5px center;
    appearance:none;margin-bottom:0;
}
select.sim-size-sel:focus{border-color:var(--p);}
.sim-price-row{display:flex;align-items:baseline;flex-wrap:wrap;gap:4px;margin-bottom:6px;min-height:20px;}
.sim-price{font-size:12px;font-weight:800;color:var(--txt);}
.sim-orig{font-size:11.5px;color:var(--mut);text-decoration:line-through;}
.sim-save{font-size:9px;font-weight:700;color:var(--p);background:var(--pl);padding:1px 6px;border-radius:8px;}
.sim-price-na{font-size:12px;color:var(--mut);font-style:italic;}
.sim-stock{font-size:10.5px;font-weight:700;padding:2px 7px;border-radius:4px;display:inline-flex;align-items:center;gap:3px;margin-bottom:8px;}
.sim-stock.in{background:#d1fae5;color:#065f46;display:none;}
.sim-stock.out{background:#fee2e2;color:#dc2626;}
.sim-dot{width:5px;height:5px;border-radius:50%;}
.sim-stock.in .sim-dot{background:#10b981;}
.sim-stock.out .sim-dot{background:#dc2626;}
a.sim-btn{display:none;}
.prod-tab-content {
    color: #171717 !important;
}
</style>

{{-- Breadcrumb --}}
<div class="bc">
    <div class="bc-inner">
        <a href="{{ route('home') }}">Home</a><span>›</span>
        <a href="{{ route('shop') }}">Shop</a>
        @if($product->categories->count()>0)
            <span>›</span><a href="#">{{ $product->categories->first()->name }}</a>
        @endif
        <span>›</span>
        <span style="color:#1c1c1c;">{{ Str::limit($product->title,50) }}</span>
    </div>
</div>

{{-- ═══════ MAIN 2-COL GRID ═══════ --}}
<div class="pd-grid" id="pdGrid">

    {{-- ===== LEFT: IMAGE SLIDER ===== --}}
    <div class="ede gallery" id="pdGallery">
        @php
    $imgs = collect();
    if($product->featured_image)
        $imgs->push([
            'src'  => asset('uploads/products/'.$product->featured_image),
            'alt'  => $product->featured_image_alt ?: $product->title,
            'type' => 'image'
        ]);
    foreach($product->images as $gi)
        $imgs->push([
            'src'  => asset('uploads/products/gallery/'.$gi->image),
            'alt'  => $gi->alt_tag ?: $product->title,
            'type' => $gi->type ?? 'image'
        ]);
@endphp

        @if($imgs->count() > 0)
        <div class="slider-wrap" id="slider-wrap">
            <div class="slide-badges">
                @if($product->is_featured)<span class="badge-tag badge-feat">⭐ Featured</span>@endif
                @if($product->sale_price && $product->price)
                    <span class="badge-tag badge-sale">{{ round((($product->price-$product->sale_price)/$product->price)*100) }}% OFF</span>
                @endif
            </div>

            @if($imgs->count() > 1)
            <button class="arrow-btn arrow-prev" onclick="slidePrev()" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            @endif

            <div class="slider-track" id="slider-track">
                @foreach($imgs as $im)
<div class="slide">
    @if(($im['type'] ?? 'image') === 'video')
        <video
            src="{{ $im['src'] }}"
            controls
            preload="metadata"
            style="max-width:100%;max-height:100%;border-radius:8px;outline:none;"
            playsinline>
            Your browser does not support video.
        </video>
    @else
        <img src="{{ $im['src'] }}" alt="{{ $im['alt'] }}">
    @endif
</div>
@endforeach
            </div>

            @if($imgs->count() > 1)
            <button class="arrow-btn arrow-next" onclick="slideNext()" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
            @endif
        </div>

        @if($imgs->count() > 1)
        <div class="thumbs-wrap" id="thumbsWrap">
            <button class="thumb-arrow prev" id="thumbPrev" onclick="scrollThumbs('prev')" aria-label="Previous thumbnail">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="thumbs" id="thumbs">
               @foreach($imgs as $i=>$im)
<div class="thumb {{ $i===0?'on':'' }}" onclick="goSlide({{ $i }})">
    @if(($im['type'] ?? 'image') === 'video')
        <div style="width:100%;height:100%;display:flex;align-items:center;
                    justify-content:center;background:#1a1a1a;border-radius:6px;">
            <span style="font-size:22px;">▶️</span>
        </div>
    @else
        <img src="{{ $im['src'] }}" alt="{{ $im['alt'] }}">
    @endif
</div>
@endforeach
            </div>
            
            <button class="thumb-arrow next" id="thumbNext" onclick="scrollThumbs('next')" aria-label="Next thumbnail">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        @endif

        @else
        <div class="no-img"><i class="fas fa-image"></i></div>
        @endif
    </div>

    {{-- ===== RIGHT: PRODUCT INFO ===== --}}
    <div class="pd-info" id="pdInfo">
        <h1 class="pd-title">{{ $product->title }}</h1>
        @if($product->sku)<div class="pd-sku">SKU: <b>{{ $product->sku }}</b></div>@endif

        @if($product->variants->count() === 0)
        <div class="price-box">
            @if($product->sale_price)
                <div class="price-main">₹{{ number_format($product->sale_price,2) }}</div>
                <div class="price-orig">₹{{ number_format($product->price,2) }}</div>
                @if($product->price)<span class="disc-tag">{{ round((($product->price-$product->sale_price)/$product->price)*100) }}% OFF</span>@endif
            @elseif($product->price)
                <div class="price-main">₹{{ number_format($product->price,2) }}</div>
            @else
                <div class="price-na">Price on request</div>
            @endif
        </div>
        <div class="stock-pill {{ $product->stock_quantity>0?'in':'out' }}">
            <span class="sdot"></span>
            {{ $product->stock_quantity>0 ? 'In Stock ('.$product->stock_quantity.' units)' : 'Out of Stock' }}
        </div>
        @else
        <div class="price-box" id="dyn-price-box" style="display:flex;">
            <div class="price-main" id="dyn-price">—</div>
            <div class="price-orig" id="dyn-orig" style="display:none;"></div>
            <span class="disc-tag" id="dyn-disc" style="display:none;"></span>
        </div>
        <div class="stock-pill" id="dyn-stock" style="display:none;">
            <span class="sdot"></span>
            <span id="dyn-stock-txt"></span>
        </div>
        @endif

        @if($product->overview)
        <div style="margin-bottom:6px;font-size:13px;font-weight:700;color:var(--mut);text-transform:uppercase;letter-spacing:.07em;">
            <i class="fas fa-info-circle" style="margin-right:5px;color:var(--p);"></i>Overview
        </div>
        <div class="overview-box">{{ $product->overview }}</div>
        @endif

        <hr class="divider">

        {{-- ═══ VARIANT CARDS ═══ --}}
        @if($product->variants->count() > 0)
        @php
            $vCards = [];
            foreach($product->variants as $v) {
                $a = is_array($v->attributes) ? $v->attributes : [];
                $label = $v->name;
                if(count($a) === 1) $label = array_values($a)[0];
                $vCards[] = [
                    'id'            => $v->id,
                    'label'         => $label,
                    'price'         => $v->price,
                    'compare_price' => $v->compare_price ?? null,
                    'stock'         => $v->stock_quantity ?? 0,
                    'sku'           => $v->sku ?? '',
                    'name'          => $v->name,
                    'attrs'         => $a,
                ];
            }
            $firstVariantType = 'Variant';
            foreach($product->variants as $v) {
                $a = is_array($v->attributes) ? $v->attributes : [];
                if(!empty($a)) { $firstVariantType = ucfirst(array_key_first($a)); break; }
            }
        @endphp
        <div class="vg-section">
            <div class="vg-section-label">
                <span id="vg-label-text">{{ $firstVariantType }}</span>
                <span id="vg-selected-name" style="color:var(--p);font-weight:700;font-size:13px;text-transform:none;letter-spacing:0;margin-left:6px;display:none;">— <span id="vg-sel-val"></span></span>
            </div>
            <div class="variant-cards" id="variant-cards">
                @foreach($vCards as $idx => $vc)
                @php
                    $compareFor = $vc['compare_price'] ?: ($product->price ?: 0);
                    $discPct = ($compareFor > 0 && $vc['price'] > 0 && $vc['price'] < $compareFor)
                        ? round((($compareFor - $vc['price']) / $compareFor) * 100) : null;
                @endphp
                <div class="variant-card {{ $idx===0?'on':'' }}"
                     data-idx="{{ $idx }}"
                     data-price="{{ $vc['price'] }}"
                     data-compare="{{ $vc['compare_price'] ?: '' }}"
                     data-disc="{{ $discPct }}"
                     data-stock="{{ $vc['stock'] }}"
                     data-sku="{{ $vc['sku'] }}"
                     data-name="{{ $vc['name'] }}"
                     onclick="pickCard(this)">
                    @if($discPct)<span class="vc-off">{{ $discPct }}% OFF</span>@endif
                    <div class="vc-name">{{ $vc['label'] }}</div>
                    <div class="vc-ddfdddd">
                    @if($vc['price'])
                        <div class="vc-price">₹{{ number_format($vc['price'],0) }}</div>
                        @php $compareShow = $vc['compare_price'] ?: ($product->price ?: 0); @endphp
                        @if($compareShow && $compareShow != $vc['price'])
                        <div class="vc-orig">₹{{ number_format($compareShow,0) }}</div>
                        @endif
                    @else
                        <div class="vc-price" style="font-size:13px;color:var(--mut);">On Request</div>
                    @endif
                    </div>
                    @if($vc['stock'] == 0)<div class="vc-stock-out">Out of Stock</div>@endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ═══ CTA BUTTONS ═══ --}}
        <div class="cta-row">
            <button
                class="d-none-all cta-btn cta-primary"
                onclick="openEnquiry('{{ addslashes($product->title) }}')"
                type="button">
                <i class="fas fa-envelope"></i> Enquire Now
            </button>
        </div>

        @if($product->description)
        <div class="desc-box" style="margin-top:4px;">
            <div class="desc-head">
                <i class="fas fa-align-left"></i>Product Description
            </div>
            <div class="desc-body">{!! $product->description !!}</div>
        </div>
        @endif

        <hr class="divider">

        <table class="meta-tbl">
            @if($product->sku)<tr><td>SKU</td><td>{{ $product->sku }}</td></tr>@endif
            <tr>
                <td>Availability</td>
                <td>
                    @if($product->stock_quantity > 0)
                        <span style="color:#065f46;font-weight:600;">✓ In Stock</span>
                    @else
                        <span style="color:#991b1b;font-weight:600;">✗ Out of Stock</span>
                    @endif
                </td>
            </tr>
            @if($product->categories->count()>0)
            <tr>
                <td>Category</td>
                <td>
                    @foreach($product->categories as $cat)
                    <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="chip-cat">{{ $cat->name }}</a>
                    @endforeach
                </td>
            </tr>
            @endif
            @if($product->tags->count()>0)
            <tr><td>Tags</td><td>{{ $product->tags->pluck('name')->implode(', ') }}</td></tr>
            @endif
        </table>

    </div>{{-- end pd-info --}}
</div>{{-- end pd-grid --}}


{{-- ══════════════════════════════════════
     SIMILAR / RELATED PRODUCTS SECTION
══════════════════════════════════════ --}}
@php
    $relatedProducts = \App\Models\Product::with(['categories','tags','images','variants'])
        ->where('status','published')
        ->where('id','!=',$product->id)
        ->whereHas('categories', function($q) use ($product) {
            $q->whereIn('product_categories.id', $product->categories->pluck('id'));
        })
        ->latest('published_at')
        ->take(5)
        ->get();

    if($relatedProducts->count() === 0) {
        $relatedProducts = \App\Models\Product::with(['categories','tags','images','variants'])
            ->where('status','published')
            ->where('id','!=',$product->id)
            ->latest('published_at')
            ->take(6)
            ->get();
    }
@endphp

@if($relatedProducts->count() > 0)
<div class="similar-section">
    <div class="similar-head">
        <div class="similar-title">Similar Products</div>
        <a href="{{ route('shop') }}" class="similar-view-all">
            View All <i class="fas fa-arrow-right" style="font-size:11px;"></i>
        </a>
    </div>
    
    <div class="similar-grid-wrap" id="similarGridWrap">
        <button class="similar-carousel-arrow prev" id="simCarouselPrev" onclick="scrollSimilarCarousel('prev')" aria-label="Previous products" style="display:none;">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="similar-grid" id="similarGrid">
            @foreach($relatedProducts as $rp)
            @php
                $rpHasVariants = $rp->variants && $rp->variants->count() > 0;
                $rpEffPrice    = $rp->sale_price ?: $rp->price;
                $rpOrigPrice   = $rp->sale_price ? $rp->price : null;
                if ($rpHasVariants) {
                    $rpFirstV    = $rp->variants->first();
                    $rpEffPrice  = $rpFirstV->price ?? $rpEffPrice;
                    $rpOrigPrice = ($rpFirstV->compare_price && $rpFirstV->compare_price > 0)
                                   ? $rpFirstV->compare_price : null;
                }
                $rpDiscPct = ($rpOrigPrice && $rpOrigPrice > 0 && $rpEffPrice)
                             ? round((($rpOrigPrice - $rpEffPrice) / $rpOrigPrice) * 100) : 0;
                $rpInStock = $rp->stock_quantity > 0;
                $rpImg     = $rp->featured_image ? asset('uploads/products/'.$rp->featured_image) : null;
                $rpCat     = $rp->categories->first()->name ?? '';
            @endphp
            <div class="sim-card">
                @if($rpDiscPct >= 1)
                    <span class="sim-badge sale" id="sim-badge-{{ $rp->id }}">{{ $rpDiscPct }}% OFF</span>
                @elseif($rp->is_featured)
                    <span class="sim-badge feat" id="sim-badge-{{ $rp->id }}">⭐ Featured</span>
                @else
                    <span class="sim-badge sale" id="sim-badge-{{ $rp->id }}" style="display:none;"></span>
                @endif
                <a href="{{ route('product.detail', $rp->slug) }}" class="sim-img-wrap">
                    @if($rpImg)
                        <img src="{{ $rpImg }}" alt="{{ $rp->featured_image_alt ?: $rp->title }}" loading="lazy">
                    @else
                        <div class="sim-no-img"><i class="fas fa-image"></i></div>
                    @endif
                </a>
                <div class="sim-body">
                    <a href="{{ route('product.detail', $rp->slug) }}" class="sim-title">{{ $rp->title }}</a>
                    @if($rpCat)<div class="sim-brand">{{ $rpCat }}</div>@endif
                    <div class="sim-price-row">
                        @if($rpEffPrice)
                            <span class="sim-price" id="sim-price-{{ $rp->id }}">₹{{ number_format($rpEffPrice, 0) }}</span>
                            <span class="sim-orig" id="sim-orig-{{ $rp->id }}" @if(!$rpOrigPrice) style="display:none;" @endif>
                                @if($rpOrigPrice) ₹{{ number_format($rpOrigPrice, 0) }} @endif
                            </span>
                            <span class="sim-save" id="sim-save-{{ $rp->id }}" @if(!$rpOrigPrice) style="display:none;" @endif>
                                @if($rpOrigPrice) Save ₹{{ number_format($rpOrigPrice - $rpEffPrice, 0) }} @endif
                            </span>
                        @else
                            <span class="sim-price-na" id="sim-price-{{ $rp->id }}">Price on request</span>
                            <span class="sim-orig" id="sim-orig-{{ $rp->id }}" style="display:none;"></span>
                            <span class="sim-save" id="sim-save-{{ $rp->id }}" style="display:none;"></span>
                        @endif
                    </div>
                    @if($rpHasVariants)
                    <div class="sim-size-row" onclick="event.stopPropagation();" onmousedown="event.stopPropagation();">
                        <label>Size</label>
                        <select class="sim-size-sel"
                            onclick="event.stopPropagation();"
                            onmousedown="event.stopPropagation();"
                            onfocus="event.stopPropagation();"
                            onchange="simVariantChange(event, {{ $rp->id }}); event.stopPropagation();">
                            @foreach($rp->variants->take(5) as $v)
                            <option value="{{ $v->name }}"
                                data-price="{{ $v->price ?? '' }}"
                                data-compare="{{ $v->compare_price ?? '' }}"
                                data-stock="{{ $v->stock_quantity ?? 0 }}">{{ $v->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="sim-stock {{ $rpInStock ? 'in' : 'out' }}">
                        <span class="sim-dot"></span>
                        {{ $rpInStock ? 'In Stock' : 'Out of Stock' }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <button class="similar-carousel-arrow next" id="simCarouselNext" onclick="scrollSimilarCarousel('next')" aria-label="Next products" style="display:none;">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
@endif

{{-- ENQUIRY POPUP --}}
<div class="enq-overlay" id="enqOverlay" onclick="closeOnOverlay(event)">
    <div class="enq-modal" id="enqModal">
        <div class="enq-header">
            <div class="enq-header-icon"><i class="fas fa-paper-plane"></i></div>
            <h3>Send Enquiry</h3>
            <p>Fill in the form below and we'll get back to you shortly.</p>
            <button class="enq-close" onclick="closeEnquiry()" aria-label="Close">×</button>
        </div>
        <div class="enq-product-tag">
            <i class="fas fa-box"></i>
            <span id="enq-product-display">Product</span>
        </div>
        <div class="enq-body" id="enqFormWrap">
            @if(session('success'))
            <div class="enq-alert enq-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="enq-alert enq-alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            <form action="{{ route('contact.submit') }}" method="POST" id="enqForm">
                @csrf
                <input type="hidden" name="product_name" id="enq-product-name-hidden">
                <div class="enq-form-row">
                    <div class="enq-field">
                        <label>Your Name *</label>
                        <input type="text" name="name" placeholder="John Smith" value="{{ old('name') }}" required>
                    </div>
                    <div class="enq-field">
                        <label>Phone *</label>
                        <input type="tel" name="phone" placeholder="+91 98000 00000" value="{{ old('phone') }}" required>
                    </div>
                </div>
                <div class="enq-form-row">
                    <div class="enq-field">
                        <label>Email *</label>
                        <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="enq-field">
                        <label>Address</label>
                        <input type="text" name="address" placeholder="Your city / suburb" value="{{ old('address') }}">
                    </div>
                </div>
                <div class="enq-field">
                    <label>Message</label>
                    <textarea name="message" placeholder="Tell us more about your requirements...">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="enq-submit">
                    <i class="fas fa-paper-plane"></i> Send Enquiry
                </button>
            </form>
        </div>
        <div class="enq-success" id="enqSuccess">
            <div class="enq-success-icon"><i class="fas fa-check"></i></div>
            <h4>Enquiry Sent!</h4>
            <p>Thank you! We'll be in touch with you shortly.</p>
        </div>
    </div>
</div>


{{-- ═══ ALL JS ═══ --}}
<script>
/* ══════════════════════════════════════════════════════════════
   STICKY GALLERY — JS BASED (CSS sticky se 100% reliable)

   Kaise kaam karta hai:
   - window.scroll pe gallery ka translateY calculate hota hai
   - Grid ka top kitna upar gaya viewport se, utna gallery ko neeche push karo
   - Gallery kabhi right column (pdInfo) se neeche nahi jayegi
══════════════════════════════════════════════════════════════ */
(function () {
    // ✏️ Apne fixed header ki exact height yahan likhو (px mein)
    var HEADER_H  = 88;
    var TOP_GAP   = 16; // header ke neeche thoda breathing room

    var gallery = document.getElementById('pdGallery');
    var pdInfo  = document.getElementById('pdInfo');
    var pdGrid  = document.getElementById('pdGrid');

    if (!gallery || !pdInfo || !pdGrid) return;

    var ticking = false;

    function update() {
        ticking = false;

        // Mobile pe kuch nahi karna
        if (window.innerWidth <= 980) {
            gallery.style.transform = 'translateY(0)';
            return;
        }

        var OFFSET      = HEADER_H + TOP_GAP;
        var gridTop     = pdGrid.getBoundingClientRect().top;  // viewport se grid ka top
        var galleryH    = gallery.offsetHeight;
        var infoH       = pdInfo.offsetHeight;

        // Gallery kitna neeche ja sakti hai maximum (right col ki height - gallery height)
        var maxMove = Math.max(0, infoH - galleryH);

        var move = 0;

        if (gridTop < OFFSET) {
            // Grid ka top OFFSET se upar chala gaya — gallery ko neeche push karo
            move = OFFSET - gridTop;
            // Clamp between 0 and maxMove
            move = Math.min(move, maxMove);
            move = Math.max(move, 0);
        }

        gallery.style.transform = 'translateY(' + move + 'px)';
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
    // Ek baar turant bhi chalao
    update();
})();

/* ──────────────────────────────────────
   ENQUIRY POPUP
──────────────────────────────────────── */
function openEnquiry(productTitle) {
    document.getElementById('enq-product-name-hidden').value = productTitle;
    document.getElementById('enq-product-display').textContent = productTitle;
    document.getElementById('enqOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEnquiry() {
    document.getElementById('enqOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
function closeOnOverlay(e) {
    if (e.target === document.getElementById('enqOverlay')) closeEnquiry();
}
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeEnquiry();
});

@if(session('success') && old('_token'))
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('enqFormWrap').style.display = 'none';
    document.getElementById('enqSuccess').style.display  = 'block';
    openEnquiry('{{ addslashes($product->title) }}');
    setTimeout(closeEnquiry, 3000);
});
@endif

/* ──────────────────────────────────────
   MAIN PRODUCT — VARIANT CARD PICK
──────────────────────────────────────── */
function pickCard(card) {
    document.querySelectorAll('.variant-card').forEach(c => c.classList.remove('on'));
    card.classList.add('on');

    const price    = card.dataset.price;
    const compare  = card.dataset.compare;
    const stock    = parseInt(card.dataset.stock) || 0;
    const cardName = card.querySelector('.vc-name') ? card.querySelector('.vc-name').textContent.trim() : '';

    const selNameEl = document.getElementById('vg-selected-name');
    const selValEl  = document.getElementById('vg-sel-val');
    if (selNameEl && selValEl && cardName) {
        selValEl.textContent    = cardName;
        selNameEl.style.display = 'inline';
    }

    const priceEl = document.getElementById('dyn-price');
    const origEl  = document.getElementById('dyn-orig');
    const discEl  = document.getElementById('dyn-disc');
    const stockEl = document.getElementById('dyn-stock');
    if (!priceEl) return;

    if (price && parseFloat(price) > 0) {
        priceEl.textContent = '₹' + parseFloat(price).toLocaleString('en-IN', { maximumFractionDigits: 0 });
    } else {
        priceEl.textContent = 'Price on Request';
    }

    const compareVal = parseFloat(compare) || 0;
    const priceVal   = parseFloat(price)   || 0;

    if (compareVal > 0 && priceVal > 0 && priceVal < compareVal) {
        origEl.textContent   = '₹' + compareVal.toLocaleString('en-IN', { maximumFractionDigits: 0 });
        origEl.style.display = 'block';
        const calcDisc       = Math.round(((compareVal - priceVal) / compareVal) * 100);
        discEl.textContent   = calcDisc + '% OFF';
        discEl.style.display = 'inline-block';
    } else {
        origEl.textContent = ''; origEl.style.display = 'none';
        discEl.textContent = ''; discEl.style.display = 'none';
    }

    if (stock > 0) {
        stockEl.className = 'stock-pill in';
        stockEl.innerHTML = '<span class="sdot"></span><span>' + stock + ' units available</span>';
    } else {
        stockEl.className = 'stock-pill out';
        stockEl.innerHTML = '<span class="sdot"></span><span>Out of Stock</span>';
    }
    stockEl.style.display = 'inline-flex';
}

document.addEventListener('DOMContentLoaded', function () {
    const first = document.querySelector('.variant-card');
    if (first) pickCard(first);
});

/* ──────────────────────────────────────
   SIMILAR PRODUCTS — VARIANT PRICE UPDATE
──────────────────────────────────────── */
function simVariantChange(e, productId) {
    e.stopPropagation();
    e.preventDefault();
    const opt     = e.target.options[e.target.selectedIndex];
    const price   = parseFloat(opt.getAttribute('data-price'))   || 0;
    const compare = parseFloat(opt.getAttribute('data-compare')) || 0;
    const priceEl = document.getElementById('sim-price-'  + productId);
    const origEl  = document.getElementById('sim-orig-'   + productId);
    const saveEl  = document.getElementById('sim-save-'   + productId);
    const badgeEl = document.getElementById('sim-badge-'  + productId);
    if (!priceEl) return;
    if (price > 0) {
        priceEl.textContent = '₹' + Math.round(price).toLocaleString('en-IN');
        priceEl.className   = 'sim-price';
    } else {
        priceEl.textContent = 'Price on request';
        priceEl.className   = 'sim-price-na';
    }
    if (compare > 0 && price > 0) {
        const saved   = compare - price;
        const discPct = Math.round((saved / compare) * 100);
        if (origEl) { origEl.textContent = '₹' + Math.round(compare).toLocaleString('en-IN'); origEl.style.display = ''; }
        if (saveEl) { saveEl.textContent = 'Save ₹' + Math.round(saved).toLocaleString('en-IN'); saveEl.style.display = ''; }
        if (badgeEl) { badgeEl.textContent = discPct + '% OFF'; badgeEl.className = 'sim-badge sale'; badgeEl.style.display = ''; }
    } else {
        if (origEl)  { origEl.textContent  = ''; origEl.style.display  = 'none'; }
        if (saveEl)  { saveEl.textContent  = ''; saveEl.style.display  = 'none'; }
        if (badgeEl && badgeEl.textContent.includes('OFF')) { badgeEl.style.display = 'none'; badgeEl.textContent = ''; }
    }
}

/* ──────────────────────────────────────
   IMAGE SLIDER
──────────────────────────────────────── */
let curSlide    = 0;
const totalSlides = {{ $imgs->count() }};

function goSlide(n) {
    curSlide = ((n % totalSlides) + totalSlides) % totalSlides;
    const track = document.getElementById('slider-track');
    if (track) track.style.transform = 'translateX(-' + (curSlide * 100) + '%)';
    document.querySelectorAll('.thumb').forEach((t, i) => t.classList.toggle('on', i === curSlide));
}
function slideNext() { goSlide(curSlide + 1); }
function slidePrev() { goSlide(curSlide - 1); }

document.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowRight') slideNext();
    if (e.key === 'ArrowLeft')  slidePrev();
});

let touchStartX = 0;
const wrap = document.getElementById('slider-wrap');
if (wrap) {
    wrap.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; });
    wrap.addEventListener('touchend',   e => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 40) diff > 0 ? slideNext() : slidePrev();
    });
}

/* ──────────────────────────────────────
   THUMBNAIL CAROUSEL SCROLL
──────────────────────────────────────── */
function scrollThumbs(dir) {
    const thumbsEl = document.getElementById('thumbs');
    if (!thumbsEl) return;
    
    const thumbSize = 66 + 8; // width (66px) + gap (8px)
    const scrollAmount = thumbSize; // 1 thumb at a time
    
    const currentScroll = thumbsEl.scrollLeft || 0;
    const newScroll = dir === 'next' 
        ? currentScroll + scrollAmount 
        : currentScroll - scrollAmount;
    
    thumbsEl.scrollLeft = newScroll;
    
    // Update button state after scroll
    setTimeout(updateThumbButtons, 100);
}

function updateThumbButtons() {
    const thumbsEl = document.getElementById('thumbs');
    const prevBtn = document.getElementById('thumbPrev');
    const nextBtn = document.getElementById('thumbNext');
    
    if (!thumbsEl || !prevBtn || !nextBtn) return;
    
    const currentScroll = thumbsEl.scrollLeft || 0;
    const maxScroll = thumbsEl.scrollWidth - thumbsEl.offsetWidth;
    
    prevBtn.disabled = currentScroll <= 0;
    nextBtn.disabled = currentScroll >= (maxScroll - 5);
}

// Initial setup & event listeners
document.addEventListener('DOMContentLoaded', function() {
    updateThumbButtons();
    const thumbsEl = document.getElementById('thumbs');
    if (thumbsEl) {
        thumbsEl.addEventListener('scroll', updateThumbButtons);
    }
});

window.addEventListener('resize', updateThumbButtons);

/* ──────────────────────────────────────
   SIMILAR PRODUCTS CAROUSEL — Mobile/Tablet
   
   5 items ek saath dikhenge
   Arrow buttons se scroll ho
   Swipe bhi work karega
──────────────────────────────────────── */
(function() {
    const wrap = document.getElementById('similarGridWrap');
    const grid = document.getElementById('similarGrid');
    const prevBtn = document.getElementById('simCarouselPrev');
    const nextBtn = document.getElementById('simCarouselNext');
    
    if (!wrap || !grid) return;
    
    // Check if carousel mode (mobile/tablet)
    function isCarouselMode() {
        return window.innerWidth <= 860;
    }
    
    // Update button visibility & state
    function updateButtons() {
        if (!isCarouselMode()) {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            return;
        }
        
        if (prevBtn) prevBtn.style.display = 'flex';
        if (nextBtn) nextBtn.style.display = 'flex';
        
        const cards = grid.querySelectorAll('.sim-card');
        const cardWidth = cards[0]?.offsetWidth || 250;
        const gap = 14;
        const itemSize = cardWidth + gap;
        const totalWidth = (cards.length * itemSize) - gap;
        const maxScroll = totalWidth - wrap.offsetWidth;
        const currentScroll = grid.scrollLeft || 0;
        
        if (prevBtn) prevBtn.disabled = currentScroll <= 0;
        if (nextBtn) nextBtn.disabled = currentScroll >= maxScroll - 10;
    }
    
    // Scroll carousel
    window.scrollSimilarCarousel = function(dir) {
        const cards = grid.querySelectorAll('.sim-card');
        if (!cards.length) return;
        
        const cardWidth = cards[0].offsetWidth;
        const gap = 14;
        const itemSize = cardWidth + gap;
        const scrollAmount = itemSize * 8; // 5 items at a time
        
        const currentScroll = grid.scrollLeft || 0;
        const newScroll = dir === 'next' 
            ? currentScroll + scrollAmount 
            : currentScroll - scrollAmount;
        
        grid.style.scrollBehavior = 'smooth';
        grid.scrollLeft = newScroll;
        
        setTimeout(updateButtons, 400);
    };
    
    // Touch swipe support
    let touchStartX = 0;
    grid.addEventListener('touchstart', e => {
        touchStartX = e.touches[0].clientX;
    });
    
    grid.addEventListener('touchend', e => {
        const touchEndX = e.changedTouches[0].clientX;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > 50) {
            window.scrollSimilarCarousel(diff > 0 ? 'next' : 'prev');
        }
    });
    
    // Initial setup
    setTimeout(updateButtons, 100);
    window.addEventListener('resize', updateButtons);
})();

</script>

@endsection
