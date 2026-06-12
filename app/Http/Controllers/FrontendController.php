<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\WhatWeDo;
use App\Models\OurService;
use App\Models\OurServiceMain;
use App\Models\OurWorkProcess;
use App\Models\IndustryWeServe;
use App\Models\OurWorkProcessMain;
use App\Models\Logo;
use App\Models\HomeContact;
use App\Models\FooterMain;
use App\Models\Offering;
use App\Models\CoreValueMain;
use App\Models\CoreValue;
use App\Models\ExperienceThePower;
use App\Models\Industry;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\ContactConfirmationMail;
use App\Mail\QuotationMail;
use App\Models\PrivacyPolicy;
use App\Models\TermsOfService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FrontendController extends Controller
{

    public function index()
{
    $sliders         = Slider::orderBy('created_at', 'desc')->get();
    $whatWeDos       = WhatWeDo::orderBy('created_at', 'desc')->get();
    $ourServices     = OurService::orderBy('created_at', 'desc')->get();
    $workProcesses   = OurWorkProcess::orderBy('created_at', 'desc')->get();
    $industries      = IndustryWeServe::orderBy('created_at', 'desc')->get();
    $workProcessMain = OurWorkProcessMain::first();
    $homeContact     = HomeContact::first();
    $logo            = Logo::first();
    $footerData      = FooterMain::first();
    $homeCategories  = \App\Models\HomeCategory::orderBy('sort_order', 'asc')->get();

    $brandSection = \App\Models\HomeBrandSection::first();
    $brands       = \App\Models\HomeBrand::where('is_active', 1)->orderBy('sort_order')->get();
    $homeLogos    = \App\Models\HomeLogo::where('is_active', 1)->orderBy('sort_order')->get();

    $menus = \App\Models\Menu::whereNull('parent_id')
            ->with('children.children')
            ->where('is_active', 1)
            ->orderBy('order')
            ->get();

    // ✅ ALL-PRODUCTS component ke liye
    $allHomeProducts = Product::with(['categories', 'variants'])
        ->where('status', 'published')
        ->latest('published_at')
        ->get();

    // ✅ All-products ke liye categories (sidebar filter)
    $homeProductCategories = \App\Models\ProductCategory::withCount([
        'products' => fn($q) => $q->where('status', 'published')
    ])->orderBy('name')->get();

 // ✅ SIRF YEH 3 LINES ADD KARO
    $instaPosts = Cache::remember('insta_feed', 3600, function () {
        return Http::get('https://feeds.behold.so/vXQ5XepduZCxb0ppvQDI')->json()['posts'] ?? [];
    });

    return view('frontend.home', compact(
        'sliders', 'whatWeDos', 'ourServices', 'workProcesses',
        'workProcessMain', 'industries', 'homeContact', 'logo',
        'footerData', 'menus', 'homeCategories',
        'brandSection', 'brands', 'homeLogos',
        'allHomeProducts', 'homeProductCategories',
        'instaPosts'  // ✅ SIRF YEH EK WORD ADD KARO
    ));
}

    public function about()
    {
        $logo               = Logo::first();
        $offering           = Offering::first();
        $coreValueMain      = CoreValueMain::first();
        $coreValues         = CoreValue::orderBy('created_at', 'asc')->get();
        $experienceThePower = ExperienceThePower::first();
        $footerData         = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.pages.about', compact(
            'logo', 'offering', 'coreValueMain', 'coreValues',
            'experienceThePower', 'footerData', 'menus'
        ));
    }

    public function productDetail($slug)
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $product = Product::with(['categories', 'tags', 'images', 'variants'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.product-detail', compact('product', 'logo', 'footerData', 'menus'));
    }

    public function services()
    {
        $logo           = Logo::first();
        $ourServiceMain = OurServiceMain::first();
        $ourServices    = OurService::orderBy('created_at', 'asc')->get();
        $footerData     = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.pages.services', compact('logo', 'ourServiceMain', 'ourServices', 'footerData', 'menus'));
    }

    public function serviceDetail($slug)
    {
        $logo = Logo::first();

        if ($slug === '3d-printing-2') {
            $service = OurService::where('slug', '3d-printing-2')->first();
            if (!$service) {
                $service = OurService::where('slug', '3d-printing')->firstOrFail();
            }
        } else {
            $service = OurService::where('slug', $slug)->firstOrFail();
        }

        $relatedServices = OurService::where('id', '!=', $service->id)
                                     ->orderBy('created_at', 'asc')
                                     ->get();
        $footerData = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        if ($slug === '3d-printing-2') {
            return view('frontend.pages.service-3d-printing', compact('logo', 'service', 'relatedServices', 'footerData', 'menus'));
        }
        if ($slug === '3d-scanning') {
            return view('frontend.pages.service-3d-scanning', compact('logo', 'service', 'relatedServices', 'footerData', 'menus'));
        }
        if ($slug === 'router-cutting') {
            return view('frontend.pages.service-router-cutting', compact('logo', 'service', 'relatedServices', 'footerData', 'menus'));
        }
        if ($slug === 'plastic-fabrication') {
            return view('frontend.pages.service-plastic-fabrication', compact('logo', 'service', 'relatedServices', 'footerData', 'menus'));
        }
        if ($slug === 'prototyping') {
            return view('frontend.pages.service-prototyping', compact('logo', 'service', 'relatedServices', 'footerData', 'menus'));
        }
        if ($slug === 'reverse-engineering') {
            return view('frontend.pages.service-reverse-engineering', compact('logo', 'service', 'relatedServices', 'footerData', 'menus'));
        }

        return view('frontend.pages.service-detail', compact('logo', 'service', 'relatedServices', 'footerData', 'menus'));
    }

    public function wearLiners()
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.services.wear-liners', compact('logo', 'footerData', 'menus'));
    }

    public function conveyorGuards()
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.services.conveyor-guards', compact('logo', 'footerData', 'menus'));
    }

    public function shopNew()
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.shop-new', compact('logo', 'footerData', 'menus'));
    }

    public function industries()
    {
        $logo       = Logo::first();
        $industries = Industry::orderBy('created_at', 'asc')->get();
        $footerData = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.industries', compact('industries', 'logo', 'footerData', 'menus'));
    }

    public function faq()
    {
        $logo            = Logo::first();
        $footerData      = FooterMain::first();
        $printingFaqs    = \App\Models\PrintingFaq::orderBy('created_at', 'asc')->get();
        $scanningFaqs    = \App\Models\ScanningFaq::orderBy('created_at', 'asc')->get();
        $engineeringFaqs = \App\Models\EngineeringFaq::orderBy('created_at', 'asc')->get();
        $routingFaqs     = \App\Models\RoutingFaq::orderBy('created_at', 'asc')->get();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.faq', compact(
            'logo', 'footerData',
            'printingFaqs', 'scanningFaqs', 'engineeringFaqs', 'routingFaqs',
            'menus'
        ));
    }

    public function blog(Request $request)
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $categories  = \App\Models\BlogCategory::withCount('blogs')->orderBy('name', 'asc')->get();
        $tags        = \App\Models\BlogTag::withCount('blogs')->orderBy('name', 'asc')->get();
        $recentPosts = \App\Models\Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')->take(5)->get();

        $query = \App\Models\Blog::with(['categories', 'tags'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title',   'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate(9);

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.blog', compact('blogs', 'categories', 'tags', 'recentPosts', 'logo', 'footerData', 'menus'));
    }

    public function blogShow($slug)
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $blog = \App\Models\Blog::with(['categories', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedPosts = \App\Models\Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->whereHas('categories', function ($q) use ($blog) {
                $q->whereIn('blog_categories.id', $blog->categories->pluck('id'));
            })
            ->orderBy('published_at', 'desc')
            ->take(3)->get();

        $recentPosts = \App\Models\Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(5)->get();

        $categories = \App\Models\BlogCategory::withCount('blogs')->orderBy('name', 'asc')->get();
        $tags       = \App\Models\BlogTag::withCount('blogs')->orderBy('name', 'asc')->get();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.blog-single', compact(
            'blog', 'relatedPosts', 'recentPosts',
            'categories', 'tags', 'logo', 'footerData', 'menus'
        ));
    }

    public function blogCategory($slug)
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $category = \App\Models\BlogCategory::where('slug', $slug)->firstOrFail();

        $blogs = \App\Models\Blog::with(['categories', 'tags'])
            ->where('status', 'published')
            ->whereHas('categories', function ($q) use ($category) {
                $q->where('blog_categories.id', $category->id);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories  = \App\Models\BlogCategory::withCount('blogs')->orderBy('name', 'asc')->get();
        $tags        = \App\Models\BlogTag::withCount('blogs')->orderBy('name', 'asc')->get();
        $recentPosts = \App\Models\Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')->take(5)->get();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.blog', compact('blogs', 'category', 'categories', 'tags', 'recentPosts', 'logo', 'footerData', 'menus'));
    }

    public function blogTag($slug)
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $tag = \App\Models\BlogTag::where('slug', $slug)->firstOrFail();

        $blogs = \App\Models\Blog::with(['categories', 'tags'])
            ->where('status', 'published')
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('blog_tags.id', $tag->id);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories  = \App\Models\BlogCategory::withCount('blogs')->orderBy('name', 'asc')->get();
        $tags        = \App\Models\BlogTag::withCount('blogs')->orderBy('name', 'asc')->get();
        $recentPosts = \App\Models\Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')->take(5)->get();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.blog', compact('blogs', 'tag', 'categories', 'tags', 'recentPosts', 'logo', 'footerData', 'menus'));
    }

    public function contact()
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.contact', compact('logo', 'footerData', 'menus'));
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'required|email|max:255',
            'address'      => 'nullable|string|max:500',
            'product_name' => 'nullable|string|max:255',
            'message'      => 'nullable|string|max:2000',
        ]);

        $contact = Contact::create($validated);

        try {
            Mail::to('developer.deepak56256@gmail.com')->send(new ContactFormMail($contact));
        } catch (\Exception $e) {
            \Log::error('Admin email failed: ' . $e->getMessage());
        }

        try {
            Mail::to($contact->email)->send(new ContactConfirmationMail($contact));
        } catch (\Exception $e) {
            \Log::error('User confirmation email failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    public function uploadFile()
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.upload-file', compact('logo', 'footerData', 'menus'));
    }

    public function uploadFileSubmit(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'required|email|max:255',
            'address'      => 'required|string|max:500',
            'product_name' => 'required|string|max:255',
            'file'         => 'required|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(base_path('uploads/quotations'), $filename);
            $validated['file_path'] = 'uploads/quotations/' . $filename;
        }

        \App\Models\Quotation::create($validated);

        return redirect()->back()->with('success', 'Thank you! We will review your file and get back to you soon.');
    }

    // ══════════════════════════════════════════════════════════════
    //  SHOP  —  ✅ MariaDB-compatible sorting
    //  ❌ OLD (broken):  orderByRaw('COALESCE(sale_price, price) ASC NULLS LAST')
    //  ✅ NEW (fixed):   CASE WHEN approach — works on MySQL & MariaDB
    // ══════════════════════════════════════════════════════════════
    public function shop(Request $request)
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        // ── Sidebar data ──────────────────────────────────────────
        $categories = \App\Models\ProductCategory::withCount(['products' => function ($q) {
                $q->where('status', 'published');
            }])
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $tags = \App\Models\ProductTag::withCount(['products' => function ($q) {
                $q->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        $totalProducts = \App\Models\Product::where('status', 'published')->count();

        // ── Filter context ────────────────────────────────────────
        $currentCategory = null;
        $currentTag      = null;

        // ── Base query ────────────────────────────────────────────
        $query = \App\Models\Product::with(['categories', 'tags', 'images', 'variants'])
            ->where('status', 'published');

        // Category filter
        if ($request->filled('category')) {
            $currentCategory = \App\Models\ProductCategory::where('slug', $request->category)->first();
            if ($currentCategory) {
                $query->whereHas('categories', function ($q) use ($currentCategory) {
                    $q->where('product_categories.id', $currentCategory->id);
                });
            }
        }

        // Tag filter
        if ($request->filled('tag')) {
            $currentTag = \App\Models\ProductTag::where('slug', $request->tag)->first();
            if ($currentTag) {
                $query->whereHas('tags', function ($q) use ($currentTag) {
                    $q->where('product_tags.id', $currentTag->id);
                });
            }
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_price', '>=', $request->min_price)
                  ->orWhere(function ($q2) use ($request) {
                      $q2->whereNull('sale_price')
                         ->where('price', '>=', $request->min_price);
                  });
            });
        }
        if ($request->filled('max_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_price', '<=', $request->max_price)
                  ->orWhere(function ($q2) use ($request) {
                      $q2->whereNull('sale_price')
                         ->where('price', '<=', $request->max_price);
                  });
            });
        }

        // In-stock filter
        if ($request->filled('in_stock')) {
            $query->where('stock_quantity', '>', 0);
        }

        // On-sale filter
        if ($request->filled('on_sale')) {
            $query->whereNotNull('sale_price')
                  ->whereColumn('sale_price', '<', 'price');
        }

        // ── Sorting ───────────────────────────────────────────────
        // ⚠️  "NULLS LAST" is PostgreSQL syntax — NOT supported in MariaDB/MySQL.
        // ✅  We use CASE WHEN to achieve the same result safely.
        switch ($request->get('sort', 'latest')) {

            case 'price_low':
                // Effective price: sale_price if > 0, otherwise price.
                // Products with no price at all go to the bottom.
                $query->orderByRaw("
                    CASE
                        WHEN (sale_price IS NULL OR sale_price = 0)
                             AND (price IS NULL OR price = 0) THEN 1
                        ELSE 0
                    END ASC,
                    CASE
                        WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price
                        ELSE price
                    END ASC
                ");
                break;

            case 'price_high':
                $query->orderByRaw("
                    CASE
                        WHEN (sale_price IS NULL OR sale_price = 0)
                             AND (price IS NULL OR price = 0) THEN 1
                        ELSE 0
                    END ASC,
                    CASE
                        WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price
                        ELSE price
                    END DESC
                ");
                break;

            case 'oldest':
                $query->oldest('published_at');
                break;

            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;

            case 'featured':
                $query->orderBy('is_featured', 'desc')->latest('published_at');
                break;

            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $products = $query->paginate(16)->withQueryString();

        return view('frontend.shop', compact(
            'logo', 'footerData', 'menus',
            'products', 'categories', 'tags',
            'totalProducts', 'currentCategory', 'currentTag'
        ));
    }

    public function shopCategory(Request $request, $categorySlug)
    {
        $request->merge(['category' => $categorySlug]);
        return $this->shop($request);
    }

    public function privacyPolicy()
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();
        $page       = PrivacyPolicy::first();

        if (!$page) {
            abort(404);
        }

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.privacy-policy', compact('logo', 'footerData', 'menus', 'page'));
    }

    public function termsOfService()
    {
        $logo       = Logo::first();
        $footerData = FooterMain::first();
        $page       = TermsOfService::first();

        if (!$page) {
            abort(404);
        }

        $menus = \App\Models\Menu::whereNull('parent_id')
                ->with('children.children')
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();

        return view('frontend.terms-of-service', compact('logo', 'footerData', 'menus', 'page'));
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// ============================================
// API METHODS FOR REACT
// ============================================

public function apiSliders()
{
    $sliders = Slider::orderBy('created_at', 'desc')->get();
    return response()->json($sliders);
}
public function apiHomeCategories()
{
    $categories = \App\Models\HomeCategory::orderBy('sort_order', 'asc')->get();
    return response()->json($categories);
}
public function apiOfferings()
{
    $offering = Offering::first();
    return response()->json($offering);
}

public function apiCoreValues()
{
    $coreValues = CoreValue::orderBy('created_at', 'asc')->get();
    return response()->json($coreValues);
}

public function apiCoreValuesMain()
{
    $coreValueMain = CoreValueMain::first();
    return response()->json($coreValueMain);
}

public function apiExperienceThePower()
{
    $experience = ExperienceThePower::first();
    return response()->json($experience);
}

public function apiServices()
{
    $services = OurService::orderBy('created_at', 'asc')->get();
    return response()->json($services);
}

public function apiServiceDetail($slug)
{
    $service = OurService::where('slug', $slug)->first();
    if (!$service) {
        return response()->json(['error' => 'Service not found'], 404);
    }
    return response()->json($service);
}

public function apiProducts()
{
    $products = Product::with(['categories', 'tags', 'images', 'variants'])
        ->where('status', 'published')
        ->latest('published_at')
        ->get();
    return response()->json($products);
}

public function apiProductDetail($slug)
{
    $product = Product::with(['categories', 'tags', 'images', 'variants'])
        ->where('slug', $slug)
        ->where('status', 'published')
        ->first();
    
    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }
    return response()->json($product);
}





public function apiContactSubmit(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'message' => 'nullable|string|max:2000',
    ]);

    Contact::create($validated);
    
    return response()->json(['message' => 'Contact submitted successfully'], 201);
}

public function apiFaqs()
{
    $printingFaqs = \App\Models\PrintingFaq::orderBy('created_at', 'asc')->get();
    $scanningFaqs = \App\Models\ScanningFaq::orderBy('created_at', 'asc')->get();
    $engineeringFaqs = \App\Models\EngineeringFaq::orderBy('created_at', 'asc')->get();
    $routingFaqs = \App\Models\RoutingFaq::orderBy('created_at', 'asc')->get();
    
    return response()->json([
        'printing' => $printingFaqs,
        'scanning' => $scanningFaqs,
        'engineering' => $engineeringFaqs,
        'routing' => $routingFaqs,
    ]);
}

public function apiIndustries()
{
    $industries = Industry::orderBy('created_at', 'asc')->get();
    return response()->json($industries);
}

public function apiLogo()
{
    $logo = Logo::first();
    return response()->json($logo);
}

public function apiFooter()
{
    $footer = FooterMain::first();
    return response()->json($footer);
}

public function apiMenus()
{
    $menus = \App\Models\Menu::whereNull('parent_id')
        ->with('children.children')
        ->where('is_active', 1)
        ->orderBy('order')
        ->get();
    return response()->json($menus);
}


public function apiProductSection($id)
{
    $section = \App\Models\HomeProductSection::find($id);
    if (!$section) {
        return response()->json(['error' => 'Not found'], 404);
    }
    return response()->json($section);
}

public function apiProductSectionProducts($id)
{
    $section = \App\Models\HomeProductSection::find($id);
    if (!$section || !$section->is_active) {
        return response()->json([]);
    }

    // ✅ Category filter apply karo
    $query = \App\Models\Product::with(['categories', 'variants', 'images'])
        ->where('status', 'published');

    // ✅ Agar category_id set hai to filter karo
    if ($section->category_id) {
        $query->whereHas('categories', function ($q) use ($section) {
            $q->where('product_categories.id', $section->category_id);
        });
    }

    $products = $query->latest('published_at')
                      ->take($section->product_limit ?? 12)
                      ->get();

    return response()->json($products);
}


public function apiPromotionalBanner()
{
    $banner = \App\Models\PromotionalBanner::where('is_active', 1)->first();
    return response()->json($banner);
}


public function apiIndustriesWeServe()
{
    $industries = \App\Models\IndustryWeServe::orderBy('created_at', 'desc')->get();
    return response()->json($industries);
}

public function apiVideoSection($id)
{
    $section = \App\Models\HomeVideoSection::find($id);
    if (!$section) return response()->json(['error' => 'Not found'], 404);
    return response()->json($section);
}

public function apiVideoSectionVideos($id)
{
    $section = \App\Models\HomeVideoSection::find($id);
    if (!$section || !$section->is_active) return response()->json([]);
    return response()->json([
        'section' => $section,
        'videos'  => $section->videos ?? [],
    ]);
}


public function apiLatestBlogs()
{
    $blogs = \App\Models\Blog::with(['categories', 'tags'])
        ->where('status', 'published')
        ->latest('published_at')
        ->take(8) // Get 8 blogs for the slider (4 on desktop, 1.5 on mobile)
        ->get();
    return response()->json($blogs);
}
 
// Existing method (keep as is)
public function apiBlogs()
{
    $blogs = \App\Models\Blog::with(['categories', 'tags'])
        ->where('status', 'published')
        ->latest('published_at')
        ->get();
    return response()->json($blogs);
}

public function apiBrandSection() {
    $section = \App\Models\HomeBrandSection::first();
    return response()->json($section);
}

public function apiBrands() {
    $brands = \App\Models\HomeBrand::where('is_active', 1)->orderBy('sort_order')->get();
    return response()->json($brands);
}

public function apiAnnouncementBar()
{
    $bar = \App\Models\AnnouncementBar::where('is_active', 1)->first();
    return response()->json($bar);
}









/* Catageory page */


// SHOP API - Collections page ke liye
public function apiShop(Request $request)
{
    $cacheKey = 'shop_' . md5($request->fullUrl());

    $data = Cache::remember($cacheKey, 300, function () use ($request) {
        
        $query = Product::with(['categories', 'variants', 'images'])
            ->where('status', 'published');

        if ($request->filled('category')) {
            $cat = ProductCategory::where('slug', $request->category)->first();
            if ($cat) {
                $query->whereHas('categories', function ($q) use ($cat) {
                    $q->where('product_categories.id', $cat->id);
                });
            }
        }

        $sort = $request->get('sort', 'latest');
        if ($sort === 'price_low')  $query->orderByRaw("COALESCE(sale_price, price) ASC");
        elseif ($sort === 'price_high') $query->orderByRaw("COALESCE(sale_price, price) DESC");
        elseif ($sort === 'name_asc')   $query->orderBy('title', 'asc');
        else $query->latest('published_at');

        $products   = $query->paginate(16);
        $categories = ProductCategory::withCount([
            'products' => fn($q) => $q->where('status', 'published')
        ])->where('is_active', 1)->orderBy('name')->get();

        return [
            'products'   => $products->items(),
            'categories' => $categories,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'total'        => $products->total(),
            ],
        ];
    });

    return response()->json($data);
}
// CATEGORIES - Sidebar ke liye
public function apiCategories()
{
    $categories = ProductCategory::withCount([
        'products' => fn($q) => $q->where('status', 'published')
    ])
        ->where('is_active', 1)
        ->orderBy('name')
        ->get();

    return response()->json($categories);
}








/*

public function addToWishlist(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
    ]);

    try {
        // Check karo ki pehle se wishlist mein hai ya nahi
        $exists = \App\Models\Wishlist::where('product_id', $request->product_id)->first();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Already in wishlist'
            ], 409);
        }

        // Naya wishlist item add karo
        \App\Models\Wishlist::create([
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Added to wishlist'
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
} */


// app/Http/Controllers/FrontendController.php


public function addToWishlist(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
    ]);
 
    // ← Firebase UID se user dhundho
    $firebaseUid = $request->header('X-Firebase-UID');
    $user = $firebaseUid
        ? \App\Models\GoogleUser::where('firebase_uid', $firebaseUid)->first()
        : null;
 
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Please login.'
        ], 401);
    }
 
    try {
        // ← Sirf is user ke liye duplicate check karo
        $exists = \App\Models\Wishlist::where('product_id', $request->product_id)
            ->where('user_id', $user->id)
            ->first();
 
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Already in wishlist'
            ], 409);
        }
 
        \App\Models\Wishlist::create([
            'product_id' => $request->product_id,
            'user_id'    => $user->id,  // ← Ab user_id save hoga
        ]);
 
        return response()->json([
            'success' => true,
            'message' => 'Added to wishlist'
        ], 201);
 
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
 
public function removeFromWishlist($productId)
{
    // ← Firebase UID se user dhundho
    $firebaseUid = request()->header('X-Firebase-UID');
    $user = $firebaseUid
        ? \App\Models\GoogleUser::where('firebase_uid', $firebaseUid)->first()
        : null;
 
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Please login.'
        ], 401);
    }
 
    try {
        // ← Sirf is user ka record delete karo
        $deleted = \App\Models\Wishlist::where('product_id', $productId)
            ->where('user_id', $user->id)
            ->delete();
 
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Removed from wishlist'
            ]);
        }
 
        return response()->json([
            'success' => false,
            'message' => 'Not found in wishlist'
        ], 404);
 
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
 
public function getWishlist()
{
    // ← Firebase UID se user dhundho
    $firebaseUid = request()->header('X-Firebase-UID');
    $user = $firebaseUid
        ? \App\Models\GoogleUser::where('firebase_uid', $firebaseUid)->first()
        : null;
 
    if (!$user) {
        return response()->json([
            'success'  => true,
            'count'    => 0,
            'products' => []
        ]);
    }
 
    try {
        // ← Sirf is user ki wishlist fetch karo
        $wishlists = \App\Models\Wishlist::with(['product.images', 'product.variants'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
 
        $products = $wishlists->map(fn($item) => $item->product)->filter()->values();
 
        return response()->json([
            'success'  => true,
            'count'    => $products->count(),
            'products' => $products
        ]);
 
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
 
public function checkWishlistStatus($productId)
{
    // ← Firebase UID se user dhundho
    $firebaseUid = request()->header('X-Firebase-UID');
    $user = $firebaseUid
        ? \App\Models\GoogleUser::where('firebase_uid', $firebaseUid)->first()
        : null;
 
    if (!$user) {
        // ← Login nahi hai to sirf false return karo (error nahi)
        return response()->json([
            'success'    => true,
            'in_wishlist' => false
        ]);
    }
 
    try {
        // ← Sirf is user ke liye check karo
        $inWishlist = \App\Models\Wishlist::where('product_id', $productId)
            ->where('user_id', $user->id)
            ->exists();
 
        return response()->json([
            'success'    => true,
            'in_wishlist' => $inWishlist
        ]);
 
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
 

public function wishlistPage()
{
    $logo       = Logo::first();
    $footerData = FooterMain::first();

    $wishlists = \App\Models\Wishlist::with('product')
        ->orderBy('created_at', 'desc')
        ->get();

    $products = $wishlists->map(function($item) {
        return $item->product;
    })->filter(); // NULL values remove karne ke liye

    $menus = \App\Models\Menu::whereNull('parent_id')
            ->with('children.children')
            ->where('is_active', 1)
            ->orderBy('order')
            ->get();

    return view('frontend.wishlist', compact('logo', 'footerData', 'menus', 'products'));
}




// ============================================
// GOOGLE AUTH API
// ============================================

public function googleLoginOrRegister(Request $request)
{
    $request->validate([
        'firebase_uid' => 'required|string',
        'name'         => 'required|string',
        'email'        => 'required|email',
        'avatar'       => 'nullable|string',
    ]);

    try {
        $user = \App\Models\GoogleUser::updateOrCreate(
            ['firebase_uid' => $request->firebase_uid],
            [
                'name'     => $request->name,
                'email'    => $request->email,
                'avatar'   => $request->avatar,
                'provider' => 'google',
            ]
        );

        return response()->json([
            'success' => true,
            'user'    => $user,
            'message' => 'Login successful!',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function googleGetUser($firebase_uid)
{
    $user = \App\Models\GoogleUser::where('firebase_uid', $firebase_uid)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'user'    => $user,
    ], 200);
}

// FrontendController.php mein add karo
public function apiProductDiscount($productId)
{
    $now = now();

    $discount = \App\Models\Discount::where('is_active', 1)
        ->where(function($q) use ($now) {
            $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })
        ->where(function($q) use ($now) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
        })
        ->where(function($q) use ($productId) {
            $q->whereHas('rule', function($r) {
                $r->where('applies_to', 'all_products');
            })
            ->orWhereHas('products', function($p) use ($productId) {
                $p->where('product_id', $productId)
                  ->where('product_type', 'product');
            })
            ->orWhereHas('products', function($p) use ($productId) {
                $p->where('product_type', 'collection')
                  ->whereIn('product_id', function($sub) use ($productId) {
                      $sub->select('product_category_id')
                          ->from('product_category_product')
                          ->where('product_id', $productId);
                  });
            });
        })
        ->where('type', '!=', 'free_shipping')
        ->with(['rule', 'bxgy'])   // ✅ bxgy bhi load karo
        ->orderBy('value', 'desc')
        ->first();

    if (!$discount) {
        return response()->json(['has_discount' => false]);
    }

    // ✅ BXGY ka alag response
    if ($discount->type === 'buy_x_get_y') {
        $bxgy = $discount->bxgy;
        if (!$bxgy) return response()->json(['has_discount' => false]);

        return response()->json([
            'has_discount'       => true,
            'type'               => 'buy_x_get_y',
            'title'              => $discount->title,
            'buy_quantity'       => $bxgy->buy_quantity,
            'get_quantity'       => $bxgy->get_quantity,
            'get_value_type'     => $bxgy->get_value_type, // 'free', 'percentage', 'amount'
            'get_value'          => $bxgy->get_value,
            'max_uses_per_order' => $bxgy->max_uses_per_order,
        ]);
    }

    // Normal discount response
    return response()->json([
        'has_discount'  => true,
        'type'          => $discount->type,
        'value_type'    => $discount->value_type,
        'value'         => $discount->value,
        'title'         => $discount->title,
        'min_quantity'  => $discount->rule?->min_quantity ?? 0,
        'min_amount'    => $discount->rule?->min_amount ?? 0,
    ]);
}


public function apiFreeShippingDiscount()
{
    $now = now();

    $discount = \App\Models\Discount::where('is_active', 1)
        ->where('type', 'free_shipping')
        ->where(function($q) use ($now) {
            $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })
        ->where(function($q) use ($now) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
        })
        ->with('rule')
        ->first();

    if (!$discount) {
        return response()->json(['has_discount' => false]);
    }

    return response()->json([
        'has_discount' => true,
        'title'        => $discount->title,
        'min_amount'   => $discount->rule?->min_amount ?? 0,
    ]);
}

public function apiCheckCartDiscount(Request $request)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.product_id' => 'required|integer',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    $discounts = [];
    
    foreach ($request->items as $item) {
        $product = Product::find($item['product_id']);
        
        $discount = Discount::where('is_active', 1)
            ->where('type', 'buy_x_get_y')
            ->with(['rule', 'bxgy'])
            ->first();
        
        if ($discount && $discount->type === 'buy_x_get_y') {
            $bxgy = $discount->bxgy;
            $applicable = $item['quantity'] >= ($bxgy->buy_quantity ?? 1);
            
            if ($applicable) {
                $freeQty = floor($item['quantity'] / ($bxgy->buy_quantity ?? 1)) * ($bxgy->get_quantity ?? 1);
                
                $discounts[$item['product_id']] = [
                    'applicable' => true,
                    'free_qty' => $freeQty,
                    'discount_label' => $discount->title,
                ];
            }
        }
    }
    
    return response()->json($discounts);
}

public function apiCalculateShipping(Request $request)
{
    $cartTotal = (float) $request->get('cart_total', 0);
    $country   = strtolower(trim($request->get('country', 'India')));

    // Free shipping discount check karo pehle
    $now = now();
    $freeDiscount = \App\Models\Discount::where('is_active', 1)
        ->where('type', 'free_shipping')
        ->where(function($q) use ($now) {
            $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })
        ->where(function($q) use ($now) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
        })
        ->with('rule')
        ->first();

    $freeShippingMin = $freeDiscount?->rule?->min_amount ?? 0;
    $isFreeShipping  = $freeShippingMin > 0 && $cartTotal >= $freeShippingMin;

    // Zone dhundho — case-insensitive country match
    $zones = \App\Models\ShippingZone::where('is_active', 1)->get();
    $matchedZone = null;

    foreach ($zones as $zone) {
        $countries = $zone->countries ?? [];
        
        // Countries lowercase karo comparison ke liye
        $countriesLower = array_map('strtolower', array_map('trim', $countries));
        
        if (empty($countries)) {
            // Empty = Rest of World fallback
            if (!$matchedZone) $matchedZone = $zone;
        } elseif (in_array($country, $countriesLower)) {
            $matchedZone = $zone;
            break;
        }
    }

    if (!$matchedZone) {
        return response()->json([
            'success'  => true,
            'methods'  => [],
            'message'  => 'No shipping available for this location',
        ]);
    }

    // Us zone ki active rates lo
    $rates = \App\Models\ShippingRate::with('method')
        ->where('zone_id', $matchedZone->id)
        ->where('is_active', 1)
        ->get();

    $methods = [];

    foreach ($rates as $rate) {
        if (!$rate->method || !$rate->method->is_active) continue;

        $charge   = 0;
        $eligible = true;

        switch ($rate->rate_type) {
            case 'free':
                $charge = 0;
                break;

            case 'flat_rate':
                $charge = $isFreeShipping ? 0 : (float) $rate->base_rate;
                break;

            case 'cart_value':
                if ($rate->min_cart_value && $cartTotal < $rate->min_cart_value) {
                    $eligible = false;
                } else {
                    $charge = $isFreeShipping ? 0 : (float) $rate->base_rate;
                }
                break;

            case 'weight_based':
                $charge = $isFreeShipping ? 0 : (float) $rate->base_rate;
                break;
        }

        if (!$eligible) continue;

        $methods[] = [
            'rate_id'       => $rate->id,
            'method_id'     => $rate->method->id,
            'name'          => $rate->method->name,
            'description'   => $rate->method->description,
            'delivery_time' => $rate->method->delivery_time,
            'charge'        => $charge,
            'rate_type'     => $rate->rate_type,
            'cod_available' => $rate->cod_available,
            'cod_charge'    => (float) $rate->cod_charge,
            'is_free'       => $charge == 0,
        ];
    }

    // Charge ke hisaab se sort karo
    usort($methods, fn($a, $b) => $a['charge'] <=> $b['charge']);

    return response()->json([
        'success'           => true,
        'zone'              => $matchedZone->name,
        'methods'           => $methods,
        'free_shipping_min' => $freeShippingMin,
        'is_free_shipping'  => $isFreeShipping,
    ]);
}
public function apiContactUs()
{
    $contactUs = \App\Models\ContactUs::first();
    return response()->json($contactUs);
}
public function apiPrivacyPolicy()
{
    $page = \App\Models\PrivacyPolicy::first();
 
    if (!$page) {
        return response()->json(['error' => 'Not found'], 404);
    }
 
    return response()->json($page);
}
 
public function apiTermsOfService()
{
    $page = \App\Models\TermsOfService::first();
 
    if (!$page) {
        return response()->json(['error' => 'Not found'], 404);
    }
 
    return response()->json($page);
}


 

public function apiFooterNew()
{
    $footer = \App\Models\FooterNew::first();
    return response()->json($footer);
}


public function apiGeneralFaqs()
{
    $faqs = \App\Models\Faq::orderBy('created_at', 'asc')->get();
    return response()->json($faqs);
}






public function apiGallery($id)
{
    $gallery = \App\Models\Gallery::find($id);
 
    if (!$gallery || !$gallery->is_active) {
        return response()->json(['error' => 'Gallery not found'], 404);
    }
 
    return response()->json([
        'id'          => $gallery->id,
        'title'       => $gallery->title,
        'slug'        => $gallery->slug,
        'description' => $gallery->description,
        'is_active'   => $gallery->is_active,
        'images_count' => $gallery->images()->count(),
        'videos_count' => $gallery->videos()->count(),
    ]);
}
 
public function apiGalleryMedia($id)
{
    $gallery = \App\Models\Gallery::find($id);
 
    if (!$gallery || !$gallery->is_active) {
        return response()->json(['error' => 'Gallery not found'], 404);
    }
 
    $images = $gallery->images()->orderBy('sort_order')->get()->map(function ($media) {
        return [
            'id'        => $media->id,
            'type'      => 'image',
            'url'       => asset('uploads/gallery/images/' . $media->file_name),
            'thumbnail' => asset('uploads/gallery/images/' . $media->file_name),
            'title'     => $media->title,
            'alt'       => $media->alt_tag,
        ];
    });
 
    $videos = $gallery->videos()->orderBy('sort_order')->get()->map(function ($media) {
        return [
            'id'        => $media->id,
            'type'      => 'video',
            'url'       => asset('uploads/gallery/videos/' . $media->file_name),
            'thumbnail' => $media->thumbnail
                ? asset('uploads/gallery/thumbnails/' . $media->thumbnail)
                : null,
            'title'     => $media->title,
            'alt'       => $media->alt_tag,
        ];
    });
 
    return response()->json([
        'gallery_id' => $gallery->id,
        'title'      => $gallery->title,
        'images'     => $images,
        'videos'     => $videos,
    ]);
}





public function apiProductReviews($productId)
{
    $reviews = \App\Models\ProductReview::where('product_id', $productId)
        ->where('is_approved', 1)
        ->orderBy('created_at', 'desc')
        ->get();
 
    // Rating breakdown
    $total     = $reviews->count();
    $avgRating = $total > 0 ? round($reviews->avg('rating'), 2) : 0;
 
    $breakdown = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    foreach ($reviews as $r) {
        $breakdown[(int)$r->rating]++;
    }
 
    return response()->json([
        'reviews'       => $reviews,
        'total'         => $total,
        'average'       => $avgRating,
        'breakdown'     => $breakdown,
    ]);
}
 
// ── 2. Review submit karo (POST) ─────────────────────────────
public function apiProductReviewStore(Request $request, $productId)
{
    $request->validate([
        'reviewer_name'  => 'required|string|max:255',
        'reviewer_email' => 'nullable|email|max:255',
        'rating'         => 'required|integer|min:1|max:5',
        'review_content' => 'required|string|min:5|max:2000',
    ]);
 
    // Product exist karta hai?
    $product = \App\Models\Product::where('id', $productId)
        ->where('status', 'published')
        ->firstOrFail();
 
    // Duplicate check - same email + same product
    if ($request->filled('reviewer_email')) {
        $exists = \App\Models\ProductReview::where('product_id', $productId)
            ->where('reviewer_email', $request->reviewer_email)
            ->exists();
 
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.',
            ], 409);
        }
    }
 
    $review = \App\Models\ProductReview::create([
        'product_id'     => $productId,
        'reviewer_name'  => $request->reviewer_name,
        'reviewer_email' => $request->reviewer_email,
        'rating'         => $request->rating,
        'review_content' => $request->review_content,
        'is_verified'    => false,
        'is_approved'    => true,
    ]);
 
    return response()->json([
        'success' => true,
        'message' => 'Review submitted successfully!',
        'review'  => $review,
    ], 201);
}

public function apiPageSeo($route)
{
    $seo = \App\Models\PageSeo::where('route_name', $route)->first();
    if (!$seo) return response()->json(['error' => 'Not found'], 404);
    return response()->json($seo);
}







}
