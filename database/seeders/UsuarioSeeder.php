<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([

            // =====================
            // ADMIN
            // =====================
            [
                'id'         => 1,
                'name'       => '[ADMIN]',
                'email'      => 'admin@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'administrador',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '952.223.400-15',
                'celular'    => '(81) 99999-0001',
                'instituicao'=> 'UFAPE',
            ],

            // =====================
            // COORDENADORES
            // =====================
            [
                'id'         => 2,
                'name'       => '[COORDENADOR][1]',
                'email'      => 'coord1@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'coordenador',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '441.516.320-34',
                'celular'    => '(81) 99999-0001',
                'instituicao'=> 'UFAPE',
            ],
            [
                'id'         => 3,
                'name'       => '[COORDENADOR][2]',
                'email'      => 'coord2@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'coordenador',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '515.056.480-09',
                'celular'    => '(81) 99999-0002',
                'instituicao'=> 'UFAPE',
            ],

            // =====================
            // PROPONENTES
            // =====================
            [
                'id'         => 4,
                'name'       => '[PROPONENTE][1]',
                'email'      => 'prop1@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'proponente',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '467.006.680-34',
                'celular'    => '(81) 99999-0003',
                'instituicao'=> 'UFAPE',
            ],
            [
                'id'         => 5,
                'name'       => '[PROPONENTE][2]',
                'email'      => 'prop2@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'proponente',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '461.295.810-17',
                'celular'    => '(81) 99999-0004',
                'instituicao'=> 'UFAPE',
            ],

            // =====================
            // PARTICIPANTES
            // =====================
            [
                'id'         => 7,
                'name'       => '[PARTICIPANTE][1]',
                'email'      => 'part1@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'participante',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '211.582.360-50',
                'celular'    => '(81) 99999-0005',
                'instituicao'=> 'UFAPE',
            ],
            [
                'id'         => 8,
                'name'       => '[PARTICIPANTE][2]',
                'email'      => 'part2@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'participante',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '315.837.350-54',
                'celular'    => '(81) 99999-0006',
                'instituicao'=> 'UFAPE',
            ],

            // =====================
            // AVALIADORES
            // =====================
            [
                'id'         => 9,
                'name'       => '[AVALIADOR][1]',
                'email'      => 'aval1@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'avaliador',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '252.581.000-73',
                'celular'    => '(81) 99999-0007',
                'instituicao'=> 'UFAPE',
            ],

            // =====================
            // ADMIN RESPONSÁVEL
            // =====================
            [
                'id'         => 12,
                'name'       => '[ADMIN_RESPONSAVEL]',
                'email'      => 'adminresp@ufape.br',
                'password'   => Hash::make('10203040'),
                'tipo'       => 'administradorResponsavel',
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
                'cpf'        => '982.515.170-60',
                'celular'    => '(81) 99999-0008',
                'instituicao'=> 'UFAPE',
            ],
        ]);
    }
}