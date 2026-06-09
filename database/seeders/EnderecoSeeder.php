<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnderecoSeeder extends Seeder
{
    public function run()
    {
        $enderecos = [
            ['id' => 1,  'user_id' => 1],
            ['id' => 2,  'user_id' => 2],
            ['id' => 3,  'user_id' => 3],
            ['id' => 4,  'user_id' => 4],
            ['id' => 5,  'user_id' => 5],
            ['id' => 6,  'user_id' => 7],
            ['id' => 7,  'user_id' => 8],
            ['id' => 8,  'user_id' => 9],
            ['id' => 9,  'user_id' => 12],
        ];

        foreach ($enderecos as $i => $map) {
            $num = $i + 1;
            DB::table('enderecos')->insert([
                'id'         => $map['id'],
                'rua'        => 'Rua Semente ' . $num,
                'numero'     => (string)(100 + $num),
                'bairro'     => 'Bairro Teste',
                'cidade'     => 'Recife',
                'uf'         => 'PE',
                'cep'        => '50010-040',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('users')
                ->where('id', $map['user_id'])
                ->update(['enderecoId' => $map['id']]);
        }
    }
}