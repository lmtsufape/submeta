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
            $table->timestamps();
            $table->string('titulo');
            $table->string('grandeArea');
            $table->string('area');
            $table->string('subArea');
            $table->string('decisaoCONSU');
            $table->string('anexoDecisaoCONSU');
            $table->string('autorizacaoComiteEtica');
            $table->string('anexoAutorizacaoComiteEtica');
            $table->string('coordenador'); //preencher automaticamente
            $table->string('anexoLattesCoordenador'); 
            $table->string('anexoPlanilhaPontuacao');
            $table->string('pontuacaoPlanilha');
            $table->string('linkGrupoPesquisa');
            $table->string('linkLattesEstudante');
            $table->string('autores')->nullable();
            $table->date('data')->nullable();
            $table->text('resumo')->nullable();
            $table->text('avaliado')->nullable();

            $table->integer('modalidadeId');
            $table->integer('areaId');
            $table->integer('autorId');
            $table->integer('eventoId');
            $table->integer('proponente_id');
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
