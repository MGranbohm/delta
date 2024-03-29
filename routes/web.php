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

Route::get('/', 'ChatController@index');

Route::post('/message', 'MessageController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/watson/{input}', 'WatsonApiController@getResponse');

Route::get('/testInput', 'MessageController@testInput');

Route::get('/mood', 'MoodController@check');

Route::get('/sound/{WatsonResponse}', 'SoundController@watsonSound');
