<?php

Route::get('/', 'AuthController@index')->name('login')->middleware('guest');
Route::post('/', 'AuthController@store_login')->name('store-login')->middleware('guest');
Route::get('logout', 'AuthController@logout')->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('class', 'ClassController@index')->name('class.index');
    Route::get('class/create', 'ClassController@create')->name('class.create');
    Route::get('class/{class}/edit', 'ClassController@edit')->name('class.edit');
    Route::resource('student', 'StudentController')->except('show');
    Route::get('student-class/{class}', 'StudentController@student_class')->name('student-class');
    Route::get('student/destroy-picture/{student}', 'StudentController@destroy_picture')->name('student.destroy-picture');
});
