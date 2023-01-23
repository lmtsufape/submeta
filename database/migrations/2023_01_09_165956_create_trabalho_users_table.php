<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabalhoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalho_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('trabalho_id');
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');

            $table->integer('funcao_participante_id');
            $table->foreign('funcao_participante_id')->references('id')->on('funcao_participantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabalho_users');
    }
}
