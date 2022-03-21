<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSolicitacaoCertificadoToNotificacaos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notificacaos', function (Blueprint $table) {
            $table->unsignedBigInteger('solicitacao_certificado_id')->nullable();
            $table->foreign('solicitacao_certificado_id')->references('id')->on('solicitacoes_certificados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notificacaos', function (Blueprint $table) {
            $table->dropForeign(['solicitacao_certificado_id']);
            $table->dropColumn('solicitacao_certificado_id');
        });
    }
}
