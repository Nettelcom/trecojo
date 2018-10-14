<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function(){

    Route::post('/user', 'Api\UseraController@addUser')->name('addUser');
    Route::post('/company', 'Api\UseraController@addCompany')->name('addCompany');
    Route::post('/addRequestClient', 'Api\UseraController@addRequestClient')->name('addRequestClient');
    Route::post('/addRequestCompany', 'Api\UseraController@addRequestCompany')->name('addRequestCompany');
    Route::post('/add_clients_company_api', 'Api\UseraController@add_clients_company_api')->name('add_clients_company_api');
});

