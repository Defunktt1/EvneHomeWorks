<?php

namespace application;

use application\core\Route;
include 'application/core/Route.php';

Route::get('php/', 'TextController@index');
Route::get('', 'HomeController@index');
Route::get('php/search/', 'TextController@get');

Route::abort();