<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalhos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->string('status')->nullable();
            $table->string('aprovado')->nullable();
            $table->string('linkGrupoPesquisa');
            $table->string('linkLattesEstudante');
            $table->string('pontuacaoPlanilha');
            $table->date('data')->nullable();
            //Anexos
            $table->string('anexoProjeto');
            $table->string('anexoDecisaoCONSU')->nullable();
            $table->string('anexoPlanilhaPontuacao');
            $table->string('anexoLattesCoordenador');
            $table->string('anexoGrupoPesquisa');
            $table->string('anexoAutorizacaoComiteEtica')->nullable(); 
            $table->string('justificativaAutorizacaoEtica')->nullable();
            //chaves estrangeiras
            $table->unsignedBigInteger('grande_area_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('sub_area_id');
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('coordenador_id');
            $table->unsignedBigInteger('proponente_id');
            $table->softDeletes();

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
        Schema::dropIfExists('trabalhos');
    }
}
