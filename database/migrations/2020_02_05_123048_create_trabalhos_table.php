<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalhos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('titulo');
            $table->string('autores')->nullable();
            $table->date('data')->nullable();
            $table->text('resumo')->nullable();
            $table->text('avaliado')->nullable();

            $table->integer('modalidadeId');
            $table->integer('areaId');
            $table->integer('autorId');
            $table->integer('eventoId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabalhos');
    }
}
