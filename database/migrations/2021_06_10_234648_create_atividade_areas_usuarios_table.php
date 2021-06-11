<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadeAreasUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_atividade_areas_usuarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('usuario_id')->unsigned();
            $table->integer('atividades_area_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_atividade_areas_usuarios');
    }
}
