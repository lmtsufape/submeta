<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Participante;
use App\Proponente;
use App\GrandeArea;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {



        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cpf' => ['required', 'cpf'],
            'celular' => ['required','string'],
            'instituicao' => ['required','string','max:255'],     
            'cargo' => ['required'],
            'vinculo' => ['required'],

            'titulacaoMaxima' => ['required_with:anoTitulacao,areaFormacao,grandeArea,area,subarea,bolsistaProdutividade,linkLattes'],
            'anoTitulacao'=> ['required_with:titulacaoMaxima,areaFormacao,grandeArea,area,subarea,bolsistaProdutividade,linkLattes'],
            'areaFormacao'=> ['required_with:titulacaoMaxima,anoTitulacao,grandeArea,area,subarea,bolsistaProdutividade,linkLattes'],
            'grandeArea'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,area,subarea,bolsistaProdutividade,linkLattes'],
            'area'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,grandeArea,subarea,bolsistaProdutividade,linkLattes'],
            'subarea'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,grandeArea,area,bolsistaProdutividade,linkLattes'],
            'bolsistaProdutividade'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,grandeArea,area,subarea,linkLattes'],            
            'linkLattes'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,grandeArea,area,subarea,bolsistaProdutividade'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //dd($data);
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->cpf = $data['cpf'];
        $user->celular = $data['celular'];
        $user->instituicao = $data['instituicao'];

        if($data['cargo'] === "Estudante" && $data['vinculo'] !== "Pós-doutorando"){
            $user->tipo = 'participante';
            $user->save();

            $participante = new Participante();
            $user->participantes()->save($participante);
        }else{
            $user->tipo = 'proponente';
            $user->save();

            $proponente = new Proponente();
            $proponente->SIAPE = $data['SIAPE'];
            $proponente->cargo = $data['cargo'];
            $proponente->vinculo = $data['vinculo'];
            $proponente->titulacaoMaxima = $data['titulacaoMaxima'];
            $proponente->anoTitulacao = $data['anoTitulacao'];
            $proponente->areaFormacao = $data['areaFormacao'];
            $proponente->grandeArea = $data['grandeArea'];
            $proponente->area = $data['area'];
            $proponente->subArea = $data['subarea'];
            $proponente->bolsistaProdutividade = $data['bolsistaProdutividade'];
            $proponente->nivel = $data['nivel'];
            $proponente->linkLattes = $data['linkLattes'];            
            
            $user->proponentes()->save($proponente);
        }
        

        return $user;
    }

    public function showRegistrationForm(){        
        $grandesAreas = GrandeArea::orderBy('nome')->get();
        return view('auth.register')->with(['grandeAreas' => $grandesAreas]);
    }
}
