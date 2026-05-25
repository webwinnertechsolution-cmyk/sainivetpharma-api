@extends('frontend.layouts.layout')

@section('title', $title ?? 'Blog - Red-Labs')

@section('body_class', 'header-style-1 header-fixed sidebar-right footer- builder-default builder-kit-18')

@section('content')
<!-- Blog Banner -->
<div class="blog-banner">
    <div class="blog-banner-content">
        <h1>Blog</h1>
    </div>
</div>

<!-- Mobile Filter Button -->
<div class="mobile-filter-btn">
    <button id="filterToggle" class="filter-btn">
        <i class="fas fa-filter"></i> Filter
    </button>
</div>

<div id="main-content" class="site-main clearfix" style="display: block;">
    <div id="content-wrap" class="container">
        
        <!-- Blog Grid Section -->
        <div class="blog-grid-section">
            <div class="blog-grid-container">
                @foreach($blogs as $blog)
                <div class="blog-grid-item">
                    <a href="{{ route('frontend.blog.show', $blog->slug) }}" class="blog-card">
                        <div class="blog-image">
                            <img src="{{ asset('uploads/blogs/' . $blog->featured_image) }}" alt="{{ $blog->image_alt_tag }}" />
                        </div>
                        <div class="blog-content">
                            <h3 class="blog-title">{{ $blog->title }}</h3>
                            <p class="blog-excerpt">{{ Str::limit(strip_tags($blog->excerpt ?? $blog->content), 120) }}</p>
                            <div class="blog-meta">
							<span class="blog-date">Read More</span>
                                <span class="blog-date">{{ $blog->created_at->format('F j, Y') }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="blog-pagination">
                {{ $blogs->links() }}
            </div>
        </div>

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-desktop">
            <div id="inner-sidebar" class="inner-content-wrap">
                
                <!-- Categories Widget -->
                <div id="categories-1" class="widget widget_categories">
                    <h2 class="widget-title"><span>Categories</span></h2>
                    <ul>
                        @foreach($categories as $category)
                        <li class="cat-item">
                            <a href="{{ route('frontend.blog.category', $category->slug) }}">{{ $category->name }}</a> 
                            <span>{{ $category->blogs_count }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Posts Widget -->
                <div id="widget_news_post-1" class="widget widget_recent_posts">
                    <h2 class="widget-title"><span>Recent Posts</span></h2>
                    <ul class="recent-news clearfix">
                        @foreach($recentPosts as $post)
                        <li class="clearfix" style="padding-bottom:17.5px;margin-bottom:17.5px">
                            <div class="thumb show" style="width:70px;height:70px;margin-right:15px">
                                <img width="140" height="140" src="{{ asset('uploads/blogs/' . $post->featured_image) }}" class="attachment-byron-post-widget size-byron-post-widget blog-widget-image" alt="{{ $post->image_alt_tag }}" decoding="async" />
                            </div>
                            <div class="texts">
                                <h3><a href="{{ route('frontend.blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
                                <span class="post-date">{{ $post->published_at ? $post->published_at->format('F j, Y') : $post->created_at->format('F j, Y') }}</span>
                            </div>                
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Socials Widget 
                <div id="widget_socials-1" class="widget widget_socials">
                    <h2 class="widget-title"><span>Follow Us</span></h2>
                    <div class="socials clearfix" style="margin: 0 -7.5px">
                        <div class="icon" style="padding: 0 7.5px;"><a target="_blank" title="twitter" href="https://www.twitter.com/" style="margin-bottom:7.5px;width:50px;height:50px;line-height:52px;font-size:16px;border-radius:50px"><i class="fab fa-twitter"></i></a></div>
                        <div class="icon" style="padding: 0 7.5px;"><a target="_blank" title="facebook-f" href="https://www.facebook.com/" style="margin-bottom:7.5px;width:50px;height:50px;line-height:52px;font-size:16px;border-radius:50px"><i class="fab fa-facebook-f"></i></a></div>
                        <div class="icon" style="padding: 0 7.5px;"><a target="_blank" title="linkedin-in" href="https://www.linkedin.com/" style="margin-bottom:7.5px;width:50px;height:50px;line-height:52px;font-size:16px;border-radius:50px"><i class="fab fa-linkedin-in"></i></a></div>
                        <div class="icon" style="padding: 0 7.5px;"><a target="_blank" title="instagram" href="https://www.instagram.com/" style="margin-bottom:7.5px;width:50px;height:50px;line-height:52px;font-size:16px;border-radius:50px"><i class="fab fa-instagram"></i></a></div>
                    </div>
                </div>
-->
            </div><!-- /#inner-sidebar -->
        </div><!-- /#sidebar -->

    </div>
</div>

<!-- Mobile Sidebar Drawer -->
<div id="sidebarDrawer" class="sidebar-drawer">
    <div class="drawer-header">
        <h3>Filter</h3>
        <button id="closeDrawer" class="close-drawer">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="drawer-content">
        
        <!-- Categories Widget -->
        <div class="widget widget_categories">
            <h2 class="widget-title"><span>Categories</span></h2>
            <ul>
                @foreach($categories as $category)
                <li class="cat-item">
                    <a href="{{ route('frontend.blog.category', $category->slug) }}">{{ $category->name }}</a> 
                    <span>{{ $category->blogs_count }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Recent Posts Widget -->
        <div class="widget widget_recent_posts">
            <h2 class="widget-title"><span>Recent Posts</span></h2>
            <ul class="recent-news clearfix">
                @foreach($recentPosts as $post)
                <li class="clearfix" style="padding-bottom:17.5px;margin-bottom:17.5px">
                    <div class="thumb show" style="width:70px;height:70px;margin-right:15px">
                        <img width="140" height="140" src="{{ asset('uploads/blogs/' . $post->featured_image) }}" class="attachment-byron-post-widget size-byron-post-widget blog-widget-image" alt="{{ $post->image_alt_tag }}" decoding="async" />
                    </div>
                    <div class="texts">
                        <h3><a href="{{ route('frontend.blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
                        <span class="post-date">{{ $post->published_at ? $post->published_at->format('F j, Y') : $post->created_at->format('F j, Y') }}</span>
                    </div>                
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Socials Widget
        <div class="widget widget_socials">
            <h2 class="widget-title"><span>Follow Us</span></h2>
            <div class="socials clearfix" style="margin: 0 -7.5px">
                <div class="icon" style="padding: 0 7.5px;"><a target="_blank" title="twitter" href="https://www.twitter.com/" style="margin-bottom:7.5px;width:50px;height:50px;line-height:52px;font-size:16px;border-radius:50px"><i class="fab fa-twitter"></i></a></div>
                <div class="icon" style="padding: 0 7.5px;"><a target="_blank" title="facebook-f" href="https://www.facebook.com/" style="margin-bottom:7.5px;width:50px;height:50px;line-height:52px;font-size:16px;border-radius:50px"><i class="fab fa-facebook-f"></i></a></div>
                <div class="icon" style="padding: 0 7.5px;"><a target="_blank" title="linkedin-in" href="https://www.linkedin.com/" style="margin-bottom:7.5px;width:50px;height:50px;line-height:52px;font-size:16px;border-radius:50px"><i class="fab fa-linkedin-in"></i></a></div>
                <div class="icon" style="padding: 0 7.5px;"><a target="_blank" title="instagram" href="https://www.instagram.com/" style="margin-bottom:7.5px;width:50px;height:50px;line-height:52px;font-size:16px;border-radius:50px"><i class="fab fa-instagram"></i></a></div>
            </div>
        </div>
 -->
    </div>
</div>

<!-- Drawer Overlay -->
<div id="drawerOverlay" class="drawer-overlay"></div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/byron-style.css') }}">
<style>
/* Blog Banner */
.blog-banner {
    width: 100%;
    height: 200px;
    background: #30674d;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 40px;
}

.blog-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
    opacity: 0.3;
}

.blog-banner-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.blog-banner h1 {
    color: #fff;
    font-size: 48px;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* Mobile Filter Button */
.mobile-filter-btn {
    display: none;
    padding: 0 15px;
    margin-bottom: 20px;
}

.filter-btn {
    background: #30674d;
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.filter-btn:hover {
    background: #234a39;
    transform: translateY(-2px);
}

.filter-btn i {
    font-size: 14px;
}

/* Sidebar Drawer (Mobile) */
.sidebar-drawer {
    position: fixed;
    top: 0;
    right: -350px;
    width: 350px;
    height: 100vh;
    background: #fff;
    box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    z-index: 9999;
    transition: right 0.3s ease;
    overflow-y: auto;
}

.sidebar-drawer.active {
    right: 0;
}

.drawer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e7e7e7;
    background: #f8f8f8;
}

.drawer-header h3 {
    margin: 0;
    font-size: 20px;
    color: #30674d;
    font-weight: 600;
}

.close-drawer {
    background: none;
    border: none;
    font-size: 24px;
    color: #666;
    cursor: pointer;
    padding: 5px;
    line-height: 1;
    transition: color 0.3s;
}

.close-drawer:hover {
    color: #30674d;
}

.drawer-content {
    padding: 20px;
}

.drawer-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0,0,0,0.5);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.drawer-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
    display: flex;
    gap: 30px;
}

/* Blog Grid Section */
.blog-grid-section {
    flex: 1;
}

.blog-grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-bottom: 50px;
}

.blog-grid-item {
    position: relative;
}

.blog-card {
    display: block;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    text-decoration: none;
    height: 100%;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(48, 103, 77, 0.15);
}

.blog-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    position: relative;
}

.blog-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-image img {
    transform: scale(1.05);
}

.blog-content {
    padding: 20px;
}

.blog-title {
    font-size: 14px;
    line-height: 19px;
    margin: 0 0 10px;
    color: #333;
    font-weight: 600;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.blog-card:hover .blog-title {
    color: #30674d!important;
}

.blog-excerpt {
    font-size: 14px;
    line-height: 18px;
    color: #666;
    margin: 0 0 -6px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-weight: 400;
}

.blog-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 15px;
    border-top: 1px solid #f0f0f0;
}

.blog-date {
    font-size: 12px;
    color: #30674d!important;
}

/* Pagination */
.blog-pagination {
    text-align: center;
    margin: 40px 0;
}

/* Sidebar */
#sidebar {
    width: 300px;
    flex-shrink: 0;
}

.widget {
    margin-bottom: 40px;
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.widget-title {
    font-size: 16px;
    margin: 0 0 13px 0;
    position: relative;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

.widget-title span {
    border-bottom: 2px solid #30674d!important;
    padding-bottom: 10px;
}

.widget_categories ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.widget_categories li {
    padding-bottom: 8px!important;
    padding-top: 8px!important;
    border-bottom: 1px solid #f5f5f5;
    display: flex;
    justify-content: space-between;
}

.widget_categories li a {
    font-family: "Inter", sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: #30674d!important;
    padding: 0;
    text-decoration: none;
}

.widget_categories li a:hover {
    color: #234a39!important;
}

.widget.widget_categories .cat-item span {
    display: inline-block;
    text-align: right;
    padding: 0 0px;
    margin: 0px 0;
    color: #777;
    font-size: 14px;
}

.recent-news {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-news li {
    display: flex;
    align-items: flex-start;
    padding-bottom: 0!important;
    margin-bottom: 8px!important;
}

.recent-news .thumb img {
    border-radius: 5px;
    object-fit: cover;
}

.recent-news .texts h3 {
    font-size: 16px;
    line-height: 16px;
    margin: 0 0 -1px;
}

.recent-news .texts h3 a {
    color: #30674d!important;
    text-decoration: none;
    font-size: 12px;
    line-height: 0px!important;
}

.recent-news .texts h3 a:hover {
    color: #234a39!important;
}

.recent-news .post-date {
    font-size: 12px;
    color: #aaa;
}

.widget.widget_recent_posts .recent-news .texts {
    overflow: hidden;
    width: 70%!important;
}

.thumb.show {
    width: 30%!important;
}

.socials {
    display: flex;
    flex-wrap: wrap;
}

.socials .icon a {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.socials .icon a:hover {
    background: #30674d !important;
    transform: translateY(-3px);
}

#inner-sidebar {
    padding: 17px 12px;
    border: 1px solid #e7e7e7;
    border-radius: 5px;
}

/* Tablet (3 columns) */
@media (max-width: 1024px) {
    .container {
        max-width: 960px;
    }
    
    .blog-grid-container {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    #sidebar {
        width: 280px;
    }
}

/* Tablet Portrait (2 columns) */
@media (max-width: 768px) {
    .blog-banner h1 {
        font-size: 36px;
    }
    
    .mobile-filter-btn {
        display: block;
    }
    
    .sidebar-desktop {
        display: none;
    }
    
    .container {
        flex-direction: column;
    }
    
    .blog-grid-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .blog-title {
        font-size: 16px;
    }
}
.blog-banner h1 {
    color: #fff;
    font-size: 30px;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.blog-banner {
    width: 100%;
    height: 107px;
    background: linear-gradient(135deg, #30674d 0%, #234a39 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 40px;
}
/* Mobile (1 column) */
@media (max-width: 767px) {
    .blog-banner {
        height: 150px;
    }
    
    .blog-banner h1 {
        font-size: 28px;
    }
    
    .sidebar-drawer {
        width: 90%;
        right: -90%;
    }
    
    .blog-grid-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .blog-image {
        height: 220px;
    }
    
    .blog-title {
        font-size: 18px;
        -webkit-line-clamp: 3;
    }
    
    .blog-excerpt {
        font-size: 15px;
    }
    
    .container {
        padding: 0 10px;
    }
}
/* Custom Accent Colors */
.accent-color, .header-info .content:before, .header-button a, .header-top-menu ul li:hover, .header-socials a:hover, #footer-widgets .widget.widget_socials .socials a:hover, .header-style-4 #main-nav > ul > li:hover > a, #main-nav .sub-menu li a:hover {
    color: #da200b !important;
}
#inner-sidebar {
    padding: 17px 12px;
    border: 1px solid #e7e7e7;
    border-radius: 5px;
}
#sidebar .widget .widget-title {
    font-size: 16px;
    margin: 0 0 13px 0;
}
.widget.widget_archive ul li a, .widget.widget_categories ul li a, .widget.widget_pages ul li a {
    font-family: "Inter", sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: #30674d!important;
    padding: 0;
}
.widget.widget_categories .cat-item span {
    display: inline-block;
    text-align: right;
    padding: 0 0px;
    margin: 0px 0;
    color: #777;
    font-size: 14px;
}
li.cat-item {
    padding-bottom: 8px!important;
    padding-top: 8px!important;
}
.recent-news .texts h3 a {
    color: #333;
    text-decoration: none;
    font-size: 12px;
    line-height: 0px!important;
}
.recent-news .texts h3 {
    font-size: 16px;
    line-height: 16px;
    margin: 0 0 5px;
}
.widget.widget_recent_posts .recent-news .texts {
    overflow: hidden;
    width: 70%!important;
}
.thumb.show {
    width: 30%!important;
}
li.clearfix {
    padding-bottom: 0!important;
    margin-bottom: 3px!important;
}
.widget.widget_recent_posts .post-date {
    font-size: 12px;
}
li.clearfix {
    padding-bottom: 0!important;
    margin-bottom: 8px!important;
}
.recent-news .texts h3 {
    font-size: 16px;
    line-height: 16px;
    margin: 0 0 -1px;
}
.recent-news .texts h3 a {
    color: #30674d!important;
    text-decoration: none;
    font-size: 12px;
    line-height: 0px!important;
}
.blog-card:hover .blog-title {
    color: #30674d!important;
}
.blog-title {
    font-size: 14px;
    line-height: 19px;
    margin: 0 0 10px;
    color: #333;
    font-weight: 600;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.blog-excerpt {
    font-size: 14px;
    line-height: 18px;
    color: #666;
    margin: 0 0 -6px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-weight: 400;
}
.blog-date {
    font-size: 12px;
    color: #30674d!important;
}
.widget-title span {
    border-bottom: 2px solid #30674d!important;
    padding-bottom: 10px;
}
div#content-wrap {
    padding-bottom: 40px;
}
div#widget_news_post-1 {
    margin-bottom: 8px!important;
}
.blog-excerpt {
    font-size: 14px;
    line-height: 18px;
    color: #666;
    margin: 0 0 11px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-weight: 400;
}
.blog-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 7px;
    border-top: 1px solid #f0f0f0;
    margin-bottom: -7px;
}

.blog-banner {
    width: 100%;
    height: 107px;
    background: #f0f4f0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 40px;
}
.blog-banner h1 {
    color: #30674d;
    font-size: 30px;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
}


@media (max-width: 767px) {
.blog-excerpt {
    font-size: 14px;
    line-height: 18px;
    color: #666;
    margin: 0 0 19px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-weight: 400;
}
div#content-wrap {
    padding-inline: 20px;
}
.blog-banner h1 {
    font-size: 22px;
}
.blog-banner {
    height: 95px;
}
.filter-btn {
    background: #30674d;
    color: #fff;
    border: none;
    padding: 2px 24px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    height: 33px;
}
.blog-excerpt {
    font-size: 14px;
    line-height: 18px;
    color: #666;
    margin: 0 0 15px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-weight: 400;
}
.blog-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #f0f0f0;
    margin-bottom: -7px;
}
.drawer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e7e7e7;
    background: #f8f8f8;
    padding-block: 1px;
}






}








</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterToggle = document.getElementById('filterToggle');
    const closeDrawer = document.getElementById('closeDrawer');
    const sidebarDrawer = document.getElementById('sidebarDrawer');
    const drawerOverlay = document.getElementById('drawerOverlay');
    
    // Open drawer
    if (filterToggle) {
        filterToggle.addEventListener('click', function() {
            sidebarDrawer.classList.add('active');
            drawerOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    
    // Close drawer
    function closeSidebarDrawer() {
        sidebarDrawer.classList.remove('active');
        drawerOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (closeDrawer) {
        closeDrawer.addEventListener('click', closeSidebarDrawer);
    }
    
    if (drawerOverlay) {
        drawerOverlay.addEventListener('click', closeSidebarDrawer);
    }
});
</script>
@endpush
