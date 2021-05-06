<?php

namespace App\Http\Controllers;

use App\AnexosTemp;
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
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailParaUsuarioNaoCadastrado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\SubmissaoTrabalho;
use App\Mail\EventoCriado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\OutrasInfoParticipante;

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
        $grandeAreas = GrandeArea::orderBy('nome')->get();
        $funcaoParticipantes = FuncaoParticipantes::orderBy('nome')->get();
        $proponente = Proponente::where('user_id', Auth::user()->id)->first();

        if($proponente == null){
          return view('proponente.cadastro')->with(['mensagem' => 'Você não possui perfil de Proponente, para submeter algum projeto preencha o formulário.']);;
        }

        $rascunho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id',$edital->id)->where('status', 'Rascunho')
                                ->orderByDesc('updated_at')->first();

      //dd($rascunho);

        return view('evento.submeterTrabalho',[
                                            'edital'             => $edital,
                                            'grandeAreas'        => $grandeAreas,
                                            'funcaoParticipantes'=> $funcaoParticipantes,
                                            'rascunho'           => $rascunho,
                                            'enum_turno'         => OutrasInfoParticipante::ENUM_TURNO
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
      // if($proponente == null){
      //   return view('proponente.cadastro');
      // }
      //$trabalho->proponentes()->save($proponente);
      //dd($proponente);
      $trabalho = "trabalho";
      if($evento->inicioSubmissao > $mytime){
        if($mytime >= $evento->fimSubmissao){
            return redirect()->route('home');
        }
      }

      //--Salvando os dados da submissão temporariamente
      $trabalho = $this->armazenarInfoTemp($request, $proponente);

      //O anexo de Decisão do CONSU dependo do tipo de edital
      if( $evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM'){

        $validatedData = $request->validate([
          'editalId'                => ['required', 'string'],
          'nomeProjeto'             => ['required', 'string'],
          'grandeArea'              => ['required', 'string'],
          'area'                    => ['required', 'string'],
          'subArea'                 => ['required', 'string'],
          'pontuacaoPlanilha'       => ['required', 'string'],
          'linkGrupo'               => ['required', 'string', 'link_grupo'],
          'linkLattesEstudante'     => ['required', 'string', 'link_lattes'],
          'nomeParticipante.*'      => ['required', 'string'],
          'emailParticipante.*'     => ['required', 'string'],
          'funcaoParticipante'      => ['required', 'array', 'size:'.$request->countParticipante],
          'funcaoParticipante.*'    => ['required', 'string'],
          'nomePlanoTrabalho.*'     => ['nullable', 'string'],
          //--Verificando se anexos já foram submetidos
          'anexoProjeto'            => [($request->anexoProjetoPreenchido!=='sim'?'required':''), 'file', 'mimes:pdf', 'max:2048'],
          'anexoCONSU'              => [($request->anexoConsuPreenchido!=='sim'?'required':''), 'file', 'mimes:pdf', 'max:2048'],
          'botao'                   => ['required'],
          'anexoComiteEtica'        => [($request->anexoComitePreenchido!=='sim'&&$request->anexoJustificativaPreenchido!=='sim'?'required_without:justificativaAutorizacaoEtica':''), 'file', 'mimes:pdf', 'max:2048'],
          'justificativaAutorizacaoEtica' => [($request->anexoJustificativaPreenchido!=='sim'&&$request->anexoComitePreenchido!=='sim'?'required_without:anexoComiteEtica':''), 'file', 'mimes:pdf', 'max:2048'],
          'anexoLattesCoordenador'  => [($request->anexoLattesPreenchido!=='sim'?'required': ''), 'file', 'mimes:pdf', 'max:2048'],
          'anexoPlanilha'           => [($request->anexoPlanilhaPreenchido!=='sim'?'required':''), 'file', 'mimes:xls,xlsx,ods', 'max:2048'],
          'anexoPlanoTrabalho.*'    => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ]);
        
        if(gettype($this->validarAnexosRascunho($request, $trabalho)) != 'integer'){
          return $this->validarAnexosRascunho($request, $trabalho);
        }

        //$trabalho = Trabalho::create([
        $trabalho['titulo']                        = $request->nomeProjeto;
        $trabalho['coordenador_id']                = $coordenador->id;
        $trabalho['grande_area_id']                = $request->grandeArea;
        $trabalho['area_id']                       = $request->area;
        $trabalho['sub_area_id']                   = $request->subArea;
        $trabalho['pontuacaoPlanilha']             = $request->pontuacaoPlanilha;
        $trabalho['linkGrupoPesquisa']             = $request->linkGrupo;
        $trabalho['linkLattesEstudante']           = $request->linkLattesEstudante;
        $trabalho['data']                          = $mytime;
        $trabalho['evento_id']                     = $request->editalId;
        $trabalho['status']                        = 'Submetido';
        $trabalho['proponente_id']                 = $proponente->id;
        //Anexos
        $trabalho['anexoDecisaoCONSU']             = $request->anexoCONSU != null ? $request->anexoCONSU : $trabalho->anexoDecisaoCONSU;
        $trabalho['anexoProjeto']                  = $request->anexoProjeto != null ? $request->anexoProjeto : $trabalho->anexoProjeto;
        $trabalho['anexoAutorizacaoComiteEtica']   = $request->anexoComiteEtica != null ? $request->anexoComiteEtica : $trabalho->anexoAutorizacaoComiteEtica;
        $trabalho['justificativaAutorizacaoEtica'] = $request->justificativaAutorizacaoEtica != null ? $request->justificativaAutorizacaoEtica : $trabalho->justificativaAutorizacaoEtica;
        $trabalho['anexoLattesCoordenador']        = $request->anexoLattesCoordenador != null ? $request->anexoLattesCoordenador : $trabalho->anexoLattesCoordenador;
        $trabalho['anexoPlanilhaPontuacao']        = $request->anexoPlanilha != null ? $request->anexoPlanilha : $trabalho->anexoPlanilhaPontuacao;

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
          'linkGrupo'               => ['required', 'string', 'link_grupo'],
          'linkLattesEstudante'     => ['required', 'string', 'link_lattes'],
          'nomeParticipante.*'      => ['required', 'string'],
          'emailParticipante.*'     => ['required', 'string'],
          'funcaoParticipante.*'    => ['required', 'string'],
          'nomePlanoTrabalho.*'     => ['nullable', 'string'],
          'anexoProjeto'            => [($request->anexoProjetoPreenchido!=='sim'?'required':''), 'file', 'mimes:pdf', 'max:2048'],
          'anexoLattesCoordenador'  => [($request->anexoLattesPreenchido!=='sim'?'required':''), 'file', 'mimes:pdf', 'max:2048'],
          'anexoPlanilha'           => [($request->anexoPlanilhaPreenchido!=='sim'?'required':''), 'file', 'mimes:xls,xlsx,ods', 'max:2048'],
          'anexoPlanoTrabalho.*'    => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        if(gettype($this->validarAnexosRascunho($request, $trabalho)) != 'integer'){
          return $this->validarAnexosRascunho($request, $trabalho);
        }
        //$trabalho = Trabalho::create([
          $trabalho['titulo']                        = $request->nomeProjeto;
          $trabalho['coordenador_id']                = $coordenador->id;
          $trabalho['grande_area_id']                = $request->grandeArea;
          $trabalho['area_id']                       = $request->area;
          $trabalho['sub_area_id']                   = $request->subArea;
          $trabalho['pontuacaoPlanilha']             = $request->pontuacaoPlanilha;
          $trabalho['linkGrupoPesquisa']             = $request->linkGrupo;
          $trabalho['linkLattesEstudante']           = $request->linkLattesEstudante;
          $trabalho['data']                          = $mytime;
          $trabalho['evento_id']                     = $request->editalId;
          $trabalho['status']                        = 'Submetido';
          $trabalho['proponente_id']                 = $proponente->id;
          //Anexos
          $trabalho['anexoProjeto']                  = $request->anexoProjeto;
          $trabalho['anexoAutorizacaoComiteEtica']   = $request->anexoComiteEtica;
          $trabalho['justificativaAutorizacaoEtica'] = $request->justificativaAutorizacaoEtica;
          $trabalho['anexoLattesCoordenador']        = $request->anexoLattesCoordenador;
          $trabalho['anexoPlanilhaPontuacao']        = $request->anexoPlanilha;

      }

      //Envia email com senha temp para cada participante do projeto
      if($request->emailParticipante != null){

        foreach ($request->emailParticipante as $key => $value) {
          $userParticipante = User::where('email', $value)->first();
          $participante = new Participante();
          if($userParticipante == null){

            $passwordTemporario = Str::random(8);
            $subject = "Participante de Projeto";
            Mail::to($value)->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, $request->nomeProjeto, 'Participante', $evento->nome, $passwordTemporario, $subject));
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
            $usuario->participantes()->save($participante);
            $usuario->save();

            $participante->trabalhos()->save($trabalho);
          }else{

            $participante->user_id = $userParticipante->id;
            $participante->trabalho_id = $trabalho->id;
            $participante->funcao_participante_id = $request->funcaoParticipante[$key];
            $participante->save();
            $userParticipante->participantes()->save($participante);
            $userParticipante->save();
            $participante->trabalhos()->save($trabalho);
            $subject = "Participante de Projeto";
            $email = $value;
            Mail::to($email)
                  ->send(new SubmissaoTrabalho($userParticipante, $subject, $evento, $trabalho));
          }

          if($request->nomePlanoTrabalho[$key] != null){
            $usuario = User::where('email', $value)->first();
            $participante = Participante::where([['user_id', '=', $usuario->id], ['trabalho_id', '=', $trabalho->id]])->first();
            $path = 'trabalhos/' . $request->editalId . '/' . $trabalho->id .'/';
            $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
            $file = $request->anexoPlanoTrabalho[$key];
            Storage::putFileAs($path, $file, $nome);

            $mytime = Carbon::now('America/Recife');
            $mytime = $mytime->toDateString();
            $arquivo = new Arquivo();
            $arquivo->titulo = $request->nomePlanoTrabalho[$key];
            $arquivo->nome = $path . $nome;
            $arquivo->trabalhoId = $trabalho->id;
            $arquivo->data = $mytime;
            $arquivo->participanteId = $participante->id;
            $arquivo->versaoFinal = true;
            $arquivo->save();
          }
        }
      }

      //-- Salvando anexos no storage ---//

      $pasta = 'trabalhos/' . $request->editalId . '/' . $trabalho->id;

      $trabalho = $this->armazenarAnexosFinais($request, $pasta, $trabalho, $evento);
      $subject = "Submissão de Trabalho";
      $autor = Auth()->user();
      $evento = $evento;
      $trabalho = $trabalho;
      Mail::to($autor->email)
            ->send(new SubmissaoTrabalho($autor, $subject, $evento, $trabalho));

      return redirect()->route('evento.visualizar',['id'=>$request->editalId]);
    }

    public function storeParcial(Request $request){
      $mytime = Carbon::now('America/Recife');
      $mytime = $mytime->toDateString();
      $evento = Evento::find($request->editalId);
      $coordenador = CoordenadorComissao::find($evento->coordenadorId);

      //Relaciona o projeto criado com o proponente que criou o projeto
      $proponente = Proponente::where('user_id', Auth::user()->id)->first();

      $trabalho = "trabalho";
      if($evento->inicioSubmissao > $mytime){
        if($mytime >= $evento->fimSubmissao){
            return redirect()->route('home');
        }
      }

      //--Salvando os dados da submissão temporariamente
      $this->armazenarInfoTemp($request, $proponente);

      return redirect()->route('projetos.edital',['id'=>$request->editalId]);
    }

    //Armazena temporariamente dados da submissão, no banco de dados e no storage
    public function armazenarInfoTemp(Request $request, $proponente){

      //---Dados do Projeto
      $trabalho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id',$request->editalId)->where('status', 'Rascunho')
                                ->orderByDesc('updated_at')->first();
      //dd($trabalho);
      if($trabalho == null){
        $trabalho = new Trabalho();
        $trabalho->proponente_id = $proponente->id;
        $trabalho->evento_id = $request->editalId;
        $trabalho->status = 'Rascunho';

        $stringKeys = ['titulo','linkGrupoPesquisa', 'linkLattesEstudante','pontuacaoPlanilha','anexoProjeto',
                        'anexoPlanilhaPontuacao', 'anexoLattesCoordenador'];
        $intKeys = ['grande_area_id','area_id','sub_area_id','coordenador_id'];

        $trabalho->fill(
          array_fill_keys($stringKeys, "") + array_fill_keys($intKeys, 1)
        )->save();
        //dd($trabalho);
      }

      if(!(is_null($request->nomeProjeto)) ) {
        $trabalho->titulo = $request->nomeProjeto;
      }
      if(!(is_null($request->grandeArea))){
        $trabalho->grande_area_id = $request->grandeArea;
      }
      if(!(is_null($request->area))){
        $trabalho->area_id = $request->area;
      }
      if(!(is_null($request->subArea))){
        $trabalho->sub_area_id = $request->subArea;
      }
      if(!(is_null($request->pontuacaoPlanilha))){
        $trabalho->pontuacaoPlanilha = $request->pontuacaoPlanilha;
      }
      if(!(is_null($request->linkGrupo))){
        $trabalho->linkGrupoPesquisa = $request->linkGrupo;
      }

      //Anexos do projeto

      $pasta = 'trabalhos/' . $request->editalId . '/' . $trabalho->id;

      if(!(is_null($request->anexoCONSU)) ) {
        $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoCONSU,  "CONSU.pdf");
      }
      if (!(is_null($request->anexoComiteEtica))) {
        $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoComiteEtica,  "Comite_de_etica.pdf");
      }
      if (!(is_null($request->justificativaAutorizacaoEtica))) {
        $trabalho->justificativaAutorizacaoEtica = Storage::putFileAs($pasta, $request->justificativaAutorizacaoEtica,  "Justificativa.pdf");
      }
      if (!(is_null($request->anexoProjeto))) {
        $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto,  "Projeto.pdf");
      }
      if (!(is_null($request->anexoLattesCoordenador))) {
        $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLattesCoordenador,  "Lattes_Coordenador.pdf");
      }
      if (!(is_null($request->anexoPlanilha))) {
        $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilha,  "Planilha.". $request->file('anexoPlanilha')->extension());
      }

      $trabalho->update();

      //---Anexos planos de trabalho

      //dd($trabalho);

      return $trabalho;
    }

    public function validarAnexosRascunho(Request $request, $trabalho){
      //dd($trabalho->getAttributes());
      $validator = Validator::make($trabalho->getAttributes(),[
         'anexoPlanilhaPontuacao'           => $request->anexoPlanilha==null?['planilha']:[],
      ]);

      if ($validator->fails()) {
        //dd('asdf');
        return back()->withErrors($validator)->withInput();
      }
      return 1;
    }

    public function armazenarAnexosFinais($request, $pasta, $trabalho, $evento){

      // Anexo Projeto
      if(isset($request->anexoProjeto)){
        $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto, 'Projeto.pdf');
      }

      //Anexo Decisão CONSU
      if( $evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM') {
        if( isset($request->anexoCONSU)){
          $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoCONSU, 'CONSU.pdf');
        }
      }

      //Autorização ou Justificativa
      if( isset($request->anexoComiteEtica)){
        $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoComiteEtica, 'Comite_de_etica.pdf');

      } elseif( isset($request->justificativaAutorizacaoEtica)){
        $trabalho->justificativaAutorizacaoEtica = Storage::putFileAs($pasta, $request->justificativaAutorizacaoEtica, 'Justificativa.pdf');
      }

     //Anexo Lattes
      if( isset($request->anexoLattesCoordenador)){
        $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLattesCoordenador, 'Lattes_Coordenador.pdf');
      }

      //Anexo Planilha
      if( isset($request->anexoPlanilha)){
        $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilha, "Planilha.". $request->file('anexoPlanilha')->extension());
      }

      $trabalho->update();

      return $trabalho;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Trabalho  $trabalho
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
      $projeto = Trabalho::find($id);
      $edital = Evento::find($projeto->evento_id);
      $grandeArea = GrandeArea::where('id', $projeto->grande_area_id)->select('nome')->first();
      $area = Area::where('id', $projeto->area_id)->select('nome')->first();
      $subarea = Subarea::where('id', $projeto->sub_area_id)->select('nome')->first();
      $proponente = Proponente::find($projeto->proponente_id);
      $funcaoParticipantes = FuncaoParticipantes::all();
      $participantes = Participante::where('trabalho_id', $id)->get();
      $participantesUsersIds = Participante::where('trabalho_id', $id)->select('user_id')->get();
      $users = User::whereIn('id', $participantesUsersIds)->get();
      $arquivos = Arquivo::where('trabalhoId', $id)->get();
      return view('projeto.visualizar')->with(['projeto' => $projeto,
                                           'grandeArea' => $grandeArea,
                                           'area' => $area,
                                           'subArea' => $subarea,
                                           'proponente' => $proponente,
                                           'edital' => $edital,
                                           'users' => $users,
                                           'funcaoParticipantes' => $funcaoParticipantes,
                                           'participantes' => $participantes,
                                           'arquivos' => $arquivos,]);
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
      $participantesUsersIds = Participante::where('trabalho_id', $id)->select('user_id')->get();
      $users = User::whereIn('id', $participantesUsersIds)->get();
      $arquivos = Arquivo::where('trabalhoId', $id)->get();
      //dd(Participante::all());
      return view('projeto.editar')->with(['projeto' => $projeto,
                                           'grandeAreas' => $grandeAreas,
                                           'areas' => $areas,
                                           'subAreas' => $subareas,
                                           'edital' => $edital,
                                           'users' => $users,
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

      if (!(is_null($request->anexoLattesCoordenador))) {
        Storage::delete($trabalho->anexoLattesCoordenador);
        $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLattesCoordenador,  "Latter_Coordenador.pdf");
      }

      if (!(is_null($request->anexoPlanilha))) {
        Storage::delete($trabalho->anexoLattesCoordenador);
        $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilha,  "Planilha.pdf");
      }
      //atualizando projeto
      $trabalho->update();

      // criando novos participantes que podem ter sido adicionados
      $participantesUsersIds = Participante::where('trabalho_id', '=', $trabalho->id)->select('user_id')->get();
      $users = User::whereIn('id', $participantesUsersIds)->get();
      $emailParticipantes = [];
      foreach ($users as $user) {
        array_push($emailParticipantes, $user->email);
      }
      foreach ($request->emailParticipante as $key => $value) {
        // criando novos participantes que podem ter sido adicionados
        if (!(in_array($request->emailParticipante[$key], $emailParticipantes, false))) {
          $userParticipante = User::where('email', $value)->first();
          if($userParticipante == null){
            $passwordTemporario = Str::random(8);
            $subject = "Participante de Projeto";
            Mail::to($value)->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, '  ', 'Participante', $evento->nome, $passwordTemporario, $subject));
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

          }else{
            $participante = new Participante();
            $participante->user_id = $userParticipante->id;
            $participante->trabalho_id = $trabalho->id;
            $participante->funcao_participante_id = $request->funcaoParticipante[$key];
            $participante->save();

            $participante->trabalhos()->save($trabalho);

            $subject = "Participante de Projeto";
            $email = $value;
            Mail::to($email)
                  ->send(new SubmissaoTrabalho($userParticipante, $subject, $evento, $trabalho));
          }

          $path = 'trabalhos/' . $request->editalId . '/' . $trabalho->id .'/';
          $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
          $file = $request->anexoPlanoTrabalho[$key];
          Storage::putFileAs($path, $file, $nome);

          $arquivo = new Arquivo();
          $arquivo->titulo = $request->nomePlanoTrabalho[$key];
          $arquivo->nome = $path . $nome;
          $arquivo->trabalhoId = $trabalho->id;
          $arquivo->data = $mytime;
          $arquivo->participanteId = $participante->id;
          $arquivo->versaoFinal = true;
          $arquivo->save();
        }

        //atualizando os participantes que já estão no projeto e planos de trabalho se enviados
        if (in_array($request->emailParticipante[$key], $emailParticipantes, false)) {
          $userParticipante = User::where('email', $value)->first();
          if($userParticipante != null){

            $user = User::where('email', $request->emailParticipante[$key])->first();
            $participante = Participante::where([['user_id', '=', $user->id], ['trabalho_id', '=', $trabalho->id]])->first();

            $user->name = $request->nomeParticipante[$key];
            $user->update();

            $participante->funcao_participante_id = $request->funcaoParticipante[$key];
            $participante->update();

            //atualizando planos de trabalho
            if ($request->anexoPlanoTrabalho != null && array_key_exists($key, $request->anexoPlanoTrabalho)) {
              if (!(is_null($request->anexoPlanoTrabalho[$key]))) {
                $arquivo = Arquivo::where('participanteId', $participante->id)->first();
                //se plano já existir, deletar
                if($arquivo != null){
                  Storage::delete($arquivo->nome);
                  $arquivo->delete();
                }

                //atualizar plano
                if($request->semPlano[$key] == null){
                  $path = 'trabalhos/' . $request->editalId . '/' . $trabalho->id .'/';
                  $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
                  $file = $request->anexoPlanoTrabalho[$key];
                  Storage::putFileAs($path, $file, $nome);

                  $arquivo = new Arquivo();
                  $arquivo->titulo = $request->nomePlanoTrabalho[$key];
                  $arquivo->nome = $path . $nome;
                  $arquivo->trabalhoId = $trabalho->id;
                  $arquivo->data = $mytime;
                  $arquivo->participanteId = $participante->id;
                  $arquivo->versaoFinal = true;
                  $arquivo->save();
                }
              }
            }
            //removendo planos de trabalho
            if($request->nomePlanoTrabalho != null && array_key_exists($key, $request->nomePlanoTrabalho)){
              if($request->semPlano[$key] == 'sim'){
                $arquivo = Arquivo::where('participanteId', $participante->id)->first();
                //se plano já existir, deletar
                if($arquivo != null){
                  Storage::delete($arquivo->nome);
                  $arquivo->delete();
                }
              }
            }
          }
        }
      }

      // Atualizando possiveis usuários removidos
      $participantesUsersIds = Participante::where('trabalho_id', '=', $trabalho->id)->select('user_id')->get();
      $users = User::whereIn('id', $participantesUsersIds)->get();

      foreach ($users as $user) {
        if (!(in_array($user->email, $request->emailParticipante, false))) {
          $participante = Participante::where([['user_id', '=', $user->id], ['trabalho_id', '=', $trabalho->id]])->first();
          $arquivo = Arquivo::where('participanteId', $participante->id)->first();
          if($arquivo != null){
            Storage::delete($arquivo->nome);
            $arquivo->delete();
          }
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
    public function destroy(Request $request)
    {
        $trabalho = Trabalho::find($request->id);
        //dd($trabalho);
        Storage::deleteDirectory('trabalhos/' . $trabalho->evento->id . '/' . $trabalho->id );

        $trabalho->delete();
        return redirect()->back()->with(['mensagem' => 'Projeto deletado com sucesso!']);
    }

    public function excluirParticipante($id){
      $participante = Participante::where('user_id', Auth()->user()->id)
                                  ->where('trabalho_id', $id)->first();

      $participante->trabalhos()->detach($id);
      $participante->delete();

      return redirect()->back();
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
      $hoje = Carbon::today('America/Recife');
      $hoje = $hoje->toDateString();

      return view('proponente.projetosEdital')->with(['edital' => $edital, 'projetos' => $projetos, 'hoje'=>$hoje]);
    }

    public function baixarAnexoProjeto($id) {
      $projeto = Trabalho::find($id);
      //dd($projeto);
      if (Storage::disk()->exists($projeto->anexoProjeto)) {
        return Storage::download($projeto->anexoProjeto);
      }
      return abort(404);
    }

    public function baixarAnexoConsu($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->anexoDecisaoCONSU)) {
        return Storage::download($projeto->anexoDecisaoCONSU);
      }
      return abort(404);
    }

    public function baixarAnexoComite($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->anexoAutorizacaoComiteEtica)) {
        return Storage::download($projeto->anexoAutorizacaoComiteEtica);
      }
      return abort(404);
    }

    public function baixarAnexoLattes($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->anexoLattesCoordenador)) {
        return Storage::download($projeto->anexoLattesCoordenador);
      }
      return abort(404);
    }

    public function baixarAnexoPlanilha($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->anexoPlanilhaPontuacao)) {
        return Storage::download($projeto->anexoPlanilhaPontuacao);
      }
      return abort(404);
    }

    public function baixarAnexoJustificativa($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->justificativaAutorizacaoEtica)) {
        return Storage::download($projeto->justificativaAutorizacaoEtica);
      }

      return abort(404);
    }

    public function baixarAnexoTemp($eventoId, $nomeAnexo) {
      $proponente = Proponente::where('user_id', Auth::user()->id)->first();

      $trabalho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id',$eventoId)->where('status', 'Rascunho')
                  ->orderByDesc('updated_at')->first();

      if (Storage::disk()->exists($trabalho->$nomeAnexo)) {
        return Storage::download($trabalho->$nomeAnexo);
      }
      return abort(404);
    }

    public function baixarEventoTemp($nomeAnexo){
      $eventoTemp = Evento::where('criador_id', Auth::user()->id)->where('anexosStatus', 'temporario')
                            ->orderByDesc('updated_at')->first();

      if (Storage::disk()->exists($eventoTemp->$nomeAnexo)) {
        return Storage::download($eventoTemp->$nomeAnexo);
      }
      return abort(404);
    }
}