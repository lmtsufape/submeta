<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnexoSipacToTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trabalhos', function (Blueprint $table) {
            $table->string('anexo_SIPAC')->nullable();
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
            $table->dropColumn('anexo_SIPAC');
        });
    }
}
