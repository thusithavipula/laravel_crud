<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return Redirect::route('guest-login');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'AuthController@getLoginPage')->name('guest-login');
    Route::post('/login', 'AuthController@postLogin')->name('post-login');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin-home');
    Route::get('/settings', 'AdminController@settings')->name('admin-settings');
    Route::post('/register', 'AuthController@register')->name('admin-register');
    Route::post('/logout', 'AuthController@logout')->name('admin-logout');

    Route::group(['prefix' => 'subjects'], function () {
        Route::get('/', 'SubjectController@index')->name('admin-subjects');
        Route::get('/get', 'SubjectController@getAllSubjects')->name('admin-get-subjects');
        Route::post('/store', 'SubjectController@storeSubject')->name('admin-store-subjects');
        Route::get('/delete/{subject_id}', 'SubjectController@deleteSubject')->name('admin-delete-subjects');
    });

    Route::group(['prefix' => 'instructors'], function () {
        Route::get('/', 'InstructorController@index')->name('admin-instructors');
        Route::get('/get', 'InstructorController@getAllInstructors')->name('admin-get-instructors');
        Route::post('/store', 'InstructorController@storeInstructor')->name('admin-store-instructors');
        Route::get('/delete/{instructor_id}', 'InstructorController@deleteInstructor')->name('admin-delete-instructors');
    });

    Route::group(['prefix' => 'students'], function () {
        Route::get('/', 'StudentController@index')->name('admin-students');
        Route::get('/get', 'StudentController@getAllStudents')->name('admin-get-students');
        Route::post('/store', 'StudentController@storeStudent')->name('admin-store-students');
        Route::get('/delete/{student_id}', 'StudentController@deleteStudent')->name('admin-delete-students');
    });
});

