<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosExtensaoGeradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_extensao_gerados', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('tecnico_cientifico');
            $table->integer('qtd_tecnico_cientifico');
            $table->string('divulgacao');
            $table->integer('qtd_divulgacao');
            $table->string('didatico_instrucional');
            $table->integer('qtd_didatico_instrucional');
            $table->string('multimidia');
            $table->integer('qtd_multimidia');
            $table->string('artistico_cultural');
            $table->integer('qtd_artistico_cultural');

            $table->unsignedBigInteger('relatorio_id');
            $table->foreign('relatorio_id')->references('id')->on('relatorios');

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
        Schema::dropIfExists('produtos_extensao_gerados');
    }
}
