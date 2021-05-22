<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliadorsPlanoTrabalhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliadors_plano_trabalho', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->text('parecer')->nullable();
            $table->string('AnexoParecer')->nullable();
            $table->boolean('status')->nullable();            
            $table->string('recomendacao')->nullable();
            $table->softDeletes();

            $table->unsignedBigInteger('arquivo_id');
            $table->unsignedBigInteger('avaliador_id');

            $table->foreign('arquivo_id')->references('id')->on('arquivos');
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
        Schema::dropIfExists('avaliadors_plano_trabalho');
    }
}
