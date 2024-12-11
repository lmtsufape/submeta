<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterTipoVinculoCheckInRelatorioIntegrantesInternosTable extends Migration
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
            DB::statement('ALTER TABLE relatorio_integrantes_internos DROP CONSTRAINT IF EXISTS relatorio_integrantes_internos_tipo_vinculo_check');
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
            DB::statement('ALTER TABLE relatorio_integrantes_internos ADD CONSTRAINT relatorio_integrantes_internos_tipo_vinculo_check CHECK (tipo_vinculo IN (\'Docente\', \'Substituto/a\', \'Técnico/a Administrativo/a\'))');
        });
    }
}
