<?php

Route::group(['namespace' => 'EG\Hospital\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix() . '/hospital', 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'departments', 'as' => 'departments.'], function () {

            Route::resource('', 'DepartmentController')->parameters(['' => 'department']);

            Route::delete('items/destroy', [
                'as'            => 'deletes',
                'uses'          => 'DepartmentController@deletes',
                'permission'    => 'department.destroy',
            ]);

        });

        Route::group(['prefix' => 'doctors', 'as' => 'doctors.'], function () {

            Route::resource('', 'DoctorController')->parameters(['' => 'doctor']);

            Route::delete('items/destroy', [
                'as'            => 'deletes',
                'uses'          => 'DoctorController@deletes',
                'permission'    => 'doctor.destroy',
            ]);

        });

        Route::group(['prefix' => 'appointments', 'as' => 'appointments.'], function () {

            Route::resource('', 'AppointmentController')->parameters(['' => 'appointment']);

            Route::delete('items/destroy', [
                'as'            => 'deletes',
                'uses'          => 'AppointmentController@deletes',
                'permission'    => 'appointment.destroy',
            ]);

        });

    });

});
