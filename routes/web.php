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




    Route::get('/create_space_invoice', 'InvoicesController@CreateSpaceInvoice')->name('create_space_invoice');
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

    //space


    //space contracts
    Route::get('/space_contracts_management', 'ContractsController@SpaceContractsManagement');
    Route::get('/renew_space_contract_form/{id}','ContractsController@renewSpaceContractForm')->name('renew_space_contract_form');



    //Insurance
    Route::get('/insurance', 'InsuranceController@index');
    Route::post('/add_insurance', 'InsuranceController@addInsurance')->name('add_insurance');
    Route::post('/edit_insurance/{id}', 'InsuranceController@editInsurance')->name('edit_insurance');
    Route::get('/deactivate_insurance/{id}', 'InsuranceController@deactivateInsurance')->name('deactivate_insurance');


    //Insurance contracts
    Route::get('/terminate_insurance_contract/{id}', 'ContractsController@terminateInsuranceContract')->name('terminate_insurance_contract');
    Route::get('/edit_insurance_contract/{id}/', 'ContractsController@EditInsuranceContractForm')->name('edit_insurance_contract');
    Route::get('/edit_insurance_contract_final/{contract_id}', 'ContractsController@EditInsuranceContractFinalProcessing')->name('edit_insurance_contract_final');
    Route::get('/insurance_contracts_management', 'ContractsController@InsuranceContractsManagement');
    Route::get('/insurance_contract_form', 'ContractsController@InsuranceContractForm');
    Route::get('/create_insurance_contract', 'ContractsController@CreateInsuranceContract')->name('create_insurance_contract');

    Route::get('/edit_space_contract/{id}/', 'ContractsController@EditSpaceContractForm')->name('edit_contract');
    Route::get('/edit_space_contract_final/{contract_id}/client_id/{client_id}', 'ContractsController@EditSpaceContractFinalProcessing')->name('edit_space_contract_final');
    Route::post('/add_space', 'SpaceController@addSpace')->name('add_space');
    Route::post('/edit_space/{id}', 'SpaceController@editSpace')->name('edit_space');
    Route::get('/delete_space/{id}', 'SpaceController@deleteSpace')->name('delete_space');



    //Invoices Space
        Route::get('/invoice_pdf', 'InvoicesController@index');
        Route::get('/invoice_management', 'InvoicesController@invoiceManagement');
        Route::post('/send_invoice_space/{id}', 'InvoicesController@sendInvoiceSpace')->name('send_invoice_space');
        Route::post('/change_payment_status_space/{id}', 'InvoicesController@changePayementStatusSpace')->name('change_payment_status_space');



        //Invoices car rental
        Route::get('/car_rental_invoice_management', 'InvoicesController@CarRentalInvoiceManagement');
        Route::post('/change_payment_status_car_rental/{id}', 'InvoicesController@changePayementStatusCarRental')->name('change_payment_status_car_rental');
        Route::post('/send_invoice_car_rental/{id}', 'InvoicesController@sendInvoiceCarRental')->name('send_invoice_car_rental');


        //Insurance invoices
        Route::get('/insurance_invoice_management', 'InvoicesController@insuranceInvoiceManagement');
        Route::post('/send_invoice_insurance/{id}', 'InvoicesController@sendInvoiceInsurance')->name('send_invoice_insurance');
        Route::post('/change_payment_status_insurance/{id}', 'InvoicesController@changePayementStatusInsurance')->name('change_payment_status_insurance');
        Route::get('/create_insurance_invoice', 'InvoicesController@CreateInsuranceInvoice');






        //payment
        Route::get('/payment_management', 'PaymentController@paymentManagement');

        // Water Bills
        Route::get('/create_water_bills_invoice', 'InvoicesController@CreateWaterBillsInvoice')->name('create_water_bills_invoice');
        Route::get('/water_bills_invoice_management', 'InvoicesController@WaterBillsInvoiceManagement');


        // electricity Bills
        Route::get('/create_electricity_bills_invoice', 'InvoicesController@CreateElectricityBillsInvoice')->name('create_electricity_bills_invoice');
        Route::get('/electricity_bills_invoice_management', 'InvoicesController@ElectricityBillsInvoiceManagement');



        Route::get('/clients', 'clientsController@index')->name('clients');


Route::get('/clients/edit', 'clientsController@edit')->name('editclients');


Route::post('/car/add_car','carRentalController@newcar')->name('addCar');

Route::get('/car','carRentalController@index');

Route::post('/car/operational_expenditure/add','operational_expenditureController@addOperational')->name('addOperational');

Route::get('/car/edit_car','carRentalController@editcar')->name('editcar');

Route::get('/car/delete_car/{id}', 'carRentalController@deletecar')->name('deletecar');

Route::get('/car/operational_expenditure/delete/{id}', 'operational_expenditureController@deleteoperational')->name('deleteops');

Route::get('/contracts/car_rental','carContractsController@index')->name('carContracts');

Route::get('/contracts/car_rental/add','carContractsController@addContractFormA')->name('carRentalForm');

Route::get('/contracts/car_rental_B/add/{id}','carContractsController@addContractFormB')->name('carRentalFormB');

Route::get('/contracts/car_rental_C/add/{id}','carContractsController@addContractFormC')->name('carRentalFormC');

Route::get('/contracts/car_rental_D/add/{id}','carContractsController@addContractFormD')->name('carRentalFormD');

Route::get('/contracts/car_rental_D1/add/{id}','carContractsController@addContractFormD1')->name('carRentalFormD1');

Route::get('/contracts/car_rental_E/add/{id}','carContractsController@addContractFormE')->name('carRentalFormE');

Route::get('/contracts/car_rental/edit/{id}','carContractsController@editContractForm')->name('EditcarRentalForm');

Route::get('/contracts/car_rental/print','carContractsController@printContractForm')->name('printcarRentalForm');

Route::post('/contracts/car_rental/add/submit','carContractsController@newcontract')->name('newCarcontract');

Route::post('/contracts/car_rental/add_A/submit','carContractsController@newcontractA')->name('newCarcontractA');

Route::post('/contracts/car_rental/add_B/submit','carContractsController@newcontractB')->name('newCarcontractB');

Route::post('/contracts/car_rental/add_C/submit','carContractsController@newcontractC')->name('newCarcontractC');

Route::post('/contracts/car_rental/add_D/submit','carContractsController@newcontractD')->name('newCarcontractD');

Route::post('/contracts/car_rental/add_D1/submit','carContractsController@newcontractD1')->name('newCarcontractD1');

Route::post('/contracts/car_rental/add_E/submit','carContractsController@newcontractE')->name('newCarcontractE');

Route::post('/contracts/car_rental/edit/submit','carContractsController@editcontract')->name('editCarcontract');

Route::get('/contracts/car_rental/delete/{id}', 'carContractsController@deletecontract')->name('deletecontract');

Route::get('/contracts/car_rental/renew/{id}','carContractsController@renewContractForm')->name('RenewcarRentalForm');

Route::post('/autocomplete/vehicle', 'carRentalController@fetch')->name('autocomplete.fetch');

Route::post('/autocomplete2/vehicle', 'carRentalController@fetchs2')->name('autocomplete2.fetch');

Route::post('/autocomplete/vehicle_2', 'carRentalController@fetch2')->name('autocomplete.fetch2');

Route::post('/autocomplete/model', 'carRentalController@model')->name('autocomplete.model');

Route::post('/autocomplete/hirerate', 'carRentalController@hirerate')->name('autocomplete.hirerate');

Route::post('/autocomplete/space_id', 'SpaceController@fetchspaceid')->name('autocomplete.spaces');

Route::get('/reports', 'HomeController@report')->name('reports');

Route::get('/reports/space1', 'HomeController@spacereport1')->name('spacereport1');

Route::get('/reports/space1/pdf','HomeController@spacereport1PDF')->name('spacereport1pdf');

Route::get('/reports/space2/pdf','HomeController@spacereport2PDF')->name('spacereport2pdf');

Route::get('/reports/insurance/pdf','HomeController@insurancereportPDF')->name('insurancereportpdf');

Route::get('/reports/tenant/pdf','HomeController@tenantreportPDF')->name('tenantreportpdf');

Route::get('/reports/car_rental/pdf','HomeController@carreportPDF')->name('carreportpdf');

Route::get('/reports/car_rental2/pdf','HomeController@carreportPDF2')->name('carreportpdf2');

Route::get('/reports/contracts/pdf','HomeController@contractreportPDF')->name('contractreportpdf');

Route::get('/notification/{id}', 'notificationsController@ShowNotifications')->name('ShowNotifications');

Route::get('/car/available_cars', function () {
        return View::make('available_cars');
    });

});


