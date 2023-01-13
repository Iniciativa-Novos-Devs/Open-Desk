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
        Schema::create('hd_homologacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->smallInteger('resolvido')->default(0);
            $table->integer('nota')->nullable();
            $table->bigInteger('chamado_id')->index();
            $table->string('versao', 10)->nullable();
        });

        Schema::table('hd_homologacoes', function (Blueprint $table) {
            $table->foreign(['chamado_id'])->references(['id'])->on('hd_chamados')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_homologacoes', function (Blueprint $table) {
            $table->dropForeign('hd_homologacoes_chamado_id_foreign');
        });

        Schema::dropIfExists('hd_homologacoes');
    }
};
