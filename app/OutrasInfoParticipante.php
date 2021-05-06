<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutrasInfoParticipante extends Model
{
    protected $fillable = ['name', 'user_id', 'trabalho_id', 'participante_id'];
    public const ENUM_TURNO = ['Matutino',  'Vespertino', 'Noturno', 'Integral'];
}
