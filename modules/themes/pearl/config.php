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
                ->usePath()->add('font-awesome', 'fontawesome-all.css')
                ->usePath()->add('flaticon', 'flaticon.css')
                ->usePath()->add('bootstrap', 'css/bootstrap.min.css')
                ->usePath()->add('mmenu', 'css/mmenu.css')
                ->usePath()->add('owl', 'css/owl.css')
                ->usePath()->add('animate', 'css/animate.css')
                ->usePath()->add('jquery.modal', 'css/jquery.modal.min.css')
                ->usePath()->add('style', 'css/style.css');

            $theme->asset()->container('footer')
                ->usePath()->add('jquery', 'js/jquery.js')
//                ->usePath()->add('popper', 'js/popper.min.js')
                ->usePath()->add('bootstrap', 'js/bootstrap.min.js')
                ->usePath()->add('mmenu', 'js/mmenu.js')
                ->usePath()->add('owl', 'js/owl.js')
                ->usePath()->add('appear', 'js/appear.js')
                ->usePath()->add('wow', 'js/wow.js')
                ->usePath()->add('jquery.modal', 'js/jquery.modal.min.js')
                ->usePath()->add('script', 'js/script.js');

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
