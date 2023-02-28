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
use App\Endereco;
use App\Rules\UrlValidacao;
use App\Curso;

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
        if ($data['perfil'] == "Estudante")
        {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'cpf' => ['required', 'cpf', 'unique:users'],
                'rg' => ['required', 'unique:participantes'],
                'celular' => ['required', 'string', 'telefone'],
                'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
                'instituicaoSelect' => ['required_without:instituicao'],
                'outroCursoEstudante' => ['required_if:cursoEstudante,Outro', 'max:255'],
                'cursoEstudante' => ['required_without:outroCursoEstudante'],
                'perfil' => ['required'],
                'linkLattes' => ['required'],                
            ]);
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cpf' => ['required', 'cpf', 'unique:users'],
            'rg' => ['required', 'unique:participantes'],
            'celular' => ['required', 'string', 'telefone'],
            'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
            'instituicaoSelect' => ['required_without:instituicao'],
            'perfil' => ['required'],
            'vinculo' => ['required'],
            'outro' => ['required_if:vinculo,Outro'],
            'titulacaoMaxima' => ['required_with:anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'titulacaoMaxima' => Rule::requiredIf((isset($data['perfil']) && $data['perfil'] !== 'Estudante') || (isset($data['perfil']) && $data['perfil'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'anoTitulacao' => ['required_with:titulacaoMaxima,areaFormacao,bolsistaProdutividade,linkLattes'],
            'anoTitulacao' => Rule::requiredIf((isset($data['perfil']) && $data['perfil'] !== 'Estudante') || (isset($data['perfil']) && $data['perfil'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'areaFormacao' => ['required_with:titulacaoMaxima,anoTitulacao,bolsistaProdutividade,linkLattes'],
            'areaFormacao' => Rule::requiredIf((isset($data['perfil']) && $data['perfil'] !== 'Estudante') || (isset($data['perfil']) && $data['perfil'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'bolsistaProdutividade' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,linkLattes'],
            'bolsistaProdutividade' => Rule::requiredIf((isset($data['perfil']) && $data['perfil'] !== 'Estudante') || (isset($data['perfil']) && $data['perfil'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'nivel' => ['required_if:bolsistaProdutividade,sim'],
            //'nivel' => [(isset($data['perfil']) && $data['perfil'] !== 'Estudante') || (isset($data['perfil']) && $data['perfil'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],            
            'linkLattes' => [(isset($data['perfil']) && $data['perfil'] !== 'Estudante') || (isset($data['perfil']) && $data['perfil'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => [(isset($data['perfil']) && $data['perfil'] !== 'Estudante') || (isset($data['perfil']) && $data['perfil'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'link_lattes':''],

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
        $participante = new Participante();
        $participante->rg = $data['rg'];
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->cpf = $data['cpf'];
        $user->celular = $data['celular'];

        if ($data['instituicao'] != null) {
            $user->instituicao = $data['instituicao'];
        } else if (isset($data['instituicaoSelect']) && $data['instituicaoSelect'] != "Outra") {
            $user->instituicao = $data['instituicaoSelect'];
        }

        if ($data['perfil'] === "Estudante"){
            $user->tipo = 'participante';

            $endereco = new Endereco();
            $endereco->cep = $data['cep'];
            $endereco->uf = $data['uf'];
            $endereco->cidade = $data['cidade'];
            $endereco->rua = $data['rua'];
            $endereco->numero = $data['numero'];
            $endereco->bairro = $data['bairro'];
            $endereco->complemento = $data['complemento'];
            $endereco->save();

            $participante->data_de_nascimento = $data['data_de_nascimento'];
            $participante->linkLattes = $data['linkLattes'];

            if ($data['outroCursoEstudante'] != null) {
                $participante->curso = $data['outroCursoEstudante'];
            } else if (isset($data['cursoEstudante']) && $data['cursoEstudante'] != "Outro") {
                $participante->curso_id = $data['cursoEstudante'];
            }

            $user->save();
            $user->participantes()->save($participante);
            $endereco->user()->save($user);

        } else {

            $user->tipo = 'proponente';
            $user->save();

            $proponente = new Proponente();
            $proponente->cargo = $data['perfil'];
            $proponente->titulacaoMaxima = $data['titulacaoMaxima'];
            $proponente->anoTitulacao = $data['anoTitulacao'];
            $proponente->areaFormacao = $data['areaFormacao'];
            $proponente->bolsistaProdutividade = $data['bolsistaProdutividade'];
            $proponente->linkLattes = $data['linkLattes'];

            if ($data['vinculo'] != 'Outro') {
                $proponente->vinculo = $data['vinculo'];
            } else {
                $proponente->vinculo = $data['outro'];
            }

            if ($data['SIAPE'] != null) {
                $proponente->SIAPE = $data['SIAPE'];
            }

            if ($data['bolsistaProdutividade'] == 'sim') {
                $proponente->nivel = $data['nivel'];
            }            
            
            $user->proponentes()->save($proponente);
            $user->participantes()->save($participante);

            if($data['perfil'] == 'Professor'){
                $proponente->cursos()->sync($data['curso']);
            }
        }
        
        return $user;
    }

    public function showRegistrationForm()
    {
        $cursos = Curso::orderBy('nome')->get();
        return view('auth.register', compact('cursos'));
    }
}
