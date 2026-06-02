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
                <span class="menu-title">ANNOUNCEMENT BAR</span>
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
		
		
		
        {{-- HOME Menu with Submenu --}}
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
					
					
					<!--
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/what-we-do') }}">What we do</a>
                    </li>
					-->						
								

								
							<!-- First Dropdown - Our Services -->
						<!--
						<li class="nav-item">
							<input type="radio" id="services-dropdown" name="dropdowns">
							<label for="services-dropdown" class="sdsd">
								<span class="menu-title nav-link">Our Services</span>
								<i class="menu-arrow"></i>
								<i class="mdi mdi-lock menu-icon"></i>
							</label>
							<ul class="drop">
								<!-- <li> -->
								<!--
									<input type="radio" id="regularchat" name="menu">
									<label for="regularchat">
										<a class="nav-link" href="{{ url('/ourservicemain') }}">
											Our Services Section</a>
									</label>
								</li> 
								<li>
									<input type="radio" id="chatbox" name="menu">
									<label for="chatbox">
										<a class="nav-link" href="{{ url('/ourservice') }}">Our Services List</a>
									</label>
								</li>
							</ul>
						</li>
                          -->

						<!-- First Dropdown - Our Services -->
						<!--
						<li class="nav-item">
							<input type="radio" id="services-dropdown" name="dropdowns">
							<label for="services-dropdown" class="sdsd">
								<span class="menu-title nav-link">Home Product Section</span>
								<i class="menu-arrow"></i>
								<i class="mdi mdi-lock menu-icon"></i>
							</label>
							<ul class="drop">
								<!-- <li>-->
								<!--
									<input type="radio" id="regularchat" name="menu">
									<label for="regularchat">
										<a class="nav-link" href="{{ url('/ourservicemain') }}">
											Our Services Section</a>
									</label>
								</li>
								<li>
									<input type="radio" id="chatbox" name="menu">
									<label for="chatbox">
										<a class="nav-link" href="{{ url('/home-product-section') }}">Product section</a>
									</label>
								</li>
							</ul>
						</li>
						
						  -->

						<!-- Second Dropdown - Our Work Process -->
						
						<!--
						<li class="nav-item">
							<input type="radio" id="workprocess-dropdown" name="dropdowns">
							<label for="workprocess-dropdown" class="sdsd">
								<span class="menu-title nav-link">Our Work Process</span>
								<i class="menu-arrow"></i>
								<i class="mdi mdi-lock menu-icon"></i>
							</label>
							<ul class="drop">
							-->
								<!-- <li>
									<input type="radio" id="workprocess-main" name="menu2">
									<label for="workprocess-main">
										<a class="nav-link" href="{{ url('/ourworkprocessmain') }}">
											Our Work Section</a>
									</label>
								</li> -->
								
								<!--
								<li>
									<input type="radio" id="workprocess-list" name="menu2">
									<label for="workprocess-list">
										<a class="nav-link" href="{{ url('/our-work-process') }}">Our Work List</a>
									</label>
								</li>
							</ul>
						</li>
                        

						<li class="nav-item">
							<input type="radio" id="industries-dropdown" name="dropdowns">
							<label for="industries-dropdown" class="sdsd">
								<span class="menu-title nav-link">Offer's</span>
								<i class="menu-arrow"></i>
								<i class="mdi mdi-lock menu-icon"></i>
							</label>
							<ul class="drop">
								<!-- <li>
									<input type="radio" id="industries-main" name="menu3">
									<label for="industries-main">
										<a class="nav-link" href="{{ url('/industriesweservemain') }}">
											Industries Section</a>
									</label>
								</li> -->
								<li>
									<input type="radio" id="industries-list" name="menu3">
									<label for="industries-list">
										<a class="nav-link" href="{{ url('/industries-we-serve') }}">Exclusive Offer</a>
									</label>
								</li>
							</ul>
						</li> -->

                </ul>
            </div>
			
			
        </li>
		
		 
		
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
                <span class="menu-title">About Us</span>
				 <i class="menu-arrow"></i>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
            <div class="collapse" id="forms">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/offering') }}">ABOUT</a>
                    </li>
					
					
					<li class="nav-item">
							<input type="radio" id="corevalues-dropdown" name="dropdowns">
							<label for="corevalues-dropdown" class="sdsd">
								<span class="menu-title nav-link">CORE VALUES</span>
								<i class="menu-arrow"></i>
								<i class="mdi mdi-lock menu-icon"></i>
							</label>
							<ul class="drop">
								<!-- <li>
									<input type="radio" id="corevalues-main" name="menu3">
									<label for="corevalues-main">
										<a class="nav-link" href="{{ url('/corevaluesmain') }}">
											Core Section</a>
									</label>
								</li> -->
								<li>
									<input type="radio" id="corevalues-list" name="menu3">
									<label for="corevalues-list">
										<a class="nav-link" href="{{ url('/corevalues') }}">Core List</a>
									</label>
								</li>
							</ul>
						</li>
						
						 <li class="nav-item">
                        <a class="nav-link" href="{{ url('/experience-the-power') }}">PORTFOLIO</a>
                    </li>
                </ul>
            </div>
        </li>
		
		
        {{-- Icons --}}
        <!-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">SERVICES</span>
				 <i class="menu-arrow"></i>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                   <li class="nav-item">
                        <a class="nav-link" href="{{ url('/threedscanning') }}">3D SCANING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ('/threedprinting') }}">3D PRINTING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ('/plasticfabrication') }}">PLASTIC FABRICATION</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ('/routercutting') }}">ROUTER CUTTING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ('/prototyping') }}">PROTOTYPING</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="{{ ('/reverseengineering') }}">REVERSE ENGINEERING</a>
                    </li>
                </ul>
            </div>
        </li> -->
       
      <!--	   
		<li class="nav-item">
            <a class="nav-link" href="{{ url('/industry') }}" ">
                <span class="menu-title">INDUSTRIES</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>
		-->
		
<!-- 		
		<li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#logout" aria-expanded="false" aria-controls="logout">
                <span class="menu-title">SERVICES</span>
				 <i class="menu-arrow"></i>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
            <div class="collapse" id="logoutlogout">
                <ul class="nav flex-column sub-menu">
                   <li class="nav-item">
                        <a class="nav-link" href="{{ url('/threedscanning') }}">3D SCANING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ('/threedprinting') }}">3D PRINTING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ('/plasticfabrication') }}">PLASTIC FABRICATION</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ('/routercutting') }}">ROUTER CUTTING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ ('/prototyping') }}">PROTOTYPING</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="{{ ('/reverseengineering') }}">REVERSE ENGINEERING</a>
                    </li>
                </ul>
            </div>
        </li> -->
		
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
				<a class="nav-link" href="{{ url('/product') }}">Add Product</a>
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
				<a class="nav-link" href="{{ url('/product-tag') }}">Add Product Tag</a>
			  </li>
			  
			  <li class="nav-item">
				<a class="nav-link" href="{{ url('/product-category') }}">Add Product Category</a>
			  </li>
			  
			 
			</ul>
		  </div>
		</li>
				
		<li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title">BLOG</span>
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
                <span class="menu-title">SEO MANAGER</span>
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
                <span class="menu-title">FOOTER</span>
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
</style>
