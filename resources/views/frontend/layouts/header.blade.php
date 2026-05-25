<header id="site-header" class="header-fixed" style="background-color: #30674d;padding: 88px 0;border-bottom: 1px solid #FFFFFF80;">
    <style>
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .wrap-inner {
            display: flex;
            align-items: center;
        }
        #main-nav {
            margin: 0;
        }
        #menu-red-labs {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0px;
        }
        .mobile-button {
            display: none;
        }
		div#site-header-wrap {
    display: block;
    margin-bottom: 34px;
}
.site-header-inner {
    height: 91px !important;
    display: flex !important;
    align-items: center !important;
}
.menu-item {
    padding-inline: 13px!important;
}
.header-fixed.fixed-hide.fixed-show {
    display: none!important;
}
#site-header {
    position: unset!important;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
div#site-header-wrap {
    display: block;
    margin-bottom: 0;
}
.fit-vids-style {
    display: none;
}

        @media (max-width: 1024px) {
            .header-container {
                padding: 0 !important;
            }
           
            .site-header-inner {
                flex-wrap: wrap !important;
            }
            .wrap-inner {
                width: 100% !important;
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .mobile-button {
                display: block !important;
            }
            #main-nav {
                display: none !important;
                width: 100% !important;
                padding: 15px 0 !important;
            }
            #main-nav.active {
                display: block !important;
            }
            #main-nav-mobi {
                padding: 15px 20px !important;
            }
            #main-nav-mobi .menu {
                padding-left: 0 !important;
            }
            #main-nav-mobi .menu-item {
                margin: 0px 0;
            }
            #main-nav-mobi .sub-menu {
                padding-left: 20px !important;
            }
            #menu-red-labs {
                display: block;
                width: 100%;
                padding-left: 20px;
            }
            #menu-red-labs .menu-item {
                margin: 0px 0;
            }
        }

#main-nav-mobi ul li {
    border-top: 1px solid #8f9491cf !important ;
}
#main-nav-mobi {
    background-color: #30674d !important;
}
 @media (max-width: 767px) {		
		.main-logo img {
    height: auto !important;
    width: 140px;
    max-width: 400px !important;
}
 }



    </style>
    <div class="header-container">
        <div class="site-header-inner" style="display: flex; align-items: center; justify-content: space-between;">
            
            <div id="site-logo">
                <div id="site-logo-inner" style="max-width:400px;">
                    <a class="main-logo" href="{{ url('/') }}" title="Red-Labs" rel="home">
                        @if(isset($logo) && $logo->image)
                            <img src="{{ asset('uploads/logo/' . $logo->image) }}" alt="Red-Labs" style="height: auto;width: 140px;" />
                        @else
                            <img src="{{ asset('frontend/images/logo.png') }}" alt="Red-Labs" style="height: 90px; width: auto;" />
                        @endif
                    </a>
                </div>
            </div><!-- #site-logo -->
            
            <div class="wrap-inner">
                
                <div class="mobile-button"><span></span></div>

                <nav id="main-nav" class="main-nav">
                    <ul id="menu-red-labs" class="menu">
                        @if(isset($menus))
                            @foreach($menus as $menu)
                                @if($menu->children->count() > 0)
                                    <li id="menu-item-{{ $menu->id }}" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children {{ Request::is(trim($menu->url, '/').'*') ? 'current-menu-item' : '' }}" style="position: relative;">
                                        <a href="{{ $menu->url == '#' ? '#' : url($menu->url) }}" style="color: white; text-decoration: none; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 0;"><span>{{ $menu->title }}</span></a>
                                        <ul class="sub-menu">
                                            @foreach($menu->children as $child)
                                                @if($child->children->count() > 0)
                                                    <li id="menu-item-{{ $child->id }}" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children {{ Request::is(trim($child->url, '/').'*') ? 'current-menu-item' : '' }}">
                                                        <a href="{{ url($child->url) }}"><span>{{ $child->title }}</span></a>
                                                        <ul class="sub-menu">
                                                            @foreach($child->children as $grandchild)
                                                                 <li id="menu-item-{{ $grandchild->id }}" class="menu-item {{ Request::is(trim($grandchild->url, '/')) ? 'current-menu-item' : '' }}">
                                                                    <a href="{{ url($grandchild->url) }}"><span>{{ $grandchild->title }}</span></a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li id="menu-item-{{ $child->id }}" class="menu-item {{ Request::is(trim($child->url, '/')) ? 'current-menu-item' : '' }}">
                                                        <a href="{{ url($child->url) }}"><span>{{ $child->title }}</span></a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li id="menu-item-{{ $menu->id }}" class="menu-item {{ Request::is(trim($menu->url, '/')) || (url($menu->url) == url('/') && Request::is('/')) ? 'current-menu-item' : '' }}">
                                        <a href="{{ url($menu->url) }}" style="color: white; text-decoration: none; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 0;"><span>{{ $menu->title }}</span></a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>	
                </nav>
                
            </div>
        </div>
    </div>
</header>
