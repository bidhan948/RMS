<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('menu', MenuController::class)->only('index', 'store', 'update');
    Route::resource('item', ItemController::class)->only('index', 'store', 'update');
});
