<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Participante;

class CreateParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('confirmacao_convite')->nullable()->nullable(true);
            $table->string("rg")->nullable(true);
            $table->date("data_de_nascimento")->nullable(true);
            $table->string("curso")->nullable(true);
            $table->enum("turno", Participante::ENUM_TURNO)->nullable(true);
            $table->integer("ordem_prioridade")->nullable(true);
            $table->string("periodo_atual")->nullable(true);
            $table->string("total_periodos")->nullable(true);
            $table->double("media_do_curso", 3, 2)->nullable(true);

            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('trabalho_id')->nullable();
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');

            $table->unsignedBigInteger('funcao_participante_id')->nullable();
            $table->foreign('funcao_participante_id')->references('id')->on('funcao_participantes')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participantes');
    }
}
