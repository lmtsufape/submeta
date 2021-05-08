<?php

use Illuminate\Database\Seeder;

class FuncaoParticipanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funcao_participantes')->insert([
        	'nome'=>'Vice-coordenador',
        	
      	]);

      	DB::table('funcao_participantes')->insert([
        	'nome'=>'Colaborador',
        	
      	]);

      	DB::table('funcao_participantes')->insert([
        	'nome'=>'Consultor',
        	
      	]);

      	DB::table('funcao_participantes')->insert([
        	'nome'=>'Bolsista',
        	
      	]);

      	DB::table('funcao_participantes')->insert([
        	'nome'=>'Voluntário',
        	
      	]);

		DB::table('funcao_participantes')->insert([
        	'nome'=>'Pesquisador',
        	
      	]);
    }
}
