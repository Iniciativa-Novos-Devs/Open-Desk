<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHdChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_chamados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('tipo_problema_id')->index('hd_chamados_tipo_problema_id_foreign')->nullable();
            $table->unsignedBigInteger('problema_id')->index('hd_chamados_problema_id_foreign');
            $table->unsignedBigInteger('usuario_id')->index('hd_chamados_usuario_id_foreign');
            $table->json('anexos')->nullable();
            $table->unsignedBigInteger('status')->index('hd_chamados_status');
            $table->longText('observacao');
            $table->string('versao', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_chamados');
    }
}
