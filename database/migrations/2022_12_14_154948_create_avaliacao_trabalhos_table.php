<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacaoTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacao_trabalhos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('nota')->nullable();

            $table->integer('avaliador_id');
            $table->foreign('avaliador_id')->references('id')->on('avaliadors');

            $table->integer('campo_avaliacao_id');
            $table->foreign('campo_avaliacao_id')->references('id')->on('campo_avaliacaos');

            $table->integer('trabalho_id');
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avaliacao_trabalhos');
    }
}
