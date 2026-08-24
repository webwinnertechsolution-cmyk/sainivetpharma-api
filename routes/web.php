<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;

use App\Http\Controllers\InstagramController;

Route::get('/instagram', [InstagramController::class, 'index']);
// -----------------------------------------------------------------------------
// Frontend Routes (New)
// -----------------------------------------------------------------------------
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about-us', [FrontendController::class, 'about'])->name('about');
Route::get('/services/wear-liners', [FrontendController::class, 'wearLiners'])->name('services.wear-liners');
Route::get('/services/conveyor-guards', [FrontendController::class, 'conveyorGuards'])->name('services.conveyor-guards');
Route::get('/services/{slug}', [FrontendController::class, 'serviceDetail'])->name('service.detail');
Route::get('/return-refund-policy', [FrontendController::class, 'returnRefundPolicy'])->name('return-refund-policy');
Route::post('/contact/submit', [FrontendController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');


Route::get('/upload-file', [FrontendController::class, 'uploadFile'])->name('upload-file');
Route::post('/upload-file', [FrontendController::class, 'uploadFileSubmit'])->name('upload-file.submit');
Route::get('/industries', [FrontendController::class, 'industries'])->name('industries');



Route::get('/shop-new', [FrontendController::class, 'shopNew'])->name('shop-new');

// Blog Routes
Route::get('/blog', [FrontendController::class, 'blog'])->name('frontend.blog');

// Route::get('/blog/tag/{slug}', [FrontendController::class, 'blogTag'])->name('frontend.blog.tag');



// Shopify-style collection routes
Route::get('/collections', [FrontendController::class, 'shop'])->name('shop');
Route::get('/collections/{categorySlug}', [FrontendController::class, 'shopCategory'])->name('shop.category');


// Legal Pages
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('frontend.privacy.policy');
Route::get('/terms-of-service', [FrontendController::class, 'termsOfService'])->name('frontend.terms.of.service');




Route::get('/hello', function () {
    return 'Hello Debug';
});







// -----------------------------------------------------------------------------
// Admin Panel Routes (Ported)
// -----------------------------------------------------------------------------

// Login
Route::get('/admin', [BackendController::class, 'login'])->name('login');
Route::post('/admin', [BackendController::class, 'loginSubmit'])->name('login.submit');

// Dashboard & Auth Protected Routes
Route::group([], function () {
    Route::get('/dashboard', [BackendController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [BackendController::class, 'logout'])->name('logout');

    // --- CMS Modules ---
// Add inside admin group in routes/web.php

Route::get('/promotional-banner', [BackendController::class, 'promotionalBanner'])->name('promotional.banner');
Route::post('/promotional-banner/store', [BackendController::class, 'promotionalBannerStore'])->name('promotional.banner.store');
Route::get('/promotional-banner/edit/{id}', [BackendController::class, 'promotionalBannerEdit'])->name('promotional.banner.edit');
Route::post('/promotional-banner/update/{id}', [BackendController::class, 'promotionalBannerUpdate'])->name('promotional.banner.update');
Route::post('/promotional-banner/delete/{id}', [BackendController::class, 'promotionalBannerDelete'])->name('promotional.banner.delete');


Route::get('/home-video-section', [BackendController::class, 'homeVideoSection'])->name('home.video.section');
Route::post('/home-video-section/store', [BackendController::class, 'homeVideoSectionStore'])->name('home.video.section.store');
Route::get('/home-video-section/edit/{id}', [BackendController::class, 'homeVideoSectionEdit'])->name('home.video.section.edit');
Route::post('/home-video-section/update/{id}', [BackendController::class, 'homeVideoSectionUpdate'])->name('home.video.section.update');
Route::post('/home-video-section/delete/{id}', [BackendController::class, 'homeVideoSectionDelete'])->name('home.video.section.delete');


Route::get('/announcement-bar',            [BackendController::class, 'announcementBar'])->name('announcement.bar');
Route::post('/announcement-bar/store',     [BackendController::class, 'announcementBarStore'])->name('announcement.bar.store');
Route::post('/announcement-bar/update/{id}', [BackendController::class, 'announcementBarUpdate'])->name('announcement.bar.update');
Route::post('/announcement-bar/delete/{id}', [BackendController::class, 'announcementBarDelete'])->name('announcement.bar.delete');
 


Route::get('/wishlist', [FrontendController::class, 'wishlistPage'])->name('wishlist');


// ============================================
// DISCOUNT MANAGEMENT ROUTES
// ============================================

Route::get('/discount', [BackendController::class, 'discount'])->name('discount.index');
Route::get('/discount/create', [BackendController::class, 'discountCreate'])->name('discount.create');
Route::post('/discount/store', [BackendController::class, 'discountStore'])->name('discount.store');
Route::get('/discount/edit/{id}', [BackendController::class, 'discountEdit'])->name('discount.edit');
Route::post('/discount/update/{id}', [BackendController::class, 'discountUpdate'])->name('discount.update');
Route::post('/discount/toggle/{id}', [BackendController::class, 'discountToggle'])->name('discount.toggle');
Route::post('/discount/delete/{id}', [BackendController::class, 'discountDelete'])->name('discount.delete');




// Shipping Zone
Route::get('/shipping-zone', [BackendController::class, 'shippingZone'])->name('shipping.zone');
Route::post('/shipping-zone/store', [BackendController::class, 'shippingZoneStore'])->name('shipping.zone.store');
Route::get('/shipping-zone/edit/{id}', [BackendController::class, 'shippingZoneEdit'])->name('shipping.zone.edit');
Route::post('/shipping-zone/update/{id}', [BackendController::class, 'shippingZoneUpdate'])->name('shipping.zone.update');
Route::post('/shipping-zone/delete/{id}', [BackendController::class, 'shippingZoneDelete'])->name('shipping.zone.delete');

// Shipping Method
Route::get('/shipping-method', [BackendController::class, 'shippingMethod'])->name('shipping.method');
Route::post('/shipping-method/store', [BackendController::class, 'shippingMethodStore'])->name('shipping.method.store');
Route::get('/shipping-method/edit/{id}', [BackendController::class, 'shippingMethodEdit'])->name('shipping.method.edit');
Route::post('/shipping-method/update/{id}', [BackendController::class, 'shippingMethodUpdate'])->name('shipping.method.update');
Route::post('/shipping-method/delete/{id}', [BackendController::class, 'shippingMethodDelete'])->name('shipping.method.delete');

// Shipping Rate
Route::get('/shipping-rate', [BackendController::class, 'shippingRate'])->name('shipping.rate');
Route::post('/shipping-rate/store', [BackendController::class, 'shippingRateStore'])->name('shipping.rate.store');
Route::get('/shipping-rate/edit/{id}', [BackendController::class, 'shippingRateEdit'])->name('shipping.rate.edit');
Route::post('/shipping-rate/update/{id}', [BackendController::class, 'shippingRateUpdate'])->name('shipping.rate.update');
Route::post('/shipping-rate/delete/{id}', [BackendController::class, 'shippingRateDelete'])->name('shipping.rate.delete');

// ============================================
// CONTACT US MANAGEMENT
// ============================================
Route::get('/contact-us-page', [BackendController::class, 'contactUs'])->name('contact.us');
Route::post('/contact-us-page/store', [BackendController::class, 'contactUsStore'])->name('contact.us.store');
Route::post('/contact-us-page/update/{id}', [BackendController::class, 'contactUsUpdate'])->name('contact.us.update');
Route::post('/contact-us-page/delete/{id}', [BackendController::class, 'contactUsDelete'])->name('contact.us.delete');

Route::get('/faq', [BackendController::class, 'faq'])->name('faq');
    Route::post('/faq/store', [BackendController::class, 'faqStore'])->name('faq.store');
    Route::get('/faq/edit/{id}', [BackendController::class, 'faqEdit'])->name('faq.edit');
    Route::post('/faq/update/{id}', [BackendController::class, 'faqUpdate'])->name('faq.update');
    Route::post('/faq/delete/{id}', [BackendController::class, 'faqDelete'])->name('faq.delete');
	
	
	
Route::get('/gallery', [BackendController::class, 'gallery'])->name('gallery.index');
Route::get('/gallery/create', [BackendController::class, 'galleryCreate'])->name('gallery.create');
Route::post('/gallery/store', [BackendController::class, 'galleryStore'])->name('gallery.store');
Route::get('/gallery/edit/{id}', [BackendController::class, 'galleryEdit'])->name('gallery.edit');
Route::post('/gallery/update/{id}', [BackendController::class, 'galleryUpdate'])->name('gallery.update');
Route::post('/gallery/delete/{id}', [BackendController::class, 'galleryDelete'])->name('gallery.delete');
Route::post('/gallery/media/delete/{id}', [BackendController::class, 'galleryDeleteMedia'])->name('gallery.media.delete');

Route::post('/gallery/media/sort', [BackendController::class, 'gallerySortMedia'])->name('gallery.media.sort');
Route::post('/gallery/media/info/{id}', [BackendController::class, 'galleryUpdateMediaInfo'])->name('gallery.media.info');



Route::get('/orders', [BackendController::class, 'orders'])->name('orders');
Route::get('/orders/{id}', [BackendController::class, 'orderView'])->name('order.view');
Route::post('/orders/{id}/status', [BackendController::class, 'orderUpdateStatus'])->name('order.update.status');
Route::post('/orders/{id}/payment-status', [BackendController::class, 'orderUpdatePaymentStatus'])->name('order.update.payment.status');
Route::post('/orders/{id}/delete', [BackendController::class, 'orderDelete'])->name('order.delete');
Route::get('/orders/{id}/invoice', [BackendController::class, 'orderInvoice'])->name('order.invoice');

    // Sliders
    Route::get('/slider', [BackendController::class, 'slider'])->name('slider');
    Route::get('/slider/create', [BackendController::class, 'sliderCreate'])->name('slider.create');
    Route::post('/slider/store', [BackendController::class, 'sliderStore'])->name('slider.store');
    Route::get('/slider/edit/{id}', [BackendController::class, 'sliderEdit'])->name('slider.edit');
    Route::post('/slider/update/{id}', [BackendController::class, 'sliderUpdate'])->name('slider.update');
    Route::post('/slider/delete/{id}', [BackendController::class, 'sliderDelete'])->name('slider.delete');

    // What We Do
    Route::get('/what-we-do', [BackendController::class, 'whatWeDo'])->name('whatwedo');
    Route::get('/whatwedo/create', [BackendController::class, 'whatWeDoCreate'])->name('whatwedo.create');
    Route::post('/whatwedo/store', [BackendController::class, 'whatWeDoStore'])->name('whatwedo.store');
    Route::get('/whatwedo/edit/{id}', [BackendController::class, 'whatWeDoEdit'])->name('whatwedo.edit');
    Route::post('/whatwedo/update/{id}', [BackendController::class, 'whatWeDoUpdate'])->name('whatwedo.update');
    Route::post('/whatwedo/delete/{id}', [BackendController::class, 'whatWeDoDelete'])->name('whatwedo.delete');

    // Services (Main & Items)
    Route::get('/ourservicemain', [BackendController::class, 'ourServiceMain'])->name('ourservicemain');
    Route::post('/ourservicemain/store', [BackendController::class, 'ourServiceMainStore'])->name('ourservicemain.store');
    Route::get('/ourservicemain/edit/{id}', [BackendController::class, 'ourServiceMainEdit'])->name('ourservicemain.edit');
    Route::post('/ourservicemain/update/{id}', [BackendController::class, 'ourServiceMainUpdate'])->name('ourservicemain.update');
    Route::post('/ourservicemain/delete/{id}', [BackendController::class, 'ourServiceMainDelete'])->name('ourservicemain.delete');

    Route::get('/ourservice', [BackendController::class, 'ourService'])->name('ourservice');
    Route::get('/ourservice/create', [BackendController::class, 'ourServiceCreate'])->name('ourservice.create');
    Route::post('/ourservice/store', [BackendController::class, 'ourServiceStore'])->name('ourservice.store');
    Route::get('/ourservice/edit/{id}', [BackendController::class, 'ourServiceEdit'])->name('ourservice.edit');
    Route::post('/ourservice/update/{id}', [BackendController::class, 'ourServiceUpdate'])->name('ourservice.update');
    Route::post('/ourservice/delete/{id}', [BackendController::class, 'ourServiceDelete'])->name('ourservice.delete');

    // Work Process
    Route::get('/ourworkprocessmain', [BackendController::class, 'ourWorkProcessMain'])->name('ourworkprocessmain');
    Route::post('/ourworkprocessmain/store', [BackendController::class, 'ourWorkProcessMainStore'])->name('ourworkprocessmain.store');
    Route::get('/ourworkprocessmain/edit/{id}', [BackendController::class, 'ourWorkProcessMainEdit'])->name('ourworkprocessmain.edit');
    Route::post('/ourworkprocessmain/update/{id}', [BackendController::class, 'ourWorkProcessMainUpdate'])->name('ourworkprocessmain.update');
    Route::post('/ourworkprocessmain/delete/{id}', [BackendController::class, 'ourWorkProcessMainDelete'])->name('ourworkprocessmain.delete');

    Route::get('/our-work-process', [BackendController::class, 'ourWorkProcess'])->name('our-work-process');
    Route::get('/our-work-process/create', [BackendController::class, 'ourWorkProcessCreate'])->name('our-work-process.create');
    Route::post('/our-work-process/store', [BackendController::class, 'ourWorkProcessStore'])->name('our-work-process.store');
    Route::get('/our-work-process/edit/{id}', [BackendController::class, 'ourWorkProcessEdit'])->name('our-work-process.edit');
    Route::post('/our-work-process/update/{id}', [BackendController::class, 'ourWorkProcessUpdate'])->name('our-work-process.update');
    Route::delete('/our-work-process/delete/{id}', [BackendController::class, 'ourWorkProcessDelete'])->name('our-work-process.delete');

    // Industries
    Route::get('/industriesweservemain', [BackendController::class, 'industriesWeServeMain'])->name('industriesweservemain');
    Route::post('/industriesweservemain/store', [BackendController::class, 'industriesWeServeMainStore'])->name('industriesweservemain.store');
    Route::get('/industriesweservemain/edit/{id}', [BackendController::class, 'industriesWeServeMainEdit'])->name('industriesweservemain.edit');
    Route::post('/industriesweservemain/update/{id}', [BackendController::class, 'industriesWeServeMainUpdate'])->name('industriesweservemain.update');
    Route::post('/industriesweservemain/delete/{id}', [BackendController::class, 'industriesWeServeMainDelete'])->name('industriesweservemain.delete');

    Route::get('/industries-we-serve', [BackendController::class, 'industriesWeServe'])->name('industries-we-serve');
    Route::get('/industries-we-serve/create', [BackendController::class, 'industriesWeServeCreate'])->name('industries-we-serve.create');
    Route::post('/industries-we-serve/store', [BackendController::class, 'industriesWeServeStore'])->name('industries-we-serve.store');
    Route::get('/industries-we-serve/edit/{id}', [BackendController::class, 'industriesWeServeEdit'])->name('industries-we-serve.edit');
    Route::post('/industries-we-serve/update/{id}', [BackendController::class, 'industriesWeServeUpdate'])->name('industries-we-serve.update');
    Route::delete('/industries-we-serve/delete/{id}', [BackendController::class, 'industriesWeServeDelete'])->name('industries-we-serve.delete');

    // Logo
    Route::get('/logo', [BackendController::class, 'logo'])->name('logo');
    Route::post('/logo/store', [BackendController::class, 'logoStore'])->name('logo.store');
    Route::get('/logo/edit/{id}', [BackendController::class, 'logoEdit'])->name('logo.edit');
    Route::post('/logo/update/{id}', [BackendController::class, 'logoUpdate'])->name('logo.update');
    Route::post('/logo/delete/{id}', [BackendController::class, 'logoDelete'])->name('logo.delete');

    // Menus
    Route::get('/menus', [BackendController::class, 'menuIndex'])->name('backend.menu.index');
    Route::get('/menus/create', [BackendController::class, 'menuCreate'])->name('backend.menu.create');
    Route::post('/menus', [BackendController::class, 'menuStore'])->name('backend.menu.store');
    Route::get('/menus/{id}/edit', [BackendController::class, 'menuEdit'])->name('backend.menu.edit');
    Route::put('/menus/{id}', [BackendController::class, 'menuUpdate'])->name('backend.menu.update');
    Route::delete('/menus/{id}', [BackendController::class, 'menuDestroy'])->name('backend.menu.destroy');
    Route::post('/menus/{id}/toggle', [BackendController::class, 'menuToggleStatus'])->name('backend.menu.toggle');

    // Footer Main
    Route::get('/footermain', [BackendController::class, 'footerMain'])->name('footermain');
    Route::post('/footermain/store', [BackendController::class, 'footerMainStore'])->name('footermain.store');
    Route::get('/footermain/edit/{id}', [BackendController::class, 'footerMainEdit'])->name('footermain.edit');
    // Note: The controller uses redirect()->route('footermain') which expects this name
    Route::post('/footermain/update/{id}', [BackendController::class, 'footerMainUpdate'])->name('footermain.update');
    Route::post('/footermain/delete/{id}', [BackendController::class, 'footerMainDelete'])->name('footermain.delete');

    // Home Contact section
    Route::get('/home-contact', [BackendController::class, 'homeContact'])->name('homecontact');
    Route::post('/home-contact/store', [BackendController::class, 'homeContactStore'])->name('homecontact.store');
    Route::get('/home-contact/edit/{id}', [BackendController::class, 'homeContactEdit'])->name('homecontact.edit');
    Route::post('/home-contact/update/{id}', [BackendController::class, 'homeContactUpdate'])->name('homecontact.update');
    Route::post('/home-contact/delete/{id}', [BackendController::class, 'homeContactDelete'])->name('homecontact.delete');

    // Contact Admin
    Route::get('/admin/contacts', [BackendController::class, 'contacts'])->name('admin.contacts');
    Route::post('/admin/contacts/delete/{id}', [BackendController::class, 'contactDelete'])->name('admin.contacts.delete');

   
    // ... (Other specific FAQs and pages can be added as needed)
    Route::get('/offering', [BackendController::class, 'offering'])->name('offering');
    Route::post('/offering/store', [BackendController::class, 'offeringStore'])->name('offering.store');
    Route::get('/offering/edit/{id}', [BackendController::class, 'offeringEdit'])->name('offering.edit');
    Route::post('/offering/update/{id}', [BackendController::class, 'offeringUpdate'])->name('offering.update');
    Route::post('/offering/delete/{id}', [BackendController::class, 'offeringDelete'])->name('offering.delete');

    Route::get('/industry', [BackendController::class, 'industry'])->name('industry');
    Route::post('/industry/store', [BackendController::class, 'industryStore'])->name('industry.store');
    Route::get('/industry/edit/{id}', [BackendController::class, 'industryEdit'])->name('industry.edit');
    Route::post('/industry/update/{id}', [BackendController::class, 'industryUpdate'])->name('industry.update');
    Route::post('/industry/delete/{id}', [BackendController::class, 'industryDelete'])->name('industry.delete');

    // Core Values
    Route::get('/corevalues', [BackendController::class, 'coreValues'])->name('corevalues');
    Route::get('/corevalues/create', [BackendController::class, 'coreValuesCreate'])->name('corevalues.create');
    Route::post('/corevalues/store', [BackendController::class, 'coreValuesStore'])->name('corevalues.store');
    Route::get('/corevalues/edit/{id}', [BackendController::class, 'coreValuesEdit'])->name('corevalues.edit');
    Route::post('/corevalues/update/{id}', [BackendController::class, 'coreValuesUpdate'])->name('corevalues.update');
    Route::post('/corevalues/delete/{id}', [BackendController::class, 'coreValuesDelete'])->name('corevalues.delete');

    Route::get('/corevaluesmain', [BackendController::class, 'coreValuesMain'])->name('corevaluesmain');
    Route::post('/corevaluesmain/store', [BackendController::class, 'coreValuesMainStore'])->name('corevaluesmain.store');
    Route::get('/corevaluesmain/edit/{id}', [BackendController::class, 'coreValuesMainEdit'])->name('corevaluesmain.edit');
    Route::post('/corevaluesmain/update/{id}', [BackendController::class, 'coreValuesMainUpdate'])->name('corevaluesmain.update');
    Route::post('/corevaluesmain/delete/{id}', [BackendController::class, 'coreValuesMainDelete'])->name('corevaluesmain.delete');

    // Experience The Power
    Route::get('/experience-the-power', [BackendController::class, 'experienceThePower'])->name('experience.the.power');
    Route::post('/experience-the-power/store', [BackendController::class, 'experienceThePowerStore'])->name('experience.the.power.store');
    Route::get('/experience-the-power/edit/{id}', [BackendController::class, 'experienceThePowerEdit'])->name('experience.the.power.edit');
    Route::post('/experience-the-power/update/{id}', [BackendController::class, 'experienceThePowerUpdate'])->name('experience.the.power.update');
    Route::post('/experience-the-power/delete/{id}', [BackendController::class, 'experienceThePowerDelete'])->name('experience.the.power.delete');

   
// Blog Admin
Route::get('/admin-blog', [BackendController::class, 'blog'])->name('blog');
Route::get('/blog/create', [BackendController::class, 'blogCreate'])->name('blog.create'); // ← ADD THIS
Route::post('/blog/store', [BackendController::class, 'blogStore'])->name('blog.store');
Route::get('/blog/edit/{id}', [BackendController::class, 'blogEdit'])->name('blog.edit');
Route::post('/blog/update/{id}', [BackendController::class, 'blogUpdate'])->name('blog.update');
Route::post('/blog/delete/{id}', [BackendController::class, 'blogDelete'])->name('blog.delete');
    
    Route::get('/blog-category', [BackendController::class, 'blogCategory'])->name('blog.category');
    Route::post('/blog-category/store', [BackendController::class, 'blogCategoryStore'])->name('blog.category.store');
    Route::post('/blog-category/delete/{id}', [BackendController::class, 'blogCategoryDelete'])->name('blog.category.delete');

    Route::get('/blog-tag', [BackendController::class, 'blogTag'])->name('blog.tag');
    Route::post('/blog-tag/store', [BackendController::class, 'blogTagStore'])->name('blog.tag.store');
    // Blog Tags
    Route::post('/blog-tag/delete/{id}', [BackendController::class, 'blogTagDelete'])->name('blog.tag.delete');

    // Page SEO Manager
    Route::get('/pageseo', [\App\Http\Controllers\Admin\PageSeoController::class, 'index'])->name('admin.pageseo.index');
    Route::get('/pageseo/create', [\App\Http\Controllers\Admin\PageSeoController::class, 'create'])->name('admin.pageseo.create');
    Route::post('/pageseo', [\App\Http\Controllers\Admin\PageSeoController::class, 'store'])->name('admin.pageseo.store');
    Route::get('/pageseo/{id}/edit', [\App\Http\Controllers\Admin\PageSeoController::class, 'edit'])->name('admin.pageseo.edit');
    Route::put('/pageseo/{id}', [\App\Http\Controllers\Admin\PageSeoController::class, 'update'])->name('admin.pageseo.update');
Route::delete('/pageseo/{id}', [\App\Http\Controllers\Admin\PageSeoController::class, 'destroy'])->name('admin.pageseo.destroy');




Route::get('/product-category', [BackendController::class, 'productCategory'])->name('product.category');
Route::post('/product-category/store', [BackendController::class, 'productCategoryStore'])->name('product.category.store');
Route::get('/product-category/edit/{id}', [BackendController::class, 'productCategoryEdit'])->name('product.category.edit');
Route::post('/product-category/update/{id}', [BackendController::class, 'productCategoryUpdate'])->name('product.category.update');
Route::post('/product-category/delete/{id}', [BackendController::class, 'productCategoryDelete'])->name('product.category.delete');


Route::get('/product-tag', [BackendController::class, 'productTag'])->name('product.tag');
Route::post('/product-tag/store', [BackendController::class, 'productTagStore'])->name('product.tag.store');
Route::get('/product-tag/edit/{id}', [BackendController::class, 'productTagEdit'])->name('product.tag.edit');
Route::post('/product-tag/update/{id}', [BackendController::class, 'productTagUpdate'])->name('product.tag.update');
Route::post('/product-tag/delete/{id}', [BackendController::class, 'productTagDelete'])->name('product.tag.delete');

// Brand Section
Route::get('/brand-section', [BackendController::class, 'brandSection'])->name('brand.section');
Route::post('/brand-section/save', [BackendController::class, 'brandSectionSave'])->name('brand.section.save');
Route::post('/brand/store', [BackendController::class, 'brandStore'])->name('brand.store');
Route::get('/brand/edit/{id}', [BackendController::class, 'brandEdit'])->name('brand.edit');
Route::post('/brand/update/{id}', [BackendController::class, 'brandUpdate'])->name('brand.update');
Route::post('/brand/delete/{id}', [BackendController::class, 'brandDelete'])->name('brand.delete');


// ============================================
// PRODUCT MANAGEMENT ROUTES
// ============================================

Route::get('/product', [BackendController::class, 'product'])->name('product');
Route::post('/product/store', [BackendController::class, 'productStore'])->name('product.store');

// ✅ SPECIFIC ROUTES PEHLE — create, edit
Route::get('/product/create', [BackendController::class, 'productCreate'])->name('product.create');
Route::get('/product/edit/{id}', [BackendController::class, 'productEdit'])->name('product.edit');
Route::post('/product/update/{id}', [BackendController::class, 'productUpdate'])->name('product.update');
Route::post('/product/delete/{id}', [BackendController::class, 'productDelete'])->name('product.delete');
Route::post('/product/gallery-image/{id}', [BackendController::class, 'productDeleteGalleryImage'])->name('product.gallery.delete');
Route::post('/product/variant/{id}', [BackendController::class, 'productDeleteVariant'])->name('product.variant.delete');

// ✅ WILDCARD ROUTE BAAD MEIN — yeh {slug} sab kuch catch karta hai
Route::get('/product/{slug}', [FrontendController::class, 'productDetail'])->name('product.detail');
    // Quotation Management
    Route::get('/quotations', [\App\Http\Controllers\Admin\QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/{id}', [\App\Http\Controllers\Admin\QuotationController::class, 'show'])->name('quotations.show');

    // Contact Submissions (Alias for admin.contacts to match sidebar)
    Route::get('/admin/contact-submissions', [BackendController::class, 'contacts'])->name('contact.submissions');
});


// ============================================================
// Yeh routes apne web.php mein admin group ke andar add karo
// ============================================================

// Home Categories
Route::get('/home-category', [BackendController::class, 'homeCategory'])->name('home.category');
Route::post('/home-category/store', [BackendController::class, 'homeCategoryStore'])->name('home.category.store');
Route::get('/home-category/edit/{id}', [BackendController::class, 'homeCategoryEdit'])->name('home.category.edit');
Route::post('/home-category/update/{id}', [BackendController::class, 'homeCategoryUpdate'])->name('home.category.update');
Route::post('/home-category/delete/{id}', [BackendController::class, 'homeCategoryDelete'])->name('home.category.delete');


// Home Product Sections (Shortcode System)
Route::get('/home-product-section', [BackendController::class, 'homeProductSection'])->name('home.product.section');
Route::post('/home-product-section/store', [BackendController::class, 'homeProductSectionStore'])->name('home.product.section.store');
Route::get('/home-product-section/edit/{id}', [BackendController::class, 'homeProductSectionEdit'])->name('home.product.section.edit');
Route::post('/home-product-section/update/{id}', [BackendController::class, 'homeProductSectionUpdate'])->name('home.product.section.update');
Route::post('/home-product-section/delete/{id}', [BackendController::class, 'homeProductSectionDelete'])->name('home.product.section.delete');



// web.php ke admin group mein add karo:

Route::get('/homelogo', [BackendController::class, 'homeLogo'])->name('homelogo.index');
Route::post('/homelogo/store', [BackendController::class, 'homeLogoStore'])->name('homelogo.store');
Route::get('/homelogo/edit/{id}', [BackendController::class, 'homeLogoEdit'])->name('homelogo.edit');
Route::post('/homelogo/update/{id}', [BackendController::class, 'homeLogoUpdate'])->name('homelogo.update');
Route::post('/homelogo/delete/{id}', [BackendController::class, 'homeLogoDelete'])->name('homelogo.delete');
 
 
// Footer New Management
Route::get('/footer-new', [BackendController::class, 'footerNew'])->name('footer.new');
Route::post('/footer-new/store', [BackendController::class, 'footerNewStore'])->name('footer.new.store');
Route::post('/footer-new/update/{id}', [BackendController::class, 'footerNewUpdate'])->name('footer.new.update');
Route::post('/footer-new/delete/{id}', [BackendController::class, 'footerNewDelete'])->name('footer.new.delete');




Route::prefix('admin')->group(function () {
    
    // ... existing admin routes ...

    // Privacy Policy Management (ADMIN)
    Route::get('/privacy-policy', [BackendController::class, 'privacyPolicy'])->name('privacy.policy');
    Route::post('/privacy-policy/store', [BackendController::class, 'privacyPolicyStore'])->name('privacy.policy.store');
    Route::post('/privacy-policy/update/{id}', [BackendController::class, 'privacyPolicyUpdate'])->name('privacy.policy.update');
    Route::post('/privacy-policy/delete/{id}', [BackendController::class, 'privacyPolicyDelete'])->name('privacy.policy.delete');

    // Terms of Service Management (ADMIN)
    Route::get('/terms-of-service', [BackendController::class, 'termsOfService'])->name('terms.of.service');
    Route::post('/terms-of-service/store', [BackendController::class, 'termsOfServiceStore'])->name('terms.of.service.store');
    Route::post('/terms-of-service/update/{id}', [BackendController::class, 'termsOfServiceUpdate'])->name('terms.of.service.update');
    Route::post('/terms-of-service/delete/{id}', [BackendController::class, 'termsOfServiceDelete'])->name('terms.of.service.delete');


    // Return & Refund Policy
Route::get('/admin/return-refund-policy', [BackendController::class, 'returnRefundPolicy'])->name('return.refund.policy');
Route::post('/admin/return-refund-policy', [BackendController::class, 'returnRefundPolicyStore'])->name('return.refund.policy.store');
Route::put('/admin/return-refund-policy/{id}', [BackendController::class, 'returnRefundPolicyUpdate'])->name('return.refund.policy.update');
Route::delete('/admin/return-refund-policy/{id}', [BackendController::class, 'returnRefundPolicyDelete'])->name('return.refund.policy.delete');
});






// -----------------------------------------------------------------------------
// Catch-All Route (Must be last)
// -----------------------------------------------------------------------------
Route::get('/blog/category/{slug}', [FrontendController::class, 'blogCategory'])->name('frontend.blog.category');
Route::get('/blog/tag/{slug}', [FrontendController::class, 'blogTag'])->name('frontend.blog.tag');
// Moved here to act as a catch-all for blog slugs
Route::get('/{slug}', [FrontendController::class, 'blogShow'])->name('frontend.blog.show');

Route::get('/return-refund-policy', [App\Http\Controllers\FrontendController::class, 'returnRefundPolicy'])->name('frontend.return-refund-policy');



Route::prefix('admin')->group(function () {
    Route::get('/return-refund-policy', [App\Http\Controllers\BackendController::class, 'returnRefundPolicy'])->name('admin.return.refund.policy');
    Route::post('/return-refund-policy/store', [App\Http\Controllers\BackendController::class, 'returnRefundPolicyStore'])->name('admin.return.refund.policy.store');
    Route::post('/return-refund-policy/update/{id}', [App\Http\Controllers\BackendController::class, 'returnRefundPolicyUpdate'])->name('admin.return.refund.policy.update');
    Route::delete('/return-refund-policy/delete/{id}', [App\Http\Controllers\BackendController::class, 'returnRefundPolicyDelete'])->name('admin.return.refund.policy.delete');
});
