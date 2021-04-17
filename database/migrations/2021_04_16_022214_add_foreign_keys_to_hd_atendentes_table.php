<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHdAtendentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_atendentes', function (Blueprint $table) {
            $table->foreign('chamado_id')->references('id')->on('hd_chamados')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('tipo_movimentacao_id')->references('id')->on('hd_tipo_movimentacoes')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('usuario_id')->references('id')->on('hd_usuarios')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('usuario_transferencia_id')->references('id')->on('hd_usuarios')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_atendentes', function (Blueprint $table) {
            $table->dropForeign('hd_atendentes_chamado_id_foreign');
            $table->dropForeign('hd_atendentes_tipo_movimentacao_id_foreign');
            $table->dropForeign('hd_atendentes_usuario_id_foreign');
            $table->dropForeign('hd_atendentes_usuario_transferencia_id_foreign');
        });
    }
}
