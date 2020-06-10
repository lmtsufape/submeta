<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\User;
use App\Participante;
use App\Proponente;

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
            'outro' => ['required_if:vinculo,Outro'],
            'titulacaoMaxima' => ['required_with:anoTitulacao,areaFormacao,bolsistaProdutividade,linkLattes'],
            'titulacaoMaxima' => Rule::requiredIf($data['cargo'] !== 'Estudante' || ($data['cargo'] === 'Estudante' && $data['vinculo'] === 'Pós-doutorando')),
            'anoTitulacao'=> ['required_with:titulacaoMaxima,areaFormacao,bolsistaProdutividade,linkLattes'],
            'anoTitulacao' => Rule::requiredIf($data['cargo'] !== 'Estudante' || ($data['cargo'] === 'Estudante' && $data['vinculo'] === 'Pós-doutorando')),
            'areaFormacao'=> ['required_with:titulacaoMaxima,anoTitulacao,bolsistaProdutividade,linkLattes'],
            'areaFormacao' => Rule::requiredIf($data['cargo'] !== 'Estudante' || ($data['cargo'] === 'Estudante' && $data['vinculo'] === 'Pós-doutorando')),
            'bolsistaProdutividade'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,linkLattes'],            
            'bolsistaProdutividade' => Rule::requiredIf($data['cargo'] !== 'Estudante' || ($data['cargo'] === 'Estudante' && $data['vinculo'] === 'Pós-doutorando')),
            'nivel' => ['required_if:bolsistaProdutividade,sim'],
            'linkLattes'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'linkLattes' => Rule::requiredIf($data['cargo'] !== 'Estudante' || ($data['cargo'] === 'Estudante' && $data['vinculo'] === 'Pós-doutorando')),
            
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
            if($data['SIAPE'] != null){
                $proponente->SIAPE = $data['SIAPE'];
            }
            $proponente->cargo = $data['cargo'];

            if($data['vinculo'] != 'Outro'){
                $proponente->vinculo = $data['vinculo'];
            }else{
                $proponente->vinculo = $data['outro'];
            }

            $proponente->titulacaoMaxima = $data['titulacaoMaxima'];
            $proponente->anoTitulacao = $data['anoTitulacao'];
            $proponente->areaFormacao = $data['areaFormacao'];            
            $proponente->bolsistaProdutividade = $data['bolsistaProdutividade'];
            if($data['bolsistaProdutividade'] == 'sim'){
                $proponente->nivel = $data['nivel'];
            }
            $proponente->linkLattes = $data['linkLattes'];            
            
            $user->proponentes()->save($proponente);
        }
        

        return $user;
    }

    public function showRegistrationForm(){      
        return view('auth.register');
    }
}
