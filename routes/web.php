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

Route::get('/', 'EventController@index')->name('home');

Route::prefix('events')->group(function () {
    Route::get('check', 'EventController@check');
    Route::get('{event}/show', 'EventController@show');
    Route::get('{event}/read', 'EventController@read');
});

Route::prefix('tags')->group(function () {
    Route::post('store', 'TagController@store');
    Route::post('{tag}/update', 'TagController@update');
});

Route::prefix('auth')->group(function () {
    Route::post('update', 'AuthController@update');
});

Auth::routes();

/* Auto-generated admin routes */
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/users', 'Admin\UsersController@index');
    Route::get('/admin/users/create', 'Admin\UsersController@create');
    Route::post('/admin/users', 'Admin\UsersController@store');
    Route::get('/admin/users/{user}/edit', 'Admin\UsersController@edit')->name('admin/users/edit');
    Route::post('/admin/users/{user}', 'Admin\UsersController@update')->name('admin/users/update');
    Route::delete('/admin/users/{user}', 'Admin\UsersController@destroy')->name('admin/users/destroy');
    Route::get('/admin/users/{user}/resend-activation', 'Admin\UsersController@resendActivationEmail')->name('admin/users/resendActivationEmail');
});

/* Auto-generated profile routes */
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/profile', 'Admin\ProfileController@editProfile');
    Route::post('/admin/profile', 'Admin\ProfileController@updateProfile');
    Route::get('/admin/password', 'Admin\ProfileController@editPassword');
    Route::post('/admin/password', 'Admin\ProfileController@updatePassword');
});

/* Auto-generated admin routes */
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/sources', 'Admin\SourcesController@index');
    Route::get('/admin/sources/create', 'Admin\SourcesController@create');
    Route::post('/admin/sources', 'Admin\SourcesController@store');
    Route::get('/admin/sources/{source}/edit', 'Admin\SourcesController@edit')->name('admin/sources/edit');
    Route::post('/admin/sources/{source}', 'Admin\SourcesController@update')->name('admin/sources/update');
    Route::delete('/admin/sources/{source}', 'Admin\SourcesController@destroy')->name('admin/sources/destroy');
});