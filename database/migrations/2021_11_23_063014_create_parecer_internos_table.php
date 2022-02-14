<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParecerInternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parecer_internos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('statusLinkGrupoPesquisa');
            $table->string('statusLinkLattesProponente');

            $table->string('statusAnexoProjeto');
            $table->string('statusAnexoDecisaoCONSU');
            $table->string('statusAnexoPlanilhaPontuacao');
            $table->string('statusAnexoLattesCoordenador');
            $table->string('statusAnexoGrupoPesquisa');
            $table->string('statusAnexoAtuorizacaoComiteEtica');
            $table->string('statusJustificativaAutorizacaoEtica');
            $table->string('statusPlanoTrabalho');
            $table->string('statusParecer');

            $table->unsignedBigInteger('trabalho_id');
            $table->unsignedBigInteger('avaliador_id');
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
            $table->foreign('avaliador_id')->references('id')->on('avaliadors');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parecer_internos');
    }
}
