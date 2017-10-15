<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('messages/all','MessageController@allMessages');
Route::get('responses/all','MessageController@allResponses');
Route::get('response/{message}','MessageController@getResponse');
Route::post('message', 'MessageController@postMessage');
Route::delete('message/{message}', 'MessageController@deleteMessage');
Route::put('message/update/{message}', 'MessageController@update');

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

