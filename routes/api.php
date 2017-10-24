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
    Route::get('messages/{message}', 'MessageController@getMessage');
    Route::post('message', 'MessageController@postMessage');
    Route::delete('messages/{message}', 'MessageController@deleteMessage');
    Route::patch('messages/{message}', 'MessageController@update');
    Route::get('/sound/{WatsonResponse}', 'SoundController@watsonSound');

    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');



