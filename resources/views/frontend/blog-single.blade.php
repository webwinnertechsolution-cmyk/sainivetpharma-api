@extends('frontend.layouts.layout')

@section('title', $blog->meta_title ?? $blog->title . ' - Red-Labs')
@section('meta_description', $blog->meta_description ?? Str::limit(strip_tags($blog->excerpt ?? $blog->content), 160))
@section('meta_keywords', $blog->meta_keywords)
@section('og_title', $blog->og_title ?? $blog->meta_title ?? $blog->title)
@section('og_description', $blog->og_description ?? $blog->meta_description ?? Str::limit(strip_tags($blog->excerpt ?? $blog->content), 160))
@section('og_image', $blog->og_image ? asset('uploads/blogs/og/' . $blog->og_image) : ($blog->featured_image ? asset('uploads/blogs/' . $blog->featured_image) : asset('public/backend/assets/images/favicon.png')))

@section('body_class', 'header-style-1 header-fixed sidebar-right site-layout-full-width is-single-post footer- builder-default builder-kit-18')

@section('content')
<!-- Blog Banner 
<div class="blog-banner">
    <div class="blog-banner-content">
        <h1>Blog</h1>
    </div>
</div>
-->
<!-- Mobile Filter Button & Back Button -->
<div class="mobile-top-buttons">
    <a href="{{ route('frontend.blog') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Blog
    </a>
    <button id="filterToggle" class="filter-btn">
        <i class="fas fa-filter"></i> Filter
    </button>
</div>

<div id="main-content" class="site-main clearfix" style="display: block;">
    <div id="content-wrap" class="byron-container">
        
        <div id="site-content" style="width:72%" class="site-content clearfix">
            <div id="inner-content" class="inner-content-wrap">
                
                <article id="post-{{ $blog->id }}" class="clearfix post-{{ $blog->id }} post has-post-thumbnail {{ $blog->categories->map(fn($c) => 'category-'.$c->slug)->implode(' ') }} {{ $blog->tags->map(fn($t) => 'tag-'.$t->slug)->implode(' ') }}">
                    <div class="inner-content">
                        
                        @if($blog->featured_image)
                        <div class="post-media clearfix">
                            <img width="770" height="420" src="{{ asset('uploads/blogs/' . $blog->featured_image) }}" class="attachment-byron-post-standard size-byron-post-standard blog-featured-image" alt="{{ $blog->image_alt_tag ?? $blog->title }}" decoding="async" />
                        </div>
                        @endif

                        <h1 class="post-title">{{ $blog->title }}</h1>

                        <div class="post-meta style-1">
                            <div class="post-meta-content">
                                <div class="post-meta-content-inner clearfix">
                                    <span class="post-by-author item">
                                        <span class="gravatar">
                                            <img alt='' src='https://secure.gravatar.com/avatar/c2b5dc002998e6c17ab51f028197120d44687e652a5d8b22911d793ecc53e2e5?s=120&amp;d=mm&amp;r=g' class='avatar avatar-120 photo' height='120' width='120' decoding='async'/>
                                        </span> 
                                        <span class="text-wrap">
                                            <span class="text">Written by</span> <a class="name" href="/" title="View all posts by Red-Labs">DLLPL</a>
                                        </span>
                                    </span>
                                    <span class="post-date item">
                                        <span class="entry-date">{{ $blog->published_at ? $blog->published_at->format('F j, Y') : $blog->created_at->format('F j, Y') }}</span>
                                    </span>

                                </div>
                            </div>
                        </div>

                        <div class="post-content clearfix">
                            {!! $blog->content !!}
                        </div>

                        <div class="post-tags clearfix">
                            <span class="bib-tags">
                                @foreach($blog->tags as $tag)
                                <a href="{{ route('frontend.blog.tag', $tag->slug) }}" rel="tag">{{ $tag->name }}</a>
                                @endforeach
                            </span>
                        </div>

                    </div>
                    
                    <!-- Navigation Buttons 
                    <div class="post-navigation-buttons">
                        <a href="{{ route('frontend.blog') }}" class="nav-back-button">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to All Posts</span>
                        </a>
                        
                       
                    </div>
-->
                </article>

            </div><!-- /#inner-content -->
        </div><!-- /#site-content -->

        <div id="sidebar" class="sidebar-desktop">
            <div id="inner-sidebar" class="inner-content-wrap">
                
                <!-- Search Widget 
                <div id="search-1" class="widget widget_search">
                    <form role="search" method="get" action="{{ route('frontend.blog') }}" class="search-form">
                        <input type="search" class="search-field" placeholder="Type your keyword..." value="{{ request('search') }}" name="search" title="Search for:" />
                        <button type="submit" class="search-submit" title="Search">SEARCH
                            <svg viewBox="0 0 24 24" style="fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">
                                <path d="M11,3c4.4,0,8,3.6,8,8s-3.6,8-8,8s-8-3.6-8-8S6.6,3,11,3z M21,21l-4.4-4.4"/>
                            </svg>
                        </button>
                    </form>
                </div>
-->

<div class="post-navigation-buttons">
                        <a href="{{ route('frontend.blog') }}" class="nav-back-button">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to All Posts</span>
                        </a>
                        
                       
                    </div>
					
					
                <!-- Categories Widget -->
                @if($categories->count() > 0)
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
                @endif

                <!-- Recent Posts Widget -->
                @if($recentPosts->count() > 0)
                <div id="widget_news_post-1" class="widget widget_recent_posts">
                    <h2 class="widget-title"><span>Recent Posts</span></h2>
                    <ul class="recent-news clearfix">
                        @foreach($recentPosts as $post)
                        <li class="clearfix" style="padding-bottom:17.5px;margin-bottom:17.5px">
                            <div class="thumb show" style="width:70px;height:70px;;margin-right:15px">
                                @if($post->featured_image)
                                <a href="{{ route('frontend.blog.show', $post->slug) }}">
                                    <img width="140" height="140" src="{{ asset('uploads/blogs/' . $post->featured_image) }}" class="attachment-byron-post-widget size-byron-post-widget blog-widget-image" alt="{{ $post->image_alt_tag ?? $post->title }}" decoding="async" />
                                </a>
                                @endif
                            </div>
                            <div class="texts">
                                <h3><a href="{{ route('frontend.blog.show', $post->slug) }}" style="">{{ $post->title }}</a></h3>
                                <span class="post-date">{{ $post->published_at ? $post->published_at->format('F j, Y') : $post->created_at->format('F j, Y') }}</span>
                            </div>                
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Tags Widget 
                @if($tags->count() > 0)
                <div id="tag_cloud-1" class="widget widget_tag_cloud">
                    <h2 class="widget-title"><span>Tags</span></h2>
                    <div class="tagcloud">
                        @foreach($tags as $tag)
                        <a href="{{ route('frontend.blog.tag', $tag->slug) }}" class="tag-cloud-link tag-link-{{ $tag->id }} tag-link-position-{{ $loop->iteration }}" style="font-size: 14px;">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
-->
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
                <!-- Subscribe Widget
                <div id="text-1" class="widget widget_text">			
                    <div class="textwidget">
                        <div class="subscribe-box align-center" style="background-image: url('{{ asset('public/images/blog/subscribe-box-bg.jpg') }}'); background-size: cover; border-radius: 5px; overflow: hidden; padding: 115px 30px;">
                            <div class="text-wrap" style="color: #fff;">
                                <h3 class="title" style="color: #fff; font-size: 28px; margin-bottom: 19px;">Subscribe Now</h3>
                                <p>&nbsp;</p>
                                <p class="desc" style="font-size: 28px; line-height: 34px; font-weight: 300; margin-bottom: 64px;">Latest news about construction &amp; engineering</p>
                                <p><a class="btn" style="font-size: 16px; line-height: 46px; padding: 0 35px; border-radius: 3px; overflow: hidden; display: inline-block;" href="#">Subscribe</a></p>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div><!-- /#inner-sidebar -->
        </div><!-- /#sidebar -->

    </div><!-- /#content-wrap -->
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
        
        <!-- Search Widget 
        <div class="widget widget_search">
            <form role="search" method="get" action="{{ route('frontend.blog') }}" class="search-form">
                <input type="search" class="search-field" placeholder="Type your keyword..." value="{{ request('search') }}" name="search" title="Search for:" />
                <button type="submit" class="search-submit" title="Search">SEARCH
                    <svg viewBox="0 0 24 24" style="fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">
                        <path d="M11,3c4.4,0,8,3.6,8,8s-3.6,8-8,8s-8-3.6-8-8S6.6,3,11,3z M21,21l-4.4-4.4"/>
                    </svg>
                </button>
            </form>
        </div>-->

        <!-- Categories Widget -->
        @if($categories->count() > 0)
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
        @endif

        <!-- Recent Posts Widget -->
        @if($recentPosts->count() > 0)
        <div class="widget widget_recent_posts">
            <h2 class="widget-title"><span>Recent Posts</span></h2>
            <ul class="recent-news clearfix">
                @foreach($recentPosts as $post)
                <li class="clearfix" style="padding-bottom:17.5px;margin-bottom:17.5px">
                    <div class="thumb show" style="width:70px;height:70px;margin-right:15px">
                        @if($post->featured_image)
                        <a href="{{ route('frontend.blog.show', $post->slug) }}">
                            <img width="140" height="140" src="{{ asset('uploads/blogs/' . $post->featured_image) }}" class="attachment-byron-post-widget size-byron-post-widget blog-widget-image" alt="{{ $post->image_alt_tag ?? $post->title }}" decoding="async" />
                        </a>
                        @endif
                    </div>
                    <div class="texts">
                        <h3><a href="{{ route('frontend.blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
                        <span class="post-date">{{ $post->published_at ? $post->published_at->format('F j, Y') : $post->created_at->format('F j, Y') }}</span>
                    </div>                
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Tags Widget 
        @if($tags->count() > 0)
        <div class="widget widget_tag_cloud">
            <h2 class="widget-title"><span>Tags</span></h2>
            <div class="tagcloud">
                @foreach($tags as $tag)
                <a href="{{ route('frontend.blog.tag', $tag->slug) }}" class="tag-cloud-link tag-link-{{ $tag->id }} tag-link-position-{{ $loop->iteration }}" style="font-size: 14px;">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
        @endif
-->
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
    background: linear-gradient(135deg, #30674d 0%, #234a39 100%);
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

/* Mobile Top Buttons */
.mobile-top-buttons {
    display: none;
    padding: 0 15px;
    margin-bottom: 20px;
    gap: 10px;
}

.back-btn, .filter-btn {
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
    text-decoration: none;
}

.back-btn:hover, .filter-btn:hover {
    background: #234a39;
    transform: translateY(-2px);
    color: #fff;
}

.back-btn i, .filter-btn i {
    font-size: 14px;
}

/* Navigation Buttons */
.post-navigation-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #f0f0f0;
    gap: 20px;
}

.nav-back-button {
    background: #30674d;
    color: #fff;
    padding: 14px 28px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s;
}

.nav-back-button:hover {
    background: #234a39;
    transform: translateY(-2px);
    color: #fff;
}

.post-next-previous {
    display: flex;
    gap: 15px;
}

.nav-prev-post, .nav-next-post {
    background: #f8f8f8;
    color: #333;
    padding: 14px 24px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    border: 1px solid #e0e0e0;
}

.nav-prev-post:hover, .nav-next-post:hover {
    background: #30674d;
    color: #fff;
    border-color: #30674d;
    transform: translateY(-2px);
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

/* Card Style for Content Visibility on Dark Theme */
.is-single-post article .inner-content {
    background: #ffffff;
    padding: 40px;
    border-radius: 5px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* Sidebar Widgets Card Style */
#sidebar .widget {
    background: #ffffff;
    padding: 30px;
    margin-bottom: 30px;
    border-radius: 5px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* Featured Image Adjustment */
.is-single-post .post-media {
    margin: -40px -40px 30px -40px; 
    border-radius: 5px 5px 0 0;
    overflow: hidden;
}
.is-single-post .post-media img {
    width: 100%;
    height: auto;
    display: block;
}

/* Typography Colors */
.post-title {
    font-size: 32px;
    margin-bottom: 15px;
    color: #333333;
}
.post-content p {
    font-size: 16px;
    line-height: 1.8;
    color: #555555;
    margin-bottom: 20px;
}
.post-meta {
    font-size: 14px;
    color: #777777;
    margin-bottom: 20px;
}
.post-meta a {
    color: #DA200B;
    text-decoration: none;
}

/* Sidebar Specifics */
.widget-title {
    font-size: 20px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eeeeee;
    margin-top: 0;
    color: #333333; 
}
.widget-title span {
    border-bottom: 2px solid #30674d;
    padding-bottom: 15px;
}

/* Widget Lists */
.widget_categories ul, .recent-news { list-style: none; padding: 0; margin: 0; }
.widget_categories li { 
    padding: 10px 0; 
    border-bottom: 1px solid #f5f5f5; 
    display: flex; 
    justify-content: space-between; 
}
.widget_categories li a { color: #555; transition: color 0.3s; text-decoration: none; }
.widget_categories li a:hover { color: #30674d; }

/* Recent News Widget */
.recent-news li { display: flex; align-items: flex-start; }
.recent-news .thumb img { border-radius: 5px; object-fit: cover; }
.recent-news .texts h3 { font-size: 16px; line-height: 1.4; margin: 0 0 5px; }
.recent-news .texts h3 a { color: #333; text-decoration: none; }
.recent-news .texts h3 a:hover { color: #30674d; }

/* Tag Cloud */
.tagcloud a { 
    display: inline-block; 
    padding: 5px 10px; 
    background: #f5f5f5; 
    color: #666; 
    margin: 0 5px 5px 0; 
    font-size: 12px; 
    border-radius: 3px; 
    transition: all 0.3s; 
    text-decoration: none;
}
.tagcloud a:hover { background: #30674d; color: #fff; text-decoration: none; }

/* Search Form */
.search-form { position: relative; display: flex; }
.search-field { width: 100%; padding: 10px 15px; border: 1px solid #ddd; height: 50px; }
.search-submit { 
    position: absolute; right: 0; top: 0; height: 100%; 
    background: #30674d; color: #fff; border: none; 
    padding: 0 15px; width: 50px; font-size: 0; cursor: pointer; 
}
.search-submit:hover {
    background: #234a39;
}
.search-submit svg { width: 20px; height: 20px; stroke: #fff; fill: none; }

/* Subscribe Text Colour override for image bg */
.subscribe-box .title, .subscribe-box .desc { color: #ffffff !important; }

/* Custom Accent Colors for Blog Single Page */
.accent-color, a, .header-info .content:before, .header-button a, .header-top-menu ul li:hover, .header-socials a:hover, #footer-widgets .widget.widget_socials .socials a:hover, #main-nav > ul > li:hover > a, .header-style-1 #main-nav > ul > li:hover > a, .header-style-4 #main-nav > ul > li:hover > a, #main-nav .sub-menu li a:hover, .button, button, input[type="button"], input[type="reset"], input[type="submit"], .widget.widget_archive ul li a:hover, .widget.widget_categories ul li a:hover, .widget.widget_meta ul li a:hover, .widget.widget_nav_menu ul li a:hover, .widget.widget_pages ul li a:hover, .widget.widget_recent_entries ul li a:hover, .widget.widget_recent_comments ul li a:hover, .widget.widget_rss ul li a:hover, .post-meta .item.post-by-author a, .post-meta .item.post-comment a, .post-meta .item.post-meta-categories a, .post-link a, .widget.widget_recent_posts h3 a:hover, #sidebar .widget.widget_text .text-wrap .btn:hover, .logged-in-as a, #footer .widget.widget_information i, .products li .product-cat:hover, .products li h2:hover, .builder-element .master-link .icon, .builder-element .master-button.btn-outline, .builder-element .master-button.btn-white, .builder-element .master-heading .pre-heading, .builder-element .master-counter .icon-wrap, .builder-element .master-subscribe-form.style-2 button, .builder-element .master-project.style-1:hover .master-link, .builder-element .master-project.style-1:hover .master-link .icon, .builder-element .master-link:hover, .builder-element .master-subscribe-form button:hover, .builder-element .master-progress-bar .percent, .builder-element .master-icon, .builder-element .master-list .icon-wrap {
    color: #30674d !important;
}

/* Responsive */
@media (max-width: 768px) {
    .blog-banner {
        height: 150px;
    }
    
    .blog-banner h1 {
        font-size: 36px;
    }
    
    .mobile-top-buttons {
        display: flex;
    }
    
    .sidebar-desktop {
        display: none;
    }
    
    #site-content {
        width: 100% !important;
    }
    
    .post-navigation-buttons {
        flex-direction: column;
    }
    
    .nav-back-button {
        display: none; /* Hidden on mobile as we have top back button */
    }
    
    .post-next-previous {
        width: 100%;
        justify-content: space-between;
    }
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
div#content-wrap {
    max-width: 1200px!important;
}
div#content-wrap {
    max-width: 1200px!important;
    width: 1200px!important;
}
#sidebar {
    float: right;
    width: 25.624%;
    border-style: solid;
    border-color: #e7e7e7;
}
div#site-content {
    width: 73% !important;
}
.post-navigation-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: -33px;
    padding-top: 30px;
    border-top: 0px solid #f0f0f0;
    gap: 20px;
    margin-bottom: 22px;
    color: white!important;
}
.builder-kit-18 a {
    font-weight: 700;
    font-size: 12px;
}
.builder-kit-18 a {
    font-weight: 700;
    font-size: 12px;
    color: white!important;
}
div#widget_news_post-1 {
    padding-bottom: 23px!important;
}
.post-title {
    font-size: 26px;
    margin-bottom: 20px;
    color: #30674d!important;
}
img.avatar.avatar-120.photo {
    width: 34px;
    border-radius: 60px;
}
.post-content p {
    font-size: 14px;
    line-height: 22px;
    color: #000;
    margin-bottom: 20px;
}
div#main-content {
    margin-bottom: 44px;
}
#main-content {
    margin-top: 40px;
}





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
    
    .mobile-top-buttons {
        flex-direction: row;
    }
    
    .back-btn, .filter-btn {
        flex: 1;
        justify-content: center;
    }
				div#content-wrap {
				max-width: 100%!important;
				width: 100%!important;
			}
				div#site-content {
					width: 100% !important;
				}
				button#filterToggle {
					color: white!important;
				}
				.inner-content {
					padding-inline: 19px!important;
				}
				.post-media.clearfix img.attachment-byron-post-standard.size-byron-post-standard.blog-featured-image {
					width: 90%!important;
					margin: 0 auto;
				}
				div#main-content {
    margin-bottom: 0;
}
.mobile-top-buttons {
    margin-top:25px;
    position: relative;
    z-index: 9999;
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
