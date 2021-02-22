@extends('core/base::layouts.base')
@section('page')
    @include('core/base::layouts.partials.svg-icon')

    <div id="main-wrapper">
        @include('core/base::layouts.partials.top-header')
        @include('core/base::layouts.partials.sidebar')
        <div class="page-wrapper page-content">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <div class="page-content @if (Route::currentRouteName() == 'media.index') rv-media-integrate-wrapper @endif">
                            {!! Breadcrumbs::render('main', page_title()->getTitle(false)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                @yield('content')
            </div>

            <footer class="footer text-center">
                All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>


        </div><!-- ./page-wrapper -->
    </div><!-- ./main-wrapper -->
@stop

@section('javascript')
    @include('core/media::partials.media')
@endsection

@push('footer')
    @routes
@endpush
