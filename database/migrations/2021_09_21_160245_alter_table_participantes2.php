<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableParticipantes2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->string('anexoAutorizacaoPais')->nullable();
            $table->string('linkLattes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->dropColumn('anexoAutorizacaoPais');
            $table->dropColumn('linkLattes');
        });
    }
}
