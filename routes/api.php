<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::post('/signup', 'App\Http\Controllers\AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/addUser', 'App\Http\Controllers\AuthController@addUser');
        Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
        Route::get('/user', 'App\Http\Controllers\AuthController@user');
    });
});

Route::group([
    'prefix' => 'users'
], function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::post('/signup', 'App\Http\Controllers\AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/getUsers', 'App\Http\Controllers\AuthController@addUser');
        Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
        Route::get('/user', 'App\Http\Controllers\AuthController@user');
    });
});
