@extends('core/base::layouts.master')
@section('content')
    <div class="row page-content">
        <div class="col-sm-8">
            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('core/base::system.installed_packages') }}</span>
                    </h4>
                </div>
                <div class="widget-body">
                    {!! $infoTable->renderTable() !!}
                </div>
            </div>
        </div><!-- ./col-sm-8 -->

        <div class="col-sm-4">
            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('core/base::system.system_environment') }}</span>
                    </h4>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">{{ trans('core/base::system.cms_version') }}: {{ get_app_version() }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.framework_version') }}: {{ $systemEnv['version'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.timezone') }}: {{ $systemEnv['timezone'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.debug_mode') }}: {!! $systemEnv['debug_mode'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.storage_dir_writable') }}: {!! $systemEnv['storage_dir_writable'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.cache_dir_writable') }}: {!! $systemEnv['cache_dir_writable'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.app_size') }}: {{ $systemEnv['app_size'] }}</li>
                </ul>
            </div>

            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('core/base::system.server_environment') }}</span>
                    </h4>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">{{ trans('core/base::system.php_version') }}: {{ $serverEnv['version'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.server_software') }}: {{ $serverEnv['server_software'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.server_os') }}: {{ $serverEnv['server_os'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.database') }}: {{ $serverEnv['database_connection_name'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.ssl_installed') }}: {!! $serverEnv['ssl_installed'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.cache_driver') }}: {{ $serverEnv['cache_driver'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.session_driver') }}: {{ $serverEnv['session_driver'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.queue_connection') }}: {{ $serverEnv['queue_connection'] }}</li>
                    <li class="list-group-item">{{ trans('core/base::system.openssl_ext') }}: {!! $serverEnv['openssl'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.mbstring_ext') }}: {!! $serverEnv['mbstring'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.pdo_ext') }}: {!! $serverEnv['pdo'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.curl_ext') }}: {!! $serverEnv['curl'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.exif_ext') }}: {!! $serverEnv['exif'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.file_info_ext') }}: {!! $serverEnv['fileinfo'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('core/base::system.tokenizer_ext') }}: {!! $serverEnv['tokenizer']  ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>'!!}</li>
                </ul>
            </div>
        </div><!-- ./col-sm-4 -->
    </div>
@stop
