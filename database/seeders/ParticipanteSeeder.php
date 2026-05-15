<?php

use App\Participante;
use Illuminate\Database\Seeder;

class ParticipanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')
            ->where('tipo', 'participante')
            ->pluck('id')
            ->toArray();

        // pega trabalhos com seu evento
        $trabalhos = DB::table('trabalhos')
            ->select('id', 'evento_id')
            ->get();

        // mapa: evento_id → limite de participantes
        $eventos = DB::table('eventos')
            ->pluck('numParticipantes', 'id')
            ->toArray();
        // contador por trabalho
        $contador = [];
        foreach ($trabalhos as $trab) {
            $contador[$trab->id] = 0;
        }

        foreach ($users as $userId) {

            foreach ($trabalhos as $trab) { //percorre trabalhos

                $limite = $eventos[$trab->evento_id] ?? 1; //da limite de partc.

                if ($contador[$trab->id] < $limite) {

                    DB::table('participantes')->insert([
                        'user_id' => $userId,
                        'trabalho_id' => $trab->id,
                    ]);
                    $contador[$trab->id]++;
                    break;
                }
            }
        }
    }
}
