<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuncaoParticipantes extends Model
{
    public function participantes() {
        return $this->hasMany("\App\Participante", 'funcao_participante_id');
    }
}
