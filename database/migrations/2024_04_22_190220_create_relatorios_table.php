<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorios', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->enum('status', ['em análise', 'aprovado', 'devolvido para correções']);
            $table->date('inicio_projeto');
            $table->date('conclusao_projeto');
            $table->string('titulo_projeto');
            $table->json('area_tematica_principal');
            $table->json('ods');
            $table->boolean('captacao_recursos');
            $table->text('resumo');
            $table->integer('objetivos_alcancados');
            $table->string('justificativa_objetivos_alcancados')->nullable();
            $table->integer('pessoas_beneficiadas');
            $table->integer('alcance_publico_estimado');
            $table->string('justificativa_publico_estimado')->nullable();
            $table->text('beneficios_publico_atendido');
            $table->text('impactos_tecnologicos_cientificos');
            $table->text('desafios_encontrados');
            $table->text('avaliacao_projeto_executado');
            $table->boolean('formulario_indicadores');
            $table->boolean('certificacao_adicinonal');

            $table->unsignedBigInteger('trabalho_id');
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
        Schema::dropIfExists('relatorios');
    }
}
