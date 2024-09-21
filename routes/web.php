<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('sign_in');
})->name('index');

Route::middleware('auth')->group(function () {
    Route::resource('transactions', TransactionController::class);
    Route::delete('sign-out', [AuthController::class, 'destroy'])->name('sign_out');
});

Route::middleware('guest')->group(function () {
    Route::get('sign-in', [AuthController::class, 'index'])->name('sign_in');
    Route::post('sign-in', [AuthController::class, 'login'])->name('sign_in.login');

    Route::get('sign-up', [AuthController::class, 'create'])->name('sign_up');
    Route::post('sign-up', [AuthController::class, 'store'])->name('sign_up.store');
});
