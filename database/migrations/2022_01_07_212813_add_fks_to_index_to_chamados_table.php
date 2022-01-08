<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFksToIndexToChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->index([
                'problema_id',
                'usuario_id',
                'atendente_id',
                'unidade_id',
            ]);
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
            $table->dropIndex([
                'problema_id',
                'usuario_id',
                'atendente_id',
                'unidade_id',
            ]);
        });
    }
}
