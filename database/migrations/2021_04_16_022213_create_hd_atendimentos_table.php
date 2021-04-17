<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHdAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_atendimentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('chamado_id')->index('hd_atendimentos_chamado_id_foreign');
            $table->unsignedBigInteger('usuario_id')->index('hd_atendimentos_usuario_id_foreign');
            $table->unsignedBigInteger('tipo_movimentacao')->nullable()->index('hd_atendimentos_tipo_movimentacao_foreign');
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
        Schema::dropIfExists('hd_atendimentos');
    }
}
