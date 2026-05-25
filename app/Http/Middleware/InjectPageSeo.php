<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\PageSeo;
class InjectPageSeo
{
    public function handle(Request $request, Closure $next): Response
    {
        // ── Admin/Backend routes pe SEO inject mat karo ──
        $adminPrefixes = [
            'admin', 'dashboard', 'logout',
            'footer', 'slider', 'logo', 'menus',
            'blog', 'product', 'homelogo', 'home-',
            'ourservice', 'ourworkprocess', 'industries',
            'whatwedo', 'corevalue', 'experience',
            'industry', 'offering', 'printing-faq',
            'scanning-faq', 'engineering-faq', 'routing-faq',
            'footermain', 'home-contact', 'quotation',
            'brand', 'pageseo', 'contact',
        ];

        $path = $request->path();
        foreach ($adminPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return $next($request);
            }
        }

        try {
            $route = Route::currentRouteName();
            if ($route) {
                $params = Route::current()->parameters();
                $slug = $params['slug'] ?? null;
                $query = PageSeo::where('route_name', $route);
                
                if ($slug) {
                    $query->where('page_slug', $slug);
                } else {
                    $query->whereNull('page_slug');
                }
                $seo = $query->first();

                if (!$seo && $slug) {
                    $seo = PageSeo::where('route_name', $route)->whereNull('page_slug')->first();
                }

                if ($seo) {
                    $shareData = [
                        'title'            => $seo->title,
                        'meta_description' => $seo->meta_description,
                        'meta_keywords'    => $seo->meta_keywords,
                        'og_title'         => $seo->og_title ?: $seo->title,
                        'og_description'   => $seo->og_description ?: $seo->meta_description,
                    ];
                    
                    if ($seo->og_image) {
                        $shareData['og_image'] = asset('public/uploads/pages/' . $seo->og_image);
                    }
                    
                    View::share($shareData);
                }
            }
        } catch (\Exception $e) {
            Log::error('SEO Injection failed: ' . $e->getMessage());
        }

        return $next($request);
    }
}