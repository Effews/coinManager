<?php

use App\Http\Controllers\{
    CoinsController,
    TransactionsController
};
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group( function(){
    Route::post('/cadTransaction', [TransactionsController::class, 'createTransaction'])->name('transaction.create');
    Route::get('/main', [TransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/consulta', [CoinsController::class, 'index'])->name('coins.index');
});

Route::get('/coinPrice/{transacao}', [TransactionsController::class, 'getCoinPrice'])->name('transaction.getCoinPrice');
Route::get('/priceCoin/{sgCoin}', [CoinsController::class, 'price_coin'])->name('Coins.priceCoin');
Route::get('/listCoins', [CoinsController::class, 'getCoinsToList'])->name('Coins.getCoinsToList');
Route::get('/withdrawal/{cdTransaction}', [TransactionsController::class, 'withdrawal'])->name('transaction.withdrawal');

# Route::get('/teste', [TransactionsController::class, 'coinDatabaseAppreciation'])->name('Transactions.coinDatabaseAppreciation');

Route::get('/', function () {
    return view('commonUser.homepage');
})->middleware(['redirectLogin'])->name('homePageOff');;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';