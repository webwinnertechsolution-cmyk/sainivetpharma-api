<!-- Slick Slider JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<!-- Theme Dependencies -->
<script src="{{ asset('public/frontend/js/easing.js') }}"></script>
<script src="{{ asset('public/frontend/js/matchmedia.js') }}"></script>
<script src="{{ asset('public/frontend/js/fitvids.js') }}"></script>
<script src="{{ asset('public/frontend/js/animsition.js') }}"></script>

<!-- Main Theme JS -->
<script src="{{ asset('public/frontend/js/main.js') }}?v={{ time() }}"></script>

<script>
    jQuery(document).ready(function($){
        // Add a small delay to ensure DOM is fully loaded
        setTimeout(function() {
            // Initialize Main Slider (only if element exists)
            if ($('.rl-slider').length > 0 && $('.rl-slider').children().length > 0) {
                try {
                    $('.rl-slider').slick({
                        dots: false,
                        infinite: true,
                        speed: 600,
                        fade: true,
                        cssEase: 'linear',
                        autoplay: true,
                        autoplaySpeed: 6000,
                        arrows: true,
                        prevArrow: '<button type="button" class="slick-prev rl-slick-arrow"><i class="fas fa-chevron-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next rl-slick-arrow"><i class="fas fa-chevron-right"></i></button>',
                        pauseOnHover: false
                    });

                    // Initialize Animate.css on slide change
                    $('.rl-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
                        var $nextSlide = $(slick.$slides[nextSlide]);
                        $nextSlide.find('.animate__animated').each(function(){
                            var $this = $(this);
                            $this.removeClass('animate__fadeInUp');
                            void this.offsetWidth; // trigger reflow
                            $this.addClass('animate__fadeInUp');
                        });
                    });
                } catch(e) {
                    console.log('Slick slider initialization error:', e);
                }
            }

            // Initialize Services Slider (only if element exists)
            if ($('.rl-services-slider').length > 0 && $('.rl-services-slider').children().length > 0) {
                try {
                    $('.rl-services-slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
                } catch(e) {
                    console.log('Services slider initialization error:', e);
                }
            }

            // Initialize Work Process Slider (only if element exists)
            if ($('.rl-work-process-slider').length > 0 && $('.rl-work-process-slider').children().length > 0) {
                try {
                    $('.rl-work-process-slider').slick({
            dots: false,
            infinite: true,
            speed: 500,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev slick-arrow"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next slick-arrow"><i class="fas fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
                } catch(e) {
                    console.log('Work process slider initialization error:', e);
                }
            }
        }, 100); // 100ms delay to ensure DOM is ready

        // Mobile Menu Fix: Initialize immediately on ready
        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.mobile-button').show();
            
            // If main-nav exists and hasn't been moved yet, move it now
            if ($('#main-nav').length && !$('#main-nav-mobi').length) {
                var navLogo = $('.mobi-nav-extra').children('.menu-logo');
                var navExt = $('.mobi-nav-extra').children('.ext').filter(':not(".menu-logo")');
                
                $('#main-nav').attr('id', 'main-nav-mobi')
                    .appendTo('body')
                    .children('.menu').prepend(navLogo).append(navExt)
                    .find('li:has(ul)')
                    .children('ul')
                    .removeAttr('style')
                    .hide()
                    .before('<span class="arrow"></span>');

                // Inject Close Button (Inline Fallback)
                $('#main-nav-mobi').prepend('<span class="btn-menu-close"></span>');
            }
            
            // Ensure close button exists if menu was already moved
            if ($('#main-nav-mobi').length && !$('#main-nav-mobi .btn-menu-close').length) {
                $('#main-nav-mobi').prepend('<span class="btn-menu-close"></span>');
            }

            // Robust click handler for functionality
            $(document).off('click', '.mobile-button').on('click', '.mobile-button', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('hide');
                $('.mobi-overlay').addClass('show');
                $('html').addClass('disable-scroll');
                $("#main-nav-mobi").animate({ left: "0"}, 300);
            });

            $(document).off('click', '.mobi-overlay').on('click', '.mobi-overlay', function() {
                $('.mobile-button').removeClass('hide');
                $(this).removeClass('show');
                $("#main-nav-mobi").animate({ left: "-300px"}, 300);
                $('html').removeClass('disable-scroll');
            });

            // Close Menu Button Click Event (Inline Fallback)
            $(document).off('click', '.btn-menu-close').on('click', '.btn-menu-close', function() {
                $('.mobile-button').removeClass('hide');
                $('.mobi-overlay').removeClass('show');
                $("#main-nav-mobi").animate({ left: "-300px" }, 300);
                $('html').removeClass( 'disable-scroll' );
            });

            // Submenu toggles
            $(document).off('click', '#main-nav-mobi .arrow').on('click', '#main-nav-mobi .arrow', function() {
                $(this).toggleClass('active').next().stop().slideToggle();
            });
        }

        // Initialize Industries Slider (only if element exists) - with delay
        setTimeout(function() {
            if ($('.rl-industries-slider').length > 0 && $('.rl-industries-slider').children().length > 0) {
                try {
                    $('.rl-industries-slider').slick({
            dots: false,
            infinite: true,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev slick-arrow"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next slick-arrow"><i class="fas fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
                } catch(e) {
                    console.log('Industries slider initialization error:', e);
                }
            }
        }, 100); // 100ms delay to ensure DOM is ready

        // Fancy Image Animation Observer
        if ('IntersectionObserver' in window) {
            var fancyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        $(entry.target).addClass('is-in-view');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                threshold: 0.2
            });

            $('.master-fancy-image').each(function() {
                fancyImageObserver.observe(this);
            });
        } else {
            $('.master-fancy-image').addClass('is-in-view');
        }
    });
</script>
