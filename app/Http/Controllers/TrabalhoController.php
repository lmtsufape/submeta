<?php

namespace App\Http\Controllers;

use App\Trabalho;
use App\Coautor;
use App\Evento;
use App\User;
use App\AreaModalidade;
use App\Area;
use App\Revisor;
use App\Modalidade;
use App\Atribuicao;
use App\Arquivo;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailParaUsuarioNaoCadastrado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\SubmissaoTrabalho;

class TrabalhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $evento = Evento::find($id);
        $areas = Area::where('eventoId', $evento->id)->get();
        $areasId = Area::where('eventoId', $evento->id)->select('id')->get();
        $revisores = Revisor::where('eventoId', $evento->id)->get();
        $modalidades = Modalidade::all();        
        $areaModalidades = AreaModalidade::whereIn('areaId', $areasId)->get();        
        $areasEnomes = Area::wherein('id', $areasId)->get();
        $modalidadesIDeNome = [];
        foreach ($areaModalidades as $key) {
          array_push($modalidadesIDeNome,['areaId' => $key->area->id,
                                          'modalidadeId' => $key->modalidade->id,
                                          'modalidadeNome' => $key->modalidade->nome]);
        }

        $trabalhos = Trabalho::where('autorId', Auth::user()->id)->whereIn('areaId', $areasId)->get();
        // dd($evento);
        return view('evento.submeterTrabalho',[
                                              'evento'          => $evento,
                                              'areas'           => $areas,
                                              'revisores'       => $revisores,
                                              'modalidades'     => $modalidades,
                                              'areaModalidades' => $areaModalidades,
                                              'trabalhos'       => $trabalhos,
                                              'areasEnomes'     => $areasEnomes,
                                              'modalidadesIDeNome'     => $modalidadesIDeNome,
                                            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
      $mytime = Carbon::now('America/Recife');
      $mytime = $mytime->toDateString();
      $evento = Evento::find($request->eventoId);
      if($evento->inicioSubmissao > $mytime){
        if($mytime >= $evento->fimSubmissao){
            return redirect()->route('home');
        }
      }
      $validatedData = $request->validate([
        'nomeTrabalho'      => ['required', 'string',],
        'areaId'            => ['required', 'integer'],
        'modalidadeId'      => ['required', 'integer'],
        'eventoId'          => ['required', 'integer'],
        'resumo'            => ['nullable','string'],
        'nomeCoautor.*'     => ['string'],
        'emailCoautor.*'    => ['string'],
        'arquivo'           => ['required', 'file', 'mimes:pdf', 'max:2000000'],
      ]);


      $autor = Auth::user();
      $trabalhosDoAutor = Trabalho::where('eventoId', $request->eventoId)->where('autorId', Auth::user()->id)->count();
      $areaModalidade = AreaModalidade::where('areaId', $request->areaId)->where('modalidadeId', $request->modalidadeId)->first();
      Log::debug('Numero de trabalhos' . $evento);
      if($trabalhosDoAutor >= $evento->numMaxTrabalhos){
        return redirect()->back()->withErrors(['numeroMax' => 'Número máximo de trabalhos permitidos atingido.']);
      }

      if($request->emailCoautor != null){
        $i = 0;
        foreach ($request->emailCoautor as $key) {
          $i++;
        }
        if($i > $evento->numMaxCoautores){
          return redirect()->back()->withErrors(['numeroMax' => 'Número de coautores deve ser menor igual a '.$evento->numMaxCoautores]);
        }
      }

      if($request->emailCoautor != null){
        $i = 0;
        foreach ($request->emailCoautor as $key) {
          $userCoautor = User::where('email', $key)->first();
          if($userCoautor == null){
            $passwordTemporario = Str::random(8);
            Mail::to($key)->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, '  ', 'Coautor', $evento->nome, $passwordTemporario));
            $usuario = User::create([
              'email' => $key,
              'password' => bcrypt($passwordTemporario),
              'usuarioTemp' => true,
              'name' => $request->nomeCoautor[$i],
            ]);
          }
          $i++;
        }
      }

      $trabalho = Trabalho::create([
        'titulo' => $request->nomeTrabalho,
        'modalidadeId'  => $areaModalidade->modalidade->id,
        'areaId'  => $areaModalidade->area->id,
        'autorId' => $autor->id,
        'eventoId'  => $evento->id,
        'avaliado' => 'nao'
      ]);

      if($request->emailCoautor != null){
        foreach ($request->emailCoautor as $key) {
          $userCoautor = User::where('email', $key)->first();
          Coautor::create([
            'ordem' => '-',
            'autorId' => $userCoautor->id,
            'trabalhoId'  => $trabalho->id,
          ]);
        }
      }

      $file = $request->arquivo;
      $path = 'trabalhos/' . $request->eventoId . '/' . $trabalho->id .'/';
      $nome = "1.pdf";
      Storage::putFileAs($path, $file, $nome);

      $arquivo = Arquivo::create([
        'nome'  => $path . $nome,
        'trabalhoId'  => $trabalho->id,
        'versaoFinal' => true,
      ]);
      $subject = "Submissão de Trabalho";
      Mail::to($autor->email)
            ->send(new SubmissaoTrabalho($autor, $subject));
      if($request->emailCoautor != null){
        foreach ($request->emailCoautor as $key) {
          $userCoautor = User::where('email', $key)->first();
          Mail::to($userCoautor->email)
            ->send(new SubmissaoTrabalho($userCoautor, $subject));
        }
      }

      return redirect()->route('evento.visualizar',['id'=>$request->eventoId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trabalho  $trabalho
     * @return \Illuminate\Http\Response
     */
    public function show(Trabalho $trabalho)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trabalho  $trabalho
     * @return \Illuminate\Http\Response
     */
    public function edit(Trabalho $trabalho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trabalho  $trabalho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trabalho $trabalho)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trabalho  $trabalho
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trabalho $trabalho)
    {
        //
    }

    public function novaVersao(Request $request){
      $mytime = Carbon::now('America/Recife');
      $mytime = $mytime->toDateString();
      $evento = Evento::find($request->eventoId);
      if($evento->inicioSubmissao > $mytime){
        if($mytime >= $evento->fimSubmissao){
            return redirect()->route('home');
        }
      }
      $validatedData = $request->validate([
        'arquivo' => ['required', 'file', 'mimes:pdf'],
        'eventoId' => ['required', 'integer'],
        'trabalhoId' => ['required', 'integer'],
      ]);

      $trabalho = Trabalho::find($request->trabalhoId);

      if(Auth::user()->id != $trabalho->autorId){
        return redirect()->route('home');
      }

      $arquivos = $trabalho->arquivo;
      $count = 1;
      foreach ($arquivos as $key) {
        $key->versaoFinal = false;
        $key->save();
        $count++;
      }

      $file = $request->arquivo;
      $path = 'trabalhos/' . $request->eventoId . '/' . $trabalho->id .'/';
      $nome = $count . ".pdf";
      Storage::putFileAs($path, $file, $nome);

      $arquivo = Arquivo::create([
        'nome'  => $path . $nome,
        'trabalhoId'  => $trabalho->id,
        'versaoFinal' => true,
      ]);

      return redirect()->route('evento.visualizar',['id'=>$request->eventoId]);
    }

    public function detalhesAjax(Request $request){
      $validatedData = $request->validate([
        'trabalhoId' => ['required', 'integer']
      ]);

      $trabalho = Trabalho::find($request->trabalhoId);
      $revisores = Atribuicao::where('trabalhoId', $request->trabalhoId)->get();
      $revisoresAux = [];
      foreach ($revisores as $key) {
        if($key->revisor->user->name != null){
          array_push($revisoresAux, [
            'id' => $key->revisor->id,
            'nomeOuEmail'  => $key->revisor->user->name
          ]);
        }
        else{
          array_push($revisoresAux, [
            'id' => $key->revisor->id,
            'nomeOuEmail'  => $key->revisor->user->email
          ]);
        }
      }
      $revisoresDisponeis = Revisor::where('eventoId', $trabalho->eventoId)->where('areaId', $trabalho->areaId)->get();
      $revisoresAux1 = [];
      foreach ($revisoresDisponeis as $key) {
        //verificar se ja é um revisor deste trabalhos
        $revisorNaoExiste = true;
        foreach ($revisoresAux as $key1) {
          if($key->id == $key1['id']){
            $revisorNaoExiste = false;
          }
        }
        //
        if($revisorNaoExiste){
          if($key->user->name != null){
            array_push($revisoresAux1, [
              'id' => $key->id,
              'nomeOuEmail'  => $key->user->name
            ]);
          }
          else{
            array_push($revisoresAux1, [
              'id' => $key->id,
              'nomeOuEmail'  => $key->user->email
            ]);
          }
        }
      }
      return response()->json([
                               'titulo' => $trabalho->titulo,
                               'resumo'  => $trabalho->resumo,
                               'revisores' => $revisoresAux,
                               'revisoresDisponiveis' => $revisoresAux1
                              ], 200);
    }

}
