<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'EG\Base\Http\Controllers', 'middleware' => ['web', 'core']], function () {

  Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

      Route::group(['prefix' => 'system/info'], function () {
        Route::get('', [
          'as'         => 'system.info',
          'uses'       => 'SystemController@getInfo',
          'permission' => ACL_ROLE_SUPER_USER,
        ]);
      });

      Route::group(['prefix' => 'system/cache'], function () {
        Route::get('', [
          'as'      => 'system.cache',
          'uses'    => 'SystemController@getCacheManagement',
          'permission' => ACL_ROLE_SUPER_USER,
        ]);
      });

  });

});
