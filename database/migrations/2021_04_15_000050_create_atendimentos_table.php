<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_atendimentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->bigInteger('chamado_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('tipo_movimentacao')->unsigned()->nullable();

            $table->foreign('chamado_id')->references('id')->on('hd_chamados')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('hd_usuarios')->onDelete('cascade');
            $table->foreign('tipo_movimentacao')->references('id')->on('hd_tipo_movimentacoes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_atendimentos');
    }
}
