<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Fiat;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionsController extends Controller
{
    public function index()
    {
        $transacoes = DB::table('transactions')
            ->join('coins', 'transactions.coin_cd_coin', '=', 'coins.cd_coin' )->get();

        $coins = Coin::get();
        $fiats = Fiat::get();
 
        return view('commonUser.index', compact('transacoes','coins', 'fiats'));
    }

    function getCoinPrice($coin, $cdTransacao){
  
        $valorizacaoPercent = 0;
        $coins = DB::table('transactions')
            ->select('vl_fiat', 'qtd_virtual_coin')->get(); //tem que colocar where aqui com o cd da transacao

        $qtdMoedas = $coins[0]->qtd_virtual_coin;
        $valorUnitario =  $coins[0]->vl_fiat / $qtdMoedas;
       
            
        $binanceValueReturn = Http::get("https://api.binance.com/api/v3/ticker/price?symbol=".$coin."BRL");
        $binanceValueReturn = json_decode($binanceValueReturn, true);
        $binanceValueReturn = $binanceValueReturn['price'];

        
        //Valorizacao conta
            //Percent
        
        $valorizacaoPercent = (($binanceValueReturn - $valorUnitario) / $valorUnitario) * 100;
        $valorizacaoFiat = ($binanceValueReturn * $qtdMoedas) - ($valorUnitario * $qtdMoedas);
        $valorizacaoUnitaria = $binanceValueReturn - $valorUnitario;
           
        //fim valozaricao conta

        $pegaValor['success'] = true; 
        $pegaValor['valorMoeda'] = $binanceValueReturn;
        $pegaValor['percentValorizacao'] = $valorizacaoPercent;
        $pegaValor['fiatValorUn'] = $valorUnitario;
        $pegaValor['fiatValorizacao'] = $valorizacaoFiat;
        $pegaValor['valorizacaoUnitaria'] = $valorizacaoUnitaria;
  

        
        return (object)$pegaValor;
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

        $this->atualizaIndexAjax($userId);
     
    }

    public function atualizaIndexAjax($userId){
        
        $dados[] = DB::table('transactions')
        ->join('coins', 'transactions.coin_cd_coin', '=', 'coins.cd_coin' )
        ->where('users_id', '=',$userId )
        ->orderBy('cd_transacao','desc')
        ->first();

        $cdTransacao = $dados[0]->cd_transacao;
        $coin = $dados[0]->sg_coin;

        $valorizacao = $this->getCoinPrice($coin, $cdTransacao);

        $criaTransacao['success'] = true; 
        $criaTransacao['retorno'] = $dados;
        $criaTransacao['valorizacao'] = $valorizacao;
        

        echo json_encode($criaTransacao);
    }
}
