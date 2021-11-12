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

Route::get('/', 'App\Http\Controllers\ApiController@index');
Route::get('/test', 'App\Http\Controllers\ApiController@test');
//前台api
Route::post('/api/lottery', 'App\Http\Controllers\ApiController@lottery');
Route::get('/api/rate', 'App\Http\Controllers\ApiController@rate');
