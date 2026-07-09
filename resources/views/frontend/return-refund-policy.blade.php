@extends('frontend.layouts.layout')
@section('title', $page->heading ?? 'Return and Refund Policy')
@section('description', 'Read our Return and Refund Policy to understand our return, exchange and refund process.')
@section('content')
<style>
/* --- same CSS as privacy-policy.blade.php, copy as-is --- */
.legal-section {
    background: #fff !important;
}
    .legal-banner {
        width: 100%;
        height: 107px;
        background: #f0f4f0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 40px;
    }
    .legal-banner-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }
    .legal-banner h1 {
        color: #30674d;
        font-size: 30px;
        font-weight: 700;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    div#site-content {
        padding-top: 0!important;
    }
    .legal-section {
        padding: 47px 0;
    }
    .legal-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .legal-content {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .legal-content h2 {
        font-size: 20px!important;
        color: #30674d!important;
        font-weight: 600;
        margin-top: 30px;
        margin-bottom: 15px;
    }
    .legal-content h3 {
        font-size: 18px!important;
        color: #30674d!important;
        font-weight: 600;
        margin-top: 25px;
        margin-bottom: 12px;
    }
    .legal-content p {
        font-size: 14px!important;
        color: #000;
        line-height: 21px;
        margin-bottom: 15px;
        text-align: left!important;
    }
    .legal-content ul,
    .legal-content ol {
        margin-bottom: 15px;
        padding-left: 30px;
    }
    .legal-content li {
        font-size: 14px!important;
        color: #000;
        line-height: 21px;
        margin-bottom: 6px;
    }
    .legal-content strong,
    .legal-content b {
        color: #30674d;
    }
    .last-updated {
        text-align: center;
        color: #666;
        font-size: 13px;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    @media (max-width: 767px) {
        .legal-banner { height: 80px; }
        .legal-banner h1 { font-size: 22px; }
        .legal-section { padding: 30px 0; padding-top: 0; }
        .legal-content { padding: 25px 20px; }
        .legal-content h2 { font-size: 18px!important; }
        .legal-content h3 { font-size: 16px!important; }
    }
</style>
<div class="legal-banner">
    <div class="legal-banner-content">
        <h1>{{ $page->heading }}</h1>
    </div>
</div>
<div id="content-wrapc">
    <div id="site-contenct" class="site-contxent cleaxrfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content">
                <section class="legal-section">
                    <div class="legal-container">
                        <div class="legal-content">
                            {!! $page->description !!}

                            <div class="last-updated">
                                Last Updated: {{ $page->updated_at->format('F d, Y') }}
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </div>
</div>
@endsection
