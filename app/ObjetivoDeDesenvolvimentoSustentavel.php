<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjetivoDeDesenvolvimentoSustentavel extends Model
{
    protected $fillable = [
        'nome',
    ];

    public function trabalhos(){
        return $this->belongsToMany('App\Trabalho', 'objetivo_de_desenvolvimento_sustentavel_trabalhos', 'objetivo_de_desenvolvimento_sustentavel_id');
    }
}
