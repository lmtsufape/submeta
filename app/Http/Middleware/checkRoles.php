<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Support\Facades\Log;

class checkRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        if(!Auth::check()){
            Log::debug('checkRoles');
            return redirect('/');
        }

        $user = Auth::user();
        /*
        if($user->tipo == 'administrador'){
            return $next($request);
        }*/

        foreach($roles as $role){
            if($user->tipo == $role){
                return $next($request);
            }
        }

        return redirect('home')->with('error', 'Você não possui privilégios para acessar esta funcionalidade');
    }

}
