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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/mail', [App\Http\Controllers\HomeController::class, 'sendMail'])->name('mail');


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
    //'login' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/api/v1/gettoken', [App\Http\Controllers\Api\V1\TolenController::class, 'login']);
//users routes
Route::post('/api/v1/users/me', [App\Http\Controllers\Api\V1\UsersController::class, 'getMe'])->middleware(['auth:api']);
Route::post('/api/v1/users/all', [App\Http\Controllers\Api\V1\UsersController::class, 'getAllUsers'])->middleware(['auth:api', 'scope:admin']);
Route::post('/api/v1/users/getMyUsers', [App\Http\Controllers\Api\V1\UsersController::class, 'getMyUsers'])->middleware(['auth:api', 'scope:manager']);
Route::post('/api/v1/users/createAdminUser', [App\Http\Controllers\Api\V1\UsersController::class, 'createAdmin'])->middleware(['auth:api', 'scope:admin']);
Route::post('/api/v1/users/createManager', [App\Http\Controllers\Api\V1\UsersController::class, 'createManager'])->middleware(['auth:api', 'scope:admin']);
Route::post('/api/v1/users/createUser', [App\Http\Controllers\Api\V1\UsersController::class, 'createUser'])->middleware(['auth:api']);
Route::post('/api/v1/users/updateUserByAdmin', [App\Http\Controllers\Api\V1\UsersController::class, 'updateUserByAdmin'])->middleware(['auth:api', 'scope:admin']);
Route::post('/api/v1/users/updateMyUser', [App\Http\Controllers\Api\V1\UsersController::class, 'updateMyUser'])->middleware(['auth:api', 'scope:manager']);
Route::post('/api/v1/users/updateMe', [App\Http\Controllers\Api\V1\UsersController::class, 'updateMe'])->middleware(['auth:api']);
Route::post('/api/v1/users/deleteUser', [App\Http\Controllers\Api\V1\UsersController::class, 'deleteUser'])->middleware(['auth:api']);
Route::post('/api/v1/users/updateAndActivateMe', [App\Http\Controllers\Api\V1\UsersController::class, 'updateAndActivateMe'])->middleware(['auth:api']);

Route::get('/api/v1/{id}/activateUser', [App\Http\Controllers\Api\V1\UsersController::class, 'activateUser']);
Route::get('/api/v1/{id}/deactivateUser', [App\Http\Controllers\Api\V1\UsersController::class, 'deactivateUser']);
Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'index']);

//country routes
Route::post('/api/v1/countries/create', [App\Http\Controllers\Api\V1\CountriesController::class, 'CreateCountry'])->middleware(['auth:api', 'scope:admin']);
Route::post('/api/v1/countries/all', [App\Http\Controllers\Api\V1\CountriesController::class, 'CountryAll'])->middleware(['auth:api']);
Route::post('/api/v1/countries/getCountryById', [App\Http\Controllers\Api\V1\CountriesController::class, 'GetCountryById'])->middleware(['auth:api']);
Route::post('/api/v1/countries/getCountryByName', [App\Http\Controllers\Api\V1\CountriesController::class, 'GetCountryByName'])->middleware(['auth:api']);
Route::post('/api/v1/countries/getCountryIsoCode', [App\Http\Controllers\Api\V1\CountriesController::class, 'GetCountryIsoCode'])->middleware(['auth:api']);
Route::post('/api/v1/countries/updateCountry', [App\Http\Controllers\Api\V1\CountriesController::class, 'updateCountry'])->middleware(['auth:api', 'scope:admin']);
Route::post('/api/v1/countries/deleteCountry', [App\Http\Controllers\Api\V1\CountriesController::class, 'deleteCountry'])->middleware(['auth:api', 'scope:admin']);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/company',[App\Http\Controllers\HomeController::class, 'companyPage']);
    Route::get('/company/{id}',[App\Http\Controllers\HomeController::class, 'companyShowUsers']);
});
