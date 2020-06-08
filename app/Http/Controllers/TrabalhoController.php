<?php

namespace App\Http\Controllers;

use App\Trabalho;
use App\Coautor;
use App\Evento;
use App\CoordenadorComissao;
use App\User;
use App\Proponente;
use App\AreaModalidade;
use App\Area;
use App\Revisor;
use App\Modalidade;
use App\Atribuicao;
use App\Arquivo;
use App\GrandeArea;
use App\SubArea;
use App\FuncaoParticipantes;
use App\Participante;
use App\Avaliador;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailParaUsuarioNaoCadastrado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\SubmissaoTrabalho;
use App\Mail\EventoCriado;

class TrabalhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $edital = Evento::find($id);
        $grandeAreas = GrandeArea::all();
        $areas = Area::all();
        $subAreas = SubArea::all();
        $funcaoParticipantes = FuncaoParticipantes::all(); 
        return view('evento.submeterTrabalho',[
                                            'edital'             => $edital,
                                            'grandeAreas'        => $grandeAreas,
                                            'areas'              => $areas,
                                            'subAreas'           => $subAreas,
                                            'funcaoParticipantes'=> $funcaoParticipantes               
                                              
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
      // dd($request->all());
      $mytime = Carbon::now('America/Recife');
      $mytime = $mytime->toDateString();
      $evento = Evento::find($request->editalId);
      $coordenador = CoordenadorComissao::find($evento->coordenadorId);
      //Relaciona o projeto criado com o proponente que criou o projeto
      $proponente = Proponente::where('user_id', Auth::user()->id)->first();
      //$trabalho->proponentes()->save($proponente);  
      //dd($coordenador->id);
      $trabalho = "trabalho";
      if($evento->inicioSubmissao > $mytime){
        if($mytime >= $evento->fimSubmissao){
            return redirect()->route('home');
        }
      }
      
      //O anexo de Decisão do CONSU dependo do tipo de edital
      if( $evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM'){

        $validatedData = $request->validate([
          'editalId'                => ['required', 'string'],
          'nomeProjeto'             => ['required', 'string'],
          'grandeArea'              => ['required', 'string'],
          'area'                    => ['required', 'string'],
          'subArea'                 => ['required', 'string'],
          'pontuacaoPlanilha'       => ['required', 'string'],
          'linkGrupo'               => ['required', 'string'],
          'linkLattesEstudante'     => ['required', 'string'],
          'nomeParticipante.*'      => ['required', 'string'],
          'emailParticipante.*'     => ['required', 'string'],
          'funcaoParticipante.*'    => ['required', 'string'],
          'nomePlanoTrabalho.*'     => ['required', 'string'],
          'anexoProjeto'            => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          //'anexoCONSU'              => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoLatterCoordenador'  => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoPlanilha'           => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoPlanoTrabalho.*'    => ['required', 'file', 'mimes:pdf', 'max:2000000'],
        ]);
        //dd($request->all());

        $trabalho = Trabalho::create([
          'titulo'                        => $request->nomeProjeto,
          'coordenador_id'                => $coordenador->id,
          'grande_area_id'                => $request->grandeArea,
          'area_id'                       => $request->area,
          'sub_area_id'                   => $request->subArea,               
          'pontuacaoPlanilha'             => $request->pontuacaoPlanilha,
          'linkGrupoPesquisa'             => $request->linkGrupo,
          'linkLattesEstudante'           => $request->linkLattesEstudante,
          'data'                          => $mytime,
          'evento_id'                     => $request->editalId,
          'avaliado'                      => 0,
          'proponente_id'                 => $proponente->id,
          //Anexos
          'anexoDecisaoCONSU'             => $request->anexoCONSU,
          'anexoProjeto'                  => $request->anexoProjeto,
          'anexoAutorizacaoComiteEtica'   => $request->anexoComiteEtica,
          'justificativaAutorizacaoEtica' => $request->justificativaAutorizacaoEtica,
          'anexoLattesCoordenador'        => $request->anexoLatterCoordenador,
          'anexoPlanilhaPontuacao'        => $request->anexoPlanilha,
        ]);
        //dd($trabalho);
      } else {
        //Caso em que o anexo da Decisão do CONSU não necessário
        $validatedData = $request->validate([
          'editalId'                => ['required', 'string'],
          'nomeProjeto'             => ['required', 'string',],
          'grandeArea'              => ['required', 'string'],
          'area'                    => ['required', 'string'],
          'subArea'                 => ['required', 'string'],
          'pontuacaoPlanilha'       => ['required', 'string'],
          'linkGrupo'               => ['required', 'string'],
          'linkLattesEstudante'     => ['required', 'string'],
          'nomeParticipante.*'      => ['required', 'string'],
          'emailParticipante.*'     => ['required', 'string'],
          'funcaoParticipante.*'    => ['required', 'string'],
          'nomePlanoTrabalho.*'     => ['required', 'string'],
          'anexoProjeto'            => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoLatterCoordenador'  => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoPlanilha'           => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoPlanoTrabalho.*'    => ['required', 'file', 'mimes:pdf', 'max:2000000'],
        ]);

        $trabalho = Trabalho::create([
          'titulo'                        => $request->nomeProjeto,
          'coordenador_id'                => $coordenador->id,
          'grande_area_id'                => $request->grandeArea,
          'area_id'                       => $request->area,
          'sub_area_id'                   => $request->subArea,       
          'pontuacaoPlanilha'             => $request->pontuacaoPlanilha,
          'linkGrupoPesquisa'             => $request->linkGrupo,
          'linkLattesEstudante'           => $request->linkLattesEstudante,
          'data'                          => $mytime,
          'evento_id'                     => $request->editalId,
          'avaliado'                      => 0,
          'proponente_id'                 => $proponente->id,
          //Anexos
          'anexoProjeto'                  => $request->anexoProjeto,
          'anexoAutorizacaoComiteEtica'   => $request->anexoComiteEtica,
          'justificativaAutorizacaoEtica' => $request->justificativaAutorizacaoEtica,
          'anexoLattesCoordenador'        => $request->anexoLatterCoordenador,
          'anexoPlanilhaPontuacao'        => $request->anexoPlanilha,
        ]);

      }

      //Envia email com senha temp para cada participante do projeto
      if($request->emailParticipante != null){
        
        foreach ($request->emailParticipante as $key => $value) {

          $userParticipante = User::where('email', $value)->first();
          $participante = new Participante();
          if($userParticipante == null){

            $passwordTemporario = Str::random(8);
            Mail::to($value)->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, '  ', 'Participante', $evento->nome, $passwordTemporario));
            $usuario = User::create([
              'email' => $value,
              'password' => bcrypt($passwordTemporario),
              'usuarioTemp' => true,
              'name' => $request->nomeParticipante[$key],
              'tipo' => 'participante',
            ]);

            $participante->user_id = $usuario->id;
            $participante->trabalho_id = $trabalho->id;
            $participante->funcao_participante_id = $request->funcaoParticipante[$key];
            $participante->save();

            $participante->trabalhos()->save($trabalho);
          }else{

            $participante->user_id = $userParticipante->id;
            $participante->trabalho_id = $trabalho->id;
            $participante->funcao_participante_id = $request->funcaoParticipante[$key];
            $participante->save();

            $participante->trabalhos()->save($trabalho);

            $subject = "Participante de Projeto";            
            $email = $value;
            Mail::to($email)
                  ->send(new SubmissaoTrabalho($userParticipante, $subject));
          }

          $usuario = User::where('email', $value)->first();
          $participante = Participante::where([['user_id', '=', $usuario->id], ['trabalho_id', '=', $trabalho->id]])->first();
          $path = 'trabalhos/' . $request->editalId . '/' . $trabalho->id .'/';
          $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
          $file = $request->anexoPlanoTrabalho[$key];
          Storage::putFileAs($path, $file, $nome);

          $arquivo = new Arquivo();
          $arquivo->nome = $path . $nome;
          $arquivo->trabalhoId = $trabalho->id;
          $arquivo->data = $mytime;
          $arquivo->participanteId = $participante->id;
          $arquivo->versaoFinal = true;
          $arquivo->save();
        }
      }
      
      $pasta = 'trabalhos/' . $request->editalId . '/' . $trabalho->id;

      if( $evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM') {
        $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoCONSU,  "CONSU.pdf");
      }

      if (!(is_null($request->anexoComiteEtica))) {
        $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoComiteEtica,  "Comite_de_etica.pdf");
      } else {
        $trabalho->justificativaAutorizacaoEtica = Storage::putFileAs($pasta, $request->justificativaAutorizacaoEtica,  "Justificativa.pdf");
      }

      $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto,  "Projeto.pdf");
      $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLatterCoordenador,  "Latter_Coordenador.pdf");
      $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilha,  "Planilha.pdf");
      $trabalho->update();

      //dd($trabalho);

      $subject = "Submissão de Trabalho";
      $autor = Auth()->user();
      Mail::to($autor->email)
            ->send(new SubmissaoTrabalho($autor, $subject));
      
      return redirect()->route('evento.visualizar',['id'=>$request->editalId]);
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
    public function edit($id)
    {
      $projeto = Trabalho::find($id);
      $edital = Evento::find($projeto->evento_id);
      $grandeAreas = GrandeArea::all();
      $areas = Area::all();
      $subareas = Subarea::all();
      $funcaoParticipantes = FuncaoParticipantes::all();
      $participantes = Participante::where('trabalho_id', $id)->get();
      $arquivos = Arquivo::where('trabalhoId', $id)->get();

      return view('projeto.editar')->with(['projeto' => $projeto,
                                           'grandeAreas' => $grandeAreas,
                                           'areas' => $areas,
                                           'subAreas' => $subareas,
                                           'edital' => $edital,
                                           'funcaoParticipantes' => $funcaoParticipantes,
                                           'participantes' => $participantes,
                                           'arquivos' => $arquivos,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trabalho  $trabalho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $mytime = Carbon::now('America/Recife');
      $mytime = $mytime->toDateString();
      $evento = Evento::find($request->editalId);
      $coordenador = CoordenadorComissao::find($evento->coordenadorId);
      //Relaciona o projeto criado com o proponente que criou o projeto
      $proponente = Proponente::where('user_id', Auth::user()->id)->first();
      //$trabalho->proponentes()->save($proponente);  
      //dd($coordenador->id);
      $trabalho = "trabalho";
      if($evento->inicioSubmissao > $mytime){
        if($mytime >= $evento->fimSubmissao){
            return redirect()->route('home');
        }
      }

      //O anexo de Decisão do CONSU dependo do tipo de edital
      if( $evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM'){

        $validatedData = $request->validate([
          'editalId'                => ['required', 'string'],
          'nomeProjeto'             => ['required', 'string'],
          'grandeArea'              => ['required', 'string'],
          'area'                    => ['required', 'string'],
          'subArea'                 => ['required', 'string'],
          'pontuacaoPlanilha'       => ['required', 'string'],
          'linkGrupo'               => ['required', 'string'],
          'linkLattesEstudante'     => ['required', 'string'],
          'nomeParticipante.*'      => ['required', 'string'],
          'emailParticipante.*'     => ['required', 'string'],
          'funcaoParticipante.*'    => ['required', 'string'],
        ]);

      }else{
        //Caso em que o anexo da Decisão do CONSU não necessário
        $validatedData = $request->validate([
          'editalId'                => ['required', 'string'],
          'nomeProjeto'             => ['required', 'string',],
          'grandeArea'              => ['required', 'string'],
          'area'                    => ['required', 'string'],
          'subArea'                 => ['required', 'string'],
          'pontuacaoPlanilha'       => ['required', 'string'],
          'linkGrupo'               => ['required', 'string'],
          'linkLattesEstudante'     => ['required', 'string'],
          'nomeCoordenador'         => ['required', 'string'],
          'nomeParticipante.*'      => ['required', 'string'],
          'emailParticipante.*'     => ['required', 'string'],
          'funcaoParticipante.*'    => ['required', 'string'],
        ]);
      }

      $trabalho = Trabalho::find($id);
      $trabalho->titulo = $request->nomeProjeto;
      $trabalho->coordenador_id = $coordenador->id;
      $trabalho->grande_area_id = $request->grandeArea;
      $trabalho->area_id = $request->area;
      $trabalho->sub_area_id = $request->subArea;           
      $trabalho->pontuacaoPlanilha = $request->pontuacaoPlanilha;
      $trabalho->linkGrupoPesquisa = $request->linkGrupo;
      $trabalho->linkLattesEstudante = $request->linkLattesEstudante;
      $trabalho->data = $mytime;
      $trabalho->evento_id = $request->editalId;
      $trabalho->proponente_id = $proponente->id;
        
      $pasta = 'trabalhos/' . $request->editalId . '/' . $trabalho->id;

      if (!(is_null($request->anexoCONSU))) {
        Storage::delete($trabalho->anexoDecisaoCONSU);
        $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoCONSU,  "CONSU.pdf");
      }

      if (!(is_null($request->anexoProjeto))) {
        Storage::delete($trabalho->anexoProjeto);
        $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto,  "Projeto.pdf");
      }
      
      if (!(is_null($request->anexoComiteEtica))) {
        Storage::delete($trabalho->anexoComiteEtica);
        $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoComiteEtica,  "Comite_de_etica.pdf");
      }
      
      if (!(is_null($request->anexoLatterCoordenador))) {
        Storage::delete($trabalho->anexoLattesCoordenador);
        $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLatterCoordenador,  "Latter_Coordenador.pdf");
      }
      
      if (!(is_null($request->anexoPlanilha))) {
        Storage::delete($trabalho->anexoLattesCoordenador);
        $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilha,  "Planilha.pdf");
      }
      //atualizando projeto
      $trabalho->update();

      // criando novos participantes que podem ter sido adicionados
      $participantes = Participante::where('trabalho_id', $trabalho->id)->get();
      $emailParticipantes = [];
      foreach ($participantes as $participante) {
        array_push($emailParticipantes, $participante->user->email);
      }

      foreach ($request->emailParticipante as $key => $value) {
        // criando novos participantes que podem ter sido adicionados
        if (!(in_array($request->emailParticipante[$key], $emailParticipantes, false))) {
          $passwordTemporario = Str::random(8);
          Mail::to($value)->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, '  ', 'Participante', $evento->nome, $passwordTemporario));
          $usuario = User::create([
            'email' => $value,
            'password' => bcrypt($passwordTemporario),
            'usuarioTemp' => true,
            'name' => $request->nomeParticipante[$key],
            'tipo' => 'participante',
          ]);

          $participante = new Participante();
          $participante->user_id = $usuario->id;
          $participante->trabalho_id = $trabalho->id;
          $participante->funcao_participante_id = $request->funcaoParticipante[$key];
          $participante->save();

          $path = 'trabalhos/' . $request->editalId . '/' . $trabalho->id .'/';
          $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
          $file = $request->anexoPlanoTrabalho[$key];
          Storage::putFileAs($path, $file, $nome);

          $arquivo = new Arquivo();
          $arquivo->nome = $path . $nome;
          $arquivo->trabalhoId = $trabalho->id;
          $arquivo->data = $mytime;
          $arquivo->participanteId = $participante->id;
          $arquivo->versaoFinal = true;
          $arquivo->save();
        }

        //atualizando os participantes que já estão no projeto e planos de trabalho se enviados
        if (in_array($request->emailParticipante[$key], $emailParticipantes, false)) {
          $user = User::where('email', $request->emailParticipante[$key])->first();
          $participante::where([['user_id', '=', $user->id], ['trabalho_id', '=', $trabalho->id]]);

          $user->name = $request->nomeParticipante[$key];
          $user->update();

          $participante->funcao_participante_id = $request->funcaoParticipante[$key];
          $participante->update();

          // //atualizando planos de trabalho incompleto
          // dd($request);
          // if (!(is_null($request->anexoPlanoTrabalho[1]))) {
          //   $arquivo = Arquivo::where('participanteId', $participante->id)->first();
          //   Storage::delete($arquivo->nome);
          //   $arquivo->delete();

          //   $path = 'trabalhos/' . $request->editalId . '/' . $trabalho->id .'/';
          //   $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
          //   $file = $request->anexoPlanoTrabalho[$key];
          //   Storage::putFileAs($path, $file, $nome);

          //   $arquivo = new Arquivo();
          //   $arquivo->nome = $path . $nome;
          //   $arquivo->trabalhoId = $trabalho->id;
          //   $arquivo->data = $mytime;
          //   $arquivo->participanteId = $participante->id;
          //   $arquivo->versaoFinal = true;
          //   $arquivo->save();
          // }
        }
      }
      
      // Atualizando possiveis usuários removidos
      $participantes = Participante::where('trabalho_id', $trabalho->id)->get();

      foreach ($participantes as $participante) {
        if (!(in_array($participante->user->email, $request->emailParticipante, false))) {
          $arquivo = Arquivo::where('participanteId', $participante->id);
          Storage::delete($arquivo->nome);
          $arquivo->delete();
          $participante->delete();
        }
      }

      return redirect()->route('evento.visualizar',['id'=>$request->editalId]);
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
    public function atribuirAvaliadorTrabalho(Request $request){

      $request->trabalho_id;
      $trabalho = Trabalho::find($request->trabalho_id);

      $avaliadores = Avaliador::all();



      return view('coordenadorComissao.gerenciarEdital.atribuirAvaliadorTrabalho', ['avaliadores'=>$avaliadores, 'trabalho'=>$trabalho, 'evento'=> $trabalho->evento ]);

    }

    public function atribuir(Request $request){

        $trabalho = Trabalho::find($request->trabalho_id);

        $todosAvaliadores = Avaliador::all();

        $avaliadores = Avaliador::whereIn('id', $request->avaliadores)->with('user')->get();  

        $trabalho->avaliadors()->sync($request->avaliadores);

        foreach ($avaliadores as $key => $avaliador) {
          
          $user = $avaliador->user;
          $subject = "Trabalho atribuido";
          Mail::to($user->email)
              ->send(new EventoCriado($user, $subject));
        }

        return view('coordenadorComissao.detalhesEdital', ['evento'=> $trabalho->evento ]);
    }
    
    public function projetosDoEdital($id) {
      $edital = Evento::find($id);
      $projetos = Trabalho::where('evento_id', '=', $id)->get();

      return view('projeto.index')->with(['edital' => $edital, 'projetos' => $projetos]);
    }

    public function baixarAnexoProjeto($id) {
      $projeto = Trabalho::find($id);
      return Storage::download($projeto->anexoProjeto);
    }

    public function baixarAnexoConsu($id) {
      $projeto = Trabalho::find($id);
      return Storage::download($projeto->anexoDecisaoCONSU);
    }

    public function baixarAnexoComite($id) {
      $projeto = Trabalho::find($id);
      return Storage::download($projeto->anexoAutorizacaoComiteEtica);
    }

    public function baixarAnexoLattes($id) {
      $projeto = Trabalho::find($id);
      return Storage::download($projeto->anexoLattesCoordenador);
    }

    public function baixarAnexoPlanilha($id) {
      $projeto = Trabalho::find($id);
      return Storage::download($projeto->anexoPlanilhaPontuacao);
    }
}
