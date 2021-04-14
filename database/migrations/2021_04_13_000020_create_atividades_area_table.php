<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadesAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_atividades_area', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('nome')->nullable();
            $table->bigInteger('area_id')->unsigned();

            $table->foreign('area_id')->references('id')->on('hd_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_atividades_area');
    }
}
