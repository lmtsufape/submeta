<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrabalhoUser extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function funcao(){
        return $this->belongsTo('App\FuncaoParticipantes', 'funcao_participante_id');
    }
}
