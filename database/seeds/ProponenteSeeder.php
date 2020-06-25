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
      $user_id = DB::table('users')->where('name','Proponente')->select('id');

      DB::table('proponentes')->insert([
        'user_id' => '4',
        'SIAPE' => '123123123',
        'cargo' => '123123123',
        'vinculo' => '123123123',
        'titulacaoMaxima' => 'Mestrado',
        'anoTitulacao' => '123123123',
        'areaFormacao' => '123123123',        
        'bolsistaProdutividade' => '123123123',
        'nivel' => '123123123',
        'linkLattes' => 'http://lattes.cnpq.br/8363536830656923',

      ]);
      // $user_id = DB::table('users')->where('name','Gabriel')->pluck('id');

      // DB::table('proponentes')->insert([
      //   'user_id' => '1',
      //   'SIAPE' => '123123123',
      //   'cargo' => '123123123',
      //   'vinculo' => '123123123',
      //   'titulacaoMaxima' => 'Mestrado',
      //   'anoTitulacao' => '123123123',
      //   'areaFormacao' => '123123123',        
      //   'bolsistaProdutividade' => '123123123',
      //   'nivel' => '123123123',
      //   'linkLattes' => 'http://lattes.cnpq.br/8363536830656923',

      // ]);
    }
}