<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacaos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('remetente_id');
            $table->integer('destinatario_id');
            $table->integer('trabalho_id');
            $table->boolean('lido');
            $table->integer('tipo');

            $table->foreign('remetente_id')->references('id')->on('users');
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
            $table->foreign('destinatario_id')->references('id')->on('users');
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
        Schema::dropIfExists('notificacaos');
    }
}
