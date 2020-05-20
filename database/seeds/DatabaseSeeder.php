<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('enderecos')->insert([  // 1
          'rua' => 'a',
          'numero' => 1,
          'bairro' => 'b',
          'cidade' => 'c',
          'uf'     => 'd',
          'cep'    => 2,
        ]);

        DB::table('enderecos')->insert([  // 1
          'rua' => 'R. Manoel Clemente',
          'numero' => '161',
          'bairro' => 'Santo Antônio',
          'cidade' => 'Garanhuns',
          'uf'     => 'PE',
          'cep'    => '55293-040',
        ]);

        DB::table('users')->insert([  //
          'name' => 'coord',
          'email' => 'teste@teste',
          'password' => bcrypt('12345678'),
          'cpf' => 123132131,
          'instituicao'     => 'd',
          'celular'    => 2,
          'especProfissional' => 'e',
          'enderecoId' => 1,
          'email_verified_at' => '2020-02-15',
        ]);

        DB::table('users')->insert([  //
          'name' => 'Felipe',
          'email' => 'felipeaquac@yahoo.com.br',
          'password' => bcrypt('guedes80'),
          'cpf' => '999.999.999-99',
          'instituicao'     => 'UFAPE',
          'celular'    => '(99) 99999-9999',
          'especProfissional' => ' ',
          'enderecoId' => 1,
          'email_verified_at' => '2020-02-15',
        ]);

        DB::table('eventos')->insert([
          'nome'=>'II CONGRESSO REGIONAL DE ZOOTECNIA',
          // 'numeroParticipantes'=>60,
          'descricao'=>'Cada autor inscrito poderá submeter até dois (2) resumos;
O número máximo de autores por trabalho será seis autores;
Os trabalhos deverão ser submetidos na forma de resumo simples com no máximo uma (01) página, no formato PDF;',
          'tipo'=>'teste',
          'dataInicio'=>'2020-07-01',
          'dataFim'=>'2020-07-03',
          'inicioSubmissao'=>'2020-03-30',
          'fimSubmissao'=>'2020-04-20',
          'inicioRevisao'=>'2020-04-21',
          'fimRevisao'=>'2020-05-21',
          'inicioResultado'=>'2020-05-22',
          'fimResultado'=>'2020-05-23',
          'numMaxTrabalhos' => 2,
          'numMaxCoautores' => 5,
          // 'possuiTaxa'=>true,
          // 'valorTaxa'=>10,
          'enderecoId'=>2,
          'coordenadorId'=>1,
          'hasResumo'=>false,
        ]);

        $areasEventoZoo = [
                            'Produção e nutrição de ruminantes',
                            'Produção e nutrição de não-ruminantes',
                            'Reprodução e melhoramento de ruminantes',
                            'Reprodução e melhoramento de não-ruminantes',
                            'Tecnologia de produtos de origem animal',
                            'Nutrição e Criação de Animais Pet',
                            'Apicultura e Meliponicultura',
                            'Animais Silvestres',
                            'Extensão rural e Desenvolvimento Sustentável',
                            'Forragicultura'
                          ];

        for($i = 0; $i < sizeof($areasEventoZoo); $i++){
          DB::table('areas')->insert([
            'nome'      => $areasEventoZoo[$i],
            'eventoId'  => 1,
          ]);
        }

        DB::table('modalidades')->insert([
          'nome' => 'Resumo'
        ]);

        for($i = 0; $i < sizeof($areasEventoZoo); $i++){
          DB::table('area_modalidades')->insert([
            'areaId'       => $i + 1,
            'modalidadeId' => 1,
          ]);
        }


        for($i = 0; $i < 40; $i++){
          DB::table('users')->insert([  //
            'name' => 'teste',
            'email' => 'teste@teste'.$i,
            'password' => bcrypt('12345678'),
            'cpf' => ''.$i,
            'instituicao'     => 'd',
            'celular'    => 2,
            'especProfissional' => 'e',
            'enderecoId' => 1,
          ]);

          if($i < 20){
            DB::table('trabalhos')->insert([
              'titulo' => 'trabalho' . $i,
              'autores' => '-',
              'data'  => '2020-02-15',
              'modalidadeId'  => 1,
              'areaId'  => 1,
              'autorId' => $i+2,
              'eventoId' => 1,
              'avaliado' => 'nao'
            ]);
          }
          if($i >= 20 && $i < 30){
            DB::table('trabalhos')->insert([
              'titulo' => 'trabalho' . $i,
              'autores' => '-',
              'data'  => '2020-02-15',
              'modalidadeId'  => 1,
              'areaId'  => 2,
              'eventoId' => 1,
              'autorId' => $i+2,
              'avaliado' => 'nao'
            ]);
          }
          if($i >= 30){
            DB::table('trabalhos')->insert([
              'titulo' => 'trabalho' . $i,
              'autores' => '-',
              'data'  => '2020-02-15',
              'modalidadeId'  => 1,
              'areaId'  => 3,
              'eventoId' => 1,
              'autorId' => $i+2,
              'avaliado' => 'nao'
            ]);
          }

        }

        DB::table('users')->insert([  //
          'name' => 'eu',
          'email' => 'asd@asd',
          'password' => bcrypt('12345678'),
          'cpf' => 123132131,
          'instituicao'     => 'd',
          'celular'    => 2,
          'especProfissional' => 'e',
          'email_verified_at' => '2020-02-15',
          'enderecoId' => 1,
        ]);
    }
}
