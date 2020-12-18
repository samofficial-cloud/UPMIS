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


Route::post('/login/custom', [
    'uses' => 'LoginController@login',
    'as' => 'login.custom'
]);


    Auth::routes();

    Route::group(['middleware' => 'auth'], function(){

    Route::get('file','UploadFileController@create');
    Route::post('file','UploadFileController@store');

    Route::get('/', 'ChartController@index')->name('home');
    Route::get('/home2', 'ChartController@udiaindex')->name('home2');
    Route::get('/home9', 'ChartController@cptuindex')->name('home3');
     Route::get('/home16', 'ChartController@spaceindex')->name('home4');
     Route::get('/home23', 'ChartController@voteholderindex')->name('home5');

     Route::get('/dashboard/income_filter','ChartController@income_filter');
     Route::get('/dashboard/activity_filter','ChartController@activity_filter');
     Route::get('/home2/activity_filter','ChartController@udia_activity_filter');
     Route::get('/home2/income_filter','ChartController@udia_income_filter');
     Route::get('/home9/activity_filter','ChartController@cptu_activity_filter');
     Route::get('/home16/activity_filter','ChartController@space_activity_filter');
    Route::get('/home23/activity_filter','ChartController@voteholder_activity_filter');

    Route::get('/Space', 'SpaceController@index');
    Route::get('/space_contract_on_fly/{id}/', 'ContractsController@OnFlySpaceContractForm')->name('space_contract_on_fly');



    Route::get('/space_id_suggestions', 'SpaceController@spaceIdSuggestions')->name('space_id_suggestions');
    Route::get('/autocomplete.space_fields', 'SpaceController@autoCompleteSpaceFields')->name('autocomplete.space_fields');
    Route::get('/space_contract_form', 'ContractsController@SpaceContractForm');

    Route::get('/contracts_management', 'ContractsController@ContractsManagement')->name('contracts_management');

    Route::get('/invoice_management', 'InvoicesController@invoiceManagement');

    Route::get('/invoice_management/space/filter', 'InvoicesController@space_filter');

    



        //Invoices car rental
        Route::get('/car_rental_invoice_management', 'InvoicesController@CarRentalInvoiceManagement');
        Route::post('/change_payment_status_car_rental/{id}', 'InvoicesController@changePayementStatusCarRental')->name('change_payment_status_car_rental');
        Route::post('/send_invoice_car_rental/{id}', 'InvoicesController@sendInvoiceCarRental')->name('send_invoice_car_rental');
        Route::post('/create_car_invoice_manually', 'InvoicesController@CreateCarInvoiceManually')->name('create_car_invoice_manually');







        //payment
        Route::get('/payment_management', 'PaymentController@paymentManagement');

        Route::get('/payment_management/filtered', 'PaymentController@payment_filtered');

        Route::get('/check_availability_car', 'PaymentController@checkAvailabilityCar')->name('check_availability_car');


        //payments
        Route::post('/create_car_payment_manually', 'PaymentController@CreateCarPaymentManually')->name('create_car_payment_manually');


        Route::get('/clients', 'clientsController@index')->name('clients');

Route::post('/clients/Space/edit', 'clientsController@edit')->name('editclients');

Route::post('/clients/Car/edit', 'clientsController@editCarclients')->name('editCarclients');

Route::post('/clients/Insurance/edit', 'clientsController@editIns')->name('editInsclients');

Route::get('/clients/Space/view_more/{id}','clientsController@ClientViewMore')->name('ClientViewMore');

Route::get('/clients/car_rental/view_more/{name}/{email}/{centre}','clientsController@CarViewMore')->name('CarClientsViewMore');

Route::get('/clients/insurance/view_more/{name}/{email}/{centre}','clientsController@InsuranceViewMore')->name('InsuranceClientsViewMore');

Route::post('/clients/Space/SendMessage', 'clientsController@SendMessage')->name('SendMessage');

Route::post('/clients/Space/SendMessage_2', 'clientsController@SendMessage2')->name('SendMessage2');



Route::post('/car/add_car','carRentalController@newcar')->name('addCar');

Route::get('/car','carRentalController@index');

Route::post('/car/operational_expenditure/add','operational_expenditureController@addOperational')->name('addOperational');

Route::get('/car/operational_expenditure/edit', 'operational_expenditureController@editoperational')->name('editoperational');

Route::get('/car/operational_expenditure/delete/{id}', 'operational_expenditureController@deleteoperational')->name('deleteops');

Route::get('/car/edit_car','carRentalController@editcar')->name('editcar');

Route::get('/car/view_more','carRentalController@viewMore')->name('CarViewMore');

Route::get('/car/view_more/filter','carRentalController@viewMore2')->name('CarViewMore2');

Route::get('/car/view_more/filter2','carRentalController@viewMore3')->name('CarViewMore3');

Route::get('/car/view_more/filter3','carRentalController@viewMore4')->name('CarViewMore4');




Route::post('/car/hire_rate/add','hireRateController@addhirerate')->name('addhirerate');

Route::post('/car/hire_rate/edit','hireRateController@edithirerate')->name('edithirerate');

Route::get('/car/hire_rate/delete/{id}','hireRateController@deletehirerate')->name('deletehirerate');

Route::post('/car/cost_centres/add','carRentalController@addcentre')->name('addcentre');

Route::post('/car/cost_centres/edit','carRentalController@editcentre')->name('editcentre');

Route::get('/car/cost_centres/delete/{id}','carRentalController@deletecentre')->name('deletecentre');

Route::get('/car/delete_car/{id}', 'carRentalController@deletecar')->name('deletecar');

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

Route::post('/autocomplete/faculty', 'carRentalController@faculty')->name('autocomplete.faculty');


Route::post('/autocomplete/space_id', 'SpaceController@fetchspaceid')->name('autocomplete.spaces');

Route::post('/autocomplete/cost_centres', 'carRentalController@fetchcostcentres')->name('autocomplete.costcentres');


Route::post('/autocomplete/client_name', 'clientsController@fetchclient_name')->name('autocomplete.client_name');

Route::post('/autocomplete/cptu', 'carContractsController@fetchclient_details')->name('autocomplete.cptu');

Route::get('/autocomplete/cptu/all', 'carContractsController@fetchallclient_details')->name('autocomplete.allcptu');

Route::get('/reports', 'HomeController@report')->name('reports');

Route::get('/reports/space1', 'HomeController@spacereport1')->name('spacereport1');

Route::get('/reports/invoice/debt_summary', 'HomeController@debtsummaryPDF')->name('debtsummarypdf');

Route::get('/reports/space1/pdf','HomeController@spacereport1PDF')->name('spacereport1pdf');

Route::get('/reports/space2/pdf','HomeController@spacereport2PDF')->name('spacereport2pdf');

Route::get('/reports/insurance/pdf','HomeController@insurancereportPDF')->name('insurancereportpdf');

Route::get('/reports/tenant/pdf','HomeController@tenantreportPDF')->name('tenantreportpdf');

Route::get('/reports/car_rental/pdf','HomeController@carreportPDF')->name('carreportpdf');

Route::get('/reports/car_rental2/pdf','HomeController@carreportPDF2')->name('carreportpdf2');

Route::get('/reports/car_rental3/pdf','HomeController@carreportPDF3')->name('carreportpdf3');

Route::get('/reports/contracts/pdf','HomeController@contractreportPDF')->name('contractreportpdf');

Route::get('/reports/invoice/pdf','HomeController@invoicereportPDF')->name('invoicereportpdf');

Route::get('/reports/system/user/pdf','HomeController@systemreportPDF')->name('systemreportpdf');

Route::get('/reports/tenancy/pdf','HomeController@tenancyreport')->name('tenancyreportpdf');


Route::get('/notification/{id}', 'notificationsController@ShowNotifications')->name('ShowNotifications');

Route::get('/car/available_cars', function () {
        return View::make('available_cars');
    });

Route::get('/uploadfile','UploadFileController@index');
Route::post('/uploadfile','UploadFileController@showUploadFile');

Route::get('/login2', function () {
        return View('login2');
    });


Route::get('/edit_profile','HomeController@editprofile');

Route::get('/edit_profile_details','HomeController@editprofiledetails');

Route::get('/view_profile','HomeController@viewprofile')->name('viewprofile');

Route::get('/change_password','HomeController@changepassword')->name('changepassword');

Route::get('/change_password_login','HomeController@changepasswordlogin')->name('changepasswordlogin');

Route::get('/system_chats','systemChatController@index')->name('chatindex');

Route::post('/system_chats/send','systemChatController@sendMessage')->name('sendchat');

Route::post('/change_password_details','HomeController@changepassworddetails')->name('changepassword_details');

Route::post('/change_password_details_login','HomeController@changepassworddetailslogin')->name('changepassword_details_login');

Route::get('/system_chats/view/{name}','systemChatController@viewchat')->name('viewchat');

//Route::get('chart', 'ChartController@index');

});


//System settings
Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/system_settings', 'SystemSettingsController@index');
    Route::get('/user_role_management', 'SystemSettingsController@userRoleManagement')->name('user_role_management');
    Route::get('/role_management', 'SystemSettingsController@roleManagement')->name('role_management');
    Route::get('/deactivate_user/{id}', 'SystemSettingsController@deactivateUser')->name('deactivate_user');
    Route::get('/activate_user/{id}', 'SystemSettingsController@activateUser')->name('activate_user');
    Route::post('/edit_user/{id}', 'SystemSettingsController@editUser')->name('edit_user');
    Route::post('/add_user', 'SystemSettingsController@addUser')->name('add_user');

    Route::post('/edit_role/{id}', 'SystemSettingsController@editRole')->name('edit_role');
    Route::post('/add_role', 'SystemSettingsController@addRole')->name('add_role');

    Route::get('/delete_role/{id}', 'SystemSettingsController@deleteRole')->name('delete_role');
    Route::get('/delete_insurance_company/{id}', 'SystemSettingsController@deleteInsuranceCompany')->name('delete_insurance_company');
    Route::get('/delete_insurance_class/{id}', 'SystemSettingsController@deleteInsuranceClass')->name('delete_insurance_class');

    Route::post('/edit_system_changes', 'SystemSettingsController@EditSystemSettings')->name('edit_system_changes');
    Route::get('/insurance_companies', 'SystemSettingsController@insuranceCompanies')->name('insurance_companies');
    Route::get('/insurance_classes', 'SystemSettingsController@insuranceClasses')->name('insurance_classes');

    Route::post('/add_insurance_company', 'SystemSettingsController@addInsuranceCompany')->name('add_insurance_company');
    Route::post('/add_insurance_class', 'SystemSettingsController@addInsuranceClass')->name('add_insurance_class');

    Route::post('/edit_role/{id}', 'SystemSettingsController@editRole')->name('edit_role');
    Route::post('/edit_insurance_company/{id}', 'SystemSettingsController@editInsuranceCompany')->name('edit_insurance_company');
    Route::post('/edit_insurance_class/{id}', 'SystemSettingsController@editInsuranceClass')->name('edit_insurance_class');





});

//space
Route::group(['middleware' => ['auth', 'space']], function() {
    //space contracts
    Route::get('/space_contracts_management', 'ContractsController@SpaceContractsManagement');
    Route::get('/renew_space_contract_form/{id}','ContractsController@renewSpaceContractForm')->name('renew_space_contract_form');
    Route::get('/edit_space_contract/{id}/', 'ContractsController@EditSpaceContractForm')->name('edit_contract');
    Route::get('/edit_space_contract_final/{contract_id}/client_id/{client_id}', 'ContractsController@EditSpaceContractFinalProcessing')->name('edit_space_contract_final');
    Route::post('/add_space', 'SpaceController@addSpace')->name('add_space');
    Route::post('/edit_space/{id}', 'SpaceController@editSpace')->name('edit_space');
    Route::get('/delete_space/{id}', 'SpaceController@deleteSpace')->name('delete_space');
    Route::post('/generate_minor_list', 'SpaceController@generateMinorList')->name('generate_minor_list');
    Route::get('/Space', 'SpaceController@index');
    Route::get('/space_contract_on_fly/{id}/', 'ContractsController@OnFlySpaceContractForm')->name('space_contract_on_fly');
    Route::get('/space_id_suggestions', 'SpaceController@spaceIdSuggestions')->name('space_id_suggestions');
    Route::get('/autocomplete.space_fields', 'SpaceController@autoCompleteSpaceFields')->name('autocomplete.space_fields');
    Route::get('/space_contract_form', 'ContractsController@SpaceContractForm');
    Route::get('/contract_details/{contract_id}', 'ContractsController@ContractDetails')->name('contract_details');
    Route::get('/create_space_contract', 'ContractsController@CreateSpaceContract')->name('create_space_contract');
    Route::get('/renew_space_contract/{id}', 'ContractsController@RenewSpaceContract')->name('renew_space_contract');
    Route::get('/terminate_space_contract/{id}', 'ContractsController@terminateSpaceContract')->name('terminate_space_contract');
    Route::get('/contract_availability_space', 'InvoicesController@contractAvailabilitySpace')->name('contract_availability_space');

    // Water Bills
    Route::get('/create_water_bills_invoice', 'InvoicesController@CreateWaterBillsInvoice')->name('create_water_bills_invoice');
    Route::get('/water_bills_invoice_management', 'InvoicesController@WaterBillsInvoiceManagement');
    Route::post('/send_invoice_water_bills/{id}', 'InvoicesController@sendInvoiceWaterBills')->name('send_invoice_water_bills');
    Route::post('/change_payment_status_water_bills/{id}', 'InvoicesController@changePaymentStatusWaterBills')->name('change_payment_status_water_bills');
    Route::post('/create_water_invoice_manually', 'InvoicesController@CreateWaterBillInvoiceManually')->name('create_water_invoice_manually');
    Route::get('/contract_availability_water', 'InvoicesController@contractAvailabilityWater')->name('contract_availability_water');
    // Electricity Bills

    Route::get('/electricity_bills_invoice_management', 'InvoicesController@ElectricityBillsInvoiceManagement');
    Route::post('/send_invoice_electricity_bills/{id}', 'InvoicesController@sendInvoiceElectricityBills')->name('send_invoice_electricity_bills');
    Route::post('/change_payment_status_electricity_bills/{id}', 'InvoicesController@changePaymentStatusElectricityBills')->name('change_payment_status_electricity_bills');
    Route::post('/create_electricity_invoice_manually', 'InvoicesController@CreateElectricityBillInvoiceManually')->name('create_electricity_invoice_manually');
    Route::get('/contract_availability_electricity', 'InvoicesController@contractAvailabilityElectricity')->name('contract_availability_electricity');




//payments
    Route::post('/create_space_payment_manually', 'PaymentController@CreateSpacePaymentManually')->name('create_space_payment_manually');
    Route::post('/create_water_payment_manually', 'PaymentController@CreateWaterPaymentManually')->name('create_water_payment_manually');
    Route::post('/create_electricity_payment_manually', 'PaymentController@CreateElectricityPaymentManually')->name('create_electricity_payment_manually');
    Route::get('/check_availability_water', 'PaymentController@checkAvailabilityWater')->name('check_availability_water');
    Route::get('/check_availability_electricity', 'PaymentController@checkAvailabilityElectricity')->name('check_availability_electricity');
    Route::get('/check_availability_space', 'PaymentController@checkAvailabilitySpace')->name('check_availability_space');

//Invoices Space
    Route::get('/invoice_pdf', 'InvoicesController@index');
    Route::post('/create_space_invoice_manually', 'InvoicesController@CreateSpaceInvoiceManually')->name('create_space_invoice_manually');
    Route::post('/send_invoice_space/{id}', 'InvoicesController@sendInvoiceSpace')->name('send_invoice_space');
    Route::post('/change_payment_status_space/{id}', 'InvoicesController@changePayementStatusSpace')->name('change_payment_status_space');
    Route::get('/create_space_invoice', 'InvoicesController@CreateSpaceInvoice')->name('create_space_invoice');

});


//insurance
Route::group(['middleware' => ['auth', 'insurance']], function() {

    //Insurance contracts
    Route::get('/terminate_insurance_contract/{id}', 'ContractsController@terminateInsuranceContract')->name('terminate_insurance_contract');
    Route::get('/edit_insurance_contract/{id}/', 'ContractsController@EditInsuranceContractForm')->name('edit_insurance_contract');
    Route::get('/edit_insurance_contract_final/{contract_id}', 'ContractsController@EditInsuranceContractFinalProcessing')->name('edit_insurance_contract_final');
    Route::get('/insurance_contracts_management', 'ContractsController@InsuranceContractsManagement');
    Route::get('/insurance_contract_form', 'ContractsController@InsuranceContractForm');
    Route::get('/create_insurance_contract', 'ContractsController@CreateInsuranceContract')->name('create_insurance_contract');
    Route::get('/renew_insurance_contract_form/{id}/', 'ContractsController@RenewInsuranceContractForm')->name('renew_insurance_contract_form');
    Route::get('/insurance_contract_on_fly/{id}/', 'ContractsController@OnFlyInsuranceContractForm')->name('insurance_contract_on_fly');
    Route::get('/autofill_insurance_parameters/', 'ContractsController@autofillParameters')->name('autofill_insurance_parameters');
    Route::get('/contract_details_insurance/{contract_id}', 'ContractsController@ContractDetailsInsurance')->name('contract_details_insurance');




//Insurance
    Route::get('/insurance', 'InsuranceController@index');
    Route::post('/add_insurance', 'InsuranceController@addInsurance')->name('add_insurance');
    Route::post('/edit_insurance/{id}', 'InsuranceController@editInsurance')->name('edit_insurance');
    Route::get('/deactivate_insurance/{id}', 'InsuranceController@deactivateInsurance')->name('deactivate_insurance');
    Route::get('/generate_type_list', 'InsuranceController@generateTypes')->name('generate_type_list');

    //payments
    Route::post('/create_insurance_payment_manually', 'PaymentController@CreateInsurancePaymentManually')->name('create_insurance_payment_manually');
    Route::get('/check_availability_insurance', 'PaymentController@checkAvailabilityInsurance')->name('check_availability_insurance');

    //Insurance invoices
    Route::get('/insurance_invoice_management', 'InvoicesController@insuranceInvoiceManagement');
    Route::post('/send_invoice_insurance/{id}', 'InvoicesController@sendInvoiceInsurance')->name('send_invoice_insurance');
    Route::post('/change_payment_status_insurance/{id}', 'InvoicesController@changePayementStatusInsurance')->name('change_payment_status_insurance');
    Route::get('/create_insurance_invoice', 'InvoicesController@CreateInsuranceInvoice');
    Route::post('/create_insurance_invoice_manually', 'InvoicesController@CreateInsuranceInvoiceManually')->name('create_insurance_invoice_manually');
    Route::get('/get_info_insurance', 'InvoicesController@getInfoInsurance')->name('get_info_insurance');






});


Route::group(['middleware' => ['auth', 'car']], function() {

    Route::get('/contract_availability_car', 'InvoicesController@contractAvailabilityCar')->name('contract_availability_car');



});
