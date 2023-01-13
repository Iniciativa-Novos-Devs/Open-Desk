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
        Schema::create('hd_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('telefone_1')->nullable();
            $table->boolean('telefone_1_wa')->nullable()->default(false);
            $table->string('ue')->nullable()->index();
            $table->string('versao', 10)->nullable();
            $table->string('remember_token')->nullable();
            $table->boolean('app_admin')->nullable()->default(false);
            $table->integer('unidade_id')->nullable()->index();
        });

        Schema::table('hd_usuarios', function (Blueprint $table) {
            $table->foreign(['ue'])->references(['ue'])->on('hd_unidades')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hd_usuarios', function (Blueprint $table) {
            $table->dropForeign('hd_usuarios_ue_foreign');
        });

        Schema::dropIfExists('hd_usuarios');
    }
};
