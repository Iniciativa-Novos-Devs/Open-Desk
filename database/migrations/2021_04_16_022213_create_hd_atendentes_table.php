<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHdAtendentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_atendentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('chamado_id')->index('hd_atendentes_chamado_id_foreign');
            $table->unsignedBigInteger('usuario_id')->index('hd_atendentes_usuario_id_foreign');
            $table->unsignedBigInteger('tipo_movimentacao_id')->index('hd_atendentes_tipo_movimentacao_id_foreign');
            $table->unsignedBigInteger('usuario_transferencia_id')->index('hd_atendentes_usuario_transferencia_id_foreign');
            $table->longText('observacao')->nullable();
            $table->dateTime('data_transferencia')->nullable();
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
        Schema::dropIfExists('hd_atendentes');
    }
}
