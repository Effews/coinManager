<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Fiat;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        $userId = (auth()->id());

        $transacoes = Transactions::where('users_id', $userId)->get();
        $coins = Coin::get();
        $fiats = Fiat::get();
        
        return view('commonUser.index', compact('transacoes','coins', 'fiats'));
    }

    public function createTransaction(Request $request)
    {
        $userId = (auth()->id());

        Transactions::create([
            'vl_fiat' => $request->valorFiat,
            'qtd_virtual_coin' => $request->qtdVirtualCoin,
            'coin_cd_coin' => $request->coinType,
            'fiat_cd_fiat' => $request->fiatType,
            'users_id' => $userId
        ]);

        $dados = Transactions::where('users_id', $userId)->get();

        $criaTransacao['success'] = true; 
        $criaTransacao['retorno'] = $dados;

        echo json_encode($criaTransacao);
        //return redirect()->route('transactions.index');
    }
}
