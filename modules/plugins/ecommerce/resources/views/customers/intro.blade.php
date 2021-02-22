@extends('core/base::layouts.master')
@section('content')
    <div class="flexbox-grid">
        <div class="flexbox-content">
            <div class="body">
                <div class="box-wrap-emptyTmpl text-center col-12">
                    <h1 class="mt20 mb20 ws-nm font-size-emptyDisplayTmpl">{{ trans('plugins/ecommerce::customers.intro.title') }}</h1>
                    <p class="text-info-displayTmpl">{{ trans('plugins/ecommerce::customers.intro.description') }}</p>
                    <div class="empty-displayTmpl-pdtop">
                        <div class="empty-displayTmpl-image">
                            <img src="{{ asset('vendor/core/plugins/ecommerce/images/empty-customer.png') }}" alt="image">
                        </div>
                    </div>
                    <div class="empty-displayTmpl-btn">
                        <a class="btn btn-primary btn-lg" href="{{ route('customer.create') }}">{{ trans('plugins/ecommerce::customers.intro.button_text') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
