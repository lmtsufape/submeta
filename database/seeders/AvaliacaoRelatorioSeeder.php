<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvaliacaoRelatorioSeeder extends Seeder
{

/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('avaliacao_relatorios')->insert([
            'user_id' => 13,
            'arquivo_id' => 1,
            'tipo' => 'Parcial',
        ]);

        DB::table('avaliacao_relatorios')->insert([
            'user_id' => 13,
            'arquivo_id' => 2,
            'tipo' => 'Final',
        ]);
    }
}