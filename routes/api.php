<?php

use App\Http\Controllers\ApiHelperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('get-item-by-menu', [ApiHelperController::class, 'getItemByMenu'])->name('api.getItemByMenu');
Route::get('get-item-price', [ApiHelperController::class, 'getItemPrice'])->name('api.getItemPrice');
