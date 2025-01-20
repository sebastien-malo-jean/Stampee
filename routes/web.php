<?php
use App\Controllers\HomeController;
use App\Routes\Route;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');