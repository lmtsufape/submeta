<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trabalhos', function (Blueprint $table) {

            $table->foreign('grande_area_id')->references('id')->on('grande_areas');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('sub_area_id')->references('id')->on('sub_areas');
            $table->foreign('evento_id')->references('id')->on('eventos');
            $table->foreign('coordenador_id')->references('id')->on('coordenador_comissaos');

            //$table->foreignId('user_id')->constrained();
            // $table->integer('coordenador');
            // $table->integer('grandeArea_id');
            // $table->integer('area');
            // $table->integer('subArea');
            // $table->integer('eventoId');
            // $table->integer('proponente_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trabalhos', function (Blueprint $table) {
            //
        });
    }
}
