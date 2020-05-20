<?php

namespace App\Policies;

use App\User;
use App\Evento;
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
      return $user->id === $evento->coordenador->id;
    }
}
