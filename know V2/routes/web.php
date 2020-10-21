<?php

use Illuminate\Support\Facades\Route;

Route::resource( '/', 'indexController' );

Route::resource( 'block_type', 'BlockTypeController' );
Route::resource( 'block_category', 'BlockCategoryController' );
Route::resource( 'template_category', 'TemplateCategoryController' );
Route::resource( 'block', 'BlockController' );

Route::get('templates/{param1}', 'TemplatesController@show');
Route::resource( 'templates', 'TemplatesController' )->middleware('auth');
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

