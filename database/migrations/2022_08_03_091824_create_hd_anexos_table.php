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
        Schema::create('hd_anexos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('path');
            $table->string('extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->json('restrito_a_grupos')->nullable();
            $table->json('restrito_a_usuarios')->nullable();
            $table->boolean('temporario')->nullable()->default(false);
            $table->timestamp('destruir_apos')->nullable();
            $table->bigInteger('created_by_id')->nullable();
            $table->string('name')->nullable();
            $table->string('size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hd_anexos');
    }
};
