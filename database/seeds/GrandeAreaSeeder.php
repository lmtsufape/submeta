<?php

use Illuminate\Database\Seeder;

class GrandeAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Exatas e da Terra',
      	]);
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Biológicas',
      	]);
      	DB::table('grande_areas')->insert([
        	'nome'=>'Engenharias',
      	]);
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências da Saúde ',
      	]);
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Agrárias',
      	]);
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Sociais Aplicadas',
      	]);
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Humanas',
      	]);
      	DB::table('grande_areas')->insert([
        	'nome'=>'Lingüística, Letras e Artes',
      	]);

    }
}
