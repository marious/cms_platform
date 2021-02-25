<?php

use Botble\Theme\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials" and "views"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
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
                ->usePath()->add('bootstrap', 'css/bootstrap.min.css')
                ->usePath()->add('magnific-popup', 'css/magnific-popup.css')
                ->usePath()->add('themify-icons', 'css/themify-icons.css')
                ->usePath()->add('all', 'css/all.min.css')
                ->usePath()->add('animate', 'css/animate.min.css')
                ->usePath()->add('jquery.mb.YTPlayer', 'css/jquery.mb.YTPlayer.min.css')
                ->usePath()->add('owl.carousel', 'css/owl.carousel.min.css')
                ->usePath()->add('owl.theme.default', 'css/owl.theme.default.min.css')
                ->usePath()->add('style', 'css/style.css')
                ->usePath()->add('responsive', 'css/responsive.css');

            $theme->asset()->container('footer')
                ->usePath()->add('jquery-3.4.1', 'js/jquery-3.4.1.min.js')
                ->usePath()->add('popper', 'js/popper.min.js')
                ->usePath()->add('bootstrap', 'js/bootstrap.min.js')
                ->usePath()->add('jquery.magnific-popup', 'js/jquery.magnific-popup.min.js')
                ->usePath()->add('jquery.easing', 'js/jquery.easing.min.js')
                ->usePath()->add('jquery.mb.YTPlayer', 'js/jquery.mb.YTPlayer.min.js')
                ->usePath()->add('mixitup', 'js/mixitup.min.js')
                ->usePath()->add('wow', 'js/wow.min.js')
                ->usePath()->add('owl.carousel', 'js/owl.carousel.min.js')
                ->usePath()->add('jquery.countdown', 'js/jquery.countdown.min.js')
                ->usePath()->add('validator', 'js/validator.min.js')
                ->usePath()->add('scripts', 'js/scripts.js');

            if (function_exists('shortcode')) {
                $theme->composer(['index', 'page', 'post'], function (\Botble\Shortcode\View\View $view) {
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
    ]
];
