<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHdAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_atendimentos', function (Blueprint $table) {
            $table->foreign('chamado_id')->references('id')->on('hd_chamados')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('tipo_movimentacao')->references('id')->on('hd_tipo_movimentacoes')->onUpdate('RESTRICT')->onDelete('SET NULL');
            $table->foreign('usuario_id')->references('id')->on('hd_usuarios')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_atendimentos', function (Blueprint $table) {
            $table->dropForeign('hd_atendimentos_chamado_id_foreign');
            $table->dropForeign('hd_atendimentos_tipo_movimentacao_foreign');
            $table->dropForeign('hd_atendimentos_usuario_id_foreign');
        });
    }
}
