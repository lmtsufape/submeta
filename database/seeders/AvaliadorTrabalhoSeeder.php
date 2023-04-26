<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvaliadorTrabalhoSeeder extends Seeder
{

/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('avaliador_trabalho')->insert([
            'avaliador_id' => 4,
            'trabalho_id' => 1,
            'acesso' => 3,
            'pontuacao' => 9,
            'recomendacao' => 'recomendacao teste',
            'status' => true,
            'parecer' => 'parecer teste',
        ]);

        DB::table('avaliador_trabalho')->insert([
            'avaliador_id' => 4,
            'trabalho_id' => 2,
            'acesso' => 3,
            'pontuacao' => 9,
            'recomendacao' => 'recomendacao teste',
            'status' => true,
            'parecer' => 'parecer teste',
        ]);


    }
}
   