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

Route::get('/clients', 'clientsController@index')->name('clients');

Route::get('/', function () {
    return view('index');
});

Route::get('/Space', function () {
    return view('Space');
});

Route::post('/car/add_car','carRentalController@newcar')->name('addCar');

Route::get('/car','carRentalController@index');

Route::get('/car/edit_car','carRentalController@editcar')->name('editcar');

Route::get('/car/delete_car/{id}', 'carRentalController@deletecar')->name('deletecar');

Route::get('/abcd', function () {
    return view('multform');
});

});


