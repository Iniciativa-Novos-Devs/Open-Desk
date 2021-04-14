<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_imagens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            /**
             * Colocar:
             * tamanho
             * extensao
             * origem (nullable) //Rota, controller etc
             * destinado_a (nullable) //perfil, chamado, etc
             * legenda (nullable)
             */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_imagens');
    }
}
