<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    public function index(){

    	return view('participante.index');
    }
}
