<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreasToSubAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_areas', function (Blueprint $table) {
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_areas', function (Blueprint $table) {
            $table->dropForeign('sub_areas_area_id_foreign');
            $table->dropColumn('area_id');
        });
    }
}
