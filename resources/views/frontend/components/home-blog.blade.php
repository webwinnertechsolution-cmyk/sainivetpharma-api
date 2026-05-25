{{-- Include in your layout's <head> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"> --}}
{{-- Before </body>: --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> --}}

@php
    $blogs = \App\Models\Blog::where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->take(5)
        ->get();
@endphp

@if($blogs->count() > 0)

<style>
/* ── Articles Section ── */
.articles-section {
    padding: 40px 0 50px;
    background: #fff;
}

.articles-section .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.articles-section .section-top {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 22px;
    padding: 0 4px;
}

.articles-section .section-top .left h2 {
    font-size: 22px;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0 0 4px;
    letter-spacing: -0.3px;
}

.articles-section .section-top .left p {
    font-size: 13.5px;
    color: #888;
    margin: 0;
}

.articles-section .view-all-link {
    font-size: 13.5px;
    font-weight: 700;
    color: #2a7c2e;
    text-decoration: none;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: gap 0.2s;
}

.articles-section .view-all-link:hover {
    gap: 8px;
    color: #1e5c21;
}

/* ── Scrollable Grid (Product Section Style) ── */
.articles-grid {
    display: flex;
    gap: 14px;
    overflow-x: auto;
    padding-bottom: 8px;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: #d1d5db #f3f4f6;
}

.articles-grid::-webkit-scrollbar {
    height: 5px;
}

.articles-grid::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 3px;
}

.articles-grid::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 3px;
}

/* ── Article Card ── */
.article-card {
    border-radius: 12px;
    overflow: hidden;
    border: 1.5px solid #ececec;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: box-shadow 0.25s, transform 0.25s;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    scroll-snap-align: start;
    flex-shrink: 0;
    width: 19% !important;
}

.article-card:hover {
    box-shadow: 0 6px 24px rgba(42,124,46,0.13);
    transform: translateY(-3px);
}

.article-card .card-img {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    display: block;
    background: #f0f7f0;
}

.article-card .card-img-placeholder {
    width: 100%;
    aspect-ratio: 1;
    background: linear-gradient(135deg, #f0f7f0, #e0ede0);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 12px;
}

.article-card .card-body {
    padding: 10px 11px 14px;
    border-top: 2.5px solid #f5a623;
    flex: 1;
}

.article-card .card-title {
    font-size: 12.5px;
    font-weight: 700;
    color: #2a7c2e;
    text-decoration: none;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.article-card .card-title:hover {
    color: #1e5c21;
}

/* ── Responsive ── */
@media (max-width: 767px) {
    .articles-section {
        padding: 40px 0 40px;
    }

    .articles-section .container {
        padding: 0;
    }

    .articles-section .section-top {
        margin-bottom: 13px;
        padding: 0 20px;
    }

    .articles-section .section-top .left h2 {
        font-size: 19px;
        font-weight: 500;
        color: #222;
        text-transform: capitalize;
    }

    .articles-section .section-top .left p {
        font-size: 13px;
    }

    .articles-section .view-all-link {
        font-size: 12.5px;
        color: #374151;
    }

    .articles-grid {
        padding-right: 20px;
        padding-left: 20px;
        padding-bottom: 20px;
    }

    .article-card {
        width: 250px !important;
    }

    .article-card .card-title {
        font-size: 12px;
    }

    .article-card .card-body {
        padding: 10px;
    }.articles-section .container {
    padding: 0;
    padding-left: 20px;
}
}
</style>

<section class="articles-section">
    <div class="container">

        {{-- Header row --}}
        <div class="section-top">
            <div class="left">
                <h2>Articles 📖</h2>
                <p>Farming tips in one place.</p>
            </div>
            <a href="{{ route('frontend.blog') }}" class="view-all-link">
                View All <span>→</span>
            </a>
        </div>

        {{-- Scrollable Grid --}}
        <div class="articles-grid">
            @foreach($blogs as $blog)
            <a href="{{ route('frontend.blog.show', $blog->slug) }}" class="article-card">
                @if($blog->featured_image)
                    <img 
                        src="/uploads/blogs/{{ $blog->featured_image }}" 
                        alt="{{ $blog->image_alt_tag ?? $blog->title }}" 
                        class="card-img"
                        loading="lazy"
                    >
                @else
                    <div class="card-img-placeholder">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                @endif
                <div class="card-body">
                    <div class="card-title">
                        {{ Str::limit($blog->title, 65) }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>

@endif