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
        //1
        DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Exatas e da Terra',
      	]);
        //2
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Biológicas',
      	]);
        //3
      	DB::table('grande_areas')->insert([
        	'nome'=>'Engenharias',
      	]);
        //4
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências da Saúde ',
      	]);
        //5
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Agrárias',
      	]);
        //6
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Sociais Aplicadas',
      	]);
        //7
      	DB::table('grande_areas')->insert([
        	'nome'=>'Ciências Humanas',
      	]);
        //8
      	DB::table('grande_areas')->insert([
        	'nome'=>'Lingüística, Letras e Artes',
      	]);

    }
}
