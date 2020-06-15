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




Route::get('/', 'HomeController@index')->name('home');
Route::get('/Space', 'SpaceController@index');
Route::post('/add_space', 'SpaceController@addSpace')->name('add_space');
Route::get('/edit_space/{id}', 'SpaceController@editSpace')->name('edit_space');
Route::get('/delete_space/{id}', 'SpaceController@deleteSpace')->name('delete_space');
Auth::routes();

Route::group(['middleware' => 'auth'], function(){





});


