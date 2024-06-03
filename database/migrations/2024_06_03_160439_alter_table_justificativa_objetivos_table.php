<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableJustificativaObjetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relatorios', function (Blueprint $table)
        {
            $table->text('justificativa_objetivos_alcancados')->nullable()->change();
            $table->text('justificativa_publico_estimado')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relatorios', function (Blueprint $table)
        {
            $table->string('justificativa_objetivos_alcancados')->nullable()->change();
            $table->string('justificativa_publico_estimado')->nullable()->change();
        });
    }
}
