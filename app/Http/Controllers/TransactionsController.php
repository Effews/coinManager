<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CoinsController;
use App\Models\Coin;
use App\Models\Fiat;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Type\Decimal;

class TransactionsController extends Controller
{
    public function index()
    {

        $userId = (auth()->id());

        $transacoes = DB::table('transactions')
            ->join('coins', 'transactions.coin_cd_coin', '=', 'coins.cd_coin' )
            ->where('users_id', '=',$userId )
            ->orderBy('cd_transacao','desc')
            ->get();

        $listCoins = (new CoinsController)->getCoinsToList();
        $coins = Coin::get();
        $fiats = Fiat::get();

        return view('commonUser.index', compact('transacoes','coins', 'fiats', 'listCoins'));
    }


    function getCoinPrice($cdtransacao){
  
        $valorizacaoPercent = 0;
        $coins = DB::table('transactions')
            ->join('coins', 'transactions.coin_cd_coin', '=', 'coins.cd_coin')
            ->select('transactions.vl_fiat', 'transactions.qtd_virtual_coin', 'coins.sg_coin')
            ->where('cd_transacao', '=', $cdtransacao)
            ->get();

        $qtdMoedas = $coins[0]->qtd_virtual_coin;
        $coin = $coins[0]->sg_coin;


        $valorUnitario =  $coins[0]->vl_fiat / $qtdMoedas;
       
            
        $binanceValueReturn = Http::get("https://api.binance.com/api/v3/ticker/price?symbol=".$coin."BRL");
        $binanceValueReturn = json_decode($binanceValueReturn, true);
        $binanceValueReturn = $binanceValueReturn['price'];

        
        //Valorizacao conta
        $valorizacaoPercent = number_format((($binanceValueReturn - $valorUnitario) / $valorUnitario) * 100 , 2);
        $valorizacaoFiat = number_format(($binanceValueReturn * $qtdMoedas),2);
        $valorizacaoUnitaria = number_format($binanceValueReturn - $valorUnitario,2);
        $valorInvestido = number_format($coins[0]->vl_fiat,2);
        $valorUnitario = number_format($valorUnitario, 2);
        //fim valozaricao conta

        $pegaValor['success'] = true; 
        $pegaValor['valorMoeda'] = $binanceValueReturn;
        $pegaValor['percentValorizacao'] = $valorizacaoPercent;
        $pegaValor['fiatValorUn'] = $valorUnitario;
        $pegaValor['fiatValorizacao'] = $valorizacaoFiat;
        $pegaValor['valorizacaoUnitaria'] = $valorizacaoUnitaria;
        $pegaValor['valorInvestido'] = $valorInvestido;

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

        $valorizacao = $this->getCoinPrice($cdTransacao);

        $criaTransacao['success'] = true; 
        $criaTransacao['retorno'] = $dados;
        $criaTransacao['valorizacao'] = $valorizacao;
        
        echo json_encode($criaTransacao);
    }

    public function tests(){

        $userId = (auth()->id());

        $transacoes = DB::table('transactions')
        ->get();
        $transacoes = json_decode($transacoes, true);

        $iteratorr = 0;

        foreach ($transacoes as $coinsName){
            $coins[$iteratorr] = $coinsName['cd_transacao'];
            $iteratorr = $iteratorr + 1;
        }

        return $coins;
    }
}
