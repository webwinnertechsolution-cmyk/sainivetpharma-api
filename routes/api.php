<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CheckoutController;

Route::middleware(\App\Http\Middleware\ApiCors::class)->group(function () {
    
    Route::get('/announcement-bar', [FrontendController::class, 'apiAnnouncementBar']);
    Route::get('/logo', [FrontendController::class, 'apiLogo']);
    Route::get('/footer', [FrontendController::class, 'apiFooter']);
    Route::get('/menus', [FrontendController::class, 'apiMenus']);
    Route::get('/footer-new', [FrontendController::class, 'apiFooterNew']);
    
    /* HOME PAGE */
    Route::get('/sliders', [FrontendController::class, 'apiSliders']);
    Route::get('/home-categories', [FrontendController::class, 'apiHomeCategories']);
    Route::get('/product-sections/{id}', [FrontendController::class, 'apiProductSection']);
    Route::get('/product-sections/{id}/products', [FrontendController::class, 'apiProductSectionProducts']);
    Route::get('/promotional-banner', [FrontendController::class, 'apiPromotionalBanner']);
    
    /* This is offering but file name is industries-we-serve */ 
    Route::get('/industries-we-serve', [FrontendController::class, 'apiIndustriesWeServe']);
    Route::get('/brand-section', [FrontendController::class, 'apiBrandSection']);
    Route::get('/brands', [FrontendController::class, 'apiBrands']);
    Route::get('/video-sections/{id}', [FrontendController::class, 'apiVideoSection']);
    Route::get('/video-sections/{id}/videos', [FrontendController::class, 'apiVideoSectionVideos']);
    Route::get('/blogs/latest', [FrontendController::class, 'apiLatestBlogs']);
    
    // ✅ WISHLIST ROUTES
    Route::post('/wishlist/add', [FrontendController::class, 'addToWishlist']);
    Route::post('/wishlist/remove/{productId}', [FrontendController::class, 'removeFromWishlist']);
    Route::get('/wishlist', [FrontendController::class, 'getWishlist']);
    Route::get('/wishlist/check/{productId}', [FrontendController::class, 'checkWishlistStatus']);
    
	
	Route::get('/products', [FrontendController::class, 'apiProducts']);
Route::get('/products/{slug}', [FrontendController::class, 'apiProductDetail']);
Route::get('/product-discount/{productId}', [FrontendController::class, 'apiProductDiscount']); 

Route::get('/free-shipping-discount', [FrontendController::class, 'apiFreeShippingDiscount']);

Route::get('/calculate-shipping', [FrontendController::class, 'apiCalculateShipping']);


Route::get('/contact-us', [FrontendController::class, 'apiContactUs']);
Route::get('/privacy-policy', [FrontendController::class, 'apiPrivacyPolicy']);
Route::get('/terms-of-service', [FrontendController::class, 'apiTermsOfService']);
    Route::get('/return-refund-policy', [FrontendController::class, 'apiReturnRefundPolicy']);
 Route::get('/general-faqs', [FrontendController::class, 'apiGeneralFaqs']);
 
 Route::get('/gallery/{id}', [FrontendController::class, 'apiGallery']);
Route::get('/gallery/{id}/media', [FrontendController::class, 'apiGalleryMedia']);

Route::get('/products/{productId}/reviews', [FrontendController::class, 'apiProductReviews']);
Route::post('/products/{productId}/reviews', [FrontendController::class, 'apiProductReviewStore']);
 
	// ✅ GOOGLE AUTH ROUTES
Route::post('/google/login', [FrontendController::class, 'googleLoginOrRegister']);
Route::get('/google/user/{firebase_uid}', [FrontendController::class, 'googleGetUser']);

Route::get('/page-seo/{route}', [FrontendController::class, 'apiPageSeo']);

// ============================================
// ✅ CHECKOUT ROUTES (SAINI VET PHARMA)
// ============================================
Route::post('/checkout/calculate',   [CheckoutController::class, 'apiCalculateCheckout']);
Route::post('/checkout/place-order', [CheckoutController::class, 'apiPlaceOrder']);
Route::get('/checkout/order/{orderNumber}', [CheckoutController::class, 'apiGetOrder']);
Route::post('/checkout/razorpay/verify', [CheckoutController::class, 'apiRazorpayVerify']);
Route::get('/checkout/razorpay/key', [CheckoutController::class, 'apiGetRazorpayKey']);

    Route::get('/checkout/my-orders', [
    CheckoutController::class,
    'apiGetCustomerOrders'
]);




    
    /* Category */ 
    Route::get('/shop', [FrontendController::class, 'apiShop']);
    Route::get('/categories', [FrontendController::class, 'apiCategories']);
    Route::get('/offerings', [FrontendController::class, 'apiOfferings']);
    Route::get('/core-values', [FrontendController::class, 'apiCoreValues']);
    Route::get('/core-values-main', [FrontendController::class, 'apiCoreValuesMain']);
    Route::get('/experience-the-power', [FrontendController::class, 'apiExperienceThePower']);
    Route::get('/services', [FrontendController::class, 'apiServices']);
    Route::get('/services/{slug}', [FrontendController::class, 'apiServiceDetail']);
    Route::get('/products', [FrontendController::class, 'apiProducts']);
    Route::get('/products/{slug}', [FrontendController::class, 'apiProductDetail']);
    Route::get('/blogs', [FrontendController::class, 'apiBlogs']);
    Route::get('/blogs/{slug}', [FrontendController::class, 'apiBlogDetail']);
    Route::get('/faqs', [FrontendController::class, 'apiFaqs']);
    Route::get('/industries', [FrontendController::class, 'apiIndustries']);
    Route::post('/contact', [FrontendController::class, 'apiContactSubmit']);
    Route::get('/return-refund-policy', [App\Http\Controllers\FrontendController::class, 'apiReturnRefundPolicy']);
});
