<?php

use App\Controllers\ClientController;
use App\Controllers\HomeController;
use App\Routes\Route;

Route::get('', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/client', 'ClientController@index');