<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableParticipantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->string('anexoTermoCompromisso')->nullable();
            $table->string('anexoComprovanteMatricula')->nullable();
            $table->string('anexoLattes')->nullable();
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
            $table->dropColumn('anexoTermoCompromisso');
            $table->dropColumn('anexoComprovanteMatricula');
            $table->dropColumn('anexoLattes');
        });
    }
}
