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
        Schema::create('hd_chamados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('tipo_problema_id')->nullable()->index();
            $table->bigInteger('problema_id')->index();
            $table->bigInteger('usuario_id')->index();
            $table->json('anexos')->nullable();
            $table->bigInteger('status')->index();
            $table->text('observacao');
            $table->string('versao', 10)->nullable();
            $table->string('title')->nullable();
            $table->bigInteger('unidade_id')->nullable();
            $table->bigInteger('atendente_id')->nullable();
            $table->timestamp('paused_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('transferred_at')->nullable();
            $table->string('conclusion')->nullable();
            $table->integer('area_id')->nullable();
            $table->bigInteger('homologado_por')->nullable();
            $table->timestamp('homologado_em')->nullable();
            $table->integer('homologacao_avaliacao')->nullable();
            $table->text('homologacao_observacao_fim')->nullable();
            $table->text('homologacao_observacao_back')->nullable();
            $table->integer('origem_do_problema')->nullable()->index();

            $table->index(['problema_id', 'usuario_id', 'atendente_id', 'unidade_id']);
        });

        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->foreign(['problema_id'])->references(['id'])->on('hd_problemas')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign(['tipo_problema_id'])->references(['id'])->on('hd_tipo_problemas')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::table('hd_chamados', function (Blueprint $table) {
            $table->dropForeign('hd_chamados_problema_id_foreign');
            $table->dropForeign('hd_chamados_tipo_problema_id_foreign');
            $table->dropForeign('hd_chamados_usuario_id_foreign');
        });

        Schema::dropIfExists('hd_chamados');
    }
};
