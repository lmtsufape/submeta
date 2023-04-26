<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampoAvaliacaoSeeder extends Seeder
{

/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campo_avaliacaos')->insert([
            'nome' => 'campo teste',
            'descricao' => 'descricao teste',
            'evento_id' => 1,
            'nota_maxima' => 10,
            'prioridade' => 1,
        ]);
    }
}