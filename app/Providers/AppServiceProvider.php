<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('cpf', '\App\Utils\CpfValidation@validate');    
        Validator::extend('link_lattes', '\App\Utils\LattesValidation@validate', 'Link inválido');
        Validator::extend('link_grupo', '\App\Utils\GrupoPesquisaValidation@validate', 'Link inválido');
        Validator::extend('planilha', '\App\Utils\ExtensaoValidation@validate', 'Extensão do arquivo é inválida');
    }
}
