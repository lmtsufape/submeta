<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatorioCoordenadorEVicecoordenadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorio_coordenador_e_vicecoordenadors', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->enum('tipo', ['Coordenador/a', 'Vice-Coordenador/a']);
            $table->string('nome');
            $table->string('cpf');
            $table->string('telefone');
            $table->string('email_institucional');
            $table->string('cargo');
            $table->string('curso_setor');
            $table->integer('ch_total_atuacao');

            $table->unsignedBigInteger('relatorio_id');
            $table->foreign('relatorio_id')->references('id')->on('relatorios');

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
        Schema::dropIfExists('relatorio_coordenador_e_vicecoordenadors');
    }
}
