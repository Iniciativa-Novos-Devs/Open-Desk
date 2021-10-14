<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsOfHomologationToHdChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->bigInteger('homologado_por')->nullable();
            $table->datetime('homologado_em')->nullable();
            $table->integer('homologacao_avaliacao')->nullable();
            $table->longText('homologacao_observacao_fim')->nullable();
            $table->longText('homologacao_observacao_back')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->dropColumn([
                'homologado_por',
                'homologado_em',
                'homologacao_avaliacao',
                'homologacao_observacao_fim',
                'homologacao_observacao_back',
            ]);
        });
    }
}
