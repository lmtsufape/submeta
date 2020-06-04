<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecomendacaoAvaliadorTrabalhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avaliador_trabalho', function (Blueprint $table) {
            $table->foreign('recomendacao_id')->references('id')->on('recomendacaos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avaliador_trabalho', function (Blueprint $table) {
            //
        });
    }
}
