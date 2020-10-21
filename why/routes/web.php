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

Route::get( '/', 'StickersController@index' )->name("Home");
Route::get( '/home', 'StickersController@index' )->name("Home");
Route::get( '/pdf/{id}', 'StickersController@pdf' )->name("pdf");
Route::get( '/allpdf', 'StickersController@allpdf' )->name("allpdf");
Route::get( '/allpdfcurrent', 'StickersController@allpdfCurrent' )->name("allpdfcurrent");
Route::get( '/allpdfnext', 'StickersController@allpdfNext' )->name("allpdfnext");
Route::get( '/roadwarriar', 'RoadWarriarServiceController@index' )->name("roadwarriar");
Route::get( '/test', 'StickersController@test' );

Route::get( '/roadwarriarAll/{name}', 'RoadWarriarServiceController@routeAll' )->name("roadwarriarAll");
Route::get( '/roadwarriarCurrent/{name}', 'RoadWarriarServiceController@routeCurrent' )->name("roadwarriarCurrent");
Route::get( '/roadwarriarNext/{name}', 'RoadWarriarServiceController@routeNext' )->name("roadwarriarNext");
Route::get( '/zipcodes', 'RoadWarriarServiceController@getZip' );

Route::resource('orders', 'OrderController');
Route::post('/orders/cancellall', 'OrderController@CancelAll');
Route::post('/orders/deletelist', 'OrderController@deletelist');
Route::get('/orders/deleterecord/{id}', 'OrderController@deleteRecord');
Route::get( '/close/{id}', 'StickersController@close' );
Route::get('/ordersmail', 'OrderController@delivery_mail');
//Route::get('/closeorders', 'OrderController@CompleateAllOrder');

Route::get('/cron', 'CronController@index');
Route::post('/cron', 'CronController@index');


Route::resource('products', 'ProductsController');
Route::get( '/products/addconsist/{id}/{idconsist}/{quantity}', 'ProductsController@addConsists' );
Route::get( '/products/delete/{id}/{idconsist}', 'ProductsController@deleteConsist' );
Route::get( '/cook', 'ProductsController@allProductsToCooking' );
Route::get( '/cookcurrent', 'ProductsController@allProductsToCookingCurrent' );
Route::get( '/cooknext', 'ProductsController@allProductsToCookingNext' );
Route::get( '/cookdecomposition', 'ProductsController@allProductsToCookingWithDecomposition' );
Route::get( '/cookcurrentdecomposition', 'ProductsController@allProductsToCookingCurrentWithDecomposition' );
Route::get( '/cooknextdecomposition', 'ProductsController@allProductsToCookingNextWithDecomposition' );
Route::get( '/cookpdf/{list}', 'ProductsController@pdfList' );

Route::get('/mail', 'TelegramController@new_mail');

Route::resource('telegram', 'TelegramController');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

