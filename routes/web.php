<?php

use App\Routes\Route;

/*---  ---*/
/*--- Test ---*/
Route::get('', 'HomeController@index');
Route::get('/home', 'HomeController@index');
/*--- client ---*/
Route::get('/client', 'ClientController@index');
Route::get('/client/show', 'ClientController@show');
Route::get('/client/create', 'ClientController@create');
Route::post('/client/create', 'ClientController@store');
Route::get('/client/edit', 'ClientController@edit');
Route::post('/client/edit', 'ClientController@update');
Route::post('/client/delete', 'ClientController@delete');

Route::get('/user/create', 'UserController@create');
Route::post('/user/create', 'UserController@store');

Route::get('/login', 'AuthController@index');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');
Route::get('/reset_password', 'AuthController@resetPassword');
Route::post('/reset_password', 'AuthController@resetPasswordStore');

Route::get('/stamp/create', 'StampController@create');
Route::post('/stamp/create', 'StampController@store');
Route::get('/stamp/show', 'StampController@show');
Route::get('/stamp/edit', 'StampController@edit');
Route::post('/stamp/edit', 'StampController@update');
Route::post('/stamp/delete', 'StampController@delete');