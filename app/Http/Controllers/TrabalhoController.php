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
use App\GrandeArea;
use App\SubArea;
use App\FuncaoParticipantes;
use App\Participante;
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

      if($evento->inicioSubmissao > $mytime){
        if($mytime >= $evento->fimSubmissao){
            return redirect()->route('home');
        }
      }
      
      //O anexo de Decisão do CONSU dependo do tipo de edital
      if( $evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM'){

        $validatedData = $request->validate([
          'editalId'                => ['required', 'integer'],
          'nomeProjeto'             => ['required', 'string',],
          'grandeAreaId'            => ['required', 'integer'],
          'areaId'                  => ['required', 'integer'],
          'subAreaId'               => ['required', 'integer'],
          'pontuacaoPlanilha'       => ['required', 'integer'],
          'linkGrupo'               => ['required', 'string'],
          'linkLattesEstudante'     => ['required', 'string'],
          'nomeCoordenador'         => ['required', 'string'],
          'nomeParticipante.*'      => ['required', 'string'],
          'emailParticipante.*'     => ['string'],
          'nomePlanoTrabalho.*'     => ['string'],
          'anexoProjeto'            => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoCONSU'              => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoLatterCoordenador'  => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoPlanilha'           => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoPlanoTrabalho.*'    => ['required', 'file', 'mimes:pdf', 'max:2000000'],
        ]);

        $trabalho = Trabalho::create([
          'titulo'                      => $request->nomeProjeto,
          'grande_area_id'              => $request->grandeAreaId,
          'area_id'                     => $request->areaId,
          'sub_area_id'                 => $request->subAreaId,        
          'coordenador'                 => $request->nomeCoordenador,       
          'pontuacaoPlanilha'           => $request->pontuacaoPlanilha,
          'linkGrupoPesquisa'           => $request->linkGrupo,
          'linkLattesEstudante'         => $request->linkLattesEstudante,
          'data'                        => $mytime,
          'evento_id'                   => $request->editalId,
          'avaliado'                    => 0,
          //Anexos
          'anexoDecisaoCONSU'           => $request->anexoCONSU,
          'anexoProjeto'                => $request->anexoProjeto,
          'anexoAutorizacaoComiteEtica' => $request->anexoComiteEtica,
          'anexoLattesCoordenador'      => $request->anexoLatterCoordenador,
          'anexoPlanilhaPontuacao'      => $request->anexoPlanilha,
        ]);
      }else{
        //Caso em que o anexo da Decisão do CONSU não necessário
        $validatedData = $request->validate([
          'editalId'                => ['required', 'integer'],
          'nomeProjeto'             => ['required', 'string',],
          'grandeAreaId'            => ['required', 'integer'],
          'areaId'                  => ['required', 'integer'],
          'subAreaId'               => ['required', 'integer'],
          'pontuacaoPlanilha'       => ['required', 'integer'],
          'linkGrupo'               => ['required', 'string'],
          'linkLattesEstudante'     => ['required', 'string'],
          'nomeCoordenador'         => ['required', 'string'],
          'nomeParticipante.*'      => ['required', 'string'],
          'emailParticipante.*'     => ['string'],
          'nomePlanoTrabalho.*'     => ['string'],
          'anexoProjeto'            => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoLatterCoordenador'  => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoPlanilha'           => ['required', 'file', 'mimes:pdf', 'max:2000000'],
          'anexoPlanoTrabalho.*'    => ['required', 'file', 'mimes:pdf', 'max:2000000'],
        ]);

        $trabalho = Trabalho::create([
          'titulo'                      => $request->nomeProjeto,
          'grande_area_id'              => $request->grandeAreaId,
          'area_id'                     => $request->areaId,
          'sub_area_id'                 => $request->subAreaId,        
          'coordenador'                 => $request->nomeCoordenador,       
          'pontuacaoPlanilha'           => $request->pontuacaoPlanilha,
          'linkGrupoPesquisa'           => $request->linkGrupo,
          'linkLattesEstudante'         => $request->linkLattesEstudante,
          'data'                        => $mytime,
          'evento_id'                   => $request->editalId,
          'avaliado'                    => 0,
          //Anexos
          'anexoProjeto'                => $request->anexoProjeto,
          'anexoAutorizacaoComiteEtica' => $request->anexoComiteEtica,
          'anexoLattesCoordenador'      => $request->anexoLatterCoordenador,
          'anexoPlanilhaPontuacao'      => $request->anexoPlanilha,
        ]);

      }

      //Relaciona o projeto criado com o proponente que criou o projeto
      $trabalho->proponente()->save(Auth()->user()); 

      //Envia email com senha temp para cada participante do projeto
      if($request->emailParticipante != null){
        
        foreach ($request->emailParticipante as $key => $value) {

          $userParticipante = User::where('email', $value)->first();

          if($userParticipante == null){

            $passwordTemporario = Str::random(8);
            Mail::to($value)->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, '  ', 'Participante', $evento->nome, $passwordTemporario));
            $usuario = User::create([
              'email' => $value,
              'password' => bcrypt($passwordTemporario),
              'usuarioTemp' => true,
              'name' => $request->nomeParticipante[$key],
              'funcao_participante_id' => $request->funcaoParticipante[$key],
            ]);

            $participante = $usuario->participantes()->create([
              'trabalho_id' => $trabalho->id,
            ]);

            $participante->trabalhos()->save($trabalho);
          }else{

            $subject = "Participante de Projeto";            
            $email = $value;
            Mail::to($email)
                  ->send(new SubmissaoTrabalho($userParticipante, $subject));
          }
        }
      }
      
      $anexos = array( 
                      $request->anexoCONSU, 
                      $request->anexoProjeto, 
                      $request->anexoComiteEtica,
                      $request->anexoLatterCoordenador,
                      $request->anexoPlanilha,
                    );

      foreach ($anexos as $key => $value) {

        $file = $value;
        $path = 'trabalhos/' . $request->editalId . '/' . $trabalho->id .'/';
        $nome =  "1.pdf";
        Storage::putFileAs($path, $file, $nome);

        $arquivo = Arquivo::create([
          'nome'  => $path . $nome,
          'trabalhoId'  => $trabalho->id,
          'data' => $mytime,
          'versaoFinal' => true,
        ]);
      
      }
      
      if($request->anexoPlanoTrabalho != null){        
        foreach ($request->anexoPlanoTrabalho as $key => $value) {

          $file = $value;
          $path = 'trabalhos/' . $request->editalId . '/' . $trabalho->id .'/';
          $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
          Storage::putFileAs($path, $file, $nome);

          $arquivo = Arquivo::create([
            'nome'  => $path . $nome,
            'trabalhoId'  => $trabalho->id,
            'data' => $mytime,
            'versaoFinal' => true,
          ]);
        
        }
      }

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
