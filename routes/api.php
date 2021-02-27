<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;
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
        Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
        Route::get('/user', 'App\Http\Controllers\AuthController@user');
    });
});

Route::group([
    'prefix' => 'users'
], function () {
    Route::group([
        'middleware' =>  ['auth:api', 'check.admin']
    ], function () {
        Route::post('/new', 'App\Http\Controllers\UsersController@addUser');
        Route::get('/', 'App\Http\Controllers\UsersController@getUsers');
    });
});

Route::get('/customers', function (Request $request) {
    $csvFile = Storage::get('2000_records_missing_data.csv');
    $file_handle = preg_split('/[\n]/', $csvFile);
    $headers = str_getcsv($file_handle[0], ";");
    unset($file_handle[0]);
    $line_of_text = [];
    foreach ($file_handle as $line) {
        $csv_line = str_getcsv($line, ";");
        $customer = [];
        for ($i = 0; $i < count($csv_line); $i++) {
            $customer[$headers[$i]] = $csv_line[$i];
        }
        $customer['status'] = "invalidated";
        $new_customer = Customer::create($customer);
        $line_of_text[] = $new_customer;
    }
    return response()->json([
        'ok' => true,
        "data" => $line_of_text,
        "headers" => $headers,
    ], 200);
});
