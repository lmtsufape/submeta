<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterTipoVinculoInRelatorioIntegrantesInternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relatorio_integrantes_internos', function (Blueprint $table)
        {
            $table->string('tipo_vinculo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relatorio_integrantes_internos', function (Blueprint $table)
        {
            $table->enum('tipo_vinculo', ['Docente', 'Substituto/a', 'Técnico/a Administrativo/a'])->change();
        });
    }
}
