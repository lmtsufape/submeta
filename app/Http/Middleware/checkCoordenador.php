<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Support\Facades\Log;

class checkCoordenador{
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
            Log::debug('checkCoordenador');
             return redirect('/');
          }
          if(Auth::user()->tipo=='coordenador'){
            return $next($request);
          }
          else{
            return redirect('home')->with('error', 'Você não possui privilégios para acessa esta funcionalidade');
          }
    }
}