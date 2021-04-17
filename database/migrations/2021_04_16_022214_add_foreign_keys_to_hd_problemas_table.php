<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHdProblemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_problemas', function (Blueprint $table) {
            $table->foreign('atividade_area_id')->references('id')->on('hd_atividades_area')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_problemas', function (Blueprint $table) {
            $table->dropForeign('hd_problemas_atividade_area_id_foreign');
        });
    }
}
