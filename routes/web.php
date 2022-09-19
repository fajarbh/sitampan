<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/sitampan/clear',function(){
    $exitCode1  = Artisan::call('config:cache');
    $exitCode2  = Artisan::call('route:clear');
    $exitCode3  = Artisan::call('view:clear');
    return 'sukses';
});

Route::get('/', function() {
    return response()->redirectTo("/dashboard");
});

Route::get("/login", "AuthController@index")->name("login");
Route::post("/login", "AuthController@login");
Route::get('logout', 'AuthController@logout')->name('logout');

Route::get("/dashboard", "HomeController@index");
Route::get("/dashboard/chart/plant","HomeController@chartPlant");
Route::get("/dashboard/chart/production","HomeController@chartProduction");


route::get("/komoditas","CommodityController@index");
route::get("/komoditas/api","CommodityController@api");
route::get("/komoditas/create","CommodityController@create");
route::post("/komoditas/store","CommodityController@store");
route::get("/komoditas/edit/{id}","CommodityController@edit");
route::put("/komoditas/update/{id}","CommodityController@update");
route::delete("/komoditas/delete/{id}","CommodityController@delete");

route::get("/tanam","PlantController@index");
route::get("/tanam/create/{id}","PlantController@create");
route::post("/tanam/store","PlantController@store");
route::get("/tanam/api","PlantController@api");
route::get("/tanam/{id}","PlantController@detail");
route::get("/tanam/edit/{id}","PlantController@edit");
route::put("/tanam/update/{id}","PlantController@update");
// route::get("/tanam/kelompok-tani","PlantController@farmerGroupByVillage");
// route::get("tanam/petani/{id}","PlantController@farmerByFarmerGroup");

route::get("/panen","HarvestController@index");
route::get("/panen/api","HarvestController@api");
route::get("/panen/create/{id}","HarvestController@create");
route::get("/panen/komoditas","HarvestController@getCommodity");
route::post("/panen/store","HarvestController@store");
route::get("/panen/edit/{id}","HarvestController@edit");
route::put("/panen/update/{id}","HarvestController@update");
route::get("/panen/{id}","HarvestController@detail");

route::get("/jenis-komoditas","CommoditySectorController@index");
route::get("/jenis-komoditas/api","CommoditySectorController@api");
route::get("/jenis-komoditas/create","CommoditySectorController@create");
route::post("/jenis-komoditas/store","CommoditySectorController@store");
route::get("/jenis-komoditas/edit/{id}","CommoditySectorController@edit");
route::put("/jenis-komoditas/update/{id}","CommoditySectorController@update");
route::delete("/jenis-komoditas/delete/{id}","CommoditySectorController@delete");

route::get("/lokasi-komoditas","CommodityLocationController@index");
route::get("/lokasi-komoditas/api","CommodityLocationController@api");
route::get("/lokasi-komoditas/create","CommodityLocationController@create");
route::post("/lokasi-komoditas/store","CommodityLocationController@store");
route::get("/lokasi-komoditas/edit/{id}","CommodityLocationController@edit");
route::put("/lokasi-komoditas/update/{id}","CommodityLocationController@update");
route::delete("/lokasi-komoditas/delete/{id}","CommodityLocationController@delete");

route::get("/harga-pasar","MarketPriceController@index");
route::get("/harga-pasar/api","MarketPriceController@api");
route::get("/harga-pasar/create","MarketPriceController@create");
route::post("/harga-pasar/store","MarketPriceController@store");
route::get("/harga-pasar/edit/{id}","MarketPriceController@edit");
route::put("/harga-pasar/update/{id}","MarketPriceController@update");
route::delete("/harga-pasar/delete/{id}","MarketPriceController@delete");

route::get("/harga-petani","FarmerPriceController@index");
route::get("/harga-petani/api","FarmerPriceController@api");
route::get("/harga-petani/create","FarmerPriceController@create");
route::post("/harga-petani/store","FarmerPriceController@store");
route::get("/harga-petani/edit/{id}","FarmerPriceController@edit");
route::put("/harga-petani/update/{id}","FarmerPriceController@update");
route::delete("/harga-petani/delete/{id}","FarmerPriceController@delete");

route::get("/akun","UserController@index");
route::get("/akun/api","UserController@api");
route::get("/akun/create","UserController@create");
route::post("/akun/store","UserController@store");
route::get("/akun/edit/{id}","UserController@edit");
route::put("/akun/update/{id}","UserController@update");
route::delete("/akun/delete/{id}","UserController@delete");

route::get("/kecamatan","DistrictController@index");
route::get("/kecamatan/api","DistrictController@api");
route::get("/kecamatan/create","DistrictController@create");
route::post("/kecamatan/store","DistrictController@store");
route::get("/kecamatan/edit/{id}","DistrictController@edit");
route::put("/kecamatan/update/{id}","DistrictController@update");
route::delete("/kecamatan/delete/{id}","DistrictController@delete");

route::get("/desa","VillageController@index");
route::get("/desa/api","VillageController@api");
route::get("/desa/create","VillageController@create");
route::post("/desa/store","VillageController@store");
route::get("/desa/edit/{id}","VillageController@edit");
route::put("/desa/update/{id}","VillageController@update");
route::delete("/desa/delete/{id}","VillageController@delete");

route::get("/pengepul","CollectingTraderController@index");
route::get("/pengepul/api","CollectingTraderController@api");
route::get("/pengepul/create","CollectingTraderController@create");
route::post("/pengepul/store","CollectingTraderController@store");
route::get("/pengepul/edit/{id}","CollectingTraderController@edit");
route::put("/pengepul/update/{id}","CollectingTraderController@update");
route::delete("/pengepul/delete/{id}","CollectingTraderController@delete");

route::get("/komoditas-pengepul","CollectingTraderCommodityController@index");
route::get("/komoditas-pengepul/api","CollectingTraderCommodityController@api");
route::get("/komoditas-pengepul/create","CollectingTraderCommodityController@create");
route::post("/komoditas-pengepul/store","CollectingTraderCommodityController@store");
route::get("/komoditas-pengepul/edit/{id}","CollectingTraderCommodityController@edit");
route::put("/komoditas-pengepul/update/{id}","CollectingTraderCommodityController@update");
route::delete("/komoditas-pengepul/delete/{id}","CollectingTraderCommodityController@delete");

route::get("/komoditas-petani","FarmerCommodityController@index");
route::get("/komoditas-petani/api","FarmerCommodityController@api");
route::get("/komoditas-petani/create","FarmerCommodityController@create");
route::post("/komoditas-petani/store","FarmerCommodityController@store");
route::get("/komoditas-petani/edit/{id}","FarmerCommodityController@edit");
route::put("/komoditas-petani/update/{id}","FarmerCommodityController@update");
route::delete("/komoditas-petani/delete/{id}","FarmerCommodityController@delete");

route::get("/kelompok-tani","FarmerGroupController@index");
route::get("/kelompok-tani/api","FarmerGroupController@api");
route::get("/kelompok-tani/create","FarmerGroupController@create");
route::post("/kelompok-tani/store","FarmerGroupController@store");
route::get("/kelompok-tani/edit/{id}","FarmerGroupController@edit");
route::put("/kelompok-tani/update/{id}","FarmerGroupController@update");
route::delete("/kelompok-tani/delete/{id}","FarmerGroupController@delete");

route::get("/pendaftaran-penyuluh","InstructorController@index");
route::get("/pendaftaran-penyuluh/api","InstructorController@api");
route::get("/pendaftaran-penyuluh/create","InstructorController@create");
route::post("/pendaftaran-penyuluh/store","InstructorController@store");
route::get("/pendaftaran-penyuluh/edit/{id}","InstructorController@edit");
route::put("/pendaftaran-penyuluh/update/{id}","InstructorController@update");
route::delete("/pendaftaran-penyuluh/delete/{id}","InstructorController@delete");

route::get("/pendaftaran-petani","FarmerController@index");
route::get("/pendaftaran-petani/api","FarmerController@api");
route::get("/pendaftaran-petani/create","FarmerController@create");
route::post("/pendaftaran-petani/store","FarmerController@store");
route::get("/pendaftaran-petani/edit/{id}","FarmerController@edit");
route::put("/pendaftaran-petani/update/{id}","FarmerController@update");
route::delete("/pendaftaran-petani/delete/{id}","FarmerController@delete");

route::get("/berita","NewsController@index");
route::get("/berita/api","NewsController@api");
route::get("/berita/create","NewsController@create");
route::post("/berita/store","NewsController@store");
route::get("/berita/edit/{id}","NewsController@edit");
route::put("/berita/update/{id}","NewsController@update");
route::delete("/berita/delete/{id}","NewsController@delete");

Route::get("/log", "LogActivityController@index");
Route::get("/log/api", "LogActivityController@api");
Route::get("/log/detail/{id}", "LogActivityController@detail");