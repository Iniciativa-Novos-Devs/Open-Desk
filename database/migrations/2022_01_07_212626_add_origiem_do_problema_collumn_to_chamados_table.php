<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrigiemDoProblemaCollumnToChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->integer('origem_do_problema')->nullable();
            $table->index('origem_do_problema');
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
            $table->dropColumn('origem_do_problema');
        });
    }
}
