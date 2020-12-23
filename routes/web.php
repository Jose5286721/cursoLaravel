<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
Route::get('/home','HomeController@index');
Route::resource('files','FileController');
Route::get('/payment/pay','PaypalController@pay')->name('pay');
Route::get('/payment/approval','PaypalController@approvalTransaction')->name('approbal');
Route::get('/payment/cancelled','PaypalController@cancelledTransaction')->name('cancelled');