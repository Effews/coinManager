<?php

use App\Http\Controllers\{
    CoinController,
    TransactionsController
};
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group( function(){
    Route::post('/cadTransaction', [TransactionsController::class, 'createTransaction'])->name('transaction.create');
    Route::get('/main', [TransactionsController::class, 'index'])->name('transactions.index');
   
});

//colocar dentro da rota logado assim que terminar de testar
Route::get('/coinPrice/{coin}/{transacao}', [TransactionsController::class, 'getCoinPrice'])->name('transaction.getCoinPrice');

Route::get('/', function () {
    return view('commonUser.homepage');
})->middleware(['redirectLogin'])->name('homePageOff');;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';