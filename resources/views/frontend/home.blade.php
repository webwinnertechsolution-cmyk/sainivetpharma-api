@extends('frontend.layouts.layout')

@section('body_class', 'home-page site-layout-full-width header-fixed')

@section('content')

    <div id="main-content" class="site-main clearfix">
        
        {{-- Slider Section (formerly part of body_intro) --}}
        @include('frontend.components.slider')

			@include('frontend.components.homelogo')


 {{-- ✅ HOME CATEGORIES SECTION - yeh add karo jahan chahein --}}
        @include('frontend.components.home-categories')
		
        {{-- What We Do Section 
        @include('frontend.components.what-we-do') --}}


		
        {!! render_product_section(1) !!}



        {{-- Our Services Section 
        @include('frontend.components.our-services') --}}
		
		@include('frontend.components.all-products')
		
{{-- ✅ Brands Section --}}
@include('frontend.components.brands')

	{{-- 	{!! render_product_section(2) !!} --}}

        {{-- Our Work Process Section 
        @include('frontend.components.our-work-process') --}}

   {{-- Industries We Serve Section 
        @include('frontend.components.industries-we-serve') --}}
		

{{-- @include ke upar yeh pass karo --}}
@include('instagram', ['posts' => $instaPosts])
		
{{-- Articles / Blog Section --}}
@include('frontend.components.home-blog')



     


        {{-- Contact Us Section --}}
        @include('frontend.components.home-contact') 

        {{-- Next sections will appear here --}}
        
    </div>

@endsection
