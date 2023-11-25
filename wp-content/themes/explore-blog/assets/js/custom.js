jQuery(function($) {

    /* -----------------------------------------
    Preloader
    ----------------------------------------- */
    $('#preloader').delay(1000).fadeOut();
    $('#loader').delay(1000).fadeOut("slow");

    /* -----------------------------------------
    Top Header Toggle
    ----------------------------------------- */
    $(".top-header-button").click(function(){
        $(this).toggleClass('active');
        $(".top-header-part-wrapper").toggle("ease");
    });
    $(window).on('load resize', function() {
        if ($(window).width() < 992 && $(window).width() >= 768) {
            $('.top-header-part-wrapper').find("a").unbind('keydown');
            $('.top-header-part-wrapper').find("li").last().bind('keydown', function(e) {
                if (e.which === 9) {
                    e.preventDefault();
                    $('.top-header-part ').find('.top-header-button').focus();
                }
            });
        } else if ($(window).width() < 768) {
            $('.top-header-part-wrapper').find("li").unbind('keydown');
            $('.top-header-part-wrapper').find("a").last().bind('keydown', function(e) {
                if (e.which === 9) {
                    e.preventDefault();
                    $('.top-header-part ').find('.top-header-button').focus();
                }
            });
        } else {
            $('.top-header-part-wrapper').find("li").unbind('keydown');
            $('.top-header-part-wrapper').find("a").unbind('keydown');
        }
    });

    /* -----------------------------------------
    Navigation
    ----------------------------------------- */
    $('.menu-toggle').click(function() {
        $(this).toggleClass('open');
    });

    /* -----------------------------------------
    Sticky Header
    ----------------------------------------- */
    if ( $("body").hasClass("header-fixed") ){
        const header = document.querySelector('.bottom-header-part');
        var lastScroll = 0;
        window.onscroll = function() {
            if (window.pageYOffset > 200) {
                header.classList.add('fix-header');
                setTimeout(function() { //give them a second to finish scrolling before doing a check
                    var scroll = $(window).scrollTop();
                    if (scroll > lastScroll + 30) {
                        $("body").removeClass("scroll-up");
                    } else if (scroll < lastScroll - 30) {
                        $("body").addClass("scroll-up");
                    }
                    lastScroll = scroll;
                }, 1000);
            } else {
                header.classList.remove('fix-header');
            }
        };
        $(window).on('load resize', function() {
            $(document).ready(function() {
                var divHeight = $('.bottom-header-part').height();
                $('.bottom-header-outer-wrapper').css('min-height', divHeight + 'px');
            });
        });
    }

    /* -----------------------------------------
    Keyboard Navigation
    ----------------------------------------- */
    $(window).on('load resize', function() {
        if ($(window).width() < 992 && $(window).width() >= 768) {
            $('.main-navigation').find("a").unbind('keydown');
            $('.main-navigation').find("li").last().bind('keydown', function(e) {
                if (e.which === 9) {
                    e.preventDefault();
                    $('#masthead').find('.menu-toggle').focus();
                }
            });
        } else if ($(window).width() < 768) {
            $('.main-navigation').find("li").unbind('keydown');
            $('.main-navigation').find("a").last().bind('keydown', function(e) {
                if (e.which === 9) {
                    e.preventDefault();
                    $('#masthead').find('.menu-toggle').focus();
                }
            });
        } else {
            $('.main-navigation').find("li").unbind('keydown');
            $('.main-navigation').find("a").unbind('keydown');
        }
    });

    var primary_menu_toggle = $('#masthead .menu-toggle');
    primary_menu_toggle.on('keydown', function(e) {
        var tabKey = e.keyCode === 9;
        var shiftKey = e.shiftKey;

        if (primary_menu_toggle.hasClass('open')) {
            if (shiftKey && tabKey) {
                e.preventDefault();
                $('.main-navigation').toggleClass('toggled');
                primary_menu_toggle.removeClass('open');
            };
        }
    });

    /* -----------------------------------------
    Search
    ----------------------------------------- */
    $('.header-search-wrap').find(".search-submit").bind('keydown', function(e) {
        var tabKey = e.keyCode === 9;
        if (tabKey) {
            e.preventDefault();
            $('.header-search-icon').focus();
        }
    });

    $('.header-search-icon').on('keydown', function(e) {
        var tabKey = e.keyCode === 9;
        var shiftKey = e.shiftKey;
        if ($('.header-search-wrap').hasClass('show')) {
            if (shiftKey && tabKey) {
                e.preventDefault();
                $('.header-search-wrap').removeClass('show');
                $('.header-search-icon').focus();
            }
        }
    });
    var searchWrap = $('.header-search-wrap');
    $(".header-search-icon").click(function(e) {
        e.preventDefault();
        searchWrap.toggleClass("show");
        searchWrap.find('input.search-field').focus();
    });
    $(document).click(function(e) {
        if (!searchWrap.is(e.target) && !searchWrap.has(e.target).length) {
            $(".header-search-wrap").removeClass("show");
        }
    });

    /* -----------------------------------------
    Main Slider style 1
    ----------------------------------------- */
    var swiper = new Swiper(".banner-section-style-1 .main-banner-slider .swiper-container", {
        loop: true,
        speed: 1000,
        allowSlidePrev: true,
        loopAdditionalSlides: 1,
        slidesPerView:1,
        parallax: true,
        keyboard: true,
        focusableElements: false,
        allowTouchMove: false,
        navigation: {
            nextEl: ".swiper-button-next.banner-style-1",
            prevEl: ".swiper-button-prev.banner-style-1",
        },
        on: {
            init: function() {
                updateButtonBackgrounds(this);
            },
            slideChange: function() {
                updateButtonBackgrounds(this);
            }
        }
    });

    function updateButtonBackgrounds(swiper) {
        var activeSlide = swiper.slides[swiper.activeIndex];
        var prevSlide = activeSlide.previousElementSibling || swiper.slides[swiper.slides.length - 1];
        var nextSlide = activeSlide.nextElementSibling || swiper.slides[0];

        var prevThumbnail = $(prevSlide).find('.banner-slider-single').css('background-image');
        var nextThumbnail = $(nextSlide).find('.banner-slider-single').css('background-image');

        $(".swiper-button-prev.banner-style-1").css('background-image', prevThumbnail);
        $(".swiper-button-next.banner-style-1").css('background-image', nextThumbnail);
    }

    /* -----------------------------------------
    Brands Slider
    ----------------------------------------- */
    var swiper = new Swiper(".brands-slider-wrapper", {
        loop: true,
        slidesPerView: 1,
        focusableElements: false,
        autoplay: true,
        preventClicks :true,
        a11y: false,
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 5,
            },
        },
    });
    
    /* -----------------------------------------
    trending story Slider
    ----------------------------------------- */
    var swiper = new Swiper(".trending-article-style-1 .trending-article-wrapper", {
        loop: true,
        spaceBetween: 30,
        slidesPerView: 1,
        focusableElements: false,
        preventClicks :true,
        a11y: false,
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
        navigation: {
            nextEl: ".swiper-button-next.trending-article-navigation",
            prevEl: ".swiper-button-prev.trending-article-navigation",
        },
        breakpoints: {
            640: {
                slidesPerView: 2.5,
            },
            768: {
                slidesPerView: 3.5,
            },
            1024: {
                slidesPerView: 3.5,
            },
        },
    });

    /* -----------------------------------------
    Counter
    ----------------------------------------- */
    if ($('.counter-section').length) {
        var counted = 0;
        $(window).scroll(function() {
            var oTop = $('.counter-section').offset().top - window.innerHeight;
            if (counted == 0 && $(window).scrollTop() > oTop) {
                $('.count').each(function() {
                    var $this = $(this),
                    countTo = $this.attr('data-count');
                    $({
                        countNum: $this.text()
                    }).animate({
                        countNum: countTo
                    }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                        }
                    });
                });
                counted = 1;
            }
        });
    }

    /* -----------------------------------------
    Scroll Top
    ----------------------------------------- */
    var scrollToTopBtn = $('.explore-blog-scroll-to-top');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 400) {
            scrollToTopBtn.addClass('show');
        } else {
            scrollToTopBtn.removeClass('show');
        }
    });

    scrollToTopBtn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, '300');
    });

});