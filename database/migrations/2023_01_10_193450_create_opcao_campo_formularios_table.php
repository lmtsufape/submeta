<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcaoCampoFormulariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcao_campo_formularios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('opcao');
            $table->string('class');
            $table->integer('posicao');
            $table->unsignedBigInteger('campo_formulario_id');
            $table->foreign('campo_formulario_id')->references('id')->on('campo_formularios');
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
        Schema::dropIfExists('opcao_campo_formularios');
    }
}
