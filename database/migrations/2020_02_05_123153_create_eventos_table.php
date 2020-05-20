<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nome')->nullable();
            // $table->integer('numeroParticipantes');
            $table->string('descricao')->nullable();
            $table->string('tipo')->nullable();
            $table->date('dataInicio')->nullable();
            $table->date('dataFim')->nullable();
            $table->date('inicioSubmissao')->nullable();
            $table->date('fimSubmissao')->nullable();
            $table->date('inicioRevisao')->nullable();
            $table->date('fimRevisao')->nullable();
            $table->date('inicioResultado')->nullable();
            $table->date('fimResultado')->nullable();
            $table->integer('numMaxTrabalhos')->nullable();
            $table->integer('numMaxCoautores')->nullable();
            // $table->boolean('possuiTaxa');
            // $table->double('valorTaxa');
            $table->string('fotoEvento')->nullable();
            $table->boolean('hasResumo')->nullable();

            $table->integer('coordComissaoId')->nullable();
            $table->integer('enderecoId')->nullable();
            $table->integer('coordenadorId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
