<?php
include('controllers/HomeController.php');
include('routes/Route.php');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');