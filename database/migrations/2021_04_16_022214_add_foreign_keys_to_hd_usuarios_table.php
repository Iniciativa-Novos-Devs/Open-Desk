<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHdUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_usuarios', function (Blueprint $table) {
            $table->foreign('ue')->references('ue')->on('hd_unidades')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
            $table->dropForeign('hd_usuarios_ue_foreign');
        });
    }
}
