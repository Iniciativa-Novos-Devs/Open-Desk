<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_chamado_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text('content')->nullable();
            $table->integer('type');
            $table->bigInteger('chamado_id')->index();
            $table->bigInteger('atendente_id')->nullable();
            $table->bigInteger('user_id')->nullable();
        });

        Schema::table('hd_chamado_logs', function (Blueprint $table) {
            $table->foreign(['chamado_id'])->references(['id'])->on('hd_chamados');
            $table->foreign(['atendente_id'])->references(['id'])->on('hd_usuarios');
            $table->foreign(['user_id'])->references(['id'])->on('hd_usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_chamado_logs', function (Blueprint $table) {
            $table->dropForeign('hd_chamado_logs_chamado_id_foreign');
            $table->dropForeign('hd_chamado_logs_atendente_id_foreign');
            $table->dropForeign('hd_chamado_logs_user_id_foreign');
        });

        Schema::dropIfExists('hd_chamado_logs');
    }
};
