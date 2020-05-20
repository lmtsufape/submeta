<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Endereco;
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
            // 'especProfissional' => [],
            'rua' => ['required','string','max:255'],
            'numero' => ['nullable','string'],
            'bairro' => ['required','string','max:255'],
            'cidade' => ['required','string','max:255'],
            'uf' => ['required','string'],
            'cep' => ['required','string'],
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

        // endereço
        $end = new Endereco();
        $end->rua = $data['rua'];
        $end->numero = $data['numero'];
        $end->bairro = $data['bairro'];
        $end->cidade = $data['cidade'];
        $end->uf = $data['uf'];
        $end->cep = $data['cep'];

        $end->save();
        // dd($end)

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->cpf = $data['cpf'];
        $user->celular = $data['celular'];
        $user->instituicao = $data['instituicao'];

        $user->enderecoId = $end->id;
        $user->save();

        return $user;
    }
}
