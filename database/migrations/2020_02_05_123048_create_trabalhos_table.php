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
            $table->boolean('avaliado')->nullable();
            $table->string('linkGrupoPesquisa');
            $table->string('linkLattesEstudante');
            $table->string('pontuacaoPlanilha');
            $table->date('data')->nullable();
            //Anexos
            $table->string('anexoProjeto');
            $table->string('anexoDecisaoCONSU')->nullable();
            $table->string('anexoPlanilhaPontuacao');
            $table->string('anexoLattesCoordenador');
            $table->string('anexoAutorizacaoComiteEtica');
            //chaves estrangeiras
            $table->unsignedBigInteger('grande_area_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('sub_area_id');
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('coordenador_id');

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
