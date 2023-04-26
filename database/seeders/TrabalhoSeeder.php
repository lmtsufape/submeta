<?php

use Illuminate\Database\Seeder;

class TrabalhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *$table->string('titulo');
            $table->boolean('avaliado')->nullable();
            $table->string('linkGrupoPesquisa');
            $table->string('linkLattesEstudante');
            $table->string('pontuacaoPlanilha');
            $table->date('data')->nullable();
            //Anexos
            $table->string('anexoProjeto');
            $table->string('anexoDecisaoCONSU')->nullable();
            $table->string('anexoPlanilhaPontuacao');
            $table->string('anexoLattesCoordenador');
            $table->string('anexoAutorizacaoComiteEtica');
            //chaves estrangeiras
            $table->unsignedBigInteger('grande_area_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('sub_area_id');
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('coordenador_id');

     * @return void
     */
    public function run()
    {
        DB::table('trabalhos')->insert([
        	'titulo'  			 			=>'Projeto',
        	'linkGrupoPesquisa'	 			=>'link',
        	'linkLattesEstudante'			=>'link',
        	'pontuacaoPlanilha'				=>'link',
            'status'                        =>'aprovado',
        	'data'							=>'2023-04-24',
        	'anexoProjeto'					=>'Álgebra',
        	'anexoDecisaoCONSU'				=>'Álgebra',
        	'anexoPlanilhaPontuacao'		=>'Álgebra',
        	'anexoAutorizacaoComiteEtica'	=>'Álgebra',
        	'anexoLattesCoordenador'		=>'Álgebra',
        	'grande_area_id'				=>1,
        	'area_id'						=>1,
        	'sub_area_id'					=>1,
        	'evento_id'						=>1,
        	'coordenador_id'				=>1,
            'proponente_id'                 =>1,
            'created_at'                    =>'2023-04-24',
            'aprovado'                      =>'1',
            'area_tematica_id'              =>1,
            'updated_at'                    =>'2023-04-24',
        
      	]);
        DB::table('trabalhos')->insert([
            'titulo'                        =>'Projeto 2',
            'linkGrupoPesquisa'             =>'link',
            'linkLattesEstudante'           =>'link',
            'pontuacaoPlanilha'             =>'link',
            'status'                        =>'aprovado',
            'data'                          =>'2020-01-01',
            'area_tematica_id'              =>1,
            'anexoProjeto'                  =>'Álgebra',
            'anexoDecisaoCONSU'             =>'Álgebra',
            'anexoPlanilhaPontuacao'        =>'Álgebra',
            'anexoAutorizacaoComiteEtica'   =>'Álgebra',
            'anexoLattesCoordenador'        =>'Álgebra',
            'grande_area_id'                =>1,
            'area_id'                       =>1,
            'sub_area_id'                   =>1,
            'evento_id'                     =>1,
            'coordenador_id'                =>1,
            'proponente_id'                 =>1,
            'created_at'                    =>'2023-04-24',
            'updated_at'                    =>'2023-04-24',
        
        ]);
    }
}
