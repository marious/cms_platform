@if (request()->input('media-action') === 'select-files')
    <html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {!! Assets2::renderHeader(['core']) !!}
        {!! RvMedia::renderHeader() !!}
    </head>
    <body>
    {!! RvMedia::renderContent() !!}

    @include('core/base::elements.common')
    {!! Assets2::renderFooter() !!}
    {!! RvMedia::renderFooter() !!}
    </body>
    </html>
@else
    {!! RvMedia::renderHeader() !!}

    {!! RvMedia::renderContent() !!}

    {!! RvMedia::renderFooter() !!}
@endif
