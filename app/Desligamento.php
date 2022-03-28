<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desligamento extends Model
{
	protected $fillable = [
        'status',
        'justificativa',
        'participante_id',
        'trabalho_id',
    ];

    public const STATUS_ENUM = [
        'solicitado'     => 1,
        'aceito'         => 2,
        'recusado'       => 3,
    ];

    public function participante(){
        return $this->belongsTo(Participante::class, 'participante_id', 'id');
    }

    public function trabalho(){
        return $this->belongsTo(Trabalho::class, 'trabalho_id', 'id');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case Desligamento::STATUS_ENUM['solicitado']:
                return 'Solicitado';
                break;
            case Desligamento::STATUS_ENUM['aceito']:
                return 'Aceito';
                break;
            case Desligamento::STATUS_ENUM['recusado']:
                return 'Recusado';
                break;
            default:
                break;
        }
    }
}
