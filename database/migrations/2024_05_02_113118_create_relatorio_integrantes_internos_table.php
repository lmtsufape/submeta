<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatorioIntegrantesInternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorio_integrantes_internos', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->enum('tipo', ['Servidor', 'Discente']);
            $table->enum('tipo_vinculo', ['Docente', 'Substituto/a', 'Técnico/a Administrativo/a'])->nullable();
            $table->string('nome');
            $table->string('cpf');
            $table->string('curso_graduacao')->nullable();
            $table->string('curso_setor')->nullable();
            $table->date('ingresso_proposta');
            $table->date('conclusao_proposta');
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
        Schema::dropIfExists('relatorio_integrantes_internos');
    }
}
