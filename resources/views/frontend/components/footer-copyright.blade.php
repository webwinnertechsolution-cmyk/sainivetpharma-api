@php
    $footer = \App\Models\FooterMain::first();
@endphp

@if($footer)
<div id="bottom" style=" padding: 15px 0; ">
    <div class="byron-container" style="width:100% !important; max-width:1250px;">
        <div class="bottom-bar-inner-wrap">
            <div class="inner-wrap">
                <div id="copyright" style="color: #fff; font-size: 16px;">
                    © {{ $footer->copyright_year }} {{ $footer->copyright_text }}. Powered By <a href="{{ $footer->powered_by_link }}" style="color: #DA200B; text-decoration: none;">{{ $footer->powered_by_text }}.</a>
                </div>
            </div><!-- /.bottom-bar-copyright -->
            <a id="scroll-top" class="show"></a>
        </div>
    </div>
</div>
@else
<div id="bottom" style="background-color: #010816; padding: 15px 0; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="byron-container">
        <div class="bottom-bar-inner-wrap">
            <div class="inner-wrap">
                <div id="copyright" style="color: rgba(255,255,255,0.6); font-size: 14px;">
                    © 2024 Red-Labs. Powered By <a href="https://redengineers.com.au/" style="color: #DA200B; text-decoration: none;">Red Engineers.</a>
                </div>
            </div><!-- /.bottom-bar-copyright -->
            <a id="scroll-top" class="show"></a>
        </div>
    </div>
</div>
@endif
