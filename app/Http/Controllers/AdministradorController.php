<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function index(){

    	return view('administrador.index');
    }
    public function naturezas(){

    	return view('naturezas.index');
    }
    public function usuarios(){

    	return view('administrador.usuarios');
    }
}
