<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/home/{key}', 'HomeController@showProject');
Route::get('/developers/', 'DevelopersController@index');
Route::get('/developer/{name}', 'DevelopersController@issue')->where('name', '[A-Za-z._]+');
Route::post('/setrate', 'Ajax\AjaxController@setRate');

Route::post('/getrate', 'Ajax\AjaxDevelopersController@getRate');
Route::post('/saveparams', 'Ajax\AjaxDevelopersController@saveParams');