<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentacaoComplementar extends Model
{
    protected $fillable = [
        'termoCompromisso',
        'comprovanteMatricula',
        'linkLattes',
        'pdfLattes',


        'participante_id',
    ];

    public function participante(){
       return $this->belongsTo(Participante::class, 'participante_id', 'id');
    }
}
