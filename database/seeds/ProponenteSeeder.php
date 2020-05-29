<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProponenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user_id = DB::table('users')->where('name','Proponente')->pluck('id');

      DB::table('proponentes')->insert([
        'user_id' => $user_id[0],
        //'CPF' => '123123123',
        'SIAPE' => '123123123',
        //'email' => '123123123',
        //'email' => '123123123',
        'cargo' => '123123123',
        'vinculo' => '123123123',
        'titulacaoMaxima' => '123123123',
        'anoTitulacao' => '123123123',
        'grandeArea' => '123123123',
        'area' => '123123123',
        'subArea' => '123123123',
        'bolsistaProdutividade' => '123123123',
        'nivel' => '123123123',
        'linkLattes' => '123123123',
        'created_at' => '2020-01-01 00:00:00'

      ]);
    }
}