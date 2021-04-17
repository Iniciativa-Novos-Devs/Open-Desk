<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHdAtividadesAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_atividades_area', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('hd_areas')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_atividades_area', function (Blueprint $table) {
            $table->dropForeign('hd_atividades_area_area_id_foreign');
        });
    }
}
