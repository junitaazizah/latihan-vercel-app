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
    return view('welcome');
});
Route::get('/user', [App\Http\Controllers\Backend\Users\UserController::class, 'index']);
Route::get('/find-user', [App\Http\Controllers\Backend\Users\UserController::class, 'findemail'])->name('find-json');
Route::get('/find', [App\Http\Controllers\Backend\Users\UserController::class, 'find']);
