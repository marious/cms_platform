@extends('core/base::layouts.base')
@section('body-class') login @stop
@section('page')
    <div class="row login-page">
        <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

            <div class="login-container">

                @yield('content')

                <div style="clear:both"></div>

            </div> <!-- .login-container -->

        </div> <!-- .login-sidebar -->
    </div>
@stop
