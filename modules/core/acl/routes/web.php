<?php
use EG\ACL\Http\Controllers\Auth\LoginController;

Route::get('dashboard', function () {echo 'dashboard';})->name('dashboard.index');

Route::group(['namespace' => '\EG\ACL\Http\Controllers', 'middleware' => ['core', 'web']], function () {

  Route::group(['prefix' => BaseHelper::getAdminPrefix()], function () {

    Route::group(['middleware' => 'guest'], function () {
      Route::get('login', [LoginController::class, 'showLoginForm'])->name('access.login');
      Route::post('login', [LoginController::class, 'login'])->name('access.login');
    });

    Route::group(['middleware' => 'auth'], function () {
      Route::get('logout', [
        'as'          => 'access.logout',
        'uses'        => 'Auth\LoginController@logout',
        'permission'  => false,
      ]);

    });

  });



    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
      Route::group(['prefix' => 'system'], function () {
        Route::resource('users', 'UserController')->except(['edit', 'update']);

        Route::group(['prefix' => 'users'], function () {

            Route::delete('items/destroy', [
              'as'    => 'users.deletes',
              'uses'  => 'UserController@deletes',
              'permission' => 'users.destroy',
            ]);

            Route::get('profile/{id}', [
              'as'         => 'user.profile.view',
              'uses'       => 'UserController@getUserProfile',
              'permission' => false,
            ]);


            Route::post('update-profile/{id}', [
              'as'          => 'users.update-profile',
              'uses'        => 'UserController@postUpdateProfile',
              'permission'  => false,
            ]);

            Route::post('change-pssword/{id}', [
              'as'          => 'users.change-password',
              'uses'        => 'UserController@postChangePassword',
              'permission'  => false,
            ]);

            Route::post('modify-profile-image/{id}', [
              'as'         => 'users.profile.image',
              'uses'       => 'UserController@postAvatar',
              'permission' => false,
          ]);

            Route::get('make-super/{id}', [
              'as'         => 'users.make-super',
              'uses'       => 'UserController@makeSuper',
              'permission' => ACL_ROLE_SUPER_USER,
            ]);

            Route::get('remove-super/{id}', [
              'as'         => 'users.remove-super',
              'uses'       => 'UserController@removeSuper',
              'permission' => ACL_ROLE_SUPER_USER,
            ]);

        });


        Route::resource('roles', 'RoleController');

        Route::group(['prefix' => 'roles'], function () {

          Route::delete('items/destroy', [
            'as'          => 'roles.deletes',
            'uses'        => 'RoleController@deletes',
            'permission'  => 'roles.destroy',
          ]);

          Route::get('duplicate/{id}', [
              'as'          => 'roles.duplicate',
              'uses'        => 'RoleController@getDuplicate',
              'permission'  => 'roles.create',
          ]);

          Route::get('json', [
            'as'         => 'roles.list.json',
            'uses'       => 'RoleController@getJson',
            'permission' => 'roles.index',
          ]);

          Route::post('assign', [
            'as'      => 'roles.assign',
            'uses'    => 'RoleController@postAssignMember',
            'permission' => 'roles.edit',
          ]);

        });

      });
    });

});
