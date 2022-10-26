<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nome',
    ];

    public function proponentes()
    {
        return $this->belongsToMany('App\Proponente', 'proponentes_cursos', 'curso_id');
    }
}
