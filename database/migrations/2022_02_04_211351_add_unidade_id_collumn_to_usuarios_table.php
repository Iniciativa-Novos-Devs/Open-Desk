<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnidadeIdCollumnToUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_usuarios', function (Blueprint $table) {
            $table->integer('unidade_id')->nullable();

            $table->index(['unidade_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_usuarios', function (Blueprint $table) {
            $table->dropColumn(['unidade_id']);
        });
    }
}
