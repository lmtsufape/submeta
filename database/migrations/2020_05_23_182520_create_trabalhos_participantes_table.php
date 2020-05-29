<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabalhosParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalho_participante', function (Blueprint $table) {
            $table->unsignedBigInteger('trabalho_id');
            $table->unsignedBigInteger('participante_id');

            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
            $table->foreign('participante_id')->references('id')->on('participantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabalho_participante');
    }
}
