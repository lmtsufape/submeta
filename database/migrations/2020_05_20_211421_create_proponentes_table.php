<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProponentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proponentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CPF');
            $table->string('SIAPE');
            $table->string('email')->unique();
            $table->string('cargo');
            $table->string('vinculo');
            $table->string('titulacaoMaxima');
            $table->string('anoTitulacao');
            $table->string('grandeArea');
            $table->string('area');
            $table->string('subArea');
            $table->string('bolsistaProdutividade');
            $table->string('nivel');
            $table->string('linkLattes');
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
        Schema::dropIfExists('proponentes');
    }
}
