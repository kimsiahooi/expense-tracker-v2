<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('transactions.index');
})->name('index');

Route::resource('transactions', TransactionController::class)->except(['edit', 'create', 'show']);

Route::get('sign-up', [AuthController::class, 'create'])->name('sign_up');
Route::post('sign-up', [AuthController::class, 'store'])->name('sign_up.store');

Route::get('sign-in', [AuthController::class, 'index'])->name('sign_in');
Route::post('sign-in', [AuthController::class, 'login'])->name('sign_in.login');
