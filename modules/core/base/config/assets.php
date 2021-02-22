<?php
define('LIB_PATH', '/vendor/core/base/libraries/');
return [
    'offline'           => env('ASSETS_OFFLINE', true),
    'enable_version'    => env('ASSETS_ENABLE_VERSION', false),
    'version'           => env('ASSETS_VERSION', time()),
    'scripts'           => [
        'jquery',
        'popper',
        'bootstrap',
        'core',
        'perfectScrollbar',
        'select2',
        'waves',
        'toastr',
        'script',
        'stickytableheaders',
        'jquery-waypoints',
        'fancybox',
        'datepicker',
        'custom-scrollbar',
    ],
    'styles' => [
        'fontawesome',
        'select2',
        'toastr',
        'simple-line-icons',
        'core',
        'fancybox',
        'datepicker',
        'custom-scrollbar',
    ],
    'resources' => [
        'scripts' => [
            'jquery' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => LIB_PATH . 'jquery/dist/jquery.min.js'
                ],
            ],
            'popper' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => LIB_PATH . 'popper/dist/umd/popper.min.js'
                ],
            ],
            'bootstrap' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => LIB_PATH . 'bootstrap/dist/js/bootstrap.min.js'
                ],
            ],
            'perfectScrollbar' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' =>  LIB_PATH . 'perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js'
                ],
            ],
            'waves' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/core/base/js/waves.js'
                ],
            ],
            'select2'                => [
                'use_cdn'  => true,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/select2/js/select2.min.js',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
            ],
            'core' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/core/base/js/core.js'
                ],
            ],
            'script' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/core/base/js/script.js'
                ],
            ],
            'toastr' => [
                'use_cdn'  => true,
                'location' => 'footer',
                'src'      => [
                    'local' => LIB_PATH . 'toastr/toastr.min.js',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.js',
                ],
            ],
            'jquery-waypoints'       => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => LIB_PATH . 'jquery-waypoints/jquery.waypoints.min.js',
                ],
            ],
            'bootstrap-editable'     => [
                'use_cdn'  => true,
                'location' => 'footer',
                'src'      => [
                    'local' => LIB_PATH . 'bootstrap3-editable/js/bootstrap-editable.min.js',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js',
                ],
            ],
            'datatables'             => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => [
                        LIB_PATH . 'datatables/media/js/jquery.dataTables.min.js',
                        LIB_PATH . 'datatables/media/js/dataTables.bootstrap.min.js',
                        LIB_PATH . 'datatables/extensions/Buttons/js/dataTables.buttons.min.js',
                        LIB_PATH . 'datatables/extensions/Buttons/js/buttons.bootstrap.min.js',
                    ],
                ],
            ],
            'spectrum'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => LIB_PATH . 'spectrum/spectrum.js',
                ],
            ],
            'jquery-ui' => [
                'use_cdn'  => true,
                'location' => 'footer',
                'src'      => [
                    'local' => LIB_PATH . 'jquery-ui/jquery-ui.min.js',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js',
                ],
            ],
            'jqueryTree'             => [
                'use_cdn'       => false,
                'location'      => 'footer',
                'include_style' => true,
                'src'           => [
                    'local' => LIB_PATH . 'jquery-tree/jquery.tree.min.js',
                ],
            ],
            'jquery-validation'      => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => [
                        LIB_PATH . 'jquery-validation/jquery.validate.min.js',
                        LIB_PATH . 'jquery-validation/additional-methods.min.js',
                    ],
                ],
            ],
            'moment'                 => [
                'use_cdn'  => true,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/moment-with-locales.min.js',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment-with-locales.min.js',
                ],
            ],
            'datetimepicker'         => [
                'use_cdn'  => true,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js',
                ],
            ],
            'datepicker'          => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                ],
            ],
            'form-validation' => [
                'use-cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/core/base/js/js-validation.js'
                ]
            ],
            'fancybox'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/fancybox/jquery.fancybox.min.js',
                    'cdn'   => '//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js',
                ],
            ],
            'cropper'                => [
                'use_cdn'  => true,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/cropper.min.js',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/cropper/0.7.9/cropper.min.js',
                ],
            ],
            'input-mask'             => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/jquery-inputmask/jquery.inputmask.bundle.min.js',
                ],
            ],

            'sortable'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/sortable/sortable.min.js',
                ],
            ],
            'blockui'                => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/jquery.blockui.min.js',
                ],
            ],
            'custom-scrollbar'       => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/mcustom-scrollbar/jquery.mCustomScrollbar.js',
                ],
            ],
            'stickytableheaders'     => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/stickytableheaders/jquery.stickytableheaders.js',
                ],
            ],
        ],

        /*------------ Stylesheets -------------- */
        'styles' => [
            'fontawesome'         => [
                'use_cdn'    => true,
                'location'   => 'header',
                'src'        => [
                    'local' => '/vendor/core/base/libraries/font-awesome/css/fontawesome.min.css',
                    'cdn'   => '//use.fontawesome.com/releases/v5.0.13/css/all.css',
                ],
            ],
            'datatables'          => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => [
                        LIB_PATH . 'datatables/media/css/dataTables.bootstrap.min.css',
                    ],
                ],
            ],
            'core' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/core/base/css/style.min.css',
                ],
            ],
            'bootstrap-editable'  => [
                'use_cdn'  => true,
                'location' => 'header',
                'src'      => [
                    'local' => LIB_PATH . 'bootstrap3-editable/css/bootstrap-editable.css',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css',
                ],
            ],
            'jqueryTree'          => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => LIB_PATH . 'jquery-tree/jquery.tree.min.css',
                ],
            ],
            'jquery-ui'           => [
                'use_cdn'  => true,
                'location' => 'footer',
                'src'      => [
                    'local' => LIB_PATH . 'jquery-ui/jquery-ui.min.css',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css',
                ],
            ],
            'datepicker'          => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                ],
            ],
            'datetimepicker'      => [
                'use_cdn'  => true,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css',
                ],
            ],
            'fancybox'            => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/fancybox/jquery.fancybox.min.css',
                    'cdn'   => '//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css',
                ],
            ],
            'toastr'              => [
                'use_cdn'  => true,
                'location' => 'header',
                'src'      => [
                    'local' => LIB_PATH . 'toastr/toastr.min.css',
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.css',
                ],
            ],
            'select2'             => [
                'use_cdn'  => true,
                'location' => 'header',
                'src'      => [
                    'local' => [
                        '/vendor/core/base/libraries/select2/css/select2.min.css',
                        '/vendor/core/base/libraries/select2/css/select2-bootstrap.min.css',
                    ],
                    'cdn'   => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css',
                ],
            ],
            'simple-line-icons'   => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/simple-line-icons/css/simple-line-icons.css',
                ],
            ],
            'spectrum'            => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => LIB_PATH . 'spectrum/spectrum.css',
                ],
            ],
            'custom-scrollbar'    => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/core/base/libraries/mcustom-scrollbar/jquery.mCustomScrollbar.css',
                ],
            ],
        ],
    ],
];
