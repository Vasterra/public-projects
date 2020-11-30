<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\IndicatorsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ForecastsController;
use App\Http\Middleware\CheckAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/get-companies/', [CompaniesController::class, 'companies']);
Route::get('/get-search-companies/{search}', [CompaniesController::class, 'searchcompanies']);
Route::get('/home-get-table/{id}', [HomeController::class, 'gettable']);
Route::get('/home-change-table/{data}/{id}', [HomeController::class, 'changetable']);
Route::get('/home-zero-table/{id}', [HomeController::class, 'zerotable']);
Route::get('/home-create-forecast/{id}', [HomeController::class, 'createforecast']);
Route::get('/home-save-forecast/{data}/{id}', [HomeController::class, 'saveforecast']);
Route::get('/home-forecasts/{id}', [HomeController::class, 'forecasts']);
Route::get('/home-forecast/{user}/{id}', [HomeController::class, 'forecast']);
Route::get('/home-current-user/', [HomeController::class, 'currentuser']);
Route::get('/home-add-comment/{data}/{parent}/{id}', [HomeController::class, 'addcomment']);
Route::get('/home-comments/{id}', [HomeController::class, 'comments']);


// Office (user)

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

	Route::get('/office/', [OfficeController::class, 'index'])->name('office');
	Route::post('/office/update-info/', [OfficeController::class, 'updateinfo'])->name('update-personal-info');
	Route::post('/office/update/password/', [OfficeController::class, 'updatepassword'])->name('update-personal-password');
	Route::post('/office/delete/account/', [OfficeController::class, 'deleteaccount'])->name('delete-account');
	Route::get('/office/comments', [OfficeController::class, 'comments'])->name('office-comments');
	Route::get('/office/comments/edit/{id}', [OfficeController::class, 'editcomment'])->name('office-comment-edit');
	Route::post('/office/comments/update/', [OfficeController::class, 'updatecomment'])->name('office-comment-update');
	Route::post('/office/delete/comment/', [OfficeController::class, 'deletecomment'])->name('office-delete-comment');

	Route::get('/office/forecasts/', [OfficeController::class, 'forecasts'])->name('office-forecasts');
	Route::get('/office/forecasts/edit/{id}', [OfficeController::class, 'editforecasts'])->name('office-forecast-edit');
	Route::post('/office/forecasts/update/', [OfficeController::class, 'updateforecast'])->name('office-forecast-update');
	Route::get('/office-table-forecast/{company}/{user}', [OfficeController::class, 'tableforecast']);
	Route::get('/office-change-table-forecast/{data}/{company}', [OfficeController::class, 'changetable']);
	Route::get('/office-zero-table-forecast/{company}', [OfficeController::class, 'zerotable']);
	Route::get('/office-update-table-forecast/{company}', [OfficeController::class, 'updatetable']);
	Route::post('/office/delete/forecast/', [OfficeController::class, 'deleteforecast'])->name('office-delete-forecast');

});


// Admin area

Route::middleware(['auth:sanctum', 'verified', CheckAdmin::class])->group(function () {

	Route::get('/dashboard/', [DashboardController::class, 'index'])->name('dashboard');


	Route::get('/companies/', [CompaniesController::class, 'index'])->name('companies');
	Route::get('/companies/add/', [CompaniesController::class, 'add'])->name('add-company');
	Route::get('/companies/edit/{id}', [CompaniesController::class, 'add'])->name('edit-company');
	Route::post('/companies/update/', [CompaniesController::class, 'update']);
	Route::post('/companies/delete/', [CompaniesController::class, 'delete']);	
	Route::post('/add-company/save/', [CompaniesController::class, 'save']);

	Route::get('/indicators/', [IndicatorsController::class, 'index'])->name('indicators');
	Route::post('/indicators/save/', [IndicatorsController::class, 'save']);
	Route::get('/indicators/edit/{id}', [IndicatorsController::class, 'edit'])->name('edit-indicator');
	Route::post('/indicators/update/', [IndicatorsController::class, 'update']);
	Route::post('/indicators/delete/', [IndicatorsController::class, 'delete']);

	Route::get('/settings/', [SettingsController::class, 'index'])->name('settings');
	Route::post('/settings/save-order/', [SettingsController::class, 'save_order'])->name('save-order');
	Route::post('/settings/save-formulas/', [SettingsController::class, 'save_formulas'])->name('save-formulas');
	Route::post('/settings/save-years/', [SettingsController::class, 'save_years'])->name('save-years');

	Route::get('/formula/', [FormulaController::class, 'index'])->name('formula');
	Route::get('/order/', [OrderController::class, 'index'])->name('order');


	Route::get('/get-period/{id}', [CompaniesController::class, 'period']);
	Route::get('/get-addcompany-start/', [CompaniesController::class, 'addcompanystart']);
	Route::get('/get-addcompany-table/{data}', [CompaniesController::class, 'addcompanytable']);
	Route::get('/get-start-data/', [CompaniesController::class, 'startdata']);

	
	Route::get('/get-signs/', [FormulaController::class, 'signs']);
	Route::get('/get-company-indicator/{id}', [IndicatorsController::class, 'companyindicators']);
	Route::get('/get-formula/{company}', [FormulaController::class, 'formula']);
	Route::get('/get-paste-data/{company}/{formula}/{data}', [FormulaController::class, 'pastedata']);
	Route::get('/delete-item/{company}/{formula}', [FormulaController::class, 'deleteitem']);
	Route::get('/get-names/{company}', [FormulaController::class, 'names']);
	Route::get('/set-name/{company}/{formula}/{name}', [FormulaController::class, 'setname']);
	Route::get('/set-percent/{company}/{data}', [FormulaController::class, 'setpercent']);
	Route::get('/get-percent/{company}', [FormulaController::class, 'percent']);

	Route::get('/get-order-data/{company}', [OrderController::class, 'orderdata']);
	Route::get('/order-save/{company}/{data}', [OrderController::class, 'ordersave']);	

	Route::get('/users/', [UsersController::class, 'index'])->name('users');	
	Route::get('/users/profile/{user}', [UsersController::class, 'userprofile'])->name('userprofile');	
	Route::post('/users/delete-user/', [UsersController::class, 'deleteuser'])->name('user-delete-account');
	Route::get('/users/comments/{user}', [UsersController::class, 'usercomments'])->name('usercomments');	
	Route::get('/users/comment/{id}/{user}', [UsersController::class, 'usercomment'])->name('usercomment');	
	Route::post('/users/delete-comment/', [UsersController::class, 'deletecomment'])->name('user-delete-comment');
	Route::get('/users/forecasts/{user}', [UsersController::class, 'userforecasts'])->name('userforecasts');	
	Route::get('/users/forecast/{id}/{user}', [UsersController::class, 'userforecast'])->name('userforecast');	
	Route::post('/users/delete-forecast/', [UsersController::class, 'deleteforecast'])->name('user-delete-forecast');

	Route::get('/comments/', [CommentsController::class, 'index'])->name('comments');
	Route::get('/accept-comment/{id}', [CommentsController::class, 'acceptcomment']);

	Route::get('/forecasts/', [ForecastsController::class, 'index'])->name('forecasts');
	Route::get('/accept-forecast/{id}', [ForecastsController::class, 'acceptforecast']);
	


});
