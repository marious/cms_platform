<!doctype html>
<html lang="{{ config('app.locale') }}" dir="{{ setting('locale_direction') == 'rtl' ? 'rtl': 'ltr'}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ page_title()->getTitle() }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    {!! Assets2::renderHeader(['core']) !!}
    @if(setting('locale_direction') == 'rtl')
        <link rel="stylesheet" href="{{ asset('vendor/rtl.css') }}">
    @endif
    @yield('head')
    @stack('header')
</head>
<body class="@yield('body-class')">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    @yield('page')

    @include('core/base::elements.common')

    {!! Assets2::renderFooter() !!}

    @yield('javascript')

    @stack('footer')

</body>
</html>
