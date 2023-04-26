<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvaliadorEventoSeeder extends Seeder
{

/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('avaliador_evento')->insert([
            'avaliador_id' => 4,
            'evento_id' => 1,
            'convite' => true,
        ]);

    }
}
   