<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHdHomologacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_homologacoes', function (Blueprint $table) {
            $table->foreign('chamado_id')->references('id')->on('hd_chamados')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_homologacoes', function (Blueprint $table) {
            $table->dropForeign('hd_homologacoes_chamado_id_foreign');
        });
    }
}
