<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampoFormulariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campo_formularios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label')->nullable();
            $table->string('type');
            $table->string('placeholder')->nullable();
            $table->string('default_value')->nullable();
            $table->boolean('required')->default(true);
            $table->string('class');
            $table->integer('min_characters')->default(0);
            $table->integer('max_characters')->default(200);
            $table->boolean('valor_ao_lado_da_label')->default(false);
            $table->integer('posicao');
            $table->unsignedBigInteger('formulario_id');
            $table->foreign('formulario_id')->references('id')->on('formularios');
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
        Schema::dropIfExists('campo_formularios');
    }
}
