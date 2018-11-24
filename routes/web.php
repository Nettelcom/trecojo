<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','Admin\AdminController@redirect');


// --------------------
// Backpack\Demo routes
// --------------------
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['admin'],
    'namespace'  => 'Admin',
], function () {
    

    Route::get('request','AdminController@show_requests');

    Route::get('notifications','AdminController@show_notifications');

    Route::get('show_margin','AdminController@show_margin');

    Route::get('owners','AdminController@show_owners');

    Route::get('providers','AdminController@show_providers');

    Route::get('company','AdminController@show_company');

    Route::get('payments','AdminController@show_payments');

    Route::get('request-company','AdminController@show_request_company');

    Route::get('car-types','AdminController@show_car_types');

    Route::get('maps','AdminController@show_map_view');

    Route::get('general-settings','AdminController@show_general_settings');

    Route::post('add-cars', 'CarsController@add_cars')->name('add-cars');

    Route::post('show_car', 'CarsController@show_car')->name('show_car');

    Route::post('edit-car', 'CarsController@edit_car')->name('edit_car');

    Route::get('delete_cars/{id}', 'CarsController@delete_cars')->name('delete_cars');

    Route::get('filter_cars', 'CarsController@filter_cars')->name('filter_cars');

    Route::post('add-driver', 'DriverController@addDriver')->name('add-driver');

    Route::post('show_img', 'DriverController@show_img')->name('show_img');

    Route::post('show_provider', 'DriverController@show_provider')->name('show_provider');

    Route::get('chage_status_provider/{id}', 'DriverController@chage_status_provider')->name('chage_status_provider');


    Route::post('edit-driver', 'DriverController@edit_driver')->name('edit-driver');

    Route::get('delete_provider/{id}', 'DriverController@delete_provider')->name('delete_provider');

    Route::post('add_car_provider', 'DriverController@add_car_provider')->name('add_car_provider');

    Route::post('get_provider_data', 'DriverController@get_provider_data')->name('get_provider_data');

    Route::get('consult_ruc', 'DriverController@ruc')->name('ruc');

    Route::post('add_company', 'CompanyController@add_company')->name('add_company');

    Route::get('getTypePaymentsForCompany', 'CompanyController@getTypePaymentsForCompany')->name('getTypePaymentsForCompany');

    Route::get('setPaymentCompany/{idu}/{idp}', 'CompanyController@setPaymentCompany')->name('setPaymentCompany');

    Route::get('deletePaymentCompany/{idu}', 'CompanyController@deletePaymentCompany')->name('deletePaymentCompany');

    Route::get('delete_cars_company/{id}', 'CompanyController@delete_cars_company')->name('delete_cars_company');

    Route::get('approval_status_company/{id}', 'CompanyController@approval_status_company')->name('approval_status_company');

    Route::post('show_car_company', 'CompanyController@show_car_company')->name('show_car_company');

    Route::post('add_car_company', 'CompanyController@add_car_company')->name('add_car_company');

    Route::get('delete_company/{id}', 'CompanyController@delete_company')->name('delete_company');

    Route::post('show_edit_company', 'CompanyController@show_edit_company')->name('show_edit_company');

    Route::get('change_status_company/{id}', 'CompanyController@change_status_company')->name('change_status_company');

    Route::post('update_company', 'CompanyController@update_company')->name('update_company');

    Route::post('get_users_company', 'CompanyController@get_users_company')->name('get_users_company');


    Route::get('clients', 'ClientsController@show_clients')->name('show_clients');

    Route::get('addUserCompany/{idC}/{idU}', 'ClientsController@addUserCompany')->name('addUserCompany');

    Route::get('deleteUserCompany/{id}', 'ClientsController@deleteUserCompany')->name('deleteUserCompany');

    Route::post('add_clients', 'ClientsController@add_clients')->name('add_clients');

    Route::get('getTypePaymentsForUser', 'ClientsController@getTypePaymentsForUser')->name('getTypePaymentsForUser');

    Route::post('get_company_user', 'ClientsController@get_company_user')->name('get_company_user');

    Route::get('setPaymentUser/{idU}/{idP}', 'ClientsController@setPaymentUser')->name('setPaymentUser');

    Route::get('deletePaymentUser/{idU}', 'ClientsController@deletePaymentUser')->name('deletePaymentUser');

    Route::post('add_clients_company', 'ClientsController@add_clients_company')->name('add_clients_company');

    Route::get('delete_client/{id}', 'ClientsController@delete_client')->name('delete_client');

    Route::get('approval_status/{id}', 'ClientsController@approval_status')->name('approval_status');

    Route::post('get_information_client', 'ClientsController@get_information_client')->name('get_information_client');

    Route::post('update_client', 'ClientsController@update_client')->name('update_client');

    Route::post('update_client_pwd', 'ClientsController@update_client_pwd')->name('update_client_pwd');

    Route::post('update_data_request', 'RequestController@update_data_request')->name('update_data_request');

    Route::post('getDataForId', 'RequestController@getDataForId')->name('getDataForId');

    Route::post('update_detail_request', 'RequestController@update_detail_request')->name('update_detail_request');

    Route::post('update_data_company_request', 'RequestController@update_data_company_request')->name('update_data_company_request');

    Route::get('change_state_request_company/{id}', 'RequestController@change_state_request_company')->name('change_state_request_company');

    Route::get('change_is_payment_request_company/{id}', 'RequestController@change_is_payment_request_company')->name('change_is_payment_request_company');

    Route::get('delete_request_company/{id}', 'RequestController@delete_request_company')->name('delete_request_company');

    Route::post('get_request_company', 'RequestController@get_request_company')->name('get_request_company');

    Route::post('add_request_modal_client', 'RequestController@add_request_modal_client')->name('add_request_modal_client');

    Route::post('update_detail_request_company', 'RequestController@update_detail_request_company')->name('update_detail_request_company');

    Route::post('add_request_modal_company', 'RequestController@add_request_modal_company')->name('add_request_modal_company');

    Route::post('details_request', 'RequestController@details_request')->name('details_request');

    Route::get('change_state_request/{id}', 'RequestController@change_state_request')->name('change_state_request');

    Route::get('change_is_payment_request/{id}', 'RequestController@change_is_payment_request')->name('change_is_payment_request');

    Route::get('delete_request/{id}', 'RequestController@delete_request')->name('delete_request');

    Route::post('show_update_user', 'OwnerController@show_update_user')->name('show_update_user');

    Route::post('user_update', 'OwnerController@user_update')->name('user_update');

    Route::get('delete_user/{id}', 'OwnerController@delete_user')->name('delete_user');

    Route::post('add_user', 'OwnerController@add_user')->name('add_user');

    Route::post('get_payments_for_type', 'PaymentController@get_payments_for_type')->name('get_payments_for_type');

    Route::post('get_margin_id', 'PaymentController@get_margin_id')->name('get_margin_id');

    Route::post('filter_payments', 'PaymentController@filter_payments')->name('filter_payments');

    Route::post('filter_margin_payments', 'PaymentController@filter_margin_payments')->name('filter_margin_payments');

    Route::get('rememberRequest', 'RequestController@rememberRequest')->name('rememberRequest');

    Route::get('get_type_user', 'RequestController@get_type_user')->name('get_type_user');

    Route::get('Reports', 'AdminController@show_reports')->name('show_reports');

    Route::post('report_clients', 'AdminController@report_clients')->name('report_clients');

    Route::post('report_company', 'AdminController@report_company')->name('report_company');

    Route::post('report_persona', 'AdminController@report_persona')->name('report_persona');

});



Route::get('/admin/promo-codes', function () {
    return view('promo');
});
     




