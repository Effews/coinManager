<?php

use App\Http\Controllers\{
    CoinController,
    TransactionsController
};
use Illuminate\Support\Facades\Route;

Route::post('/cadTransaction', [TransactionsController::class, 'createTransaction'])->name('transaction.create');
Route::get('/main', [TransactionsController::class, 'index'])->name('transactions.index');

Route::get('/', function () {
    return view('commonUser.teste');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';