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
use App\Proponente;
use App\Trabalho;
use App\AreaModalidade;
use App\CoordenadorComissao;
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

    public function listar()
    {
        //
        $eventos = Evento::all();
        // $comissaoEvento = ComissaoEvento::all();
        // $eventos = Evento::where('coordenadorId', Auth::user()->id)->get();
        
        return view('evento.listarEvento',['eventos'=>$eventos]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coordenadors = CoordenadorComissao::with('user')->get();
        return view('evento.criarEvento', ['coordenadors' => $coordenadors]);
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
        //$admResponsavel = AdministradorResponsavel::with('user')->where('user_id', Auth()->user()->id)->first();
        $user_id = Auth()->user()->id;

        //dd($user_id);
        // validar datas nulas antes, pois pode gerar um bug

        if(
          $request->inicioSubmissao == null ||
          $request->fimSubmissao == null    ||
          $request->inicioRevisao == null   ||
          $request->fimRevisao == null      ||
          $request->resultado == null 
          
        ){
          $validatedData = $request->validate([
            'nome'                => ['required', 'string'],
            'descricao'           => ['required', 'string'],
            'tipo'                => ['required', 'string'],            
            'inicioSubmissao'     => ['required', 'date'],
            'fimSubmissao'        => ['required', 'date'],
            'inicioRevisao'       => ['required', 'date'],
            'fimRevisao'          => ['required', 'date'],
            'resultado'           => ['required', 'date'],    
            'pdfEdital'           => ['required', 'file', 'mimes:pdf', 'max:2000000'],  	 
            'modeloDocumento'     => ['required', 'file', 'mimes:zip,doc,docx,odt,pdf', 'max:2000000'],
          ]);
        }

        // validacao normal

        $validatedData = $request->validate([
          'nome'                => ['required', 'string'],        
          'descricao'           => ['required', 'string'],
          'tipo'                => ['required', 'string'],
          'inicioSubmissao'     => ['required', 'date', 'after:' . $yesterday],
          'fimSubmissao'        => ['required', 'date', 'after:' . $request->inicioSubmissao],
          'inicioRevisao'       => ['required', 'date', 'after:' . $yesterday],
          'fimRevisao'          => ['required', 'date', 'after:' . $request->inicioRevisao],
          'resultado'           => ['required', 'date', 'after:' . $yesterday],
          'pdfEdital'           => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'modeloDocumento'     => ['required', 'file', 'mimes:zip,doc,docx,odt,pdf', 'max:2000000'],
        ]);

        $evento = Evento::create([
          'nome'                => $request->nome,
          'descricao'           => $request->descricao,
          'tipo'                => $request->tipo,
          'inicioSubmissao'     => $request->inicioSubmissao,
          'fimSubmissao'        => $request->fimSubmissao,
          'inicioRevisao'       => $request->inicioRevisao,
          'fimRevisao'          => $request->fimRevisao,
          'resultado'           => $request->resultado,
          'coordenadorId'       => $request->coordenador_id,          
          'criador_id'          => $user_id,          
        ]);
        //dd($evento);
        // $user = User::find($request->coordenador_id);
        // $user->coordenadorComissao()->editais()->save($evento);

        // se vou me tornar coordenador do Evento

        // if($request->isCoordenador == true){
        //   $evento->coordenadorId = Auth::user()->id;
        //   $evento->save();
        // }

        //$evento->coordenadorId = Auth::user()->id;

        $pdfEdital = $request->pdfEdital;
        $path = 'pdfEdital/' . $evento->id . '/';
        $nome = "edital.pdf";
        Storage::putFileAs($path, $pdfEdital, $nome);  
        $evento->pdfEdital = $path . $nome;
         
        $modeloDocumento = $request->modeloDocumento;
        $extension = $modeloDocumento->extension();
        $path = 'modeloDocumento/' . $evento->id . '/';
        $nome = "modelo" . "." . $extension;
        Storage::putFileAs($path, $modeloDocumento, $nome);
  
        $evento->modeloDocumento = $path . $nome;


        $evento->save();

        // $user = Auth::user();
        // $subject = "Evento Criado";
        // Mail::to($user->email)
        //     ->send(new EventoCriado($user, $subject));

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
        $proponente = Proponente::where('user_id', Auth::user()->id)->first();
        if($proponente != null){
          $hasTrabalho = false;
          $hasFile = false;
          $trabalhos = $proponente->trabalhos()->where('evento_id', $evento->id )->get();
          $trabalhosCount = $proponente->trabalhos()->where('evento_id', $evento->id )->count();

          if($trabalhosCount != 0){
            $hasTrabalho = true;
            $hasFile = true;
          }
        }else{
          $hasTrabalho = false;
          $hasFile = false;
          $trabalhos = 0;
          $trabalhosCount = 0;
        }
        
        
        $trabalhosId = Trabalho::where('evento_id', $evento->id)->select('id')->get();
        //$trabalhosIdCoautor = Proponente::whereIn('trabalhoId', $trabalhosId)->where('proponente_id', Auth::user()->id)->select('trabalhoId')->get();
        //$coautorCount = Coautor::whereIn('trabalhoId', $trabalhosId)->where('proponente_id', Auth::user()->id)->count();
        //$trabalhosCoautor = Trabalho::whereIn('id', $trabalhosIdCoautor)->get();
        
        // if($coautorCount != 0){
        //   $hasTrabalhoCoautor = true;
        //   $hasFile = true;
        // }

        $mytime = Carbon::now('America/Recife');
        // dd(false);
        return view('evento.visualizarEvento', [
                                                'evento'              => $evento,
                                                'trabalhos'           => $trabalhos,
                                                // 'trabalhosCoautor'    => $trabalhosCoautor,
                                                'hasTrabalho'         => $hasTrabalho,
                                                // 'hasTrabalhoCoautor'  => $hasTrabalhoCoautor,
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
        return view('evento.editarEvento',['evento'=>$evento]);
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
        //dd($request);
        $evento = Evento::find($id);    

        $evento->nome                 = $request->nome;        
        $evento->descricao            = $request->descricao;
        $evento->tipo                 = $request->tipo;       
        $evento->inicioSubmissao      = $request->inicioSubmissao;
        $evento->fimSubmissao         = $request->fimSubmissao;
        $evento->inicioRevisao        = $request->inicioRevisao;
        $evento->fimRevisao           = $request->fimRevisao;
        $evento->resultado            = $request->resultado;  
        
        if($request->pdfEdital != null){
          $pdfEdital = $request->pdfEdital;
          $path = 'pdfEdital/' . $evento->id . '/';
          $nome = "edital.pdf";
          Storage::putFileAs($path, $pdfEdital, $nome);  
        }
         
        if($request->modeloDocumento != null){
          $modeloDocumento = $request->modeloDocumento;
          $extension = $modeloDocumento->extension();
          $path = 'modeloDocumento/' . $evento->id . '/';
          $nome = "modelo" . "." . $extension;
          Storage::putFileAs($path, $modeloDocumento, $nome);
          $evento->modeloDocumento = $path . $nome;
        }

        $evento->save();

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

        // $areas = Area::where('eventoId', $id);
        $atividades = Atividade::where('eventoId', $id);
        $comissao = ComissaoEvento::where('eventosId', $id);
        $revisores = Revisor::where('eventoId', $id);
        $trabalhos = Trabalho::where('evento_id', $id);
        
        // if(isset($areas)){
        //     $areas->delete();
        // }
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

        Storage::deleteDirectory('pdfEdital/' . $evento->id );
        Storage::deleteDirectory('modeloDocumento/' . $evento->id);

        $evento->delete();

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
