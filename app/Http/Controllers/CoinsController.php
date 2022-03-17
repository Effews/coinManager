<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TransactionsController as ControllersTransactionsController;
use App\Models\Coin;
use App\Models\Fiat;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Type\Decimal;

class CoinsController extends Controller
{
    public function index()
    {
        $coins = Coin::get();

        return view('commonUser.consultCripto', compact('coins'));
    }

    function getCoinsToList(){
        $binanceAllCoins = Http::get("https://api.binance.com/api/v3/ticker/price");
        $binanceAllCoins = json_decode($binanceAllCoins, true);
       
        $BRLCoinsWithBlackListedCoins = $this->getBRLCoins($binanceAllCoins);
        $BRLCoinsWithoutBlackListedCoins = $this->blackList($BRLCoinsWithBlackListedCoins);
        $BRLCoins = $this->removeFiatIdentifier($BRLCoinsWithoutBlackListedCoins);
        $this->verifyCoinsToAddToDatabase($BRLCoins);

        return $BRLCoins;
    }

    function getBRLCoins($coinsList){
        $iterator = 0;

        foreach ($coinsList as $coinsName){

            $brlCoins = strpos($coinsName['symbol'], "BRL");

            if($brlCoins == true){
                $coins[$iterator] = $coinsName['symbol'];
                $iterator = $iterator + 1;
            }
        }

        return $coins; 
    }

    function blackList($brlCoinsList){
        $iterator2 = 0;
        $blackList = array ("BTTBRL", "HOTBRL", "ETCBRL", "CAKEBRL", "AAVEBRL");

        foreach ($brlCoinsList as $searchDescontinuedCoins){
            foreach ( $blackList as $key => $value ) { 
                if($searchDescontinuedCoins == $value){
                    unset($brlCoinsList[$iterator2]);   
                }
            }

            $iterator2 = $iterator2 + 1;
        }
        
        $coins = array_values($brlCoinsList);
        return $coins;
    }

    function removeFiatIdentifier($brlCoinsList){

        $coins = array();
        $iterator3 = 0;

        foreach($brlCoinsList as $coinsList){
            $coins[$iterator3] = substr($coinsList, 0, -3);

            $iterator3 = $iterator3 + 1;
        }

        return $coins;
    }

    function verifyCoinsToAddToDatabase($coinsList){

        $registredCoins = DB::table('coins')
        ->select('sg_coin')
        ->get();

        $registredCoins =  json_decode($registredCoins, true);

        foreach($registredCoins as $coin){
            $key = array_search($coin['sg_coin'], $coinsList );

            if($key!==false){
                unset($coinsList[$key]);
            }
        }
        
        $coinsList = array_values($coinsList);

        foreach($coinsList as $registerCoins){
            Coin::create([
                'sg_coin' => $registerCoins
            ]);
        }
    }

    function price_coin($sgCoin){
        $binanceValueReturn = Http::get("https://api.binance.com/api/v3/ticker/price?symbol=".$sgCoin."BRL");
        $binanceValueReturn = json_decode($binanceValueReturn, true);
        $binanceValueReturn = $binanceValueReturn['price'];

        return $binanceValueReturn;
    }
}