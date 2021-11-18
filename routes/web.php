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

Route::get('/', 'App\Http\Controllers\ApiController@index')->name('index');
Route::get('/rank', 'App\Http\Controllers\ApiController@rank');
//前台api
Route::post('/api/lottery', 'App\Http\Controllers\ApiController@lottery');
Route::get('/api/rate', 'App\Http\Controllers\ApiController@rate');
//登入註冊
Route::post('/api/login', 'App\Http\Controllers\ApiController@login');
Route::post('/api/signIn', 'App\Http\Controllers\ApiController@signIn');
Route::post('/api/user', 'App\Http\Controllers\ApiController@user');
Route::post('/api/logout', 'App\Http\Controllers\ApiController@logout');
//登入後功能
Route::middleware(['web'])->group(function () {
  Route::get('/history', 'App\Http\Controllers\ApiController@history');
  Route::get('/api/cards', 'App\Http\Controllers\ApiController@getCards');
  Route::get('/cards', 'App\Http\Controllers\ApiController@cards');
});