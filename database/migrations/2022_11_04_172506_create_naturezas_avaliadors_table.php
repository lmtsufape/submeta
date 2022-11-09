<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaturezasAvaliadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('naturezas_avaliadors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('natureza_id');
            $table->foreign('natureza_id')->references('id')->on('naturezas');
            $table->integer('avaliador_id');
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
        Schema::dropIfExists('naturezas_avaliadors');
    }
}
