<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjetivoDeDesenvolvimentoSustentavel extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nome',
    ];

    public function trabalhos(){
        return $this->belongsToMany('App\Trabalho', 'objetivo_de_desenvolvimento_sustentavel_trabalhos', 'objetivo_de_desenvolvimento_sustentavel_id');
    }
}
