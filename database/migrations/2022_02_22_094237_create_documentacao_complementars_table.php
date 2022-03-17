<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentacaoComplementarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentacao_complementars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('termoCompromisso')->nullable();
            $table->string('comprovanteMatricula')->nullable();
            $table->string('pdfLattes')->nullable();
            $table->string('linkLattes')->nullable();

            $table->integer('participante_id')->nullable();
            $table->foreign('participante_id')->references('id')->on('participantes');

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
        Schema::dropIfExists('documentacao_complementars');
    }
}
