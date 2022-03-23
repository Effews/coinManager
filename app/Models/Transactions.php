<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    
    protected $fillable  = ['vl_fiat', 'qtd_virtual_coin', 'withdrawal', 'fiat_cd_fiat', 'coin_cd_coin', 'users_id'];

}
