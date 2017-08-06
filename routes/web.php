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
    return view('default');
})->name('login');

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/oauth/{provider}/{mode?}', 'Auth\LoginController@oAuth');

Route::group(['prefix' => 'api',  'middleware' => 'auth'], function() {
    Route::post('votes', 'VoteController@index');
});

Route::group(['prefix' => 'api'], function() {
    Route::get('rows', 'VoteController@rows');
});