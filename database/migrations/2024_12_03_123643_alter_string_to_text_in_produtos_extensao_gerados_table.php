<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStringToTextInProdutosExtensaoGeradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos_extensao_gerados', function (Blueprint $table)
        {
            Schema::table('produtos_extensao_gerados', function (Blueprint $table)
            {
                $table->text('tecnico_cientifico')->change();
                $table->text('divulgacao')->change();
                $table->text('didatico_instrucional')->change();
                $table->text('multimidia')->change();
                $table->text('artistico_cultural')->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos_extensao_gerados', function (Blueprint $table)
        {
            Schema::table('produtos_extensao_gerados', function (Blueprint $table)
            {
                $table->string('tecnico_cientifico')->change();
                $table->string('divulgacao')->change();
                $table->string('didatico_instrucional')->change();
                $table->string('multimidia')->change();
                $table->string('artistico_cultural')->change();
            });
        });
    }
}
