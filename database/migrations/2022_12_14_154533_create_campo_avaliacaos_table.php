<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampoAvaliacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campo_avaliacaos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome')->nullable();
            $table->float('nota_maxima')->nullable();
            $table->text('descricao')->nullable();
            $table->integer('prioridade')->nullable();

            $table->integer('evento_id');
            $table->foreign('evento_id')->references('id')->on('eventos');

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
        Schema::dropIfExists('campo_avaliacaos');
    }
}
