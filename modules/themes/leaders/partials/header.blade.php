<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- SEO Meta description -->
    <meta name="description" content="">
    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
    <meta property="og:site_name" content=""/> <!-- website name -->
    <meta property="og:site" content=""/> <!-- website link -->
    <meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
    <meta property="og:description" content=""/> <!-- description shown in the actual shared post -->
    <meta property="og:image" content=""/> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content=""/> <!-- where do you want your post to link to -->
    <meta property="og:type" content="article"/>
    <!--title-->
    <title>CorporX Corporate and Business HTML Template</title>
    <!--favicon icon-->
    <link rel="icon" href="{!! Theme::asset()->url('img/favicon.png') !!}" type="image/png" sizes="16x16">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700%7COpen+Sans:400,600&display=swap" rel="stylesheet">
    {!! Theme::header() !!}
</head>
<body @if (class_exists('Language', false) && Language::getCurrentLocaleRTL()) dir="rtl" @endif>
    <!--loader start-->
    <div id="preloader">
        <div class="loader1">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!--loader end-->

    <!--header section start-->
    <header class="header">
        <div id="header-top-bar" class="primary-bg py-2">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-7 col-lg-7 d-none d-md-block d-lg-block">
                        <div class="topbar-text text-white">
                            <ul class="list-inline">
                                <li class="list-inline-item"><span class="fas fa-envelope mr-1"></span> <a href="mailto:{{ theme_option('contact_email') }}">{{ theme_option('contact_email') }}</a></li>
                                <li class="list-inline-item"><span class="fas fa-map-marker mr-1"></span> {{ theme_option('address') }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="topbar-text text-white">
                            <ul class="list-inline text-md-right text-lg-right text-left">
                                <li class="list-inline-item"><span class="ti-phone mr-2"></span> Call Now: <strong>{{ theme_option('phone_number') }}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg fixed-top white-bg">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="{!! Theme::asset()->url('img/logo-color.png') !!}" alt="logo" class="img-fluid"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="ti-menu"></span>
                </button>
                <div class="collapse navbar-collapse h-auto" id="navbarSupportedContent">
                    {!!
                        Menu::renderMenuLocation('main-menu', [
                            'options' => ['class' => 'navbar-nav ml-auto menu'],
                            'view'    => 'main-menu',
                        ])
                    !!}
                </div>
            </div>
        </nav>
    </header>
    <!--header section end-->

    <!--body content wrap start-->
    <div class="main">


