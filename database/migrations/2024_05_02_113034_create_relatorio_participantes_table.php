<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatorioParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorio_participantes', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('cpf');
            $table->integer('carga_horaria');

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
        Schema::dropIfExists('relatorio_participantes');
    }
}
