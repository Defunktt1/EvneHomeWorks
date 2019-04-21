<?php

namespace application;

use application\core\Route;
include 'application/core/Route.php';
Route::get('/', 'MainController@index');

Route::get('/hw1/', 'HomeWork1@index');
Route::get('/hw1/search/', 'HomeWork1@get');
Route::get('/hw1/search/updated/', 'HomeWork1@updated');
Route::get('/hw1/search/getall/', 'HomeWork1@getAll');

Route::get('/hw3/', 'HomeWork3@index');
Route::get('/hw3/scanoropen/', 'HomeWork3@scanNewDirOrOpenFile');
Route::get('/hw3/back/', 'HomeWork3@clickBack');
Route::get('/hw3/save/', 'HomeWork3@saveChanges');

Route::get('/hw4/', 'HomeWork4@index');

Route::get('/analyzer/', 'HomeWork5@index');
Route::get('/analyz-text/', 'HomeWork5@textAnalyz');

Route::abort();