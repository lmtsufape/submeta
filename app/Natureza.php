<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Natureza extends Model
{
    public function projetos() {
        return $this->hasMany('App\Evento');
    }

    public function avaliadors(){
        return $this->belongsToMany('App\Avaliador', 'naturezas_avaliadors', 'natureza_id');
    }
}
