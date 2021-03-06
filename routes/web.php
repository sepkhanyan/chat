<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/users', 'ChatController@getUsersList');
	Route::get('/chat/{id}', 'ChatController@getChat');
	Route::post('/send/message', 'ChatController@sendMessage');
	Route::post('/send/email', 'ChatController@sendEmail');
});
