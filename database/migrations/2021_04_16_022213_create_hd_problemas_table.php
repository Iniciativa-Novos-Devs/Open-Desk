<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHdProblemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_problemas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->longText('descricao')->nullable();
            $table->unsignedBigInteger('atividade_area_id')->nullable()->index('hd_problemas_atividade_area_id_foreign');
            $table->string('versao', 10)->nullable();
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
