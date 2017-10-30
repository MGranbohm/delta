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
    Route::get('messages/{id}', 'MessageController@getMessage');
    Route::get('responses/{id}', 'MessageController@getResponse');
    Route::post('message', 'MessageController@postMessage');
    Route::delete('messages/{id}', 'MessageController@deleteMessage');
    Route::get('/sound/{id}', 'SoundController@watsonSound');




