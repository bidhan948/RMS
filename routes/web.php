<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('menu', MenuController::class)->only('index', 'store', 'update');
    Route::resource('table', TableController::class)->only('index', 'store', 'update');
    Route::resource('order', OrderController::class);
    Route::get('order/proceed-to-payment/{token}', [OrderController::class,'proceedToPayment'])->name('order.proceedPayment');
    Route::get('order/edit-table/{token}', [OrderController::class,'editTable'])->name('order.editTable');
    Route::PUT('order/edit-table/{token}', [OrderController::class,'editTableSubmit'])->name('order.update_table');
    Route::get('order-history', [OrderController::class,'orderHistory'])->name('order.history');
    Route::post('item/report',[ItemController::class,'itemReport'])->name('item.report'); 
    Route::post('order/report',[OrderController::class,'orderReport'])->name('order.report'); 
    Route::post('order-history/report',[OrderController::class,'historyReport'])->name('order.historyReport'); 
    Route::post('order/proceed-to-payment/{token}',[OrderController::class,'proceedPaymentSubmit'])->name('order.proceedPaymentSubmit'); 
    Route::get('order/print-bill/{token}',[OrderController::class,'printBill'])->name('order.printBill'); 
    Route::resource('item', ItemController::class)->only('index', 'store', 'update','edit');
    Route::resource('discount', DiscountController::class)->only('index', 'store', 'update','edit');
});
