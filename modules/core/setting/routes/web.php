<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'EG\Setting\Http\Controllers', 'middleware' => ['web', 'core']], function () {

  Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

    Route::group(['prefix' => 'setting'], function () {

        Route::get('general', [
          'as'          => 'settings.options',
          'uses'        => 'SettingController@getOptions',
          'permission'  => 'settings.options',
        ]);

        Route::post('general/edit', [
          'as'         => 'settings.edit',
          'uses'       => 'SettingController@postEdit',
          'permission' => 'settings.options',
        ]);

        Route::get('media', [
          'as'   => 'settings.media',
          'uses' => 'SettingController@getMediaSetting',
      ]);

      Route::post('media', [
          'as'         => 'settings.media',
          'uses'       => 'SettingController@postEditMediaSetting',
      ]);


      Route::group(['prefix' => 'email', 'permission' => 'settings.email'], function () {

        Route::get('', [
          'as'   => 'settings.email',
          'uses' => 'SettingController@getEmailConfig',
        ]);

        Route::post('edit', [
            'as'   => 'settings.email.edit',
            'uses' => 'SettingController@postEditEmailConfig',
          ]);

      });

    });

  });

});
