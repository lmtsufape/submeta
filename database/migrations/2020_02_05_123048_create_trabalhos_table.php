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
            $table->string('titulo')->nullable();
            $table->string('aprovado')->nullable();
            $table->string('linkGrupoPesquisa')->nullable();
            $table->string('linkLattesEstudante')->nullable();
            $table->string('pontuacaoPlanilha')->nullable();
            $table->date('data')->nullable();
            $table->enum('status',['rascunho','submetido', 'avaliado', 'corrigido','aprovado','reprovado', 'arquivado'])->default('rascunho')->nullable(); 
            //Anexos
            $table->string('anexoProjeto')->nullable();
            $table->string('anexoDecisaoCONSU')->nullable();
            $table->string('anexoPlanilhaPontuacao')->nullable();
            $table->string('anexoLattesCoordenador')->nullable();
            $table->string('anexoGrupoPesquisa')->nullable();
            $table->string('anexoAutorizacaoComiteEtica')->nullable(); 
            $table->string('justificativaAutorizacaoEtica')->nullable();
            //chaves estrangeiras
            $table->unsignedBigInteger('grande_area_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('sub_area_id')->nullable();
            $table->unsignedBigInteger('evento_id')->nullable();
            $table->unsignedBigInteger('coordenador_id')->nullable();
            $table->unsignedBigInteger('proponente_id')->nullable();
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
