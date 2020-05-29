<?php

use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
        	'nome'=>'Matemática',
        	'grande_area_id' => '1'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Probabilidade e Estatística',
        	'grande_area_id' => '1'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Ciência da Computação',
        	'grande_area_id' => '1'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Astronomia',
        	'grande_area_id' => '1'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Física',
        	'grande_area_id' => '1'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Química',
        	'grande_area_id' => '1'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'GeoCiências',
        	'grande_area_id' => '1'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Oceanografia',
        	'grande_area_id' => '1'
      	]);

      	// Ciências Biológicas ----------------------

      	DB::table('areas')->insert([
        	'nome'=>'Biologia Geral',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Genética',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Botânica',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Zoologia',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Ecologia',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Morfologia',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Bioquímica',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Fisiologia',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Biofísica',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Farmacologia',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Imunologia',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Microbiologia',
        	'grande_area_id' => '2'
      	]);

      	DB::table('areas')->insert([
        	'nome'=>'Parasitologia',
        	'grande_area_id' => '2'
      	]);

      	//Engenharias --------------------

      	DB::table('areas')->insert([
        	'nome'=>'Engenharia Civil',
        	'grande_area_id' => '3'
      	]);

      	// Ciências da Saúde -----------------

      	DB::table('areas')->insert([
        	'nome'=>'Medicina',
        	'grande_area_id' => '4'
      	]);

      	//Ciências Agrárias ------------------

      	DB::table('areas')->insert([
        	'nome'=>'Agronomia',
        	'grande_area_id' => '5'
      	]);

      	//Ciências Sociais Aplicadas ----------

      	DB::table('areas')->insert([
        	'nome'=>'Direito',
        	'grande_area_id' => '6'
      	]);

      	//Ciências Humanas ----------------------

      	DB::table('areas')->insert([
        	'nome'=>'Filosofia',
        	'grande_area_id' => '7'
      	]);

      	//Lingüística, Letras e Artes-----------

      	DB::table('areas')->insert([
        	'nome'=>'Lingüística',
        	'grande_area_id' => '8'
      	]);



    }
}
