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

Route::get('/', function () {
    return view('ifsc_codes/index');
});

Route::resource('ifsc_codes','App\Http\Controllers\IfscCodeController');
Route::post('ifsc_codes\datatable','App\Http\Controllers\IfscCodeController@DataTable')->name('ifsc_codes.datatable');
Route::post('check_ifsc','App\Http\Controllers\IfscCodeController@check_ifsc')->name('check_ifsc');