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



    
    
});

Route::get('/admin/payments', function () {
    return view('payments');
});

Route::get('/admin/promo-codes', function () {
    return view('promo');
});
     




