<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_anexos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('path');
            $table->string('extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->json('restrito_a_grupos')->nullable();   // Caso o anexo se restrinja à algum grupo/tipo de usuário (array de IDs)
            $table->json('restrito_a_usuarios')->nullable(); // Caso o anexo se restrinja à algum usuário (array de IDs)
            $table->boolean('temporario')->nullable()->default(false); // Caso o anexo seja temporário
            $table->timestamp('destruir_apos')->nullable(); // Caso seja um anexo temporário ele deve ser excluído após a data especificada
            $table->bigInteger('created_by_id')->nullable(); // Quem criou o anexo (id na tabela hd_usuarios)
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
}
