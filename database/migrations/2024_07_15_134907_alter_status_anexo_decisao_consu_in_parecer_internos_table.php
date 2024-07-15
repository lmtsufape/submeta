<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStatusAnexoDecisaoConsuInParecerInternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parecer_internos', function (Blueprint $table)
        {
            $table->string('statusAnexoDecisaoCONSU')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parecer_internos', function (Blueprint $table)
        {
            $table->string('statusAnexoDecisaoCONSU')->nullable(false)->change();
        });
    }
}
