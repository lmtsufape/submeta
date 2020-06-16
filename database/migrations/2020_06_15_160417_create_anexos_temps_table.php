<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('anexoProjeto')->nullable();
            $table->string('anexoDecisaoCONSU')->nullable();
            $table->string('anexoPlanilhaPontuacao')->nullable();
            $table->string('anexoLattesCoordenador')->nullable();
            $table->string('anexoAutorizacaoComiteEtica')->nullable(); 
            $table->string('justificativaAutorizacaoEtica')->nullable();

            $table->integer('eventoId');
            $table->integer('proponenteId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anexos_temps');
    }
}
