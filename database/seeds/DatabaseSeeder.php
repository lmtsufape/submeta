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

        $this->call(UsuarioSeeder::class);
        $this->call(AdministradorSeeder::class);
        $this->call(AdministradorResponsavelSeeder::class);
        $this->call(ProponenteSeeder::class);
        $this->call(GrandeAreaSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(SubAreaSeeder::class);
        $this->call(FuncaoParticipanteSeeder::class);
        $this->call(CoordenadorComissaoSeeder::class);
        $this->call(ParticipanteSeeder::class);
        $this->call(NaturezaSeeder::class);
        $this->call(RecomendacaoSeeder::class);
        $this->call(AvaliadorSeeder::class);
        $this->call(AreaTematicaSeeder::class);
        $this->call(CursoSeeder::class);
        
        // $this->call(UsersTableSeeder::class);

//         DB::table('enderecos')->insert([  // 1
//           'rua' => 'a',
//           'numero' => 1,
//           'bairro' => 'b',
//           'cidade' => 'c',
//           'uf'     => 'd',
//           'cep'    => 2,
//         ]);

//         DB::table('enderecos')->insert([  // 1
//           'rua' => 'R. Manoel Clemente',
//           'numero' => '161',
//           'bairro' => 'Santo Antônio',
//           'cidade' => 'Garanhuns',
//           'uf'     => 'PE',
//           'cep'    => '55293-040',
//         ]);

//         DB::table('users')->insert([  //
//           'name' => 'coord',
//           'email' => 'teste@teste',
//           'password' => bcrypt('12345678'),
//           'cpf' => 123132131,
//           'instituicao'     => 'd',
//           'celular'    => 2,
//           'especProfissional' => 'e',
//           'enderecoId' => 1,
//           'email_verified_at' => '2020-02-15',
//         ]);

//         DB::table('users')->insert([  //
//           'name' => 'Felipe',
//           'email' => 'felipeaquac@yahoo.com.br',
//           'password' => bcrypt('guedes80'),
//           'cpf' => '999.999.999-99',
//           'instituicao'     => 'UFAPE',
//           'celular'    => '(99) 99999-9999',
//           'especProfissional' => ' ',
//           'enderecoId' => 1,
//           'email_verified_at' => '2020-02-15',
//         ]);

        // DB::table('eventos')->insert([
        //   'nome'=>'I CONGRESSO REGIONAL DE ZOOTECNIA',
        //   // 'numeroParticipantes'=>60,
        //   'descricao'=>'Cada autor inscrito poderá submeter até dois (2) resumos;
        //    O número máximo de autores por trabalho será seis autores;
        //    Os trabalhos deverão ser submetidos na forma de resumo simples com no máximo uma (01) página, no formato PDF;',
        //   'tipo'=>'PIBIC',
        //   'natureza_id'=>'1',
        //   'inicioSubmissao'=>'2020-03-30',
        //   'fimSubmissao'=>'2020-09-20',
        //   'inicioRevisao'=>'2020-04-21',
        //   'fimRevisao'=>'2020-07-21',
        //   'resultado'=>'2020-07-22',
        //   'numMaxTrabalhos' => 2,
        //   'numMaxCoautores' => 5,
        //   'coordenadorId'=>1,
        //   'created_at'=>'2020-03-30',
        //   'criador_id'=>1,
        // ]);

        // DB::table('eventos')->insert([
        //   'nome'=>'II CONGRESSO REGIONAL DE ZOOTECNIA',
        //   // 'numeroParticipantes'=>60,
        //   'descricao'=>'Cada autor inscrito poderá submeter até dois (2) resumos;
        //    O número máximo de autores por trabalho será seis autores;
        //    Os trabalhos deverão ser submetidos na forma de resumo simples com no máximo uma (01) página, no formato PDF;',
        //   'tipo'=>'PIBIC',
        //   'natureza_id'=>'2',
        //   'inicioSubmissao'=>'2020-03-30',
        //   'fimSubmissao'=>'2020-09-20',
        //   'inicioRevisao'=>'2020-04-21',
        //   'fimRevisao'=>'2020-05-21',
        //   'resultado'=>'2020-05-22',
        //   'numMaxTrabalhos' => 2,
        //   'numMaxCoautores' => 5,
        //   'coordenadorId'=>1,
        //   'criador_id'=>2,
        // ]);

        // DB::table('eventos')->insert([
        //   'nome'=>'III CONGRESSO REGIONAL DE ZOOTECNIA',
        //   // 'numeroParticipantes'=>60,
        //   'descricao'=>'Cada autor inscrito poderá submeter até dois (2) resumos;
        //    O número máximo de autores por trabalho será seis autores;
        //    Os trabalhos deverão ser submetidos na forma de resumo simples com no máximo uma (01) página, no formato PDF;',
        //   'tipo'=>'PIBIC',
        //   'natureza_id'=>'3',
        //   'inicioSubmissao'=>'2020-03-30',
        //   'fimSubmissao'=>'2020-09-20',
        //   'inicioRevisao'=>'2020-04-21',
        //   'fimRevisao'=>'2020-05-21',
        //   'resultado'=>'2020-05-22',
        //   'numMaxTrabalhos' => 2,
        //   'numMaxCoautores' => 5,
        //   'coordenadorId'=>1,
        //   'criador_id'=>3,
        // ]);

//         $areasEventoZoo = [
//                             'Produção e nutrição de ruminantes',
//                             'Produção e nutrição de não-ruminantes',
//                             'Reprodução e melhoramento de ruminantes',
//                             'Reprodução e melhoramento de não-ruminantes',
//                             'Tecnologia de produtos de origem animal',
//                             'Nutrição e Criação de Animais Pet',
//                             'Apicultura e Meliponicultura',
//                             'Animais Silvestres',
//                             'Extensão rural e Desenvolvimento Sustentável',
//                             'Forragicultura'
//                           ];


        //$this->call(TrabalhoSeeder::class);
        //$this->call(AvaliadorSeeder::class);
    }
}
