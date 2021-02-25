<?php
use EG\Theme\Theme;

return [
    'inherit' => null,

    'events' => [
        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function ($theme)
        {

        },
        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function (Theme $theme)
        {
// Partial composer.
            // $theme->partialComposer('header', function($view) {
            //     $view->with('auth', \Auth::user());
            // });

            // You may use this event to set up your assets.
            $theme->asset()->usePath()
                ->usePath()->add('bootstrap', 'css/bootstrap.css')
                ->usePath()->add('font-awesome', 'css/font-awesome.css')
                ->usePath()->add('flaticon', 'css/flaticon.css')
                ->usePath()->add('animate', 'css/animate.css')
                ->usePath()->add('owl', 'css/owl.css')
                ->usePath()->add('slick', 'css/slick.css')
                ->usePath()->add('jquery-ui', 'css/jquery-ui.css')
                ->usePath()->add('animation', 'css/animation.css')
                ->usePath()->add('swiper', 'css/swiper.min.css')
                ->usePath()->add('custom-animate', 'css/custom-animate.css')
                ->usePath()->add('jquery.fancybox', 'css/jquery.fancybox.min.css')
                ->usePath()->add('jquery.bootstrap-touchspin.css', 'css/jquery.bootstrap-touchspin.css')
                ->usePath()->add('jquery.mCustomScrollbar.min.css', 'css/jquery.mCustomScrollbar.min.css')
                ->usePath()->add('main', 'css/main.css')
                ->usePath()->add('responsive', 'css/responsive.css');

            $theme->asset()->container('footer')
                ->usePath()->add('jquery', 'js/jquery.js')
                ->usePath()->add('popper', 'js/popper.min.js')
                ->usePath()->add('jquery.scrollTo', 'js/jquery.scrollTo.js')
                ->usePath()->add('bootstrap', 'js/bootstrap.min.js')
                ->usePath()->add('tilt.jquery', 'js/tilt.jquery.min.js')
                ->usePath()->add('jquery.paroller', 'js/jquery.paroller.min.js')
                ->usePath()->add('parallax', 'js/parallax.min.js')
                ->usePath()->add('jquery.mCustomScrollbar.concat', 'js/jquery.mCustomScrollbar.concat.min.js')
                ->usePath()->add('jquery.fancybox', 'js/jquery.fancybox.js')
                ->usePath()->add('appear', 'js/appear.js')
                ->usePath()->add('owl', 'js/owl.js')
                ->usePath()->add('wow', 'js/wow.js')
                ->usePath()->add('mixitup', 'js/mixitup.js')
                ->usePath()->add('element-in-view', 'js/element-in-view.js')
                ->usePath()->add('swiper', 'js/swiper.min.js')
                ->usePath()->add('nav-tool', 'js/nav-tool.js')
                ->usePath()->add('jquery-ui', 'js/jquery-ui.js')
                ->usePath()->add('script', 'js/script.js');


            if (function_exists('shortcode')) {
                $theme->composer(['index', 'page', 'post'], function (\EG\Shortcode\View\View $view) {
                    $view->withShortcodes();
                });
            }
        },
        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [

            'default' => function ($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            }
        ]
    ],
];
