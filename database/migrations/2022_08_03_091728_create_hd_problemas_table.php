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
        Schema::create('hd_problemas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text('descricao')->nullable();
            $table->bigInteger('atividade_area_id')->nullable()->index();
            $table->string('versao', 10)->nullable();
        });

        Schema::table('hd_problemas', function (Blueprint $table) {
            $table->foreign(['atividade_area_id'])->references(['id'])->on('hd_atividades_area')->onUpdate('RESTRICT')->onDelete('CASCADE');
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

        Schema::dropIfExists('hd_problemas');
    }
};
