<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEventos2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->date('dt_inicioRelatorioParcial')->nullable();
            $table->date('dt_fimRelatorioParcial')->nullable();
            $table->date('dt_inicioRelatorioFinal')->nullable();
            $table->date('dt_fimRelatorioFinal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('dt_inicioRelatorioParcial');
            $table->dropColumn('dt_fimRelatorioParcial');
            $table->dropColumn('dt_inicioRelatorioFinal');
            $table->dropColumn('dt_fimRelatorioFinal');
        });
    }
}
