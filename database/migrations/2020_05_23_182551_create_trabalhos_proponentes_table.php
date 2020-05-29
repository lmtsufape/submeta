<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabalhosProponentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalho_proponente', function (Blueprint $table) {
            $table->unsignedBigInteger('trabalho_id');
            $table->unsignedBigInteger('proponente_id');

            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
            $table->foreign('proponente_id')->references('id')->on('proponentes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabalho_proponente');
    }
}
