<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHdChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('hd_areas')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('problema_id')->references('id')->on('hd_problemas')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('tipo_problema_id')->references('id')->on('hd_tipo_problemas')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->dropForeign('hd_chamados_area_id_foreign');
            $table->dropForeign('hd_chamados_problema_id_foreign');
            $table->dropForeign('hd_chamados_tipo_problema_id_foreign');
            $table->dropForeign('hd_chamados_usuario_id_foreign');
        });
    }
}
