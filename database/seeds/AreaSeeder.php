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
	DB::table('areas')->insert([
        	'nome'=>'Engenharia de Minas',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia de Materiais e Metalúrgica',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia Elétrica',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia Mecânica',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia Química',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia Sanitária',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia de Produção',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia Nuclear',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia de Transportes',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia Naval e Oceânica',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia Aeroespacial',
        	'grande_area_id' => '3'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Engenharia Biomédica',
        	'grande_area_id' => '3'
      	]);

      	// Ciências da Saúde -----------------

      	DB::table('areas')->insert([
        	'nome'=>'Medicina',
        	'grande_area_id' => '4'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Odontologia',
        	'grande_area_id' => '4'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Farmácia',
        	'grande_area_id' => '4'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Enfermagem',
        	'grande_area_id' => '4'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Nutrição',
        	'grande_area_id' => '4'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Saúde Coletiva',
        	'grande_area_id' => '4'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Fonoaudiologia',
        	'grande_area_id' => '4'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Fisioterapia e Terapia Ocupacional',
        	'grande_area_id' => '4'
      	]);
	DB::table('areas')->insert([
        	'nome'=>'Educação Física',
        	'grande_area_id' => '4'
      	]);
	

      	//Ciências Agrárias ------------------

      	DB::table('areas')->insert([
        	'nome'=>'Agronomia',
        	'grande_area_id' => '5'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Recursos Florestais e Engenharia Florestal',
        	'grande_area_id' => '5'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Engenharia Agrícola',
        	'grande_area_id' => '5'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Zootecnia',
        	'grande_area_id' => '5'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Medicina Veterinária',
        	'grande_area_id' => '5'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Recursos Pesqueiros e Engenharia de Pesca',
        	'grande_area_id' => '5'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Ciência e Tecnologia de Alimentos',
        	'grande_area_id' => '5'
      	]);

      	//Ciências Sociais Aplicadas ----------

      	DB::table('areas')->insert([
        	'nome'=>'Direito',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Administração',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Economia',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Arquitetura e Urbanismo',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Planejamento Urbano e Regional',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Demografia',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Ciência da Informação',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Museologia',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Comunicação',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Serviço Social',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Economia Doméstica',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Desenho Industrial',
        	'grande_area_id' => '6'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Turismo',
        	'grande_area_id' => '6'
      	]);

      	//Ciências Humanas ----------------------

      	DB::table('areas')->insert([
        	'nome'=>'Filosofia',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Sociologia',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Antropologia',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Arqueologia',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'História',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Geografia',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Psicologia',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Educação',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Ciência Política',
        	'grande_area_id' => '7'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Teologia',
        	'grande_area_id' => '7'
      	]);
      	
      	//Lingüística, Letras e Artes-----------

      	DB::table('areas')->insert([
        	'nome'=>'Lingüística',
        	'grande_area_id' => '8'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Letras',
        	'grande_area_id' => '8'
      	]);
      	DB::table('areas')->insert([
        	'nome'=>'Artes',
        	'grande_area_id' => '8'
      	]);



    }
}
