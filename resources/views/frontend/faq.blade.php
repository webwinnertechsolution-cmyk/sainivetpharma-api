@extends('frontend.layouts.layout')

@section('title', $title ?? 'FAQ - Red-Labs')
@section('meta_description', $meta_description ?? 'Have questions about our services? Find the answers here.')

@push('styles')
<style>
/* Page Layout */
.builder-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.service-section {
    padding: 80px 0;
}

/* Typography */
.align-center { text-align: center !important; }
.main-heading {
    font-size: 36px;
    line-height: 1.2;
    margin-bottom: 20px;
    font-weight: 700;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}
.sub-heading {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 30px;
    color: #333;
    text-align: center;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}
.pre-heading {
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    color: #DA200B;
    margin-bottom: 10px;
    letter-spacing: 1px;
    text-align: center;
}

/* Accordion Styles */
.builder-accordion-item {
    margin-bottom: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    overflow: hidden;
}

.builder-tab-title {
    padding: 15px 20px;
    cursor: pointer;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.3s ease, color 0.3s ease;
}

.builder-tab-title:hover {
    background: #f9f9f9;
}

.builder-accordion-title {
    flex: 1;
    font-weight: 600;
    color: #333;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.3s ease;
}

.builder-accordion-item.builder-active .builder-accordion-title {
    color: #DA200B;
}

.builder-tab-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: #fafafa;
    padding: 0 20px;
}

.builder-accordion-item.builder-active .builder-tab-content {
    max-height: 2000px; 
    padding: 20px;
    border-top: 1px solid #e0e0e0;
}

/* Icons */
.builder-accordion-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
}

.builder-accordion-item.builder-active .builder-accordion-icon {
    color: #DA200B;
}

.builder-accordion-icon svg {
    width: 14px;
    height: 14px;
    fill: currentColor;
}

.builder-accordion-icon-opened { display: none; }
.builder-accordion-item.builder-active .builder-accordion-icon-closed { display: none; }
.builder-accordion-item.builder-active .builder-accordion-icon-opened { display: block; }

/* Grid Layout */
.faq-grid {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}
.faq-col {
    width: 50%;
    padding: 0 15px;
    box-sizing: border-box;
}

@media (max-width: 1024px) {
    .faq-col { width: 100%; margin-bottom: 20px; }
}
</style>
@endpush

@section('content')
<div id="content-wrap">
    <div id="site-content" class="site-content clearfix">
        <div id="inner-content" class="inner-content-wrap">
            <article class="page-content page type-page status-publish hentry">
                
                {{-- Intro --}}
                <div class="service-section" style="padding-bottom: 0px; padding-top: 130px;">
                    <div class="builder-container align-center">
                       
                        <div class="sub-heading">Have questions about our services? Find the answers here.</div>
                    </div>
                </div>

                {{-- 3D Printing FAQs --}}
                @if($printingFaqs->count() > 0)
                <section class="service-section" style="padding-top: 0;">
                    <div class="" style="padding: 0 15px;">
                        <div class="align-center mb-30" style="margin-bottom: 30px;">
                            <div class="pre-heading">3D Printing</div>
                            <h2 class="main-heading" style="font-size: 28px;">Frequently Asked Questions</h2>
                        </div>
                        
                        @php
                            $printingFaqsArray = $printingFaqs->toArray();
                            $half = ceil(count($printingFaqsArray) / 2);
                            $leftColumn = array_slice($printingFaqsArray, 0, $half);
                            $rightColumn = array_slice($printingFaqsArray, $half);
                        @endphp
                        
                        <div class="faq-grid">
                            <div class="faq-col">
                                @foreach($leftColumn as $index => $faq)
                                    @include('frontend.partials.faq-item', ['faq' => $faq, 'uniqueId' => 'printing-l-' . $index])
                                @endforeach
                            </div>
                            <div class="faq-col">
                                @foreach($rightColumn as $index => $faq)
                                    @include('frontend.partials.faq-item', ['faq' => $faq, 'uniqueId' => 'printing-r-' . $index])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                {{-- 3D Scanning FAQs --}}
                @if($scanningFaqs->count() > 0)
                <section class="service-section" style="background-color: #f7f7f7;">
                    <div class="" style="padding: 0 15px;">
                        <div class="align-center mb-30" style="margin-bottom: 30px;">
                            <div class="pre-heading">3D Scanning</div>
                            <h2 class="main-heading" style="font-size: 28px;">Frequently Asked Questions</h2>
                        </div>
                        
                        @php
                            $scanningFaqsArray = $scanningFaqs->toArray();
                            $half = ceil(count($scanningFaqsArray) / 2);
                            $leftColumn = array_slice($scanningFaqsArray, 0, $half);
                            $rightColumn = array_slice($scanningFaqsArray, $half);
                        @endphp
                        
                        <div class="faq-grid">
                            <div class="faq-col">
                                @foreach($leftColumn as $index => $faq)
                                    @include('frontend.partials.faq-item', ['faq' => $faq, 'uniqueId' => 'scanning-l-' . $index])
                                @endforeach
                            </div>
                            <div class="faq-col">
                                @foreach($rightColumn as $index => $faq)
                                    @include('frontend.partials.faq-item', ['faq' => $faq, 'uniqueId' => 'scanning-r-' . $index])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                {{-- Reverse Engineering FAQs --}}
                @if($engineeringFaqs->count() > 0)
                <section class="service-section">
                    <div class="" style="padding: 0 15px;">
                        <div class="align-center mb-30" style="margin-bottom: 30px;">
                            <div class="pre-heading">Reverse Engineering</div>
                            <h2 class="main-heading" style="font-size: 28px;">Frequently Asked Questions</h2>
                        </div>
                        
                        @php
                            $engineeringFaqsArray = $engineeringFaqs->toArray();
                            $half = ceil(count($engineeringFaqsArray) / 2);
                            $left = array_slice($engineeringFaqsArray, 0, $half);
                            $right = array_slice($engineeringFaqsArray, $half);
                        @endphp
                        
                        <div class="faq-grid">
                            <div class="faq-col">
                                @foreach($left as $index => $faq)
                                    @include('frontend.partials.faq-item', ['faq' => $faq, 'uniqueId' => 'eng-l-' . $index])
                                @endforeach
                            </div>
                            <div class="faq-col">
                                @foreach($right as $index => $faq)
                                    @include('frontend.partials.faq-item', ['faq' => $faq, 'uniqueId' => 'eng-r-' . $index])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                {{-- CNC Routing FAQs --}}
                @if($routingFaqs->count() > 0)
                <section class="service-section" style="background-color: #f7f7f7;">
                    <div class="" style="padding: 0 15px;">
                        <div class="align-center mb-30" style="margin-bottom: 30px;">
                            <div class="pre-heading">CNC Routing</div>
                            <h2 class="main-heading" style="font-size: 28px;">Frequently Asked Questions</h2>
                        </div>
                        
                        @php
                            $routingFaqsArray = $routingFaqs->toArray();
                            $half = ceil(count($routingFaqsArray) / 2);
                            $left = array_slice($routingFaqsArray, 0, $half);
                            $right = array_slice($routingFaqsArray, $half);
                        @endphp
                        
                        <div class="faq-grid">
                            <div class="faq-col">
                                @foreach($left as $index => $faq)
                                    @include('frontend.partials.faq-item', ['faq' => $faq, 'uniqueId' => 'routing-l-' . $index])
                                @endforeach
                            </div>
                            <div class="faq-col">
                                @foreach($right as $index => $faq)
                                    @include('frontend.partials.faq-item', ['faq' => $faq, 'uniqueId' => 'routing-r-' . $index])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                @endif
                
                <div class="service-section align-center" style="padding: 0px; padding-top:15px;">
                    <div class="builder-container">
                        <p class="sub-heading">If you have any other questions, please don't hesitate to <a href="{{ url('/contact') }}" style="color: #DA200B; font-weight: 700;">contact us.</a></p>
                    </div>
                </div>

            </article>
        </div>
    </div>
</div></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordionTitles = document.querySelectorAll('.builder-tab-title');
    
    accordionTitles.forEach(function(title) {
        title.addEventListener('click', function(e) {
            e.preventDefault();
            
            const item = this.parentElement;
            const content = item.querySelector('.builder-tab-content');
            
            // Toggle active state
            const isActive = item.classList.contains('builder-active');
            
            // Close other items in the same column/context (optional - here we just toggle self)
             if (isActive) {
                item.classList.remove('builder-active');
             } else {
                item.classList.add('builder-active');
             }
        });
    });
});
</script>
@endsection
