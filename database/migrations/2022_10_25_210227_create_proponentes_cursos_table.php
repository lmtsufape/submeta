<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProponentesCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proponentes_cursos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->integer('proponente_id');
            $table->foreign('proponente_id')->references('id')->on('proponentes');

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
        Schema::dropIfExists('proponentes_cursos');
    }
}
