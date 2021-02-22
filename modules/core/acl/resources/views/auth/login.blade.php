@extends('core/acl::auth.master')
@section('content')
        <p>{{ trans('core/acl::auth.sign_in_below') }}</p>
        {!! Form::open(['route' => 'access.login', 'class' => 'login-form']) !!}
            <div class="form-group" id="emailGroup">
                <label for="">{{ trans('core/acl::auth.login.username') }}</label>
                {!! Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => trans('core/acl::auth.login.username')]) !!}
            </div>
            <div class="form-group" id="passwordGroup">
                <label for="">{{ trans('core/acl::auth.login.password') }}</label>
                {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('core/acl::auth.login.password')]) !!}
            </div>
            <div>
                <label>
                    {!! Form::checkbox('remember', '1', true, ['class' => 'hrv-checkbox']) !!} {{ trans('core/acl::auth.login.remember') }}
                </label>
            </div>
            <br>

        <button type="submit" class="btn btn-block login-button">
            <span class="signin">{{ trans('core/acl::auth.login.login') }}</span>
        </button>
        <div class="clearfix"></div>
        <br>
        <p>
        </p>

        {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \App\Models\ACL\User::class) !!}
        {!! Form::close() !!}
@endsection

@push('footer')
    <script>
        var username = document.querySelector('[name="username"]')
        var password = document.querySelector('[name="password"]');
        username.focus();

        // Focus events for email and password fields
        username.addEventListener('focusin', function(){
            document.getElementById('emailGroup').classList.add('focused');
        });
        username.addEventListener('focusout', function(){
            document.getElementById('emailGroup').classList.remove('focused');
        });

        password.addEventListener('focusin', function(){
            document.getElementById('passwordGroup').classList.add('focused');
        });
        password.addEventListener('focusout', function(){
            document.getElementById('passwordGroup').classList.remove('focused');
        });
    </script>
@endpush
