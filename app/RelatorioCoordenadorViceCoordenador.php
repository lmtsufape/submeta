<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatorioCoordenadorViceCoordenador extends Model
{
    protected $table = 'relatorio_coordenador_e_vicecoordenadors';

    protected $fillable = [
        'tipo',
        'nome',
        'cpf',
        'telefone',
        'email_institucional',
        'cargo',
        'curso_setor',
        'ch_total_atuacao',
        'relatorio_id',
    ];

    protected $casts = [
        'tipo' => 'string',
    ];

    public function relatorio()
    {
        return $this->belongsTo(Relatorio::class);
    }

    public function setAttributesCoordenador($request, $relatorio_id)
    {
        $this->tipo = 'Coordenador/a';
        $this->nome = $request['nome_coordenador'];
        $this->email_institucional = $request['email_institucional_coordenador'];
        $this->cargo = $request['cargo_coordenador'];
        $this->curso_setor = $request['curso_coordenador'];
        $this->cpf = $request['cpf_coordenador'];
        $this->telefone = $request['telefone_coordenador'];
        $this->ch_total_atuacao = $request['ch_coordenador'];
        $this->relatorio_id = $relatorio_id;

    }

    public function setAttributesViceCoordenador($request, $relatorio_id)
    {
        $this->tipo = 'Vice-Coordenador/a';
        $this->nome = $request['nome_vice_coord'];
        $this->email_institucional = $request['email_institucional_vice_coord'];
        $this->cargo = $request['cargo_vice_coord'];
        $this->curso_setor = $request['curso_vice_coord'];
        $this->cpf = $request['cpf_vice_coord'];
        $this->telefone = $request['telefone_vice_coord'];
        $this->ch_total_atuacao = $request['ch_vice_coord'];
        $this->relatorio_id = $relatorio_id;
    }
}
