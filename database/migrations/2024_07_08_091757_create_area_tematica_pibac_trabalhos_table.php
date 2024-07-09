<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaTematicaPibacTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_tematica_pibac_trabalhos', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->integer('area_tematica_pibac_id');
            $table->foreign('area_tematica_pibac_id')->references('id')->on('area_tematica_pibacs');

            $table->integer('trabalho_id');
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
        Schema::dropIfExists('area_tematica_pibac_trabalhos');
    }
}
