<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoRelatorio extends Model
{
    protected $fillable = [
        'tipo', 'comentario', 'nota', 'user_id', 'arquivo_id'
    ];

    public function plano(){
        return $this->belongsTo(Arquivo::class, 'arquivo_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
