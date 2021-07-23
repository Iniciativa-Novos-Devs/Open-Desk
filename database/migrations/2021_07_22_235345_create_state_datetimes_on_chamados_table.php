<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateDatetimesOnChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->datetime('paused_at')->nullable();
            $table->datetime('finished_at')->nullable();
            $table->datetime('transferred_at')->nullable();
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
            $table->dropColumn(['paused_at', 'finished_at', 'transferred_at']);
        });
    }
}
