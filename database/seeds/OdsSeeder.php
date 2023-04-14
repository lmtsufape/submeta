<?php

use Illuminate\Database\Seeder;

class OdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Erradicação da pobreza',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Fome zero e agricultura sustentável',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Saúde e Bem-estar',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Educação de qualidade',
      	]);

        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
            'nome'=>'Igualdade de Gênero',
        ]);      
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Água potável e Saneamento',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Energia Acessível e Limpa',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Trabalho decente e crescimento econômico',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Indústria, Inovação e Infraestrutura',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Redução das desigualdades',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Cidades e comunidades sustentáveis',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Consumo e produção responsáveis',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Ação contra a mudança global do clima',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Vida na água',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Vida terrestre',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Paz, justiça e instituições eficazes',
      	]);
        
        DB::table('objetivo_de_desenvolvimento_sustentavels')->insert([
        	'nome'=>'Parcerias e meios de implementação',
      	]);
    }
}
