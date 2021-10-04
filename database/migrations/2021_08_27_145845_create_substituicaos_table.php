<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstituicaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substituicaos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['Finalizada', 'Negada', 'Em Aguardo']);
            $table->enum('tipo', ['Completa', 'TrocarPlano', 'ManterPlano']);
            $table->text('justificativa')->nullable();
            $table->string('causa')->nullable();
            $table->text('observacao')->nullable();

            $table->unsignedBigInteger('trabalho_id');
            $table->unsignedBigInteger('participanteSubstituido_id');
            $table->unsignedBigInteger('participanteSubstituto_id');
            $table->unsignedBigInteger('planoSubstituto_id');
            $table->dateTime('concluida_em')->nullable();

            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
            $table->foreign('participanteSubstituido_id')->references('id')->on('participantes');
            $table->foreign('participanteSubstituto_id')->references('id')->on('participantes');
            $table->foreign('planoSubstituto_id')->references('id')->on('arquivos');
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
        Schema::dropIfExists('substituicaos');
    }
}
