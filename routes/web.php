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

    Route::get('owners','AdminController@show_owners');

    Route::get('providers','AdminController@show_providers');

    Route::get('company','AdminController@show_company');


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

    Route::get('consult_ruc', 'DriverController@ruc')->name('ruc');

    Route::post('add_company', 'CompanyController@add_company')->name('add_company');

    Route::get('delete_cars_company/{id}', 'CompanyController@delete_cars_company')->name('delete_cars_company');

    Route::post('show_car_company', 'CompanyController@show_car_company')->name('show_car_company');

    Route::post('add_car_company', 'CompanyController@add_car_company')->name('add_car_company');

    Route::get('delete_company/{id}', 'CompanyController@delete_company')->name('delete_company');

    Route::post('show_edit_company', 'CompanyController@show_edit_company')->name('show_edit_company');

    Route::get('change_status_company/{id}', 'CompanyController@change_status_company')->name('change_status_company');

    Route::post('update_company', 'CompanyController@update_company')->name('update_company');

    Route::get('clients', 'ClientsController@show_clients')->name('show_clients');

    Route::post('add_clients', 'ClientsController@add_clients')->name('add_clients');

    Route::get('delete_client/{id}', 'ClientsController@delete_client')->name('delete_client');

    Route::post('get_information_client', 'ClientsController@get_information_client')->name('get_information_client');

    Route::post('update_client', 'ClientsController@update_client')->name('update_client');

    Route::post('update_data_request', 'RequestController@update_data_request')->name('update_data_request');

    Route::get('change_state_request/{id}', 'RequestController@change_state_request')->name('change_state_request');

    Route::get('change_is_payment_request/{id}', 'RequestController@change_is_payment_request')->name('change_is_payment_request');

    Route::get('delete_request/{id}', 'RequestController@delete_request')->name('delete_request');

//    Route::post('/api/user', 'InteractiveController@addUser')->name('addUser');


});

Route::get('/admin/payments', function () {
    return view('payments');
});

Route::get('/admin/promo-codes', function () {
    return view('promo');
});
     




