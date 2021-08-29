<?php

use App\Http\Controllers\{
    CoinController,
    TransactionsController
};
use Illuminate\Support\Facades\Route;


//Route::get('/', [CoinController::class, 'index']);

Route::post('/', [TransactionsController::class, 'createTransaction'])->name('transaction.create');
Route::get('/', [TransactionsController::class, 'index'])->name('transactions.index');

//Route::get('/', function () {
//  return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';