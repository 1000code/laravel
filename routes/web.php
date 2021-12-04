<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', [adminController::class, 'admin'])->name('admin')->middleware('status');
});

Auth::routes();
