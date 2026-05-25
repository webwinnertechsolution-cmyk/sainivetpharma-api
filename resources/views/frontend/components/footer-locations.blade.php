@php
    $footer = \App\Models\FooterMain::first();
@endphp

<style>
    /* Force footer side by side for 769px-1024px */
    @media (min-width: 769px) {
        .footer-cstm-container {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
        }
        .footer-cstm-colmns {
            width: 50% !important;
            flex: 0 0 50% !important;
        }
    }
    @media (max-width: 768px) {
        .footer-cstm-container {
            flex-direction: column !important;
        }
        .footer-cstm-colmns {
            width: 100% !important;
            flex: 0 0 100% !important;
        }
    }
    @media (max-width: 1024px) {
    .builders-col-50 {
        flex: 1 1 100% !important;
        max-width: 50% !important;
        padding: 10px !important;
    }

    @media (max-width: 1024px) {
    .builder-column.builders-col-50.footer-cstm-colmns {
        flex: 1 1 100% !important;
        max-width: 100% !important;
        padding: 10px !important;
    }
}
}
</style>

@if($footer)
<!-- Location 1 -->
<div class="builder-column builders-col-50 footer-cstm-colmns border-rght">
    <div class="footer-cstm-cont">
        <i class="{{ $footer->location1_icon }} footer-cstm-icn"></i>
        <p class="footer-cstm-txt">{!! nl2br($footer->location1_text) !!}</p>
    </div>
</div>

<!-- Location 2 -->
<div class="builder-column builders-col-50 footer-cstm-colmns">
    <div class="footer-cstm-cont">
        <i class="{{ $footer->location2_icon }} footer-cstm-icn"></i>
        <p class="footer-cstm-txt">{!! nl2br($footer->location2_text) !!}</p>
    </div>
</div>
@else
<!-- Fallback if no footer data exists -->
<div class="builder-column builders-col-50 footer-cstm-colmns border-rght">
    <div class="footer-cstm-cont">
        <i class="fas fa-map-marker-alt footer-cstm-icn"></i>
        <p class="footer-cstm-txt">RED Engineers | <span style="color:#DA200B">RED-</span>LABS<br>A04/216 Harbour Road, Mackay Harbour. QLD 4740</p>
    </div>
</div>
<div class="builder-column builders-col-50 footer-cstm-colmns">
    <div class="footer-cstm-cont">
        <i class="fas fa-map-marker-alt footer-cstm-icn"></i>
        <p class="footer-cstm-txt">RED Engineers | <span style="color:#DA200B">RED-</span>LABS<br>Suite 1870/324 Queen St, Brisbane City, QLD, 4000</p>
    </div>
</div>
@endif
