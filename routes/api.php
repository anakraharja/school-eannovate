<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->group(function(){
    //
});
Route::prefix('mobile')->name('mobile.')->group(function () {
    Route::post('login', 'Api\Mobile\AuthController@login');
    Route::get('logout', 'Api\Mobile\AuthController@logout');
    Route::resource('class', 'Api\Mobile\ClassController');

    Route::group(['middleware' => 'check-token-api'], function () {
        Route::get('student', 'Api\Mobile\StudentController@index');
        Route::post('student', 'Api\Mobile\StudentController@store');
    });
});


