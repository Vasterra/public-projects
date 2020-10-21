<?php

use Illuminate\Support\Facades\Route;


Route::get( '/', "indexController@index" )->name( 'index' );
Route::resource( 'animal', 'AnimalController' );
Route::resource( 'animal_view', 'AnimalViewController' );
Route::resource( 'animal_category', 'AnimalCategoryController' );
Auth::routes();
Route::get( '/home', 'HomeController@index' )->name( 'home' );
