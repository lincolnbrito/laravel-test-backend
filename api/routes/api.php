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
Route::namespace('API')->name('api.')->group(function(){
    Route::apiResource('states', 'StatesController')->only(['index','show']);
    Route::apiResource('states.cities', 'CitiesController')->only(['index','show']);

    Route::apiResource('properties', 'PropertiesController')->except(['update']);
    Route::apiResource('contracts', 'ContractsController')->except(['update']);;
});
