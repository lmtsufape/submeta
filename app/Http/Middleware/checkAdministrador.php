<?php

namespace App\Http\Middleware;

use Closure;

class checkAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(!Auth::check()){
        return redirect('/')->with('error', 'É necessário estar logado para utilizar esta funcionalidade');
      }
      if(Auth::user()->tipo=='administrador'){
        return $next($request);
      }
      else{
        return redirect('home')->with('error', 'Você não possui privilégios para acessa esta funcionalidade');
      }
    }
}
