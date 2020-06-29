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
use App\Natureza;
use App\CoordenadorComissao;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Rules\ExcelRule;  
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
        $naturezas = Natureza::orderBy('nome')->get();
        $yesterday = Carbon::yesterday('America/Recife');
        $yesterday = $yesterday->toDateString();
        return view('evento.criarEvento', ['coordenadors' => $coordenadors, 'naturezas' => $naturezas, 'ontem' => $yesterday]);
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
        if(isset($request->modeloDocumento)){
          $request->validate([
            'modeloDocumento' => ['file', 'max:2048', new ExcelRule($request->file('modeloDocumento'))],
          ]);          
        }

        //--Salvando os anexos da submissão temporariamente
        $evento = $this->armazenarAnexosTemp($request);

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
            'natureza'            => ['required'],  
            'coordenador_id'      => ['required'],        
            'inicioSubmissao'     => ['required', 'date'],
            'fimSubmissao'        => ['required', 'date'],
            'inicioRevisao'       => ['required', 'date'],
            'fimRevisao'          => ['required', 'date'],
            'inicio_recurso'      => ['required', 'date'],
            'fim_recurso'         => ['required', 'date'],
            'resultado_final'     => ['required', 'date'],    
            'resultado_preliminar'=> ['required', 'date'],    
            'pdfEdital'           => [($request->pdfEditalPreenchido!=='sim'?'required':''), 'file', 'mimes:pdf', 'max:2048'],  	 
            //'modeloDocumento'     => [],
          ]);
        }

        // validacao normal
        //after   = depois 
        //before  = antes
        $validatedData = $request->validate([
          'nome'                => ['required', 'string'],        
          'descricao'           => ['required', 'string'],
          'tipo'                => ['required', 'string'],
          'natureza'            => ['required'],    
          'coordenador_id'      => ['required'],
          #----------------------------------------------
          'inicioSubmissao'     => ['required', 'date', 'after:yesterday'],
          'fimSubmissao'        => ['required', 'date', 'after_or_equal:inicioSubmissao'],
          'inicioRevisao'       => ['required', 'date', 'after:yesterday'],
          'fimRevisao'          => ['required', 'date', 'after:inicioRevisao', 'after:fimSubmissao'],
          'resultado_preliminar'=> ['required', 'date', 'after_or_equal:fimRevisao'],
          'inicio_recurso'      => ['required', 'date', 'after_or_equal:resultado_preliminar'],
          'fim_recurso'         => ['required', 'date', 'after:inicio_recurso'],
          'resultado_final'     => ['required', 'date', 'after:fim_recurso'],
          'pdfEdital'           => [($request->pdfEditalPreenchido!=='sim'?'required':''), 'file', 'mimes:pdf', 'max:2048'],
          //'modeloDocumento'     => ['file', 'mimes:zip,doc,docx,odt,pdf', 'max:2048'],
        ]);
        
        //$evento = Evento::create([
        $evento['nome']                = $request->nome;
        $evento['descricao']           = $request->descricao;
        $evento['tipo']                = $request->tipo;
        $evento['natureza_id']         = $request->natureza;
        $evento['inicioSubmissao']     = $request->inicioSubmissao;
        $evento['fimSubmissao']        = $request->fimSubmissao;
        $evento['inicioRevisao']       = $request->inicioRevisao;
        $evento['fimRevisao']          = $request->fimRevisao;
        $evento['inicio_recurso']      = $request->inicio_recurso;
        $evento['fim_recurso']         = $request->fim_recurso;
        $evento['resultado_preliminar']= $request->resultado_preliminar;
        $evento['resultado_final']     = $request->resultado_final;
        $evento['coordenadorId']       = $request->coordenador_id;          
        $evento['criador_id']          = $user_id;  
        $evento['anexosStatus']        = 'final';         
       
        //dd($evento);
        // $user = User::find($request->coordenador_id);
        // $user->coordenadorComissao()->editais()->save($evento);

        // se vou me tornar coordenador do Evento

        // if($request->isCoordenador == true){
        //   $evento->coordenadorId = Auth::user()->id;
        //   $evento->save();
        // }

        //$evento->coordenadorId = Auth::user()->id;

        //-- Salvando anexos finais
        
        if(isset($request->pdfEdital)){        
          $pdfEdital = $request->pdfEdital;
          $path = 'pdfEdital/' . $evento->id . '/';
          $nome = "edital.pdf";
          Storage::putFileAs($path, $pdfEdital, $nome);  
          $evento->pdfEdital = $path . $nome;
        }

        if(isset($request->modeloDocumento)){
          $modeloDocumento = $request->modeloDocumento;
          $extension = $modeloDocumento->extension();
          $path = 'modeloDocumento/' . $evento->id . '/';
          $nome = "modelo" . "." . $extension;
          Storage::putFileAs($path, $modeloDocumento, $nome);
    
          $evento->modeloDocumento = $path . $nome;
        } 
        
        $evento->update();

        // $user = Auth::user();
        // $subject = "Evento Criado";
        // Mail::to($user->email)
        //     ->send(new EventoCriado($user, $subject));

        return redirect()->route('coord.home');
    }

    public function armazenarAnexosTemp(Request $request){

      //---Anexos do Projeto  
      $eventoTemp = Evento::where('criador_id', Auth::user()->id)->where('anexosStatus', 'temporario')
                                ->orderByDesc('updated_at')->first();
      
      if($eventoTemp == null){
        $eventoTemp = new Evento();
        $eventoTemp->criador_id = Auth::user()->id;
        $eventoTemp->anexosStatus = 'temporario';
        $eventoTemp->save();       
      }
      
      if(!(is_null($request->pdfEdital)) ) {  
        $pasta = 'pdfEdital/' . $eventoTemp->id;        
        $eventoTemp->pdfEdital = Storage::putFileAs($pasta, $request->pdfEdital, 'edital.pdf');  
      }
      if (!(is_null($request->modeloDocumento))) {      
        $extension = $request->modeloDocumento->extension();
        $path = 'modeloDocumento/' . $eventoTemp->id;
        $nome = "modelo" . "." . $extension;       
        $eventoTemp->modeloDocumento = Storage::putFileAs($path, $request->modeloDocumento, $nome);        
      }       
      
      $eventoTemp->update();
     
      return $eventoTemp;
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
        $coordenadors = CoordenadorComissao::with('user')->get();
        $naturezas = Natureza::orderBy('nome')->get();
        $yesterday = Carbon::yesterday('America/Recife');
        $yesterday = $yesterday->toDateString(); 
        return view('evento.editarEvento',['evento'=>$evento,
                                           'coordenadores'=>$coordenadors,
                                           'naturezas'=>$naturezas,
                                           'ontem'=>$yesterday]);
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
        $yesterday = Carbon::yesterday('America/Recife');
        $yesterday = $yesterday->toDateString(); 
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
            'natureza'            => ['required'],           
            'inicioSubmissao'     => ['required', 'date'],
            'fimSubmissao'        => ['required', 'date'],
            'inicioRevisao'       => ['required', 'date', 'after:yesterday'],
            'fimRevisao'          => ['required', 'date'],
            'resultado_preliminar'=> ['required', 'date'],
            'inicio_recurso'      => ['required', 'date'],
            'fim_recurso'         => ['required', 'date'],
            'resultado_final'     => ['required', 'date'],
            'pdfEdital'           => ['file', 'mimes:pdf', 'max:2048'],  	 
            'modeloDocumento'     => ['file', 'mimes:zip,doc,docx,odt,pdf', 'max:2048'],
          ]);
        }

        $validated = $request->validate([
          'nome'                => ['required', 'string'],        
          'descricao'           => ['required', 'string', 'size:1500'],
          'tipo'                => ['required', 'string'],
          'natureza'            => ['required'], 
          'inicioSubmissao'     => ['required', 'date', 'after:yesterday'],
          'fimSubmissao'        => ['required', 'date', 'after_or_equal:inicioSubmissao'],
          'inicioRevisao'       => ['required', 'date', 'after:yesterday'],
          'fimRevisao'          => ['required', 'date', 'after:inicioRevisao', 'after:fimSubmissao'],
          'resultado_preliminar'=> ['required', 'date', 'after_or_equal:fimRevisao'],
          'inicio_recurso'      => ['required', 'date', 'after_or_equal:resultado_preliminar'],
          'fim_recurso'         => ['required', 'date', 'after:inicio_recurso'],
          'resultado_final'     => ['required', 'date', 'after:fim_recurso'],
          'modeloDocumento'     => ['file', 'mimes:zip,doc,docx,odt,pdf', 'max:2048'],
        ]);

        $evento->nome                 = $request->nome;        
        $evento->descricao            = $request->descricao;
        $evento->tipo                 = $request->tipo;
        $evento->natureza_id          = $request->natureza;   
        $evento->inicioSubmissao      = $request->inicioSubmissao;
        $evento->fimSubmissao         = $request->fimSubmissao;
        $evento->inicioRevisao        = $request->inicioRevisao;
        $evento->fimRevisao           = $request->fimRevisao;
        $evento->inicio_recurso       = $request->inicio_recurso;
        $evento->fim_recurso          = $request->fim_recurso;
        $evento->resultado_preliminar = $request->resultado_preliminar;
        $evento->resultado_final      = $request->resultado_final;
        $evento->coordenadorId        = $request->coordenador_id; 
        
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

        $evento->update();

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

    public function baixarEdital($id) {
      $evento = Evento::find($id);

      if (Storage::disk()->exists($evento->pdfEdital)) {
        return Storage::download($evento->pdfEdital);
      }

      return abort(404);
    }

    public function baixarModelos($id) {
      $evento = Evento::find($id);

      if (Storage::disk()->exists($evento->modeloDocumento)) {
        return Storage::download($evento->modeloDocumento);
      }
      
      return abort(404);
    }
}
