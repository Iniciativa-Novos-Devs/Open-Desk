<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_problemas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->longText('descricao')->nullable();
            $table->bigInteger('atividade_area_id')->unsigned();

            $table->foreign('atividade_area_id')->references('id')->on('hd_atividades_area')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_problemas');
    }
}
