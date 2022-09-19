<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'auth', 'namespace' => 'API'], function () {
    Route::post('register', 'FarmerAuthController@register');
    Route::post('login', 'FarmerAuthController@login');
});

// For user Login not specific role

Route::group(['middleware' => 'Authorization', 'namespace' => 'API'], function () {
    Route::get('/auth/logout', 'FarmerAuthController@logout');
    Route::middleware(['AuthorizeFarmer'])->group(function () {
        Route::get('/village', 'GeneralController@getVillage');
        Route::get('/news', 'GeneralController@getNews');
        Route::get('/news/{id}', 'GeneralController@getDetailNews');    
    });
});

Route::get('district', 'API\GeneralController@district');
Route::get('village/{id}', 'API\GeneralController@village');
Route::get('village-geo/{id}', 'API\GeneralController@villageGeo');
Route::get('commodity-sector', 'API\GeneralController@commoditySector');
Route::get('commodity/{id}', 'API\GeneralController@commodity');

Route::get('farmer-group/{name}', 'API\GeneralController@farmerGroupByName');
Route::get('farmer/{name}', 'API\GeneralController@getFarmerWithCommodity');
Route::get('collector/{name}', 'API\GeneralController@getCollector');
Route::get('instructor/{name}', 'API\GeneralController@getInstructor');
Route::get('plant/{name}', 'API\GeneralController@getPlant');
Route::get('harvest/{name}', 'API\GeneralController@getHarvest');
Route::get('commodity-price/{name}', 'API\GeneralController@getCommodityPrice');
