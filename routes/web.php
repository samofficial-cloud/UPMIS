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

    //Data retrieval

        Route::get('/get_insurance_contracts', 'ContractsController@getInsuranceContracts')->name('get_insurance_contracts');
        Route::get('/get_insurance_clients', 'clientsController@getInsuranceClients')->name('get_insurance_clients');
        Route::get('/get_space_contracts', 'ContractsController@getSpaceContracts')->name('get_space_contracts');
        Route::get('/get_space_clients', 'clientsController@getSpaceClients')->name('get_space_clients');
        Route::get('/get_car_clients', 'clientsController@getCarClients')->name('get_car_clients');
        Route::get('/get_research_clients', 'clientsController@getResearchClients')->name('get_research_clients');


        //Data upload
        Route::post('/upload', 'ContractsController@storeTemporarily');

        //Delete data
        Route::delete('/upload/revert_upload', 'ContractsController@removeTemporaryUploads');




        Route::post('/import_roles', 'ImportExcelController@importRoles')->name('import_roles');
        Route::get('/get_roles_format', 'ImportExcelController@rolesFormat')->name('get_roles_format');



        Route::post('/import_users', 'ImportExcelController@importUsers')->name('import_users');
        Route::get('/get_users_format', 'ImportExcelController@usersFormat')->name('get_users_format');


        Route::get('file','UploadFileController@create');
    Route::post('file','UploadFileController@store');

    Route::get('/', 'ChartController@index')->name('home');
    Route::get('/home2', 'ChartController@udiaindex')->name('home2');
    Route::get('/home9', 'ChartController@cptuindex')->name('home3');
    Route::get('/home16', 'ChartController@spaceindex')->name('home4');
    Route::get('/home23', 'ChartController@voteholderindex')->name('home5');
    Route::get('/home30', 'ChartController@flatsindex')->name('home6');

     Route::get('/dashboard/income_filter','ChartController@income_filter');
     Route::get('/dashboard/activity_filter','ChartController@activity_filter');
     Route::get('/home2/activity_filter','ChartController@udia_activity_filter');
     Route::get('/home2/income_filter','ChartController@udia_income_filter');
     Route::get('/home9/activity_filter','ChartController@cptu_activity_filter');
     Route::get('/home16/activity_filter','ChartController@space_activity_filter');
     Route::get('/home16/contract_filter','ChartController@space_contract_filter');
    Route::get('/home23/activity_filter','ChartController@voteholder_activity_filter');
    Route::get('/home30/activity_filter','ChartController@flats_activity_filter');

    Route::get('/Space', 'SpaceController@index');
    Route::get('/space_contract_on_fly/{id}/', 'ContractsController@OnFlySpaceContractForm')->name('space_contract_on_fly');



    Route::get('/space_id_suggestions', 'SpaceController@spaceIdSuggestions')->name('space_id_suggestions');
    Route::get('/autocomplete.space_fields', 'SpaceController@autoCompleteSpaceFields')->name('autocomplete.space_fields');
    Route::get('/space_contract_form', 'ContractsController@SpaceContractForm');

    Route::get('/contracts_management', 'ContractsController@ContractsManagement')->name('contracts_management');
    Route::get('/contracts_management/insurance', 'ContractsController@ContractsManagementInsurance')->name('contracts_management_insurance');
    Route::get('/contracts_management/research', 'ContractsController@ContractsManagementResearch')->name('contracts_management_research');
    Route::get('/contracts_management/car_rental', 'ContractsController@ContractsManagementCarRental')->name('contracts_management_car_rental');


    Route::get('/invoice_management', 'InvoicesController@invoiceManagement');

    Route::get('/businesses', 'HomeController@businesses')->name('businesses');

    Route::get('/businesses/research_flats', 'HomeController@researchflats')->name('research_flats');


    Route::post('/businesses/research_flats/add', 'HomeController@addresearchflats')->name('addflat');

    Route::post('/businesses/research_flats/edit', 'HomeController@editresearchflats')->name('editflat');

    Route::get('/businesses/research_flats/delete/{id}', 'HomeController@deleteresearchflats')->name('deleteflat');

    Route::get('/contracts_management/research_flats', 'HomeController@contractresearchflats')->name('contractflat');

    Route::post('/contracts_management/research_flats/add_contract', 'HomeController@add_research_contract')->name('addcontractflat');
    Route::post('/contracts_management/research_flats/terminate_contract/{id}', 'HomeController@terminate_research_contract')->name('terminatecontractflat');

    Route::post('/autocomplete/research_flats/category', 'HomeController@auto_category')->name('auto_category');

    Route::post('/autocomplete/research_flat/name', 'HomeController@flat_client_details')->name('autocomplete.flat_name');

     Route::post('/autocomplete/research_flat/all_details', 'HomeController@flat_all_details')->name('autocomplete.allflat_details');

     Route::get('/contracts_management/research_flat/print','HomeController@printResearchForm')->name('printResearchForm');

     Route::get('/contracts_management/research_flat/edit/{id}','HomeController@editResearchForm')->name('editResearchForm');
     Route::get('/contracts_management/research_flat/renew/{id}','HomeController@renewResearchForm')->name('renewResearchForm');

     Route::post('/contracts_management/research_flat/send_edit/{id}','HomeController@sendeditResearchForm')->name('sendeditResearchForm');


     Route::get('/invoice_management/space/filter', 'InvoicesController@space_filter');





        //Invoices car rental
        Route::get('/car_rental_invoice_management', 'InvoicesController@CarRentalInvoiceManagement');
        Route::post('/change_payment_status_car_rental/{id}', 'InvoicesController@changePayementStatusCarRental')->name('change_payment_status_car_rental');
        Route::post('/send_invoice_car_rental/{id}', 'InvoicesController@sendInvoiceCarRental')->name('send_invoice_car_rental');

        Route::post('/send_invoice_car_rental_account_no/{id}', 'InvoicesController@sendInvoiceCarRentalAccount')->name('send_invoice_car_rental_account_no');

        Route::post('/create_car_invoice_manually', 'InvoicesController@CreateCarInvoiceManually')->name('create_car_invoice_manually');



//Invoices research rental

        Route::post('/change_payment_status_research/{id}', 'InvoicesController@changePayementStatusResearch')->name('change_payment_status_research');
        Route::post('/send_invoice_research/{id}', 'InvoicesController@sendInvoiceResearch')->name('send_invoice_research');



        Route::post('/create_research_invoice_manually', 'InvoicesController@CreateResearchInvoiceManually')->name('create_research_invoice_manually');




        //payment
        Route::get('/payment_management', 'PaymentController@paymentManagement');

        Route::get('/payment_management/filtered', 'PaymentController@payment_filtered');

        Route::get('/check_availability_car', 'PaymentController@checkAvailabilityCar')->name('check_availability_car');


        //payments
        Route::post('/create_car_payment_manually', 'PaymentController@CreateCarPaymentManually')->name('create_car_payment_manually');







        Route::get('/check_availability_research', 'PaymentController@checkAvailabilityResearch')->name('check_availability_research');


        //payments
        Route::post('/create_research_payment_manually', 'PaymentController@CreateResearchPaymentManually')->name('create_research_payment_manually');




        Route::get('/clients', 'clientsController@index')->name('clients');
        Route::get('/clients/research', 'clientsController@researchClients')->name('research_clients');
        Route::get('/clients/insurance', 'clientsController@insuranceClients')->name('insurance_clients');
        Route::get('/clients/car_rental', 'clientsController@carClients')->name('car_rental_clients');


Route::post('/clients/Space/edit', 'clientsController@edit')->name('editclients');

Route::post('/clients/Research/edit/{id}', 'clientsController@editResearchclients')->name('editResearchclients');

Route::post('/clients/Car/edit', 'clientsController@editCarclients')->name('editCarclients');

Route::post('/clients/Insurance/edit', 'clientsController@editIns')->name('editInsclients');

Route::get('/clients/Space/view_more/{id}','clientsController@ClientViewMore')->name('ClientViewMore');

Route::get('/clients/Research/view_more/{first_name}/{last_name}/{email}/{phone_number}','clientsController@ResearchClientsViewMore')->name('ResearchClientsViewMore');

Route::get('/clients/car_rental/view_more/{name}/{email}/{centre}','clientsController@CarViewMore')->name('CarClientsViewMore');

Route::get('/clients/insurance/view_more/{full_name}/{email}/{phone_number}','clientsController@InsuranceClientsViewMore')->name('InsuranceClientsViewMore');

Route::post('/clients/Space/SendMessage', 'clientsController@SendMessage')->name('SendMessage');

Route::post('/clients/Space/SendMessage_2', 'clientsController@SendMessage2')->name('SendMessage2');



Route::post('/car/add_car','carRentalController@newcar')->name('addCar');

Route::post('/car/add_car/step2','carRentalController@newcar_step2')->name('addCar_step2');

Route::post('/car/add_car/step3','carRentalController@newcar_step3')->name('addCar_step3');

Route::get('/car/add_car/step4/{id}','carRentalController@newcar_step4')->name('addCar_step4');

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

Route::post('/contracts_management/log_sheet','carContractsController@logsheetindex')->name('logsheetindex');

Route::get('/contracts_management/log_sheet/viewmore/{id}','carContractsController@logsheet_view_more')->name('logsheetmore');

Route::post('/contracts_management/log_sheet/add','carContractsController@addlogsheet')->name('addlogsheet');

Route::post('/contracts_management/log_sheet/edit','carContractsController@editlogsheet')->name('editlogsheet');

Route::get('/contracts_management/log_sheet/delete/{id}','carContractsController@deletelogsheet')->name('deletelogsheet');

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

Route::get('/contracts/car_rental/view_more/{id}', 'carContractsController@viewmore')->name('carcontractviewmore');

Route::get('/contracts/car_rental/renew/{id}','carContractsController@renewContractForm')->name('RenewcarRentalForm');

Route::get('/contracts/car_rental/terminate/{id}','carContractsController@terminateContract')->name('terminateCarRental');

Route::post('/autocomplete/vehicle', 'carRentalController@fetch')->name('autocomplete.fetch');

Route::post('/autocomplete2/vehicle', 'carRentalController@fetchs2')->name('autocomplete2.fetch');

Route::post('/autocomplete/vehicle_2', 'carRentalController@fetch2')->name('autocomplete.fetch2');

Route::post('/autocomplete/model', 'carRentalController@model')->name('autocomplete.model');

Route::post('/autocomplete/hirerate', 'carRentalController@hirerate')->name('autocomplete.hirerate');

Route::post('/autocomplete/faculty', 'carRentalController@faculty')->name('autocomplete.faculty');


Route::post('/autocomplete/space_id', 'SpaceController@fetchspaceid')->name('autocomplete.spaces');

Route::post('/autocomplete/spaces_ids/fetch', 'SpaceController@fetchspaceidss')->name('autocomplete.spaces2');

Route::post('/autocomplete/cost_centres', 'carRentalController@fetchcostcentres')->name('autocomplete.costcentres');


Route::post('/autocomplete/client_name', 'clientsController@fetchclient_name')->name('autocomplete.client_name');

Route::post('/autocomplete/client_name/ajax', 'clientsController@ajaxclient_names')->name('ajax.client_names');

Route::post('/autocomplete/cptu', 'carContractsController@fetchclient_details')->name('autocomplete.cptu');

Route::get('/autocomplete/cptu/all', 'carContractsController@fetchallclient_details')->name('autocomplete.allcptu');

Route::get('/reports', 'HomeController@report')->name('reports');

Route::get('/reports/space1', 'HomeController@spacereport1')->name('spacereport1');

Route::get('/reports/invoice/debt_summary', 'HomeController@debtsummaryPDF')->name('debtsummarypdf');

Route::get('/reports/space1/pdf','HomeController@spacereport1PDF')->name('spacereport1pdf');

Route::get('/reports/space2/pdf','HomeController@spacereport2PDF')->name('spacereport2pdf');

Route::get('/reports/insurance/pdf','HomeController@insurancereportPDF')->name('insurancereportpdf');

Route::get('/reports/tenant/pdf','HomeController@tenantreportPDF')->name('tenantreportpdf');

Route::get('/reports/tenant/aging_analysis','HomeController@tenantAgingAnalysisReport')->name('tenant_aging_analysis_report');

Route::get('/reports/car_rental/pdf','HomeController@carreportPDF')->name('carreportpdf');

Route::get('/reports/car_rental/cost_centre_list_report','HomeController@costCentreListReport')->name('cost_centre_list_report');
Route::get('/reports/car_rental/hire_rates_report','HomeController@hireRatesReport')->name('hire_rates_report');

Route::get('/reports/car_rental2/pdf','HomeController@carreportPDF2')->name('carreportpdf2');

Route::get('/reports/car_rental3/pdf','HomeController@carreportPDF3')->name('carreportpdf3');

Route::get('/reports/contracts/pdf','HomeController@contractreportPDF')->name('contractreportpdf');

Route::get('/reports/invoice/pdf','HomeController@invoicereportPDF')->name('invoicereportpdf');

Route::get('/reports/system/user/pdf','HomeController@systemreportPDF')->name('systemreportpdf');

Route::get('/reports/tenancy/pdf','HomeController@tenancyreport')->name('tenancyreportpdf');

Route::get('/reports/research_flats/pdf','HomeController@flatsreport')->name('flatsreportpdf');


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

Route::get('/edit_profile_details','HomeController@editprofiledetails')->name('save_editprofile');

Route::post('/edit_profile/save_signature','HomeController@save_signature')->name('save_signature');

Route::get('/view_profile','HomeController@viewprofile')->name('viewprofile');

Route::get('/change_password','HomeController@changepassword')->name('changepassword');

Route::get('/change_password_login','HomeController@changepasswordlogin')->name('changepasswordlogin');

Route::get('/system_chats','systemChatController@index')->name('chatindex');

Route::post('/system_chats/send','systemChatController@sendMessage')->name('sendchat');

Route::post('/change_password_details','HomeController@changepassworddetails')->name('changepassword_details');

Route::post('/reset_password','HomeController@resetPassword')->name('reset_password');

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
    Route::get('/space_contracts_subclients/{client_id}', 'ContractsController@SpaceContractsSubClientsManagement')->name('space_contracts_subclients');
    Route::get('/renew_space_contract_form/{id}','ContractsController@renewSpaceContractForm')->name('renew_space_contract_form');
    Route::get('/renew_space_contract_form_parent_client/{id}','ContractsController@renewSpaceContractFormParentClient')->name('renew_space_contract_form_parent_client');
    Route::get('/edit_space_contract/{id}/', 'ContractsController@EditSpaceContractForm')->name('edit_contract');
    Route::get('/edit_space_contract_parent_client/{id}/', 'ContractsController@EditSpaceContractFormParentClient')->name('edit_contract_parent_client');
    Route::post('/edit_space_contract_final/{contract_id}/client_id/{client_id}', 'ContractsController@EditSpaceContractFinalProcessing')->name('edit_space_contract_final');
    Route::post('/add_space', 'SpaceController@addSpace')->name('add_space');
    Route::post('/approve_space', 'SpaceController@approveSpace')->name('approve_space');
    Route::post('/edit_space/{id}', 'SpaceController@editSpace')->name('edit_space');
    Route::post('/resubmit_space/{id}', 'SpaceController@ResubmitSpace')->name('resubmit_space');
    Route::get('/delete_space/{id}', 'SpaceController@deleteSpace')->name('delete_space');
    Route::get('/cancel_space_addition/{id}', 'SpaceController@CancelSpaceAddition')->name('cancel_space_addition');
    Route::post('/generate_minor_list', 'SpaceController@generateMinorList')->name('generate_minor_list');

    Route::post('/generate_location_list', 'SpaceController@generateLocationList')->name('generate_location_list');
    Route::post('/generate_sub_location_list', 'SpaceController@generateSubLocationList')->name('generate_sub_location_list');
    Route::post('/generate_space_id_list', 'SpaceController@generateSpaceIdList')->name('generate_space_id_list');


    Route::post('/get_space_contract_ids', 'ContractsController@getSpaceContractIds')->name('get_space_contract_ids');
    Route::get('/reports/payment/payment_history', 'ContractsController@getPaymentHistory')->name('payment_history');


    Route::get('/send_all_invoices_space', 'InvoicesController@sendAllInvoicesSpace')->name('send_all_invoices_space');
    Route::post('/add_control_no_space/{id}', 'InvoicesController@addControlNumberSpace')->name('add_control_no_space');
    Route::get('/space_contract_on_fly/{id}/', 'ContractsController@OnFlySpaceContractForm')->name('space_contract_on_fly');
    Route::get('/space_id_suggestions', 'SpaceController@spaceIdSuggestions')->name('space_id_suggestions');
    Route::get('/autocomplete.space_fields', 'SpaceController@autoCompleteSpaceFields')->name('autocomplete.space_fields');
    Route::get('/space_contract_form', 'ContractsController@SpaceContractForm');
    Route::get('/contract_details/{contract_id}', 'ContractsController@ContractDetails')->name('contract_details');
    Route::get('/space_details/{space_id}', 'ContractsController@SpaceDetails')->name('space_details');
    Route::post('/create_space_contract', 'ContractsController@CreateSpaceContract')->name('create_space_contract');
    Route::get('/renew_space_contract/{id}', 'ContractsController@RenewSpaceContract')->name('renew_space_contract');
    Route::get('/space_contract_approval/{id}', 'ContractsController@ApproveSpaceContractForm')->name('space_contract_approval');
    Route::post('/space_contract_approval_response', 'ContractsController@SpaceContractApprovalResponse')->name('space_contract_approval_response');
    Route::get('/terminate_space_contract/{id}', 'ContractsController@terminateSpaceContract')->name('terminate_space_contract');
    Route::get('/contract_availability_space', 'InvoicesController@contractAvailabilitySpace')->name('contract_availability_space');
    Route::get('/get_parent_currency', 'ContractsController@getParentCurrency')->name('get_parent_currency');
    Route::get('/print_space_contract/{id}', 'ContractsController@printSpaceContract')->name('print_space_contract');


    // Water Bills

    Route::get('/create_water_bills_invoice', 'InvoicesController@CreateWaterBillsInvoice')->name('create_water_bills_invoice');
    Route::get('/water_bills_invoice_management', 'InvoicesController@WaterBillsInvoiceManagement');
    Route::post('/send_invoice_water_bills/{id}', 'InvoicesController@sendInvoiceWaterBills')->name('send_invoice_water_bills');
    Route::post('/change_payment_status_water_bills/{id}', 'InvoicesController@changePaymentStatusWaterBills')->name('change_payment_status_water_bills');
    Route::post('/create_water_invoice_manually', 'InvoicesController@CreateWaterBillInvoiceManually')->name('create_water_invoice_manually');
    Route::get('/contract_availability_water', 'InvoicesController@contractAvailabilityWater')->name('contract_availability_water');
    Route::get('/send_all_invoices_water', 'InvoicesController@sendAllInvoicesWater')->name('send_all_invoices_water');
    Route::post('/add_control_no_water/{id}', 'InvoicesController@addControlNumberWater')->name('add_control_no_water');


    // Electricity Bills

    Route::get('/electricity_bills_invoice_management', 'InvoicesController@ElectricityBillsInvoiceManagement');
    Route::post('/send_invoice_electricity_bills/{id}', 'InvoicesController@sendInvoiceElectricityBills')->name('send_invoice_electricity_bills');
    Route::post('/change_payment_status_electricity_bills/{id}', 'InvoicesController@changePaymentStatusElectricityBills')->name('change_payment_status_electricity_bills');
    Route::post('/create_electricity_invoice_manually', 'InvoicesController@CreateElectricityBillInvoiceManually')->name('create_electricity_invoice_manually');
    Route::get('/contract_availability_electricity', 'InvoicesController@contractAvailabilityElectricity')->name('contract_availability_electricity');
    Route::get('/send_all_invoices_electricity', 'InvoicesController@sendAllInvoicesElectricity')->name('send_all_invoices_electricity');
    Route::post('/add_control_no_electricity/{id}', 'InvoicesController@addControlNumberElectricity')->name('add_control_no_electricity');


    //foward space invoice
    Route::post('/foward_space_invoice/{invoice_id}', 'InvoicesController@fowardSpaceInvoice')->name('foward_space_invoice');
    Route::post('/foward_water_invoice/{invoice_id}', 'InvoicesController@fowardWaterInvoice')->name('foward_water_invoice');
    Route::post('/foward_electricity_invoice/{invoice_id}', 'InvoicesController@fowardElectricityInvoice')->name('foward_electricity_invoice');


//payments
    Route::post('/create_space_payment_manually', 'PaymentController@CreateSpacePaymentManually')->name('create_space_payment_manually');
    Route::post('/create_water_payment_manually', 'PaymentController@CreateWaterPaymentManually')->name('create_water_payment_manually');
    Route::post('/create_electricity_payment_manually', 'PaymentController@CreateElectricityPaymentManually')->name('create_electricity_payment_manually');
    Route::get('/check_availability_water', 'PaymentController@checkAvailabilityWater')->name('check_availability_water');
    Route::get('/check_availability_electricity', 'PaymentController@checkAvailabilityElectricity')->name('check_availability_electricity');
    Route::get('/check_availability_space', 'PaymentController@checkAvailabilitySpace')->name('check_availability_space');
    Route::post('/add_discount_space/{id}', 'PaymentController@addDiscountSpace')->name('add_discount_space');
    Route::post('/edit_discount_space/{id}', 'PaymentController@editDiscountSpace')->name('edit_discount_space');
    Route::post('/cancel_discount_addition_request/{id}', 'PaymentController@cancelDiscountAdditionRequest')->name('cancel_discount_addition_request');
    Route::post('/approve_discount_request/{id}', 'PaymentController@approveDiscountRequest')->name('approve_discount_request');


//File management

    Route::get('/view_pdf/{contract_id}/{type}','ContractsController@ViewPdf')->name('view_pdf');


//Invoices Space
    Route::get('/invoice_pdf', 'InvoicesController@index');
    Route::post('/create_space_invoice_manually', 'InvoicesController@CreateSpaceInvoiceManually')->name('create_space_invoice_manually');
    Route::post('/send_invoice_space/{id}', 'InvoicesController@sendInvoiceSpace')->name('send_invoice_space');
    Route::post('/change_payment_status_space/{id}', 'InvoicesController@changePayementStatusSpace')->name('change_payment_status_space');
    Route::get('/create_space_invoice', 'InvoicesController@CreateSpaceInvoice')->name('create_space_invoice');
    Route::get('/print_space_invoice/{id}', 'InvoicesController@PrintSpaceInvoice')->name('print_space_invoice');
    Route::get('/print_water_invoice/{id}', 'InvoicesController@PrintWaterInvoice')->name('print_water_invoice');
    Route::get('/print_electricity_invoice/{id}', 'InvoicesController@PrintElectricityInvoice')->name('print_electricity_invoice');



    Route::post('/cancel_space_invoice/{id}', 'InvoicesController@CancelSpaceInvoice')->name('cancel_space_invoice');
    Route::post('/cancel_water_invoice/{id}', 'InvoicesController@CancelWaterInvoice')->name('cancel_water_invoice');
    Route::post('/cancel_electricity_invoice/{id}', 'InvoicesController@CancelElectricityInvoice')->name('cancel_electricity_invoice');

    Route::get('/conferences_management', 'SpaceController@conferencesManagement')->name('conferences_management');
    Route::post('/edit_event/{id}', 'SpaceController@editEvent')->name('edit_event');
    Route::post('/add_event', 'SpaceController@addEvent')->name('add_event');
    Route::post('/delete_event/{id}', 'SpaceController@deleteEvent')->name('delete_event');

    //Import data
    Route::post('/import_space_contracts', 'ImportExcelController@importSpaceContracts')->name('import_space_contracts');
    Route::get('/get_space_contracts_format', 'ImportExcelController@spaceContractsFormat')->name('get_space_contracts_format');

    Route::post('/import_space_payments', 'ImportExcelController@importSpacePayments')->name('import_space_payments');
    Route::get('/get_space_payments_format', 'ImportExcelController@spacePaymentsFormat')->name('get_space_payments_format');


    Route::post('/import_spaces', 'ImportExcelController@importSpaces')->name('import_spaces');
    Route::get('/get_spaces_format', 'ImportExcelController@spacesFormat')->name('get_spaces_format');

    Route::post('/import_space_invoices', 'ImportExcelController@importSpaceInvoices')->name('import_space_invoices');
    Route::get('/get_space_invoices_format', 'ImportExcelController@spaceInvoicesFormat')->name('get_space_invoices_format');

    Route::post('/import_water_bill_invoices', 'ImportExcelController@importWaterBillInvoices')->name('import_water_bill_invoices');
    Route::get('/get_water_bill_invoices_format', 'ImportExcelController@waterBillInvoicesFormat')->name('get_water_bill_invoices_format');


});Route::post('/import_electricity_bill_invoices', 'ImportExcelController@importElectricityBillInvoices')->name('import_electricity_bill_invoices');
Route::get('/get_electricity_bill_invoices_format', 'ImportExcelController@electricityBillInvoicesFormat')->name('get_electricity_bill_invoices_format');



//insurance
Route::group(['middleware' => ['auth', 'insurance']], function() {

    //Insurance contracts
    Route::get('/terminate_insurance_contract/{id}', 'ContractsController@terminateInsuranceContract')->name('terminate_insurance_contract');
    Route::get('/edit_insurance_contract/{id}/', 'ContractsController@EditInsuranceContractForm')->name('edit_insurance_contract');
    Route::post('/edit_insurance_contract_final/{contract_id}', 'ContractsController@EditInsuranceContractFinalProcessing')->name('edit_insurance_contract_final');
    Route::get('/insurance_contracts_management', 'ContractsController@InsuranceContractsManagement');
    Route::get('/insurance_contract_form', 'ContractsController@InsuranceContractForm');
    Route::get('/insurance_contract_pdf', 'ContractsController@testing');
    Route::post('/create_insurance_contract', 'ContractsController@CreateInsuranceContract')->name('create_insurance_contract');
    Route::get('/renew_insurance_contract_form/{id}/', 'ContractsController@RenewInsuranceContractForm')->name('renew_insurance_contract_form');
    Route::get('/insurance_contract_on_fly/{id}/', 'ContractsController@OnFlyInsuranceContractForm')->name('insurance_contract_on_fly');
    Route::get('/autofill_insurance_parameters/', 'ContractsController@autofillParameters')->name('autofill_insurance_parameters');
    Route::get('/contract_details_insurance/{contract_id}', 'ContractsController@ContractDetailsInsurance')->name('contract_details_insurance');
    Route::get('/send_all_invoices_insurance', 'InvoicesController@sendAllInvoicesInsurance')->name('send_all_invoices_insurance');
    Route::get('/send_all_invoices_principals_insurance', 'InvoicesController@sendAllInvoicesPrincipalsInsurance')->name('send_all_invoices_principals_insurance');
    Route::post('/add_control_no_insurance/{id}', 'InvoicesController@addControlNumberInsurance')->name('add_control_no_insurance');
    Route::post('/add_control_no_insurance_principals/{id}', 'InvoicesController@addControlNumberInsurancePrincipals')->name('add_control_no_insurance_principals');


//Insurance
    Route::get('/insurance', 'InsuranceController@index');
    Route::post('/add_insurance', 'InsuranceController@addInsurance')->name('add_insurance');
    Route::post('/edit_insurance/{id}', 'InsuranceController@editInsurance')->name('edit_insurance');
    Route::get('/deactivate_insurance/{id}', 'InsuranceController@deactivateInsurance')->name('deactivate_insurance');
    Route::get('/generate_type_list', 'InsuranceController@generateTypes')->name('generate_type_list');
    Route::get('/client_name_suggestions', 'InsuranceController@clientNameSuggestions')->name('client_name_suggestions');
    Route::get('/client_name_particulars_insurance', 'InsuranceController@clientParticulars')->name('client_name_particulars_insurance');
    Route::get('/vehicle_registration_no_suggestions', 'InsuranceController@vehicleRegistrationNumberSuggestions')->name('vehicle_registration_no_suggestions');
    //payments
    Route::post('/create_insurance_payment_manually', 'PaymentController@CreateInsurancePaymentManually')->name('create_insurance_payment_manually');
    Route::post('/create_insurance_clients_payment_manually', 'PaymentController@CreateInsuranceClientsPaymentManually')->name('create_insurance_clients_payment_manually');
    Route::get('/check_availability_insurance', 'PaymentController@checkAvailabilityInsurance')->name('check_availability_insurance');
    Route::get('/check_availability_insurance_clients', 'PaymentController@checkAvailabilityInsuranceClients')->name('check_availability_insurance_clients');

    //Insurance invoices
    Route::get('/insurance_invoice_management', 'InvoicesController@insuranceInvoiceManagement');
    Route::post('/send_invoice_insurance/{id}', 'InvoicesController@sendInvoiceInsurance')->name('send_invoice_insurance');
    Route::post('/send_invoice_insurance_principals/{id}', 'InvoicesController@sendInvoiceInsurancePrincipals')->name('send_invoice_insurance_principals');
    Route::post('/change_payment_status_insurance/{id}', 'InvoicesController@changePayementStatusInsurance')->name('change_payment_status_insurance');
    Route::post('/change_payment_status_insurance_principals/{id}', 'InvoicesController@changePayementStatusInsurancePrincipals')->name('change_payment_status_insurance_principals');
    Route::get('/create_insurance_invoice', 'InvoicesController@CreateInsuranceInvoice');
    Route::post('/create_insurance_invoice_manually', 'InvoicesController@CreateInsuranceInvoiceManually')->name('create_insurance_invoice_manually');
    Route::post('/create_insurance_invoice_clients_manually', 'InvoicesController@CreateInsuranceInvoiceClientsManually')->name('create_insurance_invoice_clients_manually');
    Route::get('/get_info_insurance', 'InvoicesController@getInfoInsurance')->name('get_info_insurance');
    Route::get('/contract_availability_insurance', 'InsuranceController@contractAvailabilityInsurance')->name('contract_availability_insurance');
    Route::get('/autocomplete.sum_insured', 'InsuranceController@autoCompleteSumInsured')->name('autocomplete.sum_insured');
    Route::get('/get_actual_value', 'InsuranceController@getActualValue')->name('get_actual_value');



    Route::post('/foward_insurance_invoice/{invoice_id}', 'InvoicesController@fowardInsuranceInvoice')->name('foward_insurance_invoice');
    Route::post('/foward_insurance_clients_invoice/{invoice_id}', 'InvoicesController@fowardInsuranceClientsInvoice')->name('foward_insurance_clients_invoice');


    Route::get('/print_insurance_invoice_clients/{id}', 'InvoicesController@PrintInsuranceInvoiceClients')->name('print_insurance_invoice_clients');
    Route::get('/print_insurance_invoice_principals/{id}', 'InvoicesController@PrintInsuranceInvoicePrincipals')->name('print_insurance_invoice_principals');

    Route::get('/cancel_insurance_invoice_clients/{id}', 'InvoicesController@CancelInsuranceClientsInvoice')->name('cancel_insurance_invoice_clients');
    Route::get('/cancel_insurance_invoice_principals/{id}', 'InvoicesController@CancelInsurancePrincipalsInvoice')->name('cancel_insurance_invoice_principals');


    //Import data
    Route::post('/import_insurance_contracts', 'ImportExcelController@importInsuranceContracts')->name('import_insurance_contracts');
    Route::get('/get_insurance_contracts_format', 'ImportExcelController@insuranceContractsFormat')->name('get_insurance_contracts_format');




    Route::post('/import_insurance_packages', 'ImportExcelController@importInsurancePackages')->name('import_insurance_packages');
    Route::get('/get_insurance_packages_format', 'ImportExcelController@insurancePackagesFormat')->name('get_insurance_packages_format');



    Route::post('/import_insurance_companies', 'ImportExcelController@importInsuranceCompanies')->name('import_insurance_companies');
    Route::get('/get_insurance_companies_format', 'ImportExcelController@insuranceCompaniesFormat')->name('get_insurance_companies_format');


    Route::post('/import_insurance_classes', 'ImportExcelController@importInsuranceClasses')->name('import_insurance_classes');
    Route::get('/get_insurance_classes_format', 'ImportExcelController@insuranceClassesFormat')->name('get_insurance_classes_format');


    Route::post('/import_insurance_invoices', 'ImportExcelController@importInsuranceInvoices')->name('import_insurance_invoices');
    Route::get('/get_insurance_invoices_format', 'ImportExcelController@insuranceInvoicesFormat')->name('get_insurance_invoices_format');

    Route::post('/import_insurance_clients_invoices', 'ImportExcelController@importInsuranceClientsInvoices')->name('import_insurance_clients_invoices');
    Route::get('/get_insurance_clients_invoices_format', 'ImportExcelController@insuranceClientsInvoicesFormat')->name('get_insurance_clients_invoices_format');




});


Route::group(['middleware' => ['auth', 'car']], function() {

    Route::get('/contract_availability_car', 'InvoicesController@contractAvailabilityCar')->name('contract_availability_car');
    Route::get('/send_all_invoices_car', 'InvoicesController@sendAllInvoicesCar')->name('send_all_invoices_car');
    Route::post('/add_control_no_car/{id}', 'InvoicesController@addControlNumberCar')->name('add_control_no_car');

    Route::post('/add_account_no_car/{id}', 'InvoicesController@addAccountNumberCar')->name('add_account_no_car');



    Route::post('/foward_car_invoice/{invoice_id}', 'InvoicesController@fowardCarInvoice')->name('foward_car_invoice');

    Route::get('/print_car_invoice/{id}', 'InvoicesController@PrintCarInvoice')->name('print_car_invoice');
    Route::get('/print_car_invoice_account/{id}', 'InvoicesController@PrintCarInvoiceAccount')->name('print_car_invoice_account');


    Route::get('/cancel_car_invoice/{id}', 'InvoicesController@CancelCarInvoice')->name('cancel_car_invoice');


    //import data
    Route::post('/import_car_contracts', 'ImportExcelController@importCarContracts')->name('import_car_contracts');
    Route::get('/get_car_contracts_format', 'ImportExcelController@carContractsFormat')->name('get_car_contracts_format');


    Route::post('/import_logsheets', 'ImportExcelController@importLogSheets')->name('import_logsheets');
    Route::get('/get_logsheets_format', 'ImportExcelController@logSheetsFormat')->name('get_logsheets_format');


    Route::post('/import_hire_rate', 'ImportExcelController@importHireRate')->name('import_hire_rate');
    Route::get('/get_hire_rate_format', 'ImportExcelController@hireRateFormat')->name('get_hire_rate_format');


    Route::post('/import_vehicles', 'ImportExcelController@importVehicles')->name('import_vehicles');
    Route::get('/get_vehicles_format', 'ImportExcelController@vehiclesFormat')->name('get_vehicles_format');


    Route::post('/import_cost_centres', 'ImportExcelController@importCostCentres')->name('import_cost_centres');
    Route::get('/get_cost_centres_format', 'ImportExcelController@CostCentresFormat')->name('get_cost_centres_format');



    Route::post('/import_car_invoices', 'ImportExcelController@importCarInvoices')->name('import_car_invoices');
    Route::get('/get_car_invoices_format', 'ImportExcelController@carInvoicesFormat')->name('get_car_invoices_format');




    Route::get('/cost_centres_management', 'carRentalController@costCentresManagement')->name('cost_centres_management');
    Route::get('/hire_rates_management', 'carRentalController@hireRatesManagement')->name('hire_rates_management');




});




Route::group(['middleware' => ['auth', 'research']], function() {

    Route::get('/contract_availability_research', 'InvoicesController@contractAvailabilityResearch')->name('contract_availability_research');
    Route::get('/send_all_invoices_research', 'InvoicesController@sendAllInvoicesResearch')->name('send_all_invoices_research');
    Route::post('/add_control_no_research/{id}', 'InvoicesController@addControlNumberResearch')->name('add_control_no_research');

    Route::post('/foward_research_invoice/{invoice_id}', 'InvoicesController@fowardResearchInvoice')->name('foward_research_invoice');

    Route::post('/generate_college_list', 'ContractsController@generateCollegeList')->name('generate_college_list');
    Route::post('/generate_department_list', 'ContractsController@generateDepartmentList')->name('generate_department_list');


    Route::get('/print_research_invoice/{id}', 'InvoicesController@PrintResearchInvoice')->name('print_research_invoice');

    Route::get('/cancel_research_invoice/{id}', 'InvoicesController@CancelResearchInvoice')->name('cancel_research_invoice');


    //Import data
    Route::post('/import_research_contracts', 'ImportExcelController@importResearchContracts')->name('import_research_contracts');
    Route::get('/get_research_contracts_format', 'ImportExcelController@researchContractsFormat')->name('get_research_contracts_format');


    Route::post('/import_research_rooms', 'ImportExcelController@importResearchRooms')->name('import_research_rooms');
    Route::get('/get_research_rooms_format', 'ImportExcelController@researchRoomsFormat')->name('get_research_rooms_format');

    Route::post('/import_research_invoices', 'ImportExcelController@importResearchInvoices')->name('import_research_invoices');
    Route::get('/get_research_invoices_format', 'ImportExcelController@researchInvoicesFormat')->name('get_research_invoices_format');






});
