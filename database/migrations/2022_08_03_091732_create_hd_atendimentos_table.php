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
        Schema::create('hd_atendimentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('chamado_id')->index();
            $table->bigInteger('usuario_id')->index();
            $table->bigInteger('tipo_movimentacao')->nullable()->index();
            $table->string('versao', 10)->nullable();
        });

        Schema::table('hd_atendimentos', function (Blueprint $table) {
            $table->foreign(['chamado_id'])->references(['id'])->on('hd_chamados')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign(['tipo_movimentacao'])->references(['id'])->on('hd_tipo_movimentacoes')->onUpdate('RESTRICT')->onDelete('SET NULL');
            $table->foreign(['usuario_id'])->references(['id'])->on('hd_usuarios')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_atendimentos', function (Blueprint $table) {
            $table->dropForeign('hd_atendimentos_chamado_id_foreign');
            $table->dropForeign('hd_atendimentos_tipo_movimentacao_foreign');
            $table->dropForeign('hd_atendimentos_usuario_id_foreign');
        });

        Schema::dropIfExists('hd_atendimentos');
    }
};
