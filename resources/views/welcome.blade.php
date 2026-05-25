<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fixed Navbar with Swiper</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  
  
   <!-- Custom CSS --> 
  <link rel="stylesheet" href="index.css"/>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


 <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  
  <style>
 /* Navbar Logo */
    .navbar-brand img {
    height: 125px;
}

   
    /* Initially transparent navbar */
    .navbar {
    background-color: #07022e00 !important;
    transition: background-color 0.4s ease, box-shadow 0.4s ease;
}
   .ms-auto {
    margin-left: auto!important;
    margin-right: 150px;
    gap: 8px;
}
a.nav-link {
    font-size: 16px;
    font-weight: 400;
}
    /* Background & shadow when scrolled */
 .navbar.scrolled {
    background-color: #030f27 !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

    /* Dropdown hover color */
    .dropdown-menu a.dropdown-item:hover {
      background-color: #007bff;
      color: white;
    }

    /* Submenu styling */
    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -1px;
      display: none;
    }

    /* Show submenu on hover */
    .dropdown-submenu:hover .dropdown-menu {
      display: block;
    }

    /* Default nav link color */
    .nav-link {
    color: #fff !important;
    transition: color 0.3s ease;
}

    .nav-link:hover {
      color:rgb(255 255 255 / 86%) !important;
	  text-decoration:underline red;
	  transition: text-decoration 0.3s ease;
    }
     .fixed-top {
    position: fixed;
    top: -20px;
    right: 0;
    left: 0;
    z-index: 1030;
}
	
/* ✅ Swiper Styles */
.swiper {
    width: 100%;
    height: 150vh;
    margin-top: 0;
    position: relative;
    z-index: 0;
    background-image: url('bg-image-24.jpg');
    margin-bottom: 38px;
}

.swiper-slide {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  color: white;
  text-align: center;
  background-size: cover;
  background-position: center;
  position: relative;
}

.slide-1 { background-image: url('backend/assets/images/slide-background1.jpeg'); }
.slide-2 { background-image: url('slide-background2.jpeg'); }
.slide-3 { background-image: url('slide-background3.png'); }

/* ✅ Slide 4 video background */
.slide-4 video {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  top: 0;
  left: 0;
  z-index: 0;
}

/* Overlay for text readability */
.overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  z-index: 1;
}

.slide-content {
    position: relative;
    z-index: 2;
    text-align: left;
    margin-right: auto;
    left: 200px;
    top: -125px;
}
.mb-3 {
    margin-bottom: 0rem!important;
}
.text-5xl {
    font-size: 2rem;
    font-weight: 400;
    font-family: 'Inter', sans-serif;
}
h1.text-6xl.mb-3.animate__zoomIn {
    color: #DA200B;
    font-size: 72px;
    font-weight: 800;
}
span.lab-text {
    color: #ffffff;
}

.text-lg {
    font-size: 25px;
    line-height: 1.75rem;
    text-align: justify;
    margin: 25px  0px 15px;
}
.btn-warning {
    --bs-btn-color: #ffffff;
    --bs-btn-bg: #FD4539;
    --bs-btn-border-color: #fd4536;
    --bs-btn-hover-color: #fffff;
    --bs-btn-hover-bg: #FD4539;
    --bs-btn-hover-border-color: #FD4539;
    --bs-btn-focus-shadow-rgb: 217,164,6;
    --bs-btn-active-color: #000;
    --bs-btn-active-bg: #FD4539;
    --bs-btn-active-border-color: #FD4539;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #000;
    --bs-btn-disabled-bg: #FD4539;
    --bs-btn-disabled-border-color: #FD4539;
}
a.btn.btn-warning.rounded-pill.px-4.py-2.animate__pulse.animate__infinite {
    border-radius: 5px !important;
}
a.btn.btn-warning.rounded-pill.px-4.py-2.animate__pulse.animate__infinite:hover {
    transition: auto;
    transform: translateX(10px);
	color:#fffff !important;
}
    /* ---- General Section Padding ---- */
    .p-b90 { padding-bottom: 15px; }
    .p-t120 { padding-top: 15px; }
    .m-b30 { margin-bottom: 30px; }

    /* ---- Section Heading ---- */
    .section-head.center.wt-small-separator-outer {
      margin-bottom: 15px;
      text-align: center;
    }
	.section-full.p-t120.p-b90 {
    margin-top: 70px;
}
    .section-head { position: relative; }
    .site-text-primary, .wt-small-separator { color: #ea130e; }
    .wt-small-separator {
      font-family: "Heebo", sans-serif;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding-right: 40px;
      font-size: 26px;
      line-height: 26px;
      margin-bottom: 15px;
      position: relative;
      display: inline-block;
      font-weight: 700;
    }
    .section-head.center .wt-small-separator div.sep-leaf-left:before,
    .section-head.center .wt-small-separator div.sep-leaf-left:after {
      background-color: #ea130e;
    }
    .section-head.center .wt-small-separator div.sep-leaf-left:before {
      right: -20px;
      width: 10px;
    }
    .section-head.center .wt-small-separator div.sep-leaf-left:after {
      right: -27px;
      width: 4px;
    }
    .section-head.center.wt-small-separator-outer h2 {
      max-width: 630px;
      margin: 0 auto;
    }
    h2 {
      font-size: 60px;
      font-weight: 700;
      font-family: "Poppins", sans-serif;
      color: #000;
    }

    /* ---- Service Card ---- */
   .service-icon-box-two {
    position: relative;
    padding: 5px 10px;
    border: 1px solid #e7e7e7;
    overflow: hidden;
    background: #fff;
    height: 340px;
    transition: all 0.4s ease;
}
    .service-icon-box-two .wt-icon-box-wraper { margin-bottom: 0px; }
    .icon-xl.inline-icon { width: auto; text-align: center !important; }
    .icon-xl i { font-size: 38px; line-height: 80px; }
    .wt-icon-box-wraper:after { content: ""; display: table; clear: both; }

   .service-icon-box-two .service-icon-box-title .wt-title {
    margin-bottom: 15px;
    /* padding-right: 60px; */
    font-size: 20px;
    font-weight: 700;
    text-align: center;
}

    /* ---- Hover Image Effect ---- */
    .service-icon-box-two::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-size: cover;
      background-position: center;
      opacity: 0;
      transform: scale(1.1);
      transition: all 0.6s ease;
      z-index: 0;
    }

    .service-icon-box-two::after {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      opacity: 0;
      transition: all 0.6s ease;
      z-index: 1;
    }

    /* Assign Different Images per Card */
    .hover-img1::before { background-image: url('image-hover1.jpg'); }
   .hover-img2::before { background-image: url('image-hover2.jpg'); }
    .hover-img3::before { background-image: url('image-hover3.jpg'); }
	.hover-img4::before { background-image: url('image-hover4.jpeg'); }
	.hover-img5::before { background-image: url('image-hover5.jpg'); }

    /* Text above image */
   .service-icon-box-two * {
    position: relative;
    z-index: 2;
    transition: color 0.3s ease;
    margin-bottom: 20px;
}	
    .service-icon-box-two:hover::before {
      opacity: 1;
      transform: scale(1);
    }
    .service-icon-box-two:hover::after {
      opacity: 1;
    }
    .service-icon-box-two:hover h4,
    .service-icon-box-two:hover p,
    .service-icon-box-two:hover a {
      color: #fff !important;
    }
    .service-icon-box-two:hover .icon-cell {
      color: #fff;
    }

    /* ---- Read More Link ---- */
    .site-button-link {
      text-transform: uppercase;
      font-weight: 600;
      transition: 0.3s;
    }
    .site-button-link:hover {
      text-decoration: underline;
    }
	.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: nowrap;
    margin-top: calc(-1 * var(--bs-gutter-y));
    margin-right: calc(-.5 * var(--bs-gutter-x));
    margin-left: calc(-.5 * var(--bs-gutter-x));
}
@media (min-width: 992px) {
    .col-lg-4 {
        flex: 0 0 auto;
        width: 20%;
    }
}
a.site-button-link.site-text-primary {
    text-decoration: none;
    color: #000 !important;
    margin-left: 35px;
}
 section.contact-section {
    position: relative;
    width: 100%;
    background: url('contact-bg-img.jpg') center/cover no-repeat;
    color: #fff;
    padding: 80px 0;
}

    section.contact-section::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(10, 25, 50, 0.8);
      z-index: 1;
    }

    .contact-container {
      position: relative;
      z-index: 2;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: auto;
      padding: 0 40px;
    }

    .contact-info {
      flex: 1;
      min-width: 300px;
      margin-right: 50px;
    }

    .contact-info h2 {
      font-size: 30px;
      margin-bottom: 20px;
      color: #fff;
    }

   .contact-info p {
    font-size: 15px;
    color: red;
    margin-bottom: 15px;
}
    .contact-info a {
      color: #ff2e2e;
      text-decoration: none;
      font-weight: bold;
    }

    .contact-form {
    flex: 1;
    min-width: 320px;
    /* background: rgba(255, 255, 255, 0.1); */
    padding: 30px;
    border-radius: 8px;
    backdrop-filter: blur(5px);
}

    .form-row {
      display: flex;
      gap: 15px;
      margin-bottom: 15px;
    }

    .form-row input {
      flex: 1;
    }

    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 12px 15px;
      border: none;
      outline: none;
      border-radius: 4px;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      font-size: 14px;
    }

    .contact-form input::placeholder,
    .contact-form textarea::placeholder {
      color: #ddd;
    }

    .contact-form button {
      background: #ff2e2e;
      color: #fff;
      padding: 12px 30px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 15px;
      transition: 0.3s;
    }

    .contact-form button:hover {
      background: #e00000;
    }

    @media (max-width: 1024px) {
      .contact-container {
        flex-direction: column;
      }
      .contact-info {
        margin-right: 0;
        margin-bottom: 40px;
      }
      .form-row {
        flex-direction: column;
      }
    }
	i.fa-solid.animate-phn.fa-phone {
    opacity: 0;
    transition: 0.3s ease;
    transform: translateX(1px);
}

i.fa-regular.animate-eml.fa-envelope{ 
	opacity: 0;
    transition: 0.3s ease;
    transform: translateX(1px);
	}
	.card-wrapper{
    max-width: 1100px;
    margin: 0 60px 35px;
    padding: 20px 10px;
    overflow: hidden;
}

.card-list .card-item{
    list-style: none;
}

.card-list .card-item .card-link{
    user-select: none;
    display: block;
    background: #fff;
    padding: 18px;
    border-radius: 12px;
    text-decoration: none;
    border: 2px solid transparent;
    box-shadow: 0 10px 10px rgba(0, 0, 0, 0.05);
    transition: 0.2s ease;
}

.card-list .card-item .card-link:active{
    cursor: grabbing;
}

.card-list .card-item .card-link:hover{
    border-color: #5372f0;
}

.card-list .card-link .card-image{
    width: 100%;
    aspect-ratio: 16 / 9;
    object-fit: cover;
    border-radius: 10px;
}

.card-list .card-link .badge{
    color: blue;
    margin: 16px 0 18px;
    padding: 8px 16px;
    font-weight: 500;
    font-size: 0.95rem;
    background: #dde4ff;
    width: fit-content;
    border-radius: 50px;
}

.card-list .card-link .card-title{
    font-size: 16px;
    color: #000;
    font-weight: 100;
}

.card-list .card-link .card-button{
    height: 35px;
    width: 35px;
    color: #5372f0;
    border-radius: 50%;
    margin: 30px 0 5px;
    background: none;
    cursor: pointer;
    transform: rotate(-45deg);
    border: 2px solid #5382f0;
    transition: 0.4s ease;
}

.card-list .card-link:hover .card-button{
    color: #fff;
    background: #5372f0;
}

.card-wrapper .swiper-pagination-bullet{
    height: 13px;
    width: 13px;
    opacity: 0.5;
    background: #5372f0;
}

.card-wrapper .swiper-pagination-bullet-active{
    opacity: 1;
}

.card-wrapper .swiper-slide-button{
    color: #5372f0;
    margin-top: -35px;
} 

@media screen and (max-width: 1024px){
    .card-wrapper{
        margin: 0 10px 25px;
    }

    .card-wrapper .swiper-slide-button{
        display: none;
    }
}

.contact-form input, .contact-form textarea {
    width: 100%;
    padding: 12px 15px;
    border: none;
    outline: none;
    border-radius: 4px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    font-size: 14px;
    margin-bottom: 10px;
}


/* ======= General ======= */
.industries {
  font-size: 36px;
  font-weight: 700;
  margin-bottom: 40px;
}

.serve {
  color: #ff3c00;
}

/* Image container */
.service-img-box {
  position: relative;
  overflow: hidden;
  border-radius: 15px;
  cursor: pointer;
}

.slider-hover {
  width: 100%;
  height: 350px;
  object-fit: cover;
  border-radius: 15px;
  transition: transform 0.4s ease;
}

/* Text overlay */
.image-overlay {
    position: absolute;
    bottom: -45px;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(180deg, transparent 50%, rgba(0, 0, 0, 0.85));
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: flex-start;
    padding: 20px;
    border-radius: 15px;
    transition: all 0.6s ease;
}

/* Text styling */
.badge {
  background: rgba(255, 255, 255, 0.25);
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 14px;
  margin-bottom: 8px;
}

.card-title {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
  line-height: 1.3;
}

/* Hover animation */
.service-img-box:hover .slider-hover {
  transform: scale(1.1);
  filter: brightness(0.8);
}

.service-img-box:hover .image-overlay {
  bottom: 0;
}



.bg-dark {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-dark-rgb),var(--bs-bg-opacity))!important;
    margin-top: 0px;
}
.col-md-5 {
    margin-top: 50px;
}
.footer {
    background-color: #01001c !important;
    color: #ccc;
    font-family: 'Poppins', sans-serif;
}

.vl {
    border-left: 1px solid #ffffff;
    height: 100%;
    width: 0;
}
.justify-content-center {
    justify-content: center!important;
    margin-top: 15px;
}
..col-md-2 {
    flex: 0 0 auto;
    width: 16.66666667%;
    height: 90px;
    margin-top: 32px;
}

.footer h5 {
    color: #fff;
    letter-spacing: 1px;
    margin-left: 20px;
}
.bi-geo-alt-fill::before {
    content: "\f3e7";
    font-size: 26px;
}
.mb-2 {
    margin-bottom: .5rem!important;
    margin-left: -12px;
}
.col-md-5 {
    flex: 0 0 auto;
    width: 41.66666667%;
    margin-top: 30px;
}
.footer .text-danger {
  color: #e63946 !important;
}
.text-center {
    text-align: left!important;
    margin-left: 80px;
}
span.text-danger copy {
    font-weight: 600;
}

  </style>
</head>

<body>

  <!-- ✅ Responsive Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="png-01-1.png" alt="logo">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item">
            <a class="nav-link" href="file:///C:/Users/dhima/Downloads/index.html">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="file:///C:/Users/dhima/Downloads/about%20us.html">About Us</a>
          </li>

          <!-- Services Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Services
            </a>
            <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
              <li><a class="dropdown-item" href="#">3D SCANNING</a></li>
              <li><a class="dropdown-item" href="#">3D PRINTING</a></li>
              <li><a class="dropdown-item" href="#">PLASTIC FABRICATION</a></li>
              <li><a class="dropdown-item" href="#">ROUTER CUTTING</a></li>
              <li><a class="dropdown-item" href="#">PROTOTYPING</a></li>
              <li><a class="dropdown-item" href="#">REVERSE ENGINEERING</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">INDUSTRIES</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">FAQ's</a>
          </li>

          <!-- Store Dropdown with Submenu -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="storeDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              STORE
            </a>
            <ul class="dropdown-menu" aria-labelledby="storeDropdown">
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Products</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Submenu-1</a></li>
                  <li><a class="dropdown-item" href="#">Submenu-2</a></li>
                </ul>
              </li>
              <li><a class="dropdown-item" href="#">SHOP</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">BLOG</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="file:///C:/Users/dhima/Downloads/contact.html#">CONTACT</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="white-line"></div>


  <!-- ✅ Swiper -->
  <div class="swiper mySwiper">
    <div class="swiper-wrapper">

      <!-- Slide 1 -->
     <div class="swiper-slide slide-1">
        <div class="overlay"></div>
        <div class="slide-content animate__animated animate__fadeInDown">
          <h1 class="text-5xl mb-3 animate__zoomIn">WELCOME TO </h1> 
		  <h1 class="text-6xl mb-3 animate__zoomIn">RED-<span class="lab-text">LABS</span></h1> 
          <p class="text-lg mb-4 animate__fadeInUp">INNOVATIVE ENGINEERED <br> MATERIALS FEATURING HIGH <br> PERFORMANCE PLASTICS AND <br> ADVANCED MANUFACTURING</p>
          <a href="#" class="btn btn-warning rounded-pill px-4 py-2 animate__pulse animate__infinite">Get a Quote <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
	  
	  
      <!-- Slide 2 -->
      <div class="swiper-slide slide-2">
        <div class="overlay"></div>
        <div class="slide-content animate__animated animate__fadeInDown">
         <h1 class="text-6xl mb-3 animate__zoomIn">RED-<span class="lab-text">LABS</span></h1>
          <p class="text-lg mb-4 animate__fadeInUp">IN STOCK AND SUPPLY CUT TO <br>SIZE SHEETS FOR ACRYLIC, <br> NYLONS, POLYURETHANE HDPE,<br> UHMWPE</p>
          <a href="#" class="btn btn-warning rounded-pill px-4 py-2 animate__pulse animate__infinite">Get a Quote <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="swiper-slide slide-3">
        <div class="overlay"></div>
        <div class="slide-content animate__animated animate__fadeInDown">
          <h1 class="text-6xl mb-3 animate__zoomIn">RED-<span class="lab-text">LABS</span></h1>
          <p class="text-lg mb-4 animate__fadeInUp">OPTIMAL MACHINE GUARDING <br>SOLUTIONS COMPLYING WITH <br> INDUSTRY STANDARDS</p>
          <a href="#" class="btn btn-warning rounded-pill px-4 py-2 animate__pulse animate__infinite">Get a Quote <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- ✅ Slide 4 with autoplay video -->
      <div class="swiper-slide slide-4">
        <video autoplay muted loop playsinline>
          <source src="slider-video-1.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
        <div class="slide-content animate__animated animate__fadeInUp">
          <h1 class="text-6xl mb-3 animate__zoomIn">RED-<span class="lab-text">LABS</span></h1>
          <p class="text-lg mb-4 animate__fadeInUp">POWERED BY RED ENGINEE <br>PRODUCT DESIGN, 3D <br>SCANNING & 3D PRINTING IN MACKAY BRISBANE</p>
          <a href="#" class="btn btn-warning rounded-pill px-4 py-2 animate__pulse animate__infinite">Get a Quote <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

    </div>
  </div>


<section class="what-we-do">
    <div class="container">
	 <div class="content-what">
      <div class="row">
        <!-- Left: Image -->
		 <div class="image-box col-md-6 mb-4 mb-md-0">
         <div class="img-box-bg"></div>
          <div class="fancy-img-bg">
           <img src="red-labs-img.jpeg" alt="RED-LABS">
         </div>
       </div>
	
        <!-- Right: Text -->
        <div class="col-md-6">
          <h2 class="what inter"> What <strong>we do</strong></h2>
          <p class="at">At <span class="red">RED-</span><span class="labs">LABS PLASTICS</span>, we provide advanced manufacturing <br>services and engineered products with a focus on plastic fabrication <br> using a variety of composite materials. Our in-house capabilities <br> include designing, CNC router cutting, scanning, 3D printing and <br> product design.We integrate creativity and innovation into our <br> products, utilising advanced fabrication and design techniques to  <br> deliver exceptional, customised solutions tailored to the unique needs <br> of our clients.</p>
          <button class="btn-read-more">READ MORE </button>
		</div>
      </div>
    </div>
  </section>
  
   

  <div class="section-full p-t120 p-b90" style="background-color:#f8f9fa;">
    <div class="container">
      <div class="section-head center wt-small-separator-outer">
        <div class="wt-small-separator site-text-primary">
          <div class="sep-leaf-left"></div>
          <div>Our Services</div>
        </div>
      </div>

      <div class="row">
        <!-- Card 1 -->
        <div class="col-lg-4 col-md-6 m-b30">
          <div class="service-icon-box-two hover-img1">
            <div class="wt-icon-box-wraper">
              <div class="icon-xl inline-icon">
                <span class="icon-cell site-text-primary">
                  <i class="bi bi-bezier"></i>
                </span>
              </div>
            </div>
            <div class="service-icon-box-title">
              <h4 class="wt-title">Chemical Research Industry</h4>
            </div>
            <div class="service-icon-box-content">
              <p>You can dream, create, design, and build the most wonderful place in the world. But it requires people.</p>
              <a href="#" class="site-button-link site-text-primary">Read More  <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-lg-4 col-md-6 m-b30">
          <div class="service-icon-box-two hover-img2">
            <div class="wt-icon-box-wraper">
              <div class="icon-xl inline-icon">
                <span class="icon-cell site-text-primary">
                  <i class="bi bi-gear-wide-connected"></i>
                </span>
              </div>
            </div>
            <div class="service-icon-box-title">
              <h4 class="wt-title">Mechanical Construction</h4>
            </div>
            <div class="service-icon-box-content">
              <p>We build innovative mechanical structures that combine strength and sustainable</p>
              <a href="#" class="site-button-link site-text-primary">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-lg-4 col-md-6 m-b30">
          <div class="service-icon-box-two hover-img3">
            <div class="wt-icon-box-wraper">
              <div class="icon-xl inline-icon">
                <span class="icon-cell site-text-primary">
                  <i class="bi bi-building"></i>
                </span>
              </div>
            </div>
            <div class="service-icon-box-title">
              <h4 class="wt-title">Engineering Solutions</h4>
            </div>
            <div class="service-icon-box-content">
              <p>Engineering precision and creativity to provide smart, efficient, and future-ready infrastructure solutions.</p>
              <a href="#" class="site-button-link site-text-primary">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
		
		
		<!-- Card 3 -->
        <div class="col-lg-4 col-md-6 m-b30">
          <div class="service-icon-box-two hover-img4">
            <div class="wt-icon-box-wraper">
              <div class="icon-xl inline-icon">
                <span class="icon-cell site-text-primary">
                  <i class="bi bi-building"></i>
                </span>
              </div>
            </div>
            <div class="service-icon-box-title">
              <h4 class="wt-title">Engineering Solutions</h4>
            </div>
            <div class="service-icon-box-content">
              <p>Engineering precision and creativity to provide smart, efficient, and future-ready infrastructure solutions.</p>
              <a href="#" class="site-button-link site-text-primary">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
		
		
		<!-- Card 3 -->
        <div class="col-lg-4 col-md-6 m-b30">
          <div class="service-icon-box-two hover-img5">
            <div class="wt-icon-box-wraper">
              <div class="icon-xl inline-icon">
                <span class="icon-cell site-text-primary">
                  <i class="bi bi-building"></i>
                </span>
              </div>
            </div>
            <div class="service-icon-box-title">
              <h4 class="wt-title">Engineering Solutions</h4>
            </div>
            <div class="service-icon-box-content">
              <p>Engineering precision and creativity to provide smart, efficient, and future-ready infrastructure solutions.</p>
              <a href="#" class="site-button-link site-text-primary">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>

    
    </div>
  </div>


	  
	  <!-- Work Process Section -->
 <div class="container swiper">
        <div class="card-wrapper">
            <ul class="card-list swiper-wrapper">
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">
                        <img src="quote1.png" class="card-image">
                        <p class="badge">UPLOADN CAD FILE</p>
                        <h2 class="card-title">UPLOAD YOUR FILE</h2>
                    </a>
                </li>
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">
                        <img src="upload-file.jpg" class="card-image">
                        <p class="badge">RECEIVE INSTANT QUOTE </p>
                        <h2 class="card-title">Guarranted 24 hours turnaround your on your Quotation</h2>
                    </a>
                </li>
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">
                        <img src="making.png" class="card-image">
                        <p class="badge">Design Assistant</p>
                        <h2 class="card-title">For design Assistant contact red Engineers
						</h2>
                    </a>
                </li>
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">
                        <img src="production.jpeg" class="card-image">
                        <p class="badge">production</p>
                        <h2 class="card-title">Will kick off production with cutting-edge 3D printing and router cutting technology </h2>
                    </a>
                </li>
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">
                        <img src="controlquality.png" class="card-image">
                        <p class="badge">Pin on board</p>
                        <h2 class="card-title">An image slider is a web element that displays multiple images in a rotating format, allowing users to navigate through visuals using arrows or indicators.</h2>
                    </a>
                </li>
            </ul>

            <div class="swiper-pagination"></div>
            <div class="swiper-slide-button swiper-button-prev"></div>
            <div class="swiper-slide-button swiper-button-next"></div>
        </div>
    </div>
	
	<div class="container">
  <h1 class="industries">
    INDUSTRIES <span class="serve">WE SERVE</span>
  </h1>

  <!-- 🟩 Add row wrapper -->
  <div class="row justify-content-center g-4">
    <div class="col-lg-3 col-md-6 m-b30">
      <div class="service-img-box">
        <img src="background-slide3.png" class="slider-hover" />
        <div class="image-overlay">
          <p class="badge">Customised Gifts</p>
          <h2 class="card-title">RED-LABS brings your gift ideas to life with bespoke<br>3D printing solutions From</h2>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 m-b30">
      <div class="service-img-box">
        <img src="background-slide3.png" class="slider-hover" />
        <div class="image-overlay">
          <p class="badge">Learn and Create</p>
          <h2 class="card-title">RED-LABS enriches <br>education by teaching<br>students about 3D printing</h2>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 m-b30">
      <div class="service-img-box">
        <img src="background-slide3.png" class="slider-hover" />
        <div class="image-overlay">
          <p class="badge">Architecture</p>
          <h2 class="card-title">RED-LABS delivers<br>precision-engineered 3D<br>printing and scanning</h2>
        </div>
      </div>
    </div>


    </div>
  </div>
</div>



 <section class="contact-section">
    <div class="contact-container">
      
      <!-- Left Info -->
     <div class="contact-info">
  <h2>Please contact us and tell us more about your project</h2>

  <p class="contact-item">
    <i class="fa-solid animate-phn fa-phone"></i>
	<i class="fa-solid fa-phone"></i>
    <span>+61-423 454 930</span>
  </p>

  <p class="contact-item">
    <i class="fa-regular animate-eml fa-envelope"></i>
	<i class="fa-regular fa-envelope"></i>
    <a href="mailto:m.behnam@australiandraft.com.au">m.behnam@australiandraft.com.au</a>
  </p>
</div>


      <!-- Right Form -->
      <div class="contact-form">
        <form>
          <div class="form-row">
            <input type="text" placeholder="Your Name" required>
            <input type="text" placeholder="Your Phone" required>
          </div>

          <div class="form-row">
            <input type="email" placeholder="Your Email" required>
            <input type="text" placeholder="Your Address">
          </div>

          <input type="text" placeholder="Product Name">
          <textarea rows="4" placeholder="Your Message"></textarea>

          <button type="submit">Submit</button>
        </form>
      </div>

    </div>
  </section>

 	
<footer class="footer bg-dark">
  <div class="container">
    <div class="row ">

      <!-- Left Column -->
      <div class="col-md-5">
        <h5 class="text-uppercase">
          RED Engineers | <span class="text-danger">RED-LABS</span>
        </h5>
        <p class="mb-2">
          <i class="bi bi-geo-alt-fill"></i>
          A04/216 Harbour Road, Mackay Harbour, QLD 4740
        </p>
      </div>

      <!-- Vertical Divider -->
      <div class="col-md-2 d-flex justify-content-center">
        <div class="vl"></div>
      </div>

      <!-- Right Column -->
      <div class="col-md-5">
        <h5 class="text-uppercase">
          RED Engineers | <span class="text-danger">RED-LABS</span>
        </h5>
        <p class="mb-2">
          <i class="bi bi-geo-alt-fill"></i>
          Suite 1870/324 Queen St, Brisbane City, QLD, 4000
        </p>
      </div>

    </div>

    <hr class="border-secondary mt-5">

    <div class="text-center small">
      @php
        $footer = \App\Models\FooterMain::first();
      @endphp
      @if($footer)
        © {{ $footer->copyright_year }} {{ $footer->copyright_text }}. Powered by <a href="{{ $footer->powered_by_link }}" class="text-danger copy text-decoration-none">{{ $footer->powered_by_text }}</a>.
      @else
        © 2024 Red-Labs. Powered by <span class="text-danger copy">Red Engineers</span>.
      @endif
    </div>
  </div>
</footer>
 
 
  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
  // ✅ Navbar Scroll Effect (only color changes)
   window.addEventListener('scroll', function () {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
	
  // ✅ Initialize Swiper
    var swiper = new Swiper(".mySwiper", {
      loop: true,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      speed: 1200,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      effect: "fade",
      fadeEffect: {
        crossFade: true,
      },
    });
	
	new Swiper('.card-wrapper', {  
  loop: true,  
  speed: 700,  
  spaceBetween: 30,  

  // If we need pagination  
  pagination: {  
    el: '.swiper-pagination',  
    clickable: true,  
    dynamicBullets: true,  
  },  

  // Navigation arrows  
  navigation: {  
    nextEl: '.swiper-button-next',  
    prevEl: '.swiper-button-prev',  
  },  
  
  breakpoints: { 
    0: {  
      slidesPerView: 1  
    },  
    768: {  
      slidesPerView: 2  
    },  
    1024: {  
      slidesPerView: 3  
    },  
  }  
});  
  </script>
</body>
</html>
