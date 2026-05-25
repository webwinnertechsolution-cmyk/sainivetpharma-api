@extends('frontend.layouts.layout')

@section('title', 'Upload File - Red-Labs')
@section('description', 'Please contact us for a free quotation and tell us more about your project')

@push('styles')
<style>
    /* Fix icon sizes on upload-file page */
    .builder-element-593b946 .builder-icon-list-icon svg {
        width: 20px !important;
        height: 20px !important;
    }
    
    .builder-element-593b946 .builder-icon-list-item {
        margin-bottom: 15px;
        list-style: none !important;
    }
    
    .builder-element-593b946 .builder-icon-list-icon {
        width: 20px;
        margin-right: 10px;
    }
    
    .builder-element-593b946 .builder-icon-list-items {
        list-style: none !important;
        padding-left: 0 !important;
    }
    
    /* Completely hide CF7 validation errors */
    .wpcf7-not-valid-tip {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        overflow: hidden !important;
    }
    
    .wpcf7-response-output {
        display: none !important;
    }
    
    .wpcf7-form-control.wpcf7-not-valid {
        border-color: inherit !important;
    }
    
    /* Responsive columns */
    @media (max-width: 1024px) {
        .builder-col-50, .builder-inner-column {
            width: 100% !important;
            flex: 0 0 100% !important;
            margin-bottom: 30px;
        }
        .builder-inner-column:last-child {
            margin-bottom: 0;
        }
    }
    
    /* Form field styling - side by side */
    .input-wrap p {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }
    .input-wrap p input {
        flex: 1;
        width: 100%;
    }
    
    /* Responsive form fields */
    @media (max-width: 768px) {
        .input-wrap p {
            flex-direction: column;
            gap: 20px;
        }
    }
    /* Captcha Layout */
    .captcha-row {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 10px;
        margin-bottom: 25px;
    }
    .captcha-img-container {
        background: #DA200B;
        padding: 5px;
        border-radius: 4px;
        height: 60px;
        width: 100%;
        max-width: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .refresh-btn {
        background: #f8f8f8;
        border: 1px solid #ddd;
        color: #8cc63f;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 4px;
        font-size: 24px;
        transition: all 0.3s ease;
    }
    .refresh-btn:hover {
        background: #eee;
        border-color: #8cc63f;
    }
</style>
@endpush

@push('scripts')
<script>
    function refreshCaptcha() {
        fetch('{{ route('captcha.refresh') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('captchaImg').src = data.url;
            });
    }
</script>
@endpush

@section('content')
<div id="main-content" class="site-main clearfix">
    <div id="content-wrap" class="builder-container">
        <div id="site-content" class="site-content clearfix">
            <div id="inner-content" class="inner-content-wrap">
                <article class="page-content post-3018 page type-page status-publish hentry">
                    <div data-builder-type="wp-page" data-builder-id="3018" class="builder builder-3018"
                        data-builder-post-type="page">
                        <section style="padding-bottom:0px;"
                            class="builder-section builder-top-section builder-element builder-element-da081fd builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no"
                            data-id="da081fd" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="builder-container builder-column-gap-default">
                                <div class="builder-column builder-col-100 builder-top-column builder-element builder-element-a39ba3a"
                                    data-id="a39ba3a" data-element_type="column">
                                    <div class="builder-widget-wrap builder-element-populated">
                                        <div class="builder-element builder-element-2a8918a builder-widget builder-widget-spacer"
                                            data-id="2a8918a" data-element_type="widget"
                                            data-widget_type="spacer.default">
                                            <div class="builder-widget-container">
                                                <div class="builder-spacer">
                                                    <div class="builder-spacer-inner"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <section style="padding-bottom: 0px;"
                                            class="builder-section builder-inner-section builder-element builder-element-402f479 builder-section-boxed builder-section-height-default builder-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no"
                                            data-id="402f479" data-element_type="section">
                                            <div class="builder-container builder-column-gap-default">
                                                <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-d030bf7"
                                                    data-id="d030bf7" data-element_type="column">
                                                    <div class="builder-widget-wrap builder-element-populated">
                                                        <div class="builder-element builder-element-1142bd0 align-left builder-widget builder-widget-mae-headings"
                                                            data-id="1142bd0" data-element_type="widget"
                                                            data-widget_type="mae-headings.default">
                                                            <div class="builder-widget-container">
                                                                <div class="master-heading">

                                                                    <h2 class="main-heading">Please contact us for a free
                                                                        quotation and tell us more about your project</h2>

                                                                    <div class="divider"></div>

                                                                    <div class="sub-heading">Thank you for your interest in
                                                                        requesting a work estimate, please fill out the form
                                                                        and we will get back to you shortly.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="builder-element builder-element-593b946 builder-icon-list--layout-traditional builder-list-item-link-full_width builder-widget builder-widget-icon-list"
                                                            data-id="593b946" data-element_type="widget"
                                                            data-widget_type="icon-list.default">
                                                            <div class="builder-widget-container">
                                                                <ul class="builder-icon-list-items">
                                                                    <li class="builder-icon-list-item">
                                                                        <a href="tel:+61-423%20454%20930">

                                                                            <span class="builder-icon-list-icon">
                                                                                <svg aria-hidden="true"
                                                                                    class="e-font-icon-svg e-fas-phone-alt"
                                                                                    viewBox="0 0 512 512"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z">
                                                                                    </path>
                                                                                </svg>
                                                                            </span>
                                                                            <span
                                                                                class="builder-icon-list-text">+61-423 454
                                                                                930</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="builder-icon-list-item">
                                                                        <a href="tel:+61-422%20242%20277">

                                                                            <span class="builder-icon-list-icon">
                                                                                <svg aria-hidden="true"
                                                                                    class="e-font-icon-svg e-fas-phone-alt"
                                                                                    viewBox="0 0 512 512"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z">
                                                                                    </path>
                                                                                </svg>
                                                                            </span>
                                                                            <span
                                                                                class="builder-icon-list-text">+61-422 242
                                                                                277</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="builder-icon-list-item">
                                                                        <a href="mailto:m.bajwa@mackaydraft.com.au">

                                                                            <span class="builder-icon-list-icon">
                                                                                <svg aria-hidden="true"
                                                                                    class="e-font-icon-svg e-fas-envelope"
                                                                                    viewBox="0 0 512 512"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z">
                                                                                    </path>
                                                                                </svg>
                                                                            </span>
                                                                            <span
                                                                                class="builder-icon-list-text">m.bajwa@mackaydraft.com.au</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="builder-icon-list-item">
                                                                        <a href="mailto:ernest.maina@red-labs.com.au">

                                                                            <span class="builder-icon-list-icon">
                                                                                <svg aria-hidden="true"
                                                                                    class="e-font-icon-svg e-fas-envelope"
                                                                                    viewBox="0 0 512 512"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z">
                                                                                    </path>
                                                                                </svg>
                                                                            </span>
                                                                            <span
                                                                                class="builder-icon-list-text">ernest.maina@red-labs.com.au</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="builder-icon-list-item">
                                                                        <span class="builder-icon-list-icon">
                                                                            <svg aria-hidden="true"
                                                                                class="e-font-icon-svg e-fas-map-pin"
                                                                                viewBox="0 0 288 512"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M112 316.94v156.69l22.02 33.02c4.75 7.12 15.22 7.12 19.97 0L176 473.63V316.94c-10.39 1.92-21.06 3.06-32 3.06s-21.61-1.14-32-3.06zM144 0C64.47 0 0 64.47 0 144s64.47 144 144 144 144-64.47 144-144S223.53 0 144 0zm0 76c-37.5 0-68 30.5-68 68 0 6.62-5.38 12-12 12s-12-5.38-12-12c0-50.73 41.28-92 92-92 6.62 0 12 5.38 12 12s-5.38 12-12 12z">
                                                                                </path>
                                                                            </svg>
                                                                        </span>
                                                                        <span class="builder-icon-list-text">Suite
                                                                            1870/324 Queen St, Brisbane City, QLD,
                                                                            4000</span>
                                                                    </li>
                                                                    <li class="builder-icon-list-item">
                                                                        <span class="builder-icon-list-icon">
                                                                            <svg aria-hidden="true"
                                                                                class="e-font-icon-svg e-fas-map-pin"
                                                                                viewBox="0 0 288 512"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M112 316.94v156.69l22.02 33.02c4.75 7.12 15.22 7.12 19.97 0L176 473.63V316.94c-10.39 1.92-21.06 3.06-32 3.06s-21.61-1.14-32-3.06zM144 0C64.47 0 0 64.47 0 144s64.47 144 144 144 144-64.47 144-144S223.53 0 144 0zm0 76c-37.5 0-68 30.5-68 68 0 6.62-5.38 12-12 12s-12-5.38-12-12c0-50.73 41.28-92 92-92 6.62 0 12 5.38 12 12s-5.38 12-12 12z">
                                                                                </path>
                                                                            </svg>
                                                                        </span>
                                                                        <span class="builder-icon-list-text">A04/216
                                                                            Harbour Road, Mackay Harbour. QLD 4740</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="builder-element builder-element-078066a align-left builder-widget builder-widget-mae-headings"
                                                            data-id="078066a" data-element_type="widget"
                                                            data-widget_type="mae-headings.default">
                                                            <div class="builder-widget-container">
                                                                <div class="master-heading">



                                                                    <div class="sub-heading">Tell us a bit about your
                                                                        project and we will match you with the perfect
                                                                        designing.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="builder-column builder-col-50 builder-inner-column builder-element builder-element-d1ef872"
                                                    data-id="d1ef872" data-element_type="column">
                                                    <div class="builder-widget-wrap builder-element-populated">
                                                        <div class="builder-element builder-element-12e1eb8 builder-widget builder-widget-spacer"
                                                            data-id="12e1eb8" data-element_type="widget"
                                                            data-widget_type="spacer.default">
                                                            <div class="builder-widget-container">
                                                                <div class="builder-spacer">
                                                                    <div class="builder-spacer-inner"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="builder-element builder-element-8d0680a cf7-style-2 align-left builder-widget builder-widget-mae-contact-form-7"
                                                            data-id="8d0680a" data-element_type="widget"
                                                            data-widget_type="mae-contact-form-7.default">
                                                            <div class="builder-widget-container">
                                                                <div class="builder-shortcode byron-cf7-0">
                                                                    <div class="contact-form-wrapper" id="contact-form-wrapper">
                                                                        <div class="screen-reader-response">
                                                                            <p role="status" aria-live="polite"
                                                                                aria-atomic="true"></p>
                                                                            <ul></ul>
                                                                        </div>
                                                                        
                                                                        @if(session('success'))
                                                                            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                                                                                {{ session('success') }}
                                                                            </div>
                                                                        @endif
                                                                        
                                                                        @if(session('error'))
                                                                            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                                                                                {{ session('error') }}
                                                                            </div>
                                                                        @endif
                                                                        
                                                                        @if($errors->any())
                                                                            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                                                                                <ul style="margin: 0; padding-left: 20px;">
                                                                                    @foreach($errors->all() as $error)
                                                                                        <li>{{ $error }}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        @endif
                                                                        
                                                                        <form action="{{ route('upload-file.submit') }}"
                                                                            method="post" 
                                                                            enctype="multipart/form-data">
                                                                            @csrf

                                                                            <div class="input-wrap">
                                                                                <p><input
                                                                                            size="40" maxlength="400"
                                                                                            placeholder="Your Name"
                                                                                            value="{{ old('name') }}"
                                                                                            type="text" name="name"
                                                                                            required /><input
                                                                                            size="40" maxlength="400"
                                                                                            placeholder="Your Phone"
                                                                                            value="{{ old('phone') }}"
                                                                                            type="tel" name="phone"
                                                                                            required />
                                                                                </p>
                                                                            </div>
                                                                            <div class="input-wrap">
                                                                                <p><input
                                                                                            size="40" maxlength="400"
                                                                                            placeholder="Your Email"
                                                                                            value="{{ old('email') }}"
                                                                                            type="email" name="email"
                                                                                            required /><input
                                                                                            size="40" maxlength="400"
                                                                                            placeholder="Your Address"
                                                                                            value="{{ old('address') }}"
                                                                                            type="text" name="address"
                                                                                            required />
                                                                                </p>
                                                                            </div>
                                                                            <div class="input-wrap">
                                                                                <p><input
                                                                                            size="40" maxlength="400"
                                                                                            placeholder="Product Name"
                                                                                            value="{{ old('product_name') }}"
                                                                                            type="text" name="product_name"
                                                                                            required />
                                                                                </p>
                                                                            </div>
                                                                            <div class="input-wrap">
                                                                                <p><input
                                                                                            size="40" maxlength="400"
                                                                                            placeholder="Enter Captcha Code"
                                                                                            type="text" name="captcha"
                                                                                            required />
                                                                                </p>
                                                                            </div>
                                                                            <div class="captcha-row">
                                                                                <div class="captcha-img-container">
                                                                                    <img src="{{ route('captcha.generate') }}" id="captchaImg" alt="Captcha" style="width: 100%; height: 100%;">
                                                                                </div>
                                                                                <div class="refresh-btn" onclick="refreshCaptcha()" title="Refresh Captcha">
                                                                                    <i class="fas fa-sync-alt"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class=" cont-cstm-style">
                                                                                <p><input
                                                                                            size="40"
                                                                                            accept=".stp,.step,.obj,.stl"
                                                                                            type="file" name="file"
                                                                                            required /><br />
                                                                                    ( e.g. Step: Stl: Obj)
                                                                                </p>
                                                                            </div>
                                                                            <p><button type="submit"
                                                                                    class="builder-button" style="background-color: #da200b; color: white; border: none; padding: 12px 24px; cursor: pointer;">Submit</button>
                                                                            </p>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <div class="builder-element builder-element-eda66ab builder-widget builder-widget-spacer"
                                            data-id="eda66ab" data-element_type="widget"
                                            data-widget_type="spacer.default">
                                            <div class="builder-widget-container">
                                                <div class="builder-spacer">
                                                    <div class="builder-spacer-inner"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </article>

            </div>
        </div><!-- /#site-content -->

    </div><!-- /#content-wrap -->

</div><!-- /.main-content -->
@endsection
