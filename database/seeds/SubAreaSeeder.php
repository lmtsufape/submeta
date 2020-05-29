<?php

use Illuminate\Database\Seeder;

class SubAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	//------------------ Ciências Exatas e da Terra  ---------
    	//Matemática ------------------
        DB::table('sub_areas')->insert([
        	'nome'=>'Álgebra',
        	'area_id' => '1'
      	]);

        //------------------ Ciências Biológicas  ----------------
      	//Genética --------------------

      	DB::table('sub_areas')->insert([
        	'nome'=>'Genética Quantitativa',
        	'area_id' => '2'
      	]);

      	//------------------ Engenharias ----------------
      	//Engenharia Civil --------------

      	DB::table('sub_areas')->insert([
        	'nome'=>'Álgebra',
        	'area_id' => '3'
      	]);

      	//------------------ Ciências da Saúde ----------------
      	//Medicina--------------

      	DB::table('sub_areas')->insert([
        	'nome'=>'Clínica Médica',
        	'area_id' => '4'
      	]);

      	//------------------ Ciências Agrárias ----------------
      	//Agronomia --------------

      	DB::table('sub_areas')->insert([
        	'nome'=>'Ciência do Solo',
        	'area_id' => '5'
      	]);

      	//------------------ Ciências Sociais Aplicadas ----------------
      	//Direito --------------

      	DB::table('sub_areas')->insert([
        	'nome'=>'Teoria do Direito',
        	'area_id' => '6'
      	]);

      	//------------------ Ciências Humanas ----------------
      	//Filosofia --------------

      	DB::table('sub_areas')->insert([
        	'nome'=>' História da Filosofia',
        	'area_id' => '7'
      	]);

      	//------------------ Lingüística, Letras e Artes ----------------
      	//Lingüística  ------------------

		DB::table('sub_areas')->insert([
        	'nome'=>'Teoria e Análise Lingüística',
        	'area_id' => '8'
      	]);
    }
}
