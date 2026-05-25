@php
    $f  = \App\Models\FooterNew::first();
    $fm = \App\Models\FooterMain::first();
@endphp

<style>
/* ── Footer New Styles ───────────────────────────── */
.footer-new-wrap {
    background-color: #030f27;
    padding: 60px 0 0;
}
.footer-new-wrap .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}
.footer-new-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    margin: 0 -15px;
}
.footer-new-col {
    width: 25%;
    padding: 0 15px 40px;
    box-sizing: border-box;
}
.footer-col-heading {
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 12px;
    font-family: 'Inter', sans-serif;
}
.footer-col-heading::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background: #DA200B;
}
.footer-col-content {
    color: rgba(255,255,255,0.75);
    font-size: 14px;
    line-height: 1.8;
    font-family: 'Inter', sans-serif;
}
/* Social Icons */
.footer-social {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 20px;
}
.footer-social a {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 15px;
    text-decoration: none;
    transition: opacity 0.2s, transform 0.2s;
}
.footer-social a:hover { opacity: 0.8; transform: translateY(-2px); }
.footer-social .s-fb  { background: #1877f2; }
.footer-social .s-ig  { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
.footer-social .s-tw  { background: #000; }
.footer-social .s-yt  { background: #ff0000; }
.footer-social .s-li  { background: #0a66c2; }
.footer-social .s-wa  { background: #25d366; }
/* Quick Links */
.footer-links-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer-links-list li {
    margin-bottom: 10px;
}
.footer-links-list li a {
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: color 0.2s;
}
.footer-links-list li a:hover { color: #fff; }
.footer-links-list li a i {
    font-size: 10px;
    color: #DA200B;
}
/* Logo */
.footer-logo {
    margin-bottom: 16px;
}
.footer-logo img {
    max-height: 60px;
    max-width: 180px;
    object-fit: contain;
}
/* Copyright Bar */
.footer-copyright {
    background: rgba(0,0,0,0.3);
    margin-top: 10px;
    padding: 18px 0;
    text-align: center;
}
.footer-copyright p {
    color: rgba(255,255,255,0.6);
    margin: 0;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
}
.footer-copyright a {
    color: #DA200B;
    text-decoration: none;
}
.footer-copyright a:hover { text-decoration: underline; }

.footer-new-col.onef {
    width: 50%;
}
.footer-new-col.threef {
    width: 30%;
}
.footer-new-col.twof {
    width: 20%;
}
#footer a {
    color: #fff!important;
}
.footer-links-list li a i {
    font-size: 10px;
    color: #fff!important;
}
.footer-col-heading::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 107px;
    height: 1px;
    background: #fff;
}
.footer-new-col.onef .footer-col-content {
    padding-right: 51px;
}
.footer-logo img {
    max-height: 82px;
    max-width: 199px;
    object-fit: contain;
}
.footer-new-col.onef .footer-col-content {
    padding-right: 51px;
    line-height: 21px;
}
.footer-links-list li {
    margin-bottom: 3px;
}
.threef .footer-col-content {
    line-height: 20px;
}

#footer {
    padding: 20px 0 20px;
    padding-bottom: 0;
}
#footer {
    padding-top: 46px;
}
/* ── Responsive ─────────────────────────────────── */
@media (max-width: 1024px) {
    .footer-new-col { width: 50%; }
}
@media (max-width: 767px) {
    .footer-new-col {
        width: 100%;
        padding-bottom: 30px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .footer-new-col:last-child { border-bottom: none; }
	
    .footer-new-wrap { padding: 40px 0 0; }
	
	
	
	.footer-new-col.onef {
    width: 100%;
}
.footer-new-col.threef {
    width: 100%;
}
.footer-new-col.twof {
    width: 100%;
}
.footer-new-col.onef .footer-col-content {
    padding-right: 0px;
    line-height: 21px;
}
.footer-new-col {
    width: 100%;
    padding-bottom: 30px;
    border-bottom: 0px solid rgba(255,255,255,0.08);
}
footer#footer {
    padding-top: 25px!important;
    padding-bottom: 0!important;
}
.footer-new-col.twof {
    padding-bottom: 24px;
}

}
</style>

<footer id="footer" class="footer-new-wrap">
    <div class="container">
        <div class="footer-new-row ">

            {{-- ══════════════════════════════════════════
                 COLUMN 1 — Logo + Content + Social Media
            ══════════════════════════════════════════ --}}
            <div class="footer-new-col onef">

                @if($f && $f->col1_logo)
                    <div class="footer-logo">
                        <img src="{{ asset('uploads/footer/' . $f->col1_logo) }}"
                             alt="{{ $f->col1_logo_alt ?? 'Logo' }}">
                    </div>
                @endif

                @if($f && $f->col1_content)
                    <div class="footer-col-content">
                        {!! $f->col1_content !!}
                    </div>
                @endif

                @if($f)
                <div class="footer-social">
                    @if($f->col1_social_facebook)
                        <a href="{{ $f->col1_social_facebook }}" target="_blank" rel="noopener" class="s-fb" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if($f->col1_social_instagram)
                        <a href="{{ $f->col1_social_instagram }}" target="_blank" rel="noopener" class="s-ig" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if($f->col1_social_twitter)
                        <a href="{{ $f->col1_social_twitter }}" target="_blank" rel="noopener" class="s-tw" title="X / Twitter">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                    @endif
                    @if($f->col1_social_youtube)
                        <a href="{{ $f->col1_social_youtube }}" target="_blank" rel="noopener" class="s-yt" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                    @if($f->col1_social_linkedin)
                        <a href="{{ $f->col1_social_linkedin }}" target="_blank" rel="noopener" class="s-li" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if($f->col1_social_whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $f->col1_social_whatsapp) }}"
                           target="_blank" rel="noopener" class="s-wa" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif
                </div>
                @endif

            </div>{{-- /col1 --}}

            {{-- ══════════════════════════════════════════
                 COLUMN 2 — Heading + Quick Links
            ══════════════════════════════════════════ --}}
            <div class="footer-new-col twof">

                @if($f && $f->col2_heading)
                    <h5 class="footer-col-heading">{{ $f->col2_heading }}</h5>
                @endif

                @if($f && $f->col2_links && count($f->col2_links))
                    <ul class="footer-links-list">
                        @foreach($f->col2_links as $link)
                            @if(!empty($link['title']))
                            <li>
                                <a href="{{ $link['url'] ?? '#' }}">
                                    <i class="fas fa-chevron-right"></i>
                                    {{ $link['title'] }}
                                </a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                @endif

            </div>{{-- /col2 --}}

            {{-- ══════════════════════════════════════════
                 COLUMN 3 — Heading + Content
            ══════════════════════════════════════════ --}}
            <div class="footer-new-col threef">

                @if($f && $f->col3_heading)
                    <h5 class="footer-col-heading">{{ $f->col3_heading }}</h5>
                @endif

                @if($f && $f->col3_content)
                    <div class="footer-col-content">
                        {!! $f->col3_content !!}
                    </div>
                @endif

            </div>{{-- /col3 --}}







            {{-- ══════════════════════════════════════════
                 COLUMN 4 — Heading + Content
            ══════════════════════════════════════════ --}}
            <!--<div class="footer-new-col ">

                @if($f && $f->col4_heading)
                    <h5 class="footer-col-heading">{{ $f->col4_heading }}</h5>
                @endif

                @if($f && $f->col4_content)
                    <div class="footer-col-content">
                        {!! $f->col4_content !!}
                    </div>
                @endif
 
            </div>{{-- /col4 --}}
-->




        </div>{{-- /footer-new-row --}}
    </div>{{-- /container --}}

    {{-- ── Copyright Bar ── --}}
   <div class="footer-copyright">
    <p>
        &copy; {{ date('Y') }}
        Design & Developed by 
        <a href="https://web-winners.com/" target="_blank">Web Winners</a>
    </p>
</div>

</footer>