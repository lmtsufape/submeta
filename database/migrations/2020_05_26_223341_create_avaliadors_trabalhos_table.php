<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliadorsTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliador_trabalho', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->text('parecer')->nullable();
            $table->string('AnexoParecer')->nullable();
            $table->boolean('status')->nullable();

            $table->unsignedBigInteger('recomendacao_id')->nullable();
            $table->unsignedBigInteger('trabalho_id');
            $table->unsignedBigInteger('avaliador_id');

            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
            $table->foreign('avaliador_id')->references('id')->on('avaliadors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avaliador_trabalho');
    }
}
