(function($) {


    "use strict";


    //Hide Loading Box (Preloader)
    function handlePreloader() {
        if($('.preloader').length){
            $('.preloader').delay(200).fadeOut(500);
        }
    }


    //Update Header Style and Scroll to Top
    function headerStyle() {
        if($('.main-header').length){
            var windowpos = $(window).scrollTop();
            var siteHeader = $('.main-header');
            var headerHeight = $('.main-header').height();
            //alert(headerHeight);
            var scrollLink = $('.scroll-to-top');
            if (windowpos >= headerHeight) {
                siteHeader.addClass('fixed-header');
                scrollLink.fadeIn(300);
            } else {
                siteHeader.removeClass('fixed-header');
                scrollLink.fadeOut(300);
            }
        }
    }

    headerStyle();


    //Hidden Sidebar
    if($('.hidden-bar').length) {
        var hiddenBar = $('.hidden-bar');
        var hiddenBarOpener = $('.info-btn');
        var hiddenBarCloser = $('.hidden-bar-closer');
        $('.hidden-bar-wrapper').mCustomScrollbar();

        //Show Sidebar
        hiddenBarOpener.on('click', function () {
            hiddenBar.addClass('visible-sidebar');
        });

        //Hide Sidebar
        hiddenBarCloser.on('click', function () {
            hiddenBar.removeClass('visible-sidebar');
        });
    }



    //Submenu Dropdown Toggle
    if($('.main-header li.dropdown ul').length){
        $('.main-header li.dropdown').append('<div class="dropdown-btn"><span class="fa fa-angle-down"></span></div>');

        //Dropdown Button
        $('.main-header li.dropdown .dropdown-btn').on('click', function() {
            $(this).prev('ul').slideToggle(500);
        });

        //Disable dropdown parent link
        $('.main-header .navigation li.dropdown > a,.hidden-bar .side-menu li.dropdown > a').on('click', function(e) {
            e.preventDefault();
        });


        // Dark Layout Button
        $('.dark-mode .dark-buttons .on').on('click', function() {
            $('.round').addClass('boll-right');
            $('body').addClass('dark-body');
        });

        // Dark Layout Button
        $('.dark-mode .dark-buttons .off').on('click', function() {
            $('.round').removeClass('boll-right');
            $('body').removeClass('dark-body');
        });

    }


    //Mobile Nav Hide Show
    if($('.mobile-menu').length){

        var mobileMenuContent = $('.main-header .nav-outer .main-menu .navigation').html();
        $('.mobile-menu .navigation').append(mobileMenuContent);
        $('.sticky-header .navigation').append(mobileMenuContent);
        $('.mobile-menu .close-btn').on('click', function() {
            $('body').removeClass('mobile-menu-visible');
        });
        //Dropdown Button
        $('.mobile-menu li.dropdown .dropdown-btn').on('click', function() {
            $(this).prev('ul').slideToggle(500);
        });
        //Menu Toggle Btn
        $('.mobile-nav-toggler').on('click', function() {
            $('body').addClass('mobile-menu-visible');
        });

        //Menu Toggle Btn
        $('.mobile-menu .menu-backdrop,.mobile-menu .close-btn').on('click', function() {
            $('body').removeClass('mobile-menu-visible');
        });

    }


    //Parallax Scene for Icons
    if($('.parallax-scene-1').length){
        var scene = $('.parallax-scene-1').get(0);
        var parallaxInstance = new Parallax(scene);
    }
    if($('.parallax-scene-2').length){
        var scene = $('.parallax-scene-2').get(0);
        var parallaxInstance = new Parallax(scene);
    }
    if($('.parallax-scene-3').length){
        var scene = $('.parallax-scene-3').get(0);
        var parallaxInstance = new Parallax(scene);
    }
    if($('.parallax-scene-4').length){
        var scene = $('.parallax-scene-4').get(0);
        var parallaxInstance = new Parallax(scene);
    }
    if($('.parallax-scene-5').length){
        var scene = $('.parallax-scene-5').get(0);
        var parallaxInstance = new Parallax(scene);
    }




    if($('.paroller').length){
        $('.paroller').paroller({
            factor: 0.2,            // multiplier for scrolling speed and offset, +- values for direction control
            factorLg: 0.4,          // multiplier for scrolling speed and offset if window width is less than 1200px, +- values for direction control
            type: 'foreground',     // background, foreground
            direction: 'horizontal' // vertical, horizontal
        });
    }



    //Header Search
    if($('.search-box-outer').length) {
        $('.search-box-outer').on('click', function() {
            $('body').addClass('search-active');
        });
        $('.close-search').on('click', function() {
            $('body').removeClass('search-active');
        });
    }



    //Custom Seclect Box
    if($('.custom-select-box').length){
        $('.custom-select-box').selectmenu().selectmenu('menuWidget').addClass('overflow');
    }



    //Main Slider Carousel
    if ($('.banner-carousel').length) {
        $('.banner-carousel').owlCarousel({
            animateOut: 'fadeOut',
            animateIn: 'slideInUp',
            loop:true,
            margin:0,
            nav:true,
            //autoHeight: true,
            autoplayHoverPause: true, // Stops autoplay
            smartSpeed: 500,
            autoplay: 6000,
            navText: [ '<span class="flaticon-left-arrow"></span>', '<span class="flaticon-right-arrow"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                800:{
                    items:1
                },
                1024:{
                    items:1
                },
                1200:{
                    items:1
                }
            }
        });
    }


    // Single Item Carousel
    if ($('.single-item-carousel').length) {
        $('.single-item-carousel').owlCarousel({
            //animateOut: 'fadeOut',
            //animateIn: 'fadeIn',
            loop:true,
            margin:0,
            nav:true,
            autoHeight: true,
            autoplayHoverPause: true, // Stops autoplay
            smartSpeed: 500,
            autoplay: 6000,
            navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                800:{
                    items:1
                },
                1024:{
                    items:1
                },
                1200:{
                    items:1
                }
            }
        });
    }




    // News Carousel
    if ($('.news-carousel').length) {
        $('.news-carousel').owlCarousel({
            //animateOut: 'fadeOut',
            //animateIn: 'fadeIn',
            loop:true,
            margin:0,
            nav:true,
            autoHeight: true,
            autoplayHoverPause: true, // Stops autoplay
            smartSpeed: 500,
            autoplay: 6000,
            navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                800:{
                    items:2
                },
                1024:{
                    items:3
                },
                1200:{
                    items:3
                }
            }
        });
    }




    // News Carousel
    if ($('.news-carousel-two').length) {
        $('.news-carousel-two').owlCarousel({
            //animateOut: 'fadeOut',
            //animateIn: 'fadeIn',
            loop:true,
            margin:0,
            nav:true,
            autoHeight: true,
            autoplayHoverPause: true, // Stops autoplay
            smartSpeed: 500,
            autoplay: 6000,
            navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                800:{
                    items:1
                },
                1024:{
                    items:2
                },
                1200:{
                    items:2
                }
            }
        });
    }





    // Services Carousel
    if ($('.services-carousel').length) {
        $('.services-carousel').owlCarousel({
            //animateOut: 'fadeOut',
            //animateIn: 'fadeIn',
            loop:true,
            margin:0,
            nav:true,
            autoHeight: true,
            autoplayHoverPause: true, // Stops autoplay
            smartSpeed: 500,
            autoplay: 6000,
            navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                800:{
                    items:2
                },
                1024:{
                    items:3
                },
                1200:{
                    items:3
                }
            }
        });
    }




    // Three Item Carousel
    if ($('.three-item-carousel').length) {
        $('.three-item-carousel').owlCarousel({
            //animateOut: 'fadeOut',
            //animateIn: 'fadeIn',
            loop:true,
            margin:30,
            nav:true,
            autoHeight: true,
            autoplayHoverPause: true, // Stops autoplay
            smartSpeed: 500,
            autoplay: 6000,
            navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                800:{
                    items:2
                },
                1024:{
                    items:3
                },
                1200:{
                    items:3
                }
            }
        });
    }




    // Four Item Carousel
    if ($('.four-item-carousel').length) {
        $('.four-item-carousel').owlCarousel({
            //animateOut: 'fadeOut',
            //animateIn: 'fadeIn',
            loop:true,
            margin:30,
            nav:true,
            autoHeight: true,
            autoplayHoverPause: true, // Stops autoplay
            smartSpeed: 500,
            autoplay: 6000,
            navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                800:{
                    items:3
                },
                1024:{
                    items:4
                },
                1200:{
                    items:4
                }
            }
        });
    }




    // Testimonial Carousel
    if ($('.testimonial-carousel').length) {
        $('.testimonial-carousel').owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            smartSpeed: 500,
            autoplay: 4000,
            navText: [ '<span class="flaticon-left-arrow-2"></span>', '<span class="flaticon-next-2"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                480:{
                    items:1
                },
                600:{
                    items:1
                },
                800:{
                    items:2
                },
                1024:{
                    items:2
                }
            }
        });
    }




    // Testimonial Carousel Two
    if ($('.testimonial-carousel-two').length) {
        $('.testimonial-carousel-two').owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            smartSpeed: 500,
            autoplay: 4000,
            navText: [ '<span class="flaticon-left-arrow-1"></span>', '<span class="flaticon-right-arrow-1"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                480:{
                    items:1
                },
                600:{
                    items:1
                },
                800:{
                    items:1
                },
                1024:{
                    items:1
                }
            }
        });
    }




    // Five Item Carousel
    if ($('.five-item-carousel').length) {
        $('.five-item-carousel').owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            smartSpeed: 500,
            autoplay: 4000,
            navText: [ '<span class="flaticon-left-arrow-2"></span>', '<span class="flaticon-next-2"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                480:{
                    items:1
                },
                600:{
                    items:1
                },
                800:{
                    items:2
                },
                1024:{
                    items:3
                },
                1224:{
                    items:4
                },
                1550:{
                    items:5
                }
            }
        });
    }




    // Sponsors Item Carousel
    if ($('.sponsors-carousel').length) {
        $('.sponsors-carousel').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            smartSpeed: 500,
            autoplay: 4000,
            navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
            responsive:{
                0:{
                    items:1
                },
                480:{
                    items:2
                },
                600:{
                    items:3
                },
                800:{
                    items:4
                },
                1024:{
                    items:4
                }
            }
        });
    }



    //Accordion Box
    if($('.accordion-box, .accordion-box-two, .accordion-box-three').length){
        $(".accordion-box, .accordion-box-two, .accordion-box-three").on('click', '.acc-btn', function() {

            var outerBox = $(this).parents('.accordion-box, .accordion-box-two, .accordion-box-three');
            var target = $(this).parents('.accordion');

            if($(this).hasClass('active')!==true){
                $(outerBox).find('.accordion .acc-btn').removeClass('active');
            }

            if ($(this).next('.acc-content').is(':visible')){
                return false;
            }else{
                $(this).addClass('active');
                $(outerBox).children('.accordion').removeClass('active-block');
                $(outerBox).find('.accordion').children('.acc-content').slideUp(300);
                target.addClass('active-block');
                $(this).next('.acc-content').slideDown(300);
            }
        });
    }




    //Fact Counter + Text Count
    if($('.count-box').length){
        $('.count-box').appear(function(){

            var $t = $(this),
                n = $t.find(".count-text").attr("data-stop"),
                r = parseInt($t.find(".count-text").attr("data-speed"), 10);

            if (!$t.hasClass("counted")) {
                $t.addClass("counted");
                $({
                    countNum: $t.find(".count-text").text()
                }).animate({
                    countNum: n
                }, {
                    duration: r,
                    easing: "linear",
                    step: function() {
                        $t.find(".count-text").text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $t.find(".count-text").text(this.countNum);
                    }
                });
            }

        },{accY: 0});
    }



    //Event Countdown Timer
    if($('.time-countdown').length){
        $('.time-countdown').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                var $this = $(this).html(event.strftime('' + '<div class="counter-column"><span class="count">%D</span>Days</div> ' + '<div class="counter-column"><span class="count">%H</span>Hours</div>  ' + '<div class="counter-column"><span class="count">%M</span>Minutes</div>  ' + '<div class="counter-column"><span class="count">%S</span>Seconds</div>'));
            });
        });
    }



    if($('.clock-wrapper').length){
        (function(){
            //generate clock animations
            var now       = new Date(),
                hourDeg   = now.getHours() / 12 * 360 + now.getMinutes() / 60 * 30,
                minuteDeg = now.getMinutes() / 60 * 360 + now.getSeconds() / 60 * 6,
                secondDeg = now.getSeconds() / 60 * 360,
                stylesDeg = [
                    "@-webkit-keyframes rotate-hour{from{transform:rotate(" + hourDeg + "deg);}to{transform:rotate(" + (hourDeg + 360) + "deg);}}",
                    "@-webkit-keyframes rotate-minute{from{transform:rotate(" + minuteDeg + "deg);}to{transform:rotate(" + (minuteDeg + 360) + "deg);}}",
                    "@-webkit-keyframes rotate-second{from{transform:rotate(" + secondDeg + "deg);}to{transform:rotate(" + (secondDeg + 360) + "deg);}}",
                    "@-moz-keyframes rotate-hour{from{transform:rotate(" + hourDeg + "deg);}to{transform:rotate(" + (hourDeg + 360) + "deg);}}",
                    "@-moz-keyframes rotate-minute{from{transform:rotate(" + minuteDeg + "deg);}to{transform:rotate(" + (minuteDeg + 360) + "deg);}}",
                    "@-moz-keyframes rotate-second{from{transform:rotate(" + secondDeg + "deg);}to{transform:rotate(" + (secondDeg + 360) + "deg);}}"
                ].join("");
            document.getElementById("clock-animations").innerHTML = stylesDeg;
        })();
    }



    //Progress Bar
    if($('.progress-line').length){
        $('.progress-line').appear(function(){
            var el = $(this);
            var percent = el.data('width');
            $(el).css('width',percent+'%');
        },{accY: 0});
    }



    //Jquery Spinner / Quantity Spinner
    if($('.quantity-spinner').length){
        $("input.quantity-spinner").TouchSpin({
            verticalbuttons: true
        });
    }



    // Tabs Box
    if($('.tabs-box').length){
        $('.tabs-box .tab-buttons .tab-btn').on('click', function(e) {
            e.preventDefault();
            var target = $($(this).attr('data-tab'));

            if ($(target).is(':visible')){
                return false;
            }else{
                target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                $(this).addClass('active-btn');
                target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab');
                $(target).fadeIn(300);
                $(target).addClass('active-tab');
            }
        });
    }



    //Gallery Filters
    if($('.filter-list').length){
        $('.filter-list').mixItUp({});
    }


    //LightBox / Fancybox
    if($('.lightbox-image').length) {
        $('.lightbox-image').fancybox({
            openEffect  : 'fade',
            closeEffect : 'fade',
            helpers : {
                media : {}
            }
        });
    }


    //Contact Form Validation
    if($('#contact-form').length){
        $('#contact-form').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                subject: {
                    required: true
                },
                message: {
                    required: true
                }
            }
        });
    }



    // Scroll to a Specific Div
    if($('.scroll-to-target').length){
        $(".scroll-to-target").on('click', function() {
            var target = $(this).attr('data-target');
            // animate
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1500);

        });
    }


    // Elements Animation
    if($('.wow').length){
        var wow = new WOW(
            {
                boxClass:     'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset:       0,          // distance to the element when triggering the animation (default is 0)
                mobile:       true,       // trigger animations on mobile devices (default is true)
                live:         true       // act on asynchronously loaded content (default is true)
            }
        );
        wow.init();
    }


    /* ==========================================================================
       When document is Scrollig, do
       ========================================================================== */

    $(window).on('scroll', function() {
        headerStyle();
    });

    /* ==========================================================================
       When document is loading, do
       ========================================================================== */

    $(window).on('load', function() {
        handlePreloader();
        //enableMasonry();
        //enableMasonryy();
    });

})(window.jQuery);
