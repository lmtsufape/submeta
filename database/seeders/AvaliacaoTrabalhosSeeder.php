<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvaliacaoTrabalhosSeeder extends Seeder
{

/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('avaliacao_trabalhos')->insert([
            'avaliador_id' => 4,
            'trabalho_id' => 1,
            'campo_avaliacao_id' => 1,
            'nota' => 9,
        ]);

        DB::table('avaliacao_trabalhos')->insert([
            'avaliador_id' => 4,
            'trabalho_id' => 2,
            'campo_avaliacao_id' => 1,
            'nota' => 9,
        ]);
    }
}