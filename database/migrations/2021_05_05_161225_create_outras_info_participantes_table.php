<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\OutrasInfoParticipante;

class CreateOutrasInfoParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outras_info_participantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("rg");
            $table->date("data_de_nascimento");
            $table->string("curso");
            $table->enum("turno", OutrasInfoParticipante::ENUM_TURNO)->nullable(true);
            $table->integer("ordem_prioridade")->nullable(true);
            $table->string("periodo_atual")->nullable(true);
            $table->string("total_periodos")->nullable(true);
            $table->double("media_do_curso", 3, 2)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outras_info_participantes');
    }
}
