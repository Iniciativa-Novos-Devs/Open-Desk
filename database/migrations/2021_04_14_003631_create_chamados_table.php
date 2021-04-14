<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_chamados', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->bigInteger('tipo_problema_id')->unsigned();
            $table->bigInteger('area_id')->unsigned();
            $table->bigInteger('problema_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('imagem_id')->unsigned()->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();

            $table->longText('observacao')->nullable();

            $table->foreign('tipo_problema_id')->references('id')->on('hd_tipo_problemas')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('hd_areas')->onDelete('cascade');
            $table->foreign('problema_id')->references('id')->on('hd_problemas')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('hd_usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_chamados');
    }
}
