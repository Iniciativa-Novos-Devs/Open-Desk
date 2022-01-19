<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamadoLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_chamado_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('content')->nullable();
            $table->integer('type');
            $table->unsignedBigInteger('chamado_id');
            $table->unsignedBigInteger('atendente_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('chamado_id')->references('id')->on('hd_chamados');
            $table->foreign('atendente_id')->references('id')->on('hd_usuarios');
            $table->foreign('user_id')->references('id')->on('hd_usuarios');

            $table->index(['chamado_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_chamado_logs');
    }
}
