<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nome')->nullable();            
            $table->string('descricao')->nullable();
            $table->string('tipo')->nullable(); 
            $table->unsignedBigInteger('natureza_id')->nullable();           
            $table->date('inicioSubmissao')->nullable();
            $table->date('fimSubmissao')->nullable();
            $table->date('inicioRevisao')->nullable();
            $table->date('fimRevisao')->nullable();
            $table->date('resultado')->nullable();        
            $table->integer('numMaxTrabalhos')->nullable();
            $table->integer('numMaxCoautores')->nullable();
            $table->boolean('hasResumo')->nullable();
            $table->integer('criador_id')->nullable();
            $table->integer('coordenadorId')->nullable();
            $table->string('pdfEdital')->nullable();
            $table->string('modeloDocumento')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
