<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChavesEstrangeiras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      //------------------------------------------------------------------------

      Schema::table('areas', function (Blueprint $table) {
          $table->foreign('eventoId')->references('id')->on('eventos');
      });

      //------------------------------------------------------------------------

      Schema::table('area_modalidades', function (Blueprint $table) {
          $table->foreign('areaId')->references('id')->on('areas');
      });
      Schema::table('area_modalidades', function (Blueprint $table) {
          $table->foreign('modalidadeId')->references('id')->on('modalidades');
      });

      //------------------------------------------------------------------------

      Schema::table('arquivos', function (Blueprint $table) {
          $table->foreign('trabalhoId')->references('id')->on('trabalhos');
      });

      //------------------------------------------------------------------------

      Schema::table('atividades', function (Blueprint $table) {
          $table->foreign('eventoId')->references('id')->on('eventos');
      });

      //------------------------------------------------------------------------

      Schema::table('atribuicaos', function (Blueprint $table) {
          $table->foreign('trabalhoId')->references('id')->on('trabalhos');
      });
      Schema::table('atribuicaos', function (Blueprint $table) {
          $table->foreign('revisorId')->references('id')->on('revisors');
      });

      //------------------------------------------------------------------------

      Schema::table('coautors', function (Blueprint $table) {
          $table->foreign('trabalhoId')->references('id')->on('trabalhos');
      });
      Schema::table('coautors', function (Blueprint $table) {
          $table->foreign('autorId')->references('id')->on('users');
      });

      //------------------------------------------------------------------------

      Schema::table('eventos', function (Blueprint $table) {
          $table->foreign('enderecoId')->references('id')->on('enderecos');
      });
      Schema::table('eventos', function (Blueprint $table) {
          $table->foreign('coordenadorId')->references('id')->on('users');
      });

      //------------------------------------------------------------------------

      Schema::table('mensagems', function (Blueprint $table) {
          $table->foreign('comissaoId')->references('id')->on('users');
      });

      //------------------------------------------------------------------------

      Schema::table('parecers', function (Blueprint $table) {
          $table->foreign('trabalhoId')->references('id')->on('trabalhos');
      });
      Schema::table('parecers', function (Blueprint $table) {
          $table->foreign('revisorId')->references('id')->on('users');
      });

      //------------------------------------------------------------------------

      Schema::table('pertences', function (Blueprint $table) {
          $table->foreign('areaId')->references('id')->on('areas');
      });
      Schema::table('pertences', function (Blueprint $table) {
          $table->foreign('revisorId')->references('id')->on('users');
      });

      //------------------------------------------------------------------------

      Schema::table('recursos', function (Blueprint $table) {
          $table->foreign('trabalhoId')->references('id')->on('trabalhos');
      });
      Schema::table('recursos', function (Blueprint $table) {
          $table->foreign('comissaoId')->references('id')->on('users');
      });

      //------------------------------------------------------------------------

      Schema::table('trabalhos', function (Blueprint $table) {
          $table->foreign('modalidadeId')->references('id')->on('modalidades');
      });
      Schema::table('trabalhos', function (Blueprint $table) {
          $table->foreign('areaId')->references('id')->on('areas');
      });
      Schema::table('trabalhos', function (Blueprint $table) {
          $table->foreign('autorId')->references('id')->on('users');
      });
      Schema::table('trabalhos', function (Blueprint $table) {
          $table->foreign('eventoId')->references('id')->on('eventos');
      });

      //------------------------------------------------------------------------

      Schema::table('users', function (Blueprint $table) {
          $table->foreign('enderecoId')->references('id')->on('enderecos');
      });

      //------------------------------------------------------------------------

      Schema::table('revisors', function (Blueprint $table) {
          $table->foreign('revisorId')->references('id')->on('users');
      });
      Schema::table('revisors', function (Blueprint $table) {
          $table->foreign('eventoId')->references('id')->on('eventos');
      });
      Schema::table('revisors', function (Blueprint $table) {
          $table->foreign('areaId')->references('id')->on('areas');
      });
      Schema::table('eventos',function (Blueprint $table){
        $table->foreign('coordComissaoId')->references('id')->on('users');
      });
      //------------------------------------------------------------------------
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
