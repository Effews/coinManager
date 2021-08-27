<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('coinName', 160);
            $table->string('cashType', 30); //Inicial da do dinheiro na moeda do pais (CAD, USD e afins). Não vai ser usado agora, só se eu decidir continuar o projeto depois
            $table->double('costPrice', 10, 7); //valor do dinheiro investido na moeda em BRL, USD ou o que seja
            $table->double('coinAmount', 10, 7); //quantidade de crypto moedas compradas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
}
