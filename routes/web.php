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






Auth::routes();

Route::group(['middleware' => 'auth'], function(){
//Route::get('/abc', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('index');
});

Route::get('/Space', function () {
    return view('Space');
});


});


