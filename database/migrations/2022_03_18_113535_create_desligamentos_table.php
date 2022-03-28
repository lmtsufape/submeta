<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesligamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desligamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status');
            $table->text('justificativa');

            $table->unsignedBigInteger('participante_id');
            $table->foreign('participante_id')->references('id')->on('participantes');
            
            $table->unsignedBigInteger('trabalho_id');
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
        Schema::dropIfExists('desligamentos');
    }
}
