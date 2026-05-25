<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToObjetivoDeDesenvolvimentoSustentaveisTable extends Migration
{
    public function up()
    {
        Schema::table('objetivo_de_desenvolvimento_sustentavels', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('objetivo_de_desenvolvimento_sustentavels', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
