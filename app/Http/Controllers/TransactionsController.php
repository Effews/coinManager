<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CoinsController;
use App\Models\Coin;
use App\Models\Fiat;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Type\Decimal;

class TransactionsController extends Controller
{
    public function index()
    {

        $coinsAppreciation = $this->coinDatabaseAppreciation();
        $listCoins = (new CoinsController)->getCoinsToList();
        $coins = Coin::get();
        $fiats = Fiat::get();

        return view('commonUser.index', compact('coins', 'fiats', 'listCoins', 'coinsAppreciation'));
    }

    function getCoinPrice($cdtransacao){
  
        $valorizacaoPercent = 0;
        $coins = DB::table('transactions')
            ->join('coins', 'transactions.coin_cd_coin', '=', 'coins.cd_coin')
            ->select('transactions.vl_fiat', 'transactions.qtd_virtual_coin', 'coins.sg_coin')
            ->where('withdrawal', 1)
            ->where('cd_transacao', '=', $cdtransacao)
            ->get();

        $qtdMoedas = $coins[0]->qtd_virtual_coin;
        $sgCoin = $coins[0]->sg_coin;


        $valorUnitario =  $coins[0]->vl_fiat / $qtdMoedas;
       
        $binanceValueReturn = Http::get("https://api.binance.com/api/v3/ticker/price?symbol=".$sgCoin."BRL");
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
        $pegaValor['codTransac'] = $cdtransacao;
        $pegaValor['sgCoin'] = $sgCoin;
        $pegaValor['qtdVirtualCoin'] = $qtdMoedas; 
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
            'withdrawal' => 1,
            'coin_cd_coin' => $request->coinType,
            'fiat_cd_fiat' => 1,
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

    public function coinDatabaseAppreciation(){
        $calculos = [];
        $userId = (auth()->id());

        $transacoes = DB::table('transactions')
            ->join('coins', 'transactions.coin_cd_coin', '=', 'coins.cd_coin' )
            ->where('users_id', '=', $userId )
            ->where('withdrawal', '=', 1 )
            ->orderBy('cd_transacao','desc')
            ->paginate(8);

        $transacoes = (object)($transacoes);
        $iteratorAppreciation = 0;

   
        foreach ($transacoes as $transacao){
            $transacoes[$iteratorAppreciation] = $this->getCoinPrice($transacoes[$iteratorAppreciation]->cd_transacao);
            echo "<script>console.log('Debug Objects: " . $iteratorAppreciation . "' );</script>";
            $iteratorAppreciation = $iteratorAppreciation + 1;
        }
    
        return $transacoes;
    }

    public function paginate($items, $perPage = 4, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
    }

    public function withdrawal($transactionID){
        
        $transacoes = DB::table('transactions')
        ->where('cd_transacao', $transactionID)
        ->update(['withdrawal' => '0']);

        return redirect()->route('transactions.index');
    }
}
