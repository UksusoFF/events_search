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