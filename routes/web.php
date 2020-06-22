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

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/Space', 'SpaceController@index');
    Route::get('/autocomplete.space_id', 'SpaceController@autoCompleteSpaceId')->name('autocomplete.space_id');
    Route::get('/autocomplete.space_size', 'SpaceController@autoCompleteSpaceSize')->name('autocomplete.space_size');
    Route::get('/space_contract_form', 'ContractsController@SpaceContractForm');
    Route::get('/space_contracts_management', 'ContractsController@SpaceContractsManagement');
    Route::get('/create_space_contract', 'ContractsController@CreateSpaceContract')->name('create_space_contract');
    Route::get('/terminate_space_contract/{id}', 'ContractsController@terminateSpaceContract')->name('terminate_space_contract');
    Route::get('/edit_space_contract/{id}/', 'ContractsController@EditSpaceContractForm')->name('edit_contract');
    Route::get('/edit_space_contract_final/{contract_id}/client_id/{client_id}', 'ContractsController@EditSpaceContractFinalProcessing')->name('edit_space_contract_final');
    Route::post('/add_space', 'SpaceController@addSpace')->name('add_space');
    Route::post('/edit_space/{id}', 'SpaceController@editSpace')->name('edit_space');
    Route::get('/delete_space/{id}', 'SpaceController@deleteSpace')->name('delete_space');

    Route::get('/clients', 'clientsController@index')->name('clients');




Route::post('/car/add_car','carRentalController@newcar')->name('addCar');

Route::get('/car','carRentalController@index');

Route::get('/car/edit_car','carRentalController@editcar')->name('editcar');

Route::get('/car/delete_car/{id}', 'carRentalController@deletecar')->name('deletecar');

Route::get('/abcd', function () {
    return view('multform');
});

});


