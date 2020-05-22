<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrabalhosToPlanoTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plano_trabalhos', function (Blueprint $table) {
            $table->unsignedBigInteger('trabalho_id');
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plano_trabalhos', function (Blueprint $table) {
            $table->dropForeign('plano_trabalhos_trabalho_id_foreign');
            $table->dropColumn('trabalho_id');
        });
    }
}
