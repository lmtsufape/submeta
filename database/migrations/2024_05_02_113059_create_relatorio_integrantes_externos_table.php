<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatorioIntegrantesExternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorio_integrantes_externos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('cpf');
            $table->string('instituicao_vinculo');
            $table->integer('ch_total_atuacao');
            $table->date('ingresso_proposta');
            $table->date('conclusao_proposta');

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
        Schema::dropIfExists('relatorio_integrantes_externos');
    }
}
