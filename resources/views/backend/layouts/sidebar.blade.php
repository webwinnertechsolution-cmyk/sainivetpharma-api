<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        
        {{-- Dashboard --}}
        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>


       <li class="nav-item">
            <a class="nav-link" href="{{ url('/announcement-bar') }}" ">
                <span class="menu-title">Announcement Bar </span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>

		 {{-- Header --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tabels" aria-expanded="false" aria-controls="forms">
                <span class="menu-title">Header</span>
				 <i class="menu-arrow"></i>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
            <div class="collapse" id="tabels">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/logo') }}">Logo</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="{{ url('/menus') }}">Menu</a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- HOME  --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#homeMenu" aria-expanded="false" aria-controls="homeMenu">
                <span class="menu-title">HOME</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
            <div class="collapse" id="homeMenu">
                <ul class="nav flex-column sub-menu">
				    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/slider') }}">slider</a>
                    </li>					
					<li class="nav-item">
                        <a class="nav-link" href="{{ url('/home-category') }}">Home Category</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="{{ url('/home-product-section') }}">Home Product </a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="{{ url('/promotional-banner') }}">Promotional Banner </a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="{{ url('/brand-section') }}">Brand Section</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="{{ url('/industries-we-serve') }}">Offer's</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="{{ url('/home-video-section') }}">Video Section</a>
                    </li>
                </ul>
            </div>
			
			
        </li>
		
		 
		{{-- About  --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
                <span class="menu-title">About Us</span>
				 <i class="menu-arrow"></i>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
            <div class="collapse" id="forms">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/offering') }}">About</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('/corevalues') }}">Teams</a>
                    </li>	
						 <li class="nav-item">
                        <a class="nav-link" href="{{ url('/experience-the-power') }}">Portfolio</a>
                    </li>
                </ul>
            </div>
        </li>

        
         <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/privacy-policy') }}" ">
                <span class="menu-title">Privacy Policy</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>

         <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/terms-of-service') }}" ">
                <span class="menu-title">Terms Of Services</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>

         <li class="nav-item">
            <a class="nav-link" href="{{ route('faq') }}" ">
                <span class="menu-title">Faq</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>


         <li class="nav-item">
            <a class="nav-link" href="{{ url('/gallery') }}" ">
                <span class="menu-title">Gallery</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>

         <li class="nav-item">
            <a class="nav-link" href="{{ url('/contact-us-page') }}" ">
                <span class="menu-title">Contact Us</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>

         <li class="nav-item">
            <a class="nav-link" href="{{ route('contact.submissions') }}" ">
                <span class="menu-title">Email Submissions</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>

		
		<li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#faqMenu" aria-expanded="false" aria-controls="faqMenu">
                <span class="menu-title">Other Pages</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
            <div class="collapse" id="faqMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/privacy-policy') }}">Privacy Policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/terms-of-service') }}">Terms Of Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/gallery') }}">Gallery</a>
                    </li>
                </ul>
            </div>
        </li>
		
			  <!--<li class="nav-item">-->
     <!--       <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">-->
     <!--           <span class="menu-title">STORE</span>-->
     <!--           <i class="menu-arrow"></i>-->
     <!--           <i class="mdi mdi-lock menu-icon"></i>-->
     <!--       </a>-->
     <!--       <div class="collapse" id="auth">-->
     <!--           <ul class="nav flex-column sub-menu">-->
     <!--               <li class="nav-item">-->
     <!--                   <a class="nav-link" href="{{ url('/blank') }}">PRODUCTS</a>-->
     <!--               </li>-->
     <!--               <li class="nav-item">-->
     <!--                   <a class="nav-link" href="{{ url('/login') }}">SHOPS</a>-->
     <!--               </li>-->
                   
     <!--           </ul>-->
     <!--       </div>-->
     <!--   </li>-->
		
		
		
		<li class="nav-item">
		  <a class="nav-link" data-bs-toggle="collapse" href="#aboutUs" aria-expanded="false" aria-controls="aboutUs">
			<span class="menu-title">Product</span>
			<i class="menu-arrow"></i>
			<i class="mdi mdi-lock menu-icon"></i>
			
		  </a>

		  <div class="collapse" id="aboutUs">
			<ul class="nav flex-column sub-menu">

			  <!-- Product -->
			  
			  
			  <li class="nav-item">
				<a class="nav-link" href="{{ url('/product/create') }}">Add Product</a>
			  </li>
                <li class="nav-item">
				<a class="nav-link" href="{{ url('/product') }}">Product List</a>
			  </li>
			  <!-- CORE VALUES (nested dropdown) -->
			
			  <li class="nav-item">
			  <!--
				<a class="nav-link" data-bs-toggle="collapse" href="#coreValuesMenu" aria-expanded="false">
				  <span class="menu-title">Add Product</span>
				  <i class="menu-arrow"></i>
				</a>
				
				
				<div class="collapse" id="coreValuesMenu">
				  <ul class="nav flex-column sub-menu">
					<li class="nav-item">
					  <a class="nav-link" href="{{ url('/corevalues') }}">Add Product Tag</a>
					</li>
				  </ul>
				</div>
			  </li>
			   -->
			<li class="nav-item">
				<a class="nav-link" href="{{ url('/product-category') }}">Add Product Category</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="{{ url('/product-tag') }}">Add Product Tag</a>
			  </li>
			  
			  
			  
			 
			</ul>
		  </div>
		</li>
				
		<li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title">Blogs</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                   
                   <li class="nav-item">
                <a class="nav-link" href="{{ route('blog') }}">All Blogs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('blog.category') }}">Blog Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('blog.tag') }}">Blog Tags</a>
            </li>
                </ul>
            </div>
        </li>
		
		
		
		
		
		
		
		
	<!--	<li class="nav-item">
            <a class="nav-link" href="{{ url('/admin-blog') }}" >
                <span class="menu-title">BLOG</span>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
        </li> -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.pageseo.index') }}" >
                <span class="menu-title">Seo Manager </span>
                <i class="mdi mdi-search-web menu-icon"></i>
            </a>
        </li>
		{{-- CONTACT Menu with Submenu --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#contactMenu" aria-expanded="false" aria-controls="contactMenu">
                <span class="menu-title">CONTACT</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
            <div class="collapse" id="contactMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/home-contact') }}">Contact Section</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.submissions') }}">
                            <i class="mdi mdi-email-multiple"></i> Submissions
                        </a>
                    </li>
                </ul>
            </div>
        </li>
	

	<!--
	<li class="nav-item">
            <a class="nav-link" href="{{ url('/footermain') }}" ">
                <span class="menu-title">FOOTER</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>
	-->
	
		<li class="nav-item">
            <a class="nav-link" href="{{ url('/footer-new') }}" ">
                <span class="menu-title">Footer</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>
        {{-- Forms --}}
        
        
		
		<!--
        {{-- Charts --}}
       <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
               
          
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    
                </ul>
            </div>
        </li>
        
        {{-- Tables --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <span class="menu-title"></span>
              
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                  
                </ul>
            </div>
        </li>
        
        {{-- User Pages --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title"></span>
               
              
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                   
                </ul>
            </div>
        </li>
        
        {{-- Documentation --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/documentation') }}">
            
            </a>
        </li>
        
        {{-- Logout --}}
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               
            </a>
        </li>
		
		-->
    </ul>
</nav>



<style>

/* Start Radio inputs */
input[name="menu"],
input[name="menu2"],
input[name="menu3"],
input[name="dropdowns"]{
   display: none;
}

/* Checkbox ko Radio inputs ki tarah handle karo */
input[type=radio]:checked ~ ul {
   display: block;
}

#uparrow,
#downarrow {
   float: right;
}

input[name=dropdowns]:checked ~ label > #downarrow {
   display: none;
}

input[name=dropdowns]:checked ~ label > #uparrow {
   display: inline-block;
}

input[name=dropdowns]:not(:checked) ~ label > #uparrow {
   display: none;
}

.drop {
   display: none;
}

.drop li {
   display: block;
   font-size: 14px;
   padding-left: 20px;
}

label.sdsd {
    display: flex;
    width: auto!important;
    justify-content: space-between;
    cursor: pointer;
}

ul.drop {
    margin-block: 12px;
    color: white!important;
    padding-left: 0;
}

ul.drop li {
    color: white!important;
}
.sdsd span.menu-title.nav-link {
    width: 90%;
}
.sidebar .nav {
    background: #30674D;
    Color: white;
}
.navbar {
    background: #30674d;
}
.navbar .navbar-brand-wrapper {
    background: #30674d;
}
.sidebar {
    background: #30674d;
    padding-top: 36px;
}
.sidebar .nav .nav-item.active {
    background: #30674D;
    Color: white;
}
.sidebar .nav .nav-item:hover {
    background: #30674D;
}
a.nav-link {
    border-top: 1px solid #8f94912e;
}
.sidebar .nav .nav-item.active > .nav-link .menu-title {
    color: #ffffff;
    font-family: "ubuntu-medium", sans-serif;
}
.sidebar .nav .nav-item.active > .nav-link i {
    color: #ffffff;
}
.sidebar .nav .nav-item:hover {
    background: rgb(26 92 46 / 22%);
}
.sidebar .nav.sub-menu .nav-item .nav-link:hover {
    color: #ffffff;
	background: rgb(26 92 46 / 22%);
}
    .sidebar .nav {
    background: #ff000000;
    Color: white;
}
    .sidebar {
    background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
    padding-top: 36px;
}
    .sidebar .nav .nav-item.active {
    background: #30674d00;
    Color: white;
}
    .sidebar .nav .nav-item.active {
    background: #30674d00!important;
    Color: white;
}
    .sidebar .nav.sub-menu .nav-item .nav-link.active {
    color: #fff!important;
    background: transparent;
}
    .sidebar .nav .nav-item:hover {
    background: rgb(26 92 46 / 0%);
}
    .sidebar  a.nav-link {
    font-family: 'Nunito', sans-serif;
    text-transform: capitalize;
    font-size: 22px!important;
}
    .sidebar .nav .nav-item .nav-link .menu-title {
    color: #ffffff;
    display: inline-block;
    font-size: 14px;
    line-height: 1;
    vertical-align: middle;
    white-space: normal;
}
    .sidebar .nav .nav-item .nav-link {
    padding-bottom: 10px!important;
    padding-top: 10px!important;
}
    .sidebar .nav .nav-item .nav-link i.menu-icon {
    font-size: 14px!important;
    color: #fff!important;
}
</style>
