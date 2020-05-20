<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('prazo')->nullable();
            $table->integer('trabalhosCorrigidos');
            $table->integer('correcoesEmAndamento');

            $table->integer('revisorId');
            $table->integer('areaId');
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
        Schema::dropIfExists('revisors');
    }
}
