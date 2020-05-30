<?php

namespace App\Policies;

use App\User;
use App\Evento;
use App\CoordenadorComissao;
use App\AdministradorResponsavel;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function isCoordenador(User $user, Evento $evento){

        
        if( Auth()->user()->coordenadorComissao != null ){
            return $evento->criador_id == Auth()->user()->coordenadorComissao->first()->id;
        }else{
            return false;
        }
        
    
    }
}
