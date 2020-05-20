<?php

namespace App\Http\Controllers;

use App\Area;
use App\Atividade;
use App\Evento;
use App\Coautor;
use App\Revisor;
use App\Atribuicao;
use App\Modalidade;
use App\ComissaoEvento;
use App\User;
use App\Trabalho;
use App\AreaModalidade;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Endereco;
use App\Mail\EventoCriado;
use Illuminate\Support\Facades\Mail;


class EventoController extends Controller
{
    public function index()
    {
        //
        $eventos = Evento::all();
        // $comissaoEvento = ComissaoEvento::all();
        // $eventos = Evento::where('coordenadorId', Auth::user()->id)->get();
        
        return view('coordenador.home',['eventos'=>$eventos]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('evento.criarEvento');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $mytime = Carbon::now('America/Recife');
        $yesterday = Carbon::yesterday('America/Recife');
        $yesterday = $yesterday->toDateString();

        // dd($request);
        // validar datas nulas antes, pois pode gerar um bug

        if(
          $request->dataInicio == null      ||
          $request->dataFim == null         ||
          $request->inicioSubmissao == null ||
          $request->fimSubmissao == null    ||
          $request->inicioRevisao == null   ||
          $request->fimRevisao == null      ||
          $request->inicioResultado == null ||
          $request->fimResultado == null
        ){
          $validatedData = $request->validate([
            'nome'                => ['required', 'string'],
            // 'numeroParticipantes' => ['required', 'integer', 'gt:0'],
            'descricao'           => ['required', 'string'],
            'tipo'                => ['required', 'string'],
            'dataInicio'          => ['required', 'date','after:'. $yesterday],
            'dataFim'             => ['required', 'date'],
            'inicioSubmissao'     => ['required', 'date'],
            'fimSubmissao'        => ['required', 'date'],
            'inicioRevisao'       => ['required', 'date'],
            'fimRevisao'          => ['required', 'date'],
            'inicioResultado'     => ['required', 'date'],
            'fimResultado'        => ['required', 'date'],
            // 'valorTaxa'           => ['required', 'integer'],
            'fotoEvento'          => ['file', 'mimes:png'],
          ]);
        }

        // validacao normal

        $validatedData = $request->validate([
          'nome'                => ['required', 'string'],
          // 'numeroParticipantes' => ['required', 'integer', 'gt:0'],
          'descricao'           => ['required', 'string'],
          'tipo'                => ['required', 'string'],
          'dataInicio'          => ['required', 'date', 'after:' . $yesterday],
          'dataFim'             => ['required', 'date', 'after:' . $request->dataInicio],
          'inicioSubmissao'     => ['required', 'date', 'after:' . $yesterday],
          'fimSubmissao'        => ['required', 'date', 'after:' . $request->inicioSubmissao],
          'inicioRevisao'       => ['required', 'date', 'after:' . $yesterday],
          'fimRevisao'          => ['required', 'date', 'after:' . $request->inicioRevisao],
          'inicioResultado'     => ['required', 'date', 'after:' . $yesterday],
          'fimResultado'        => ['required', 'date', 'after:' . $request->inicioResultado],
          // 'valorTaxa'           => ['required', 'integer'],
          'fotoEvento'          => ['file', 'mimes:png'],
        ]);

        // validar endereco

        $validatedData = $request->validate([
          'rua'                 => ['required', 'string'],
          'numero'              => ['required', 'string'],
          'bairro'              => ['required', 'string'],
          'cidade'              => ['required', 'string'],
          'uf'                  => ['required', 'string'],
          'cep'                 => ['required', 'string'],
        ]);

        $endereco = Endereco::create([
          'rua'                 => $request->rua,
          'numero'              => $request->numero,
          'bairro'              => $request->bairro,
          'cidade'              => $request->cidade,
          'uf'                  => $request->uf,
          'cep'                 => $request->cep,
        ]);

        $evento = Evento::create([
          'nome'                => $request->nome,
          // 'numeroParticipantes' => $request->numeroParticipantes,
          'descricao'           => $request->descricao,
          'tipo'                => $request->tipo,
          'dataInicio'          => $request->dataInicio,
          'dataFim'             => $request->dataFim,
          'inicioSubmissao'     => $request->inicioSubmissao,
          'fimSubmissao'        => $request->fimSubmissao,
          'inicioRevisao'       => $request->inicioRevisao,
          'fimRevisao'          => $request->fimRevisao,
          'inicioResultado'     => $request->inicioResultado,
          'fimResultado'        => $request->fimResultado,
          // 'possuiTaxa'          => $request->possuiTaxa,
          // 'valorTaxa'           => $request->valorTaxa,
          'enderecoId'          => $endereco->id,
          'coordenadorId'       => Auth::user()->id,
        ]);

        // se o evento tem foto

        if($request->fotoEvento != null){
          $file = $request->fotoEvento;
          $path = 'public/eventos/' . $evento->id;
          $nome = '/logo.png';
          Storage::putFileAs($path, $file, $nome);
          $evento->fotoEvento = $path . $nome;
          $evento->save();
        }

        // se vou me tornar coordenador do Evento

        // if($request->isCoordenador == true){
        //   $evento->coordenadorId = Auth::user()->id;
        //   $evento->save();
        // }

        $evento->coordenadorId = Auth::user()->id;
        $evento->save();

        $user = Auth::user();
        $subject = "Evento Criado";
        Mail::to($user->email)
            ->send(new EventoCriado($user, $subject));

        return redirect()->route('coord.home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evento = Evento::find($id);
        $hasTrabalho = false;
        $hasTrabalhoCoautor = false;
        $hasFile = false;
        $trabalhos = Trabalho::where('autorId', Auth::user()->id)->get();
        $trabalhosCount = Trabalho::where('autorId', Auth::user()->id)->count();
        $trabalhosId = Trabalho::where('eventoId', $evento->id)->select('id')->get();
        $trabalhosIdCoautor = Coautor::whereIn('trabalhoId', $trabalhosId)->where('autorId', Auth::user()->id)->select('trabalhoId')->get();
        $coautorCount = Coautor::whereIn('trabalhoId', $trabalhosId)->where('autorId', Auth::user()->id)->count();
        $trabalhosCoautor = Trabalho::whereIn('id', $trabalhosIdCoautor)->get();
        if($trabalhosCount != 0){
          $hasTrabalho = true;
          $hasFile = true;
        }
        if($coautorCount != 0){
          $hasTrabalhoCoautor = true;
          $hasFile = true;
        }

        $mytime = Carbon::now('America/Recife');
        // dd(false);
        return view('evento.visualizarEvento', [
                                                'evento'              => $evento,
                                                'trabalhos'           => $trabalhos,
                                                'trabalhosCoautor'    => $trabalhosCoautor,
                                                'hasTrabalho'         => $hasTrabalho,
                                                'hasTrabalhoCoautor'  => $hasTrabalhoCoautor,
                                                'hasFile'             => $hasFile,
                                                'mytime'              => $mytime
                                               ]);
    }

    public function showNaoLogado($id)
    {
        $evento = Evento::find($id);
        $hasTrabalho = false;
        $hasTrabalhoCoautor = false;
        $hasFile = false;
        $trabalhos = null;
        $trabalhosCoautor = null;

        $mytime = Carbon::now('America/Recife');
        // dd(false);
        return view('evento.visualizarEvento', [
                                                'evento'              => $evento,
                                                'trabalhos'           => $trabalhos,
                                                'trabalhosCoautor'    => $trabalhosCoautor,
                                                'hasTrabalho'         => $hasTrabalho,
                                                'hasTrabalhoCoautor'  => $hasTrabalhoCoautor,
                                                'hasFile'             => $hasFile,
                                                'mytime'              => $mytime
                                               ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $evento = Evento::find($id);
        $endereco = Endereco::find($evento->enderecoId);
        return view('evento.editarEvento',['evento'=>$evento,'endereco'=>$endereco]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::find($id);
        $endereco = Endereco::find($evento->enderecoId);

        $evento->nome                 = $request->nome;
        // $evento->numeroParticipantes  = $request->numeroParticipantes;
        $evento->descricao            = $request->descricao;
        $evento->tipo                 = $request->tipo;
        $evento->dataInicio           = $request->dataInicio;
        $evento->dataFim              = $request->dataFim;
        $evento->inicioSubmissao      = $request->inicioSubmissao;
        $evento->fimSubmissao         = $request->fimSubmissao;
        $evento->inicioRevisao        = $request->inicioRevisao;
        $evento->fimRevisao           = $request->fimRevisao;
        $evento->inicioResultado      = $request->inicioResultado;
        $evento->fimResultado         = $request->fimResultado;
        // $evento->possuiTaxa           = $request->possuiTaxa;
        // $evento->valorTaxa            = $request->valorTaxa;
        $evento->enderecoId           = $endereco->id;
        $evento->save();

        $endereco->rua                = $request->rua;
        $endereco->numero             = $request->numero;
        $endereco->bairro             = $request->bairro;
        $endereco->cidade             = $request->cidade;
        $endereco->uf                 = $request->uf;
        $endereco->cep                = $request->cep;
        $endereco->save();

        $eventos = Evento::all();
        return view('coordenador.home',['eventos'=>$eventos]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evento = Evento::find($id);
        $endereco = Endereco::find($evento->enderecoId);

        $areas = Area::where('eventoId', $id);
        $atividades = Atividade::where('eventoId', $id);
        $comissao = ComissaoEvento::where('eventosId', $id);
        $revisores = Revisor::where('eventoId', $id);
        $trabalhos = Trabalho::where('eventoId', $id);
        
        if(isset($areas)){
            $areas->delete();
        }
        if(isset($atividades)){
            $atividades->delete();
        }
        if(isset($comissao)){
            $comissao->delete();    
        }
        if(isset($revisores)){
          $revisores->delete();    
        }
        if(isset($trabalhos)){
          $trabalhos->delete();    
        }

        $evento->delete();
        $endereco->delete();

        return redirect()->back();
    }

    public function detalhes(Request $request){
        $evento = Evento::find($request->eventoId);
        $this->authorize('isCoordenador', $evento);

        $ComissaoEvento = ComissaoEvento::where('eventosId',$evento->id)->get();
        // dd($ComissaoEventos);
        $ids = [];
        foreach($ComissaoEvento as $ce){
          array_push($ids,$ce->userId);
        }
        $users = User::find($ids);

        $areas = Area::where('eventoId', $evento->id)->get();
        $areasId = Area::where('eventoId', $evento->id)->select('id')->get();
        $trabalhosId = Trabalho::whereIn('areaId', $areasId)->select('id')->get();
        $revisores = Revisor::where('eventoId', $evento->id)->get();
        $modalidades = Modalidade::all();
        $areaModalidades = AreaModalidade::whereIn('areaId', $areasId)->get();        
        $trabalhos = Trabalho::whereIn('areaId', $areasId)->orderBy('id')->get();
        $trabalhosEnviados = Trabalho::whereIn('areaId', $areasId)->count();
        $trabalhosPendentes = Trabalho::whereIn('areaId', $areasId)->where('avaliado', 'processando')->count();
        $trabalhosAvaliados = Atribuicao::whereIn('trabalhoId', $trabalhosId)->where('parecer', '!=', 'processando')->count();

        $numeroRevisores = Revisor::where('eventoId', $evento->id)->count();
        $numeroComissao = ComissaoEvento::where('eventosId',$evento->id)->count();
        // $atribuicoesProcessando
        // dd($trabalhosEnviados);
        $revs = Revisor::where('eventoId', $evento->id)->with('user')->get();

        return view('coordenador.detalhesEvento', [
                                                    'evento'                  => $evento,
                                                    'areas'                   => $areas,
                                                    'revisores'               => $revisores,
                                                    'revs'                    => $revs,
                                                    'users'                   => $users,
                                                    'modalidades'             => $modalidades,
                                                    'areaModalidades'         => $areaModalidades,
                                                    'trabalhos'               => $trabalhos,
                                                    'trabalhosEnviados'       => $trabalhosEnviados,
                                                    'trabalhosAvaliados'      => $trabalhosAvaliados,
                                                    'trabalhosPendentes'      => $trabalhosPendentes,
                                                    'numeroRevisores'         => $numeroRevisores,
                                                    'numeroComissao'          => $numeroComissao
                                                  ]);
    }

    public function numTrabalhos(Request $request){
      $evento = Evento::find($request->eventoId);
      $this->authorize('isCoordenador', $evento);
      $validatedData = $request->validate([
        'eventoId'                => ['required', 'integer'],
        'trabalhosPorAutor'       => ['required', 'integer'],
        'numCoautor'              => ['required', 'integer']
      ]);

      $evento->numMaxTrabalhos = $request->trabalhosPorAutor;
      $evento->numMaxCoautores = $request->numCoautor;
      $evento->save();

      return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }

    public function setResumo(Request $request){
      $evento = Evento::find($request->eventoId);
      $this->authorize('isCoordenador', $evento);
      $validatedData = $request->validate([
        'eventoId'                => ['required', 'integer'],
        'hasResumo'               => ['required', 'string']
      ]);
      if($request->hasResumo == 'true'){
        $evento->hasResumo = true;
      }
      else{
        $evento->hasResumo = false;
      }

      $evento->save();
      return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }

    public function setFotoEvento(Request $request){
      $evento = Evento::find($request->eventoId);
      $this->authorize('isCoordenador', $evento);
      // dd($request);
      $validatedData = $request->validate([
        'eventoId'                => ['required', 'integer'],
        'fotoEvento'              => ['required', 'file', 'mimes:png']
      ]);

      $file = $request->fotoEvento;
      $path = 'public/eventos/' . $evento->id;
      $nome = '/logo.png';
      Storage::putFileAs($path, $file, $nome);
      $evento->fotoEvento = $path . $nome;
      $evento->save();
      return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }

    public function areaParticipante() {

      $eventos = Evento::all();
      
      return view('user.areaParticipante',['eventos'=>$eventos]);

    }

    public function listComissao() {

      $comissaoEvento = ComissaoEvento::where('userId', Auth::user()->id)->get();
      $eventos = Evento::all();
      $evnts = [];

      foreach ($comissaoEvento as $comissao) {
        foreach ($eventos as $evento) {
          if($comissao->eventosId == $evento->id){
            array_push($evnts,$evento);
          }
        }
      }
      
      return view('user.comissoes',['eventos'=>$evnts]);

    }

    public function listComissaoTrabalhos(Request $request) {

      $evento = Evento::find($request->eventoId);
      $areasId = Area::where('eventoId', $evento->id)->select('id')->get();
      $trabalhos = Trabalho::whereIn('areaId', $areasId)->orderBy('id')->get();
      
      return view('user.areaComissao', ['trabalhos' => $trabalhos]);
    }


}
