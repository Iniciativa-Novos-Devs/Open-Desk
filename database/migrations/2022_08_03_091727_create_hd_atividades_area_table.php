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
        Schema::create('hd_atividades_area', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nome')->nullable();
            $table->bigInteger('area_id')->nullable()->index();
            $table->string('versao', 10)->nullable();
        });

        Schema::table('hd_atividades_area', function (Blueprint $table) {
            $table->foreign(['area_id'])->references(['id'])->on('hd_areas')->onUpdate('RESTRICT')->onDelete('CASCADE');
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

        Schema::dropIfExists('hd_atividades_area');
    }
};
