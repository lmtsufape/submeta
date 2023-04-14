<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaApresentacaoToAvaliacaoRelatorios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avaliacao_relatorios', function (Blueprint $table) {
            $table->float('nota_apresentacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avaliacao_relatorios', function (Blueprint $table) {
            $table->dropColumn('nota_apresentacao');
        });
    }
}
