<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaTematicaAvaliadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_tematica_avaliadors', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('area_tematica_id');
            $table->foreign('area_tematica_id')->references('id')->on('area_tematicas');

            $table->integer('avaliador_id');
            $table->foreign('avaliador_id')->references('id')->on('avaliadors');

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
        Schema::dropIfExists('area_tematica_avaliadors');
    }
}
