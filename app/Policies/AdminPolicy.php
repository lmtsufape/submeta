<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
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

    public function isAdministrador(User $user) {
        return $user->tipo === "administrador";
    }

    public function isAdminResp(User $user) {
        return $user->tipo === "administradorResponsavel";
    }
}
