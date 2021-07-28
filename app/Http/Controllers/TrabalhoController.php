<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use App\Area;
use App\User;
use App\Evento;
use App\Arquivo;
use App\Coautor;
use App\Revisor;
use App\SubArea;
use App\Endereco;
use App\Trabalho;
use App\Avaliador;
use Carbon\Carbon;
use App\AnexosTemp;
use App\Atribuicao;
use App\GrandeArea;
use App\Modalidade;
use App\Proponente;
use App\Participante;
use App\AreaModalidade;
use Illuminate\Http\File;
use App\Mail\EventoCriado;
use Illuminate\Support\Str;
use App\CoordenadorComissao;
use App\FuncaoParticipantes;
use Illuminate\Http\Request;
use App\Mail\SubmissaoTrabalho;
use App\OutrasInfoParticipante;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTrabalho;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UpdateTrabalho;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\EmailParaUsuarioNaoCadastrado;
use App\Notifications\SubmissaoNotification;
use Illuminate\Support\Facades\Notification;

class TrabalhoController extends Controller
{
    ###### Prototipo troca de participantes ######

    public function telaTrocaPart(Request $request){
        $projeto = Trabalho::find($request->projeto_id);
        $edital = Evento::find($projeto->evento_id);

        $participantes = $projeto->participantes;
        $participantesUsersIds = Participante::where('trabalho_id', $projeto->id)->select('user_id')->get();

        $participantesExcluidos = Participante::onlyTrashed()->where('trabalho_id', $projeto->id);
        $participantesExcluidosUsersIds = Participante::onlyTrashed()->where('trabalho_id', $projeto->id)->select('user_id');
        
        $users = User::whereIn('id', $participantesUsersIds)->get();
        $usersExcluidos = User::whereIn('id', $participantesExcluidosUsersIds)->get();
        
        $arquivos = Arquivo::where('trabalhoId', $projeto->id)->get();

        return view('trocarParti')->with(['projeto' => $projeto,
                                                'edital'     => $edital,
                                                'users'      => $users,
                                                'usersExcluidos' => $usersExcluidos,
                                                'participantes' => $participantes,
                                                'participantesExcluidos' => $participantesExcluidos,
                                                'arquivos'   => $arquivos,
                                                'estados'    => $this->estados,
                                                'enum_turno' => Participante::ENUM_TURNO,
                                           ]);
    }
    ##############################################
    public $estados = array(
      'AC' => 'Acre',
      'AL' => 'Alagoas',
      'AP' => 'Amapá',
      'AM' => 'Amazonas',
      'BA' => 'Bahia',
      'CE' => 'Ceará',
      'DF' => 'Distrito Federal',
      'ES' => 'Espirito Santo',
      'GO' => 'Goiás',
      'MA' => 'Maranhão',
      'MS' => 'Mato Grosso do Sul',
      'MT' => 'Mato Grosso',
      'MG' => 'Minas Gerais',
      'PA' => 'Pará',
      'PB' => 'Paraíba',
      'PR' => 'Paraná',
      'PE' => 'Pernambuco',
      'PI' => 'Piauí',
      'RJ' => 'Rio de Janeiro',
      'RN' => 'Rio Grande do Norte',
      'RS' => 'Rio Grande do Sul',
      'RO' => 'Rondônia',
      'RR' => 'Roraima',
      'SC' => 'Santa Catarina',
      'SP' => 'São Paulo',
      'SE' => 'Sergipe',
      'TO' => 'Tocantins',
    );
    
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

      // dd($estados);

        return view('evento.submeterTrabalho',[
        // return view('evento.backupForm',[
                                            'edital'             => $edital,
                                            'grandeAreas'        => $grandeAreas,
                                            'funcaoParticipantes'=> $funcaoParticipantes,
                                            'rascunho'           => $rascunho,
                                            'enum_turno'         => Participante::ENUM_TURNO,
                                            'estados'            => $this->estados,
                                            ]);
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

      if(!(is_null($request->anexoDecisaoCONSU)) ) {
        $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoDecisaoCONSU,  "CONSU.pdf");
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
      if (!(is_null($request->anexoPlanilhaPontuacao))) {
        $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilhaPontuacao,  "Planilha.". $request->file('anexoPlanilhaPontuacao')->getClientOriginalExtension());
      }

      $trabalho->update();

      //---Anexos planos de trabalho

      //dd($trabalho);

      return $trabalho;
    }

    public function validarAnexosRascunho(Request $request, $trabalho){
      $validator = Validator::make($trabalho->getAttributes(),[
         'anexoPlanilhaPontuacao'           => $request->anexoPlanilhaPontuacao==null?['planilha']:[],
      ]);

      if ($validator->fails()) {
        //dd('asdf');
        return back()->withErrors($validator)->withInput();
      }
      return 1;
    }

    public function armazenarAnexosFinais($request, $pasta, $trabalho, $evento){

      // Checando se é um novo trabalho ou uma edição
      
      if ($trabalho->anexoProjeto != null) {
        // Anexo Projeto
          if(isset($request->anexoProjeto)){
            if(Storage::disk()->exists($trabalho->anexoProjeto)) {
              Storage::delete($trabalho->anexoProjeto);
            }
            $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto, 'Projeto.pdf');
          }

          //Anexo Decisão CONSU
          if( $evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM') {
            if(isset($request->anexoDecisaoCONSU)){
              if(Storage::disk()->exists($trabalho->anexoDecisaoCONSU)) {
                Storage::delete($trabalho->anexoDecisaoCONSU);
              }
              $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoDecisaoCONSU, 'CONSU.pdf');
            }
          }

          //Autorização ou Justificativa
          if( isset($request->anexoAutorizacaoComiteEtica)){
            if(Storage::disk()->exists($trabalho->anexoAutorizacaoComiteEtica)) {
              Storage::delete($trabalho->anexoAutorizacaoComiteEtica);
            }
            $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoAutorizacaoComiteEtica, 'Comite_de_etica.pdf');
            $trabalho->justificativaAutorizacaoEtica = null;

          } elseif( isset($request->justificativaAutorizacaoEtica)){
            if(Storage::disk()->exists($trabalho->justificativaAutorizacaoEtica)) {
              Storage::delete($trabalho->justificativaAutorizacaoEtica);
            }
            $trabalho->justificativaAutorizacaoEtica = Storage::putFileAs($pasta, $request->justificativaAutorizacaoEtica, 'Justificativa.pdf');
            $trabalho->anexoAutorizacaoComiteEtica = null;
          }

        //Anexo Lattes
          if( isset($request->anexoLattesCoordenador)){
            if(Storage::disk()->exists($trabalho->anexoLattesCoordenador)) {
              Storage::delete($trabalho->anexoLattesCoordenador);
            }
            $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLattesCoordenador, 'Lattes_Coordenador.pdf');
          }

          //Anexo Planilha
          if( isset($request->anexoPlanilhaPontuacao)){
            if(Storage::disk()->exists($trabalho->anexoPlanilhaPontuacao)) {
              Storage::delete($trabalho->anexoPlanilhaPontuacao);
            }
           
            $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilhaPontuacao, "Planilha.". $request->file('anexoPlanilhaPontuacao')->getClientOriginalExtension());
          }

          // Anexo grupo pesquisa
          if(isset($request->anexoGrupoPesquisa)){
            if(Storage::disk()->exists($trabalho->anexoGrupoPesquisa)) {
              Storage::delete($trabalho->anexoGrupoPesquisa);
            }
            $trabalho->anexoGrupoPesquisa = Storage::putFileAs($pasta, $request->anexoGrupoPesquisa, "Grupo_de_pesquisa.". $request->file('anexoGrupoPesquisa')->extension());
          }
          $trabalho->save();
          return $trabalho;
      }

      // Anexo Projeto
      if(isset($request->anexoProjeto)){
        $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto, 'Projeto.pdf');
      }

      //Anexo Decisão CONSU
      if( $evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM') {
        if( isset($request->anexoDecisaoCONSU)){
          $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoDecisaoCONSU, 'CONSU.pdf');
        }
      }

      //Autorização ou Justificativa
      if( isset($request->anexoAutorizacaoComiteEtica)){
        $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoAutorizacaoComiteEtica, 'Comite_de_etica.pdf');
        $trabalho->justificativaAutorizacaoEtica = null;

      } elseif( isset($request->justificativaAutorizacaoEtica)){
        $trabalho->justificativaAutorizacaoEtica = Storage::putFileAs($pasta, $request->justificativaAutorizacaoEtica, 'Justificativa.pdf');
        $trabalho->anexoAutorizacaoComiteEtica = null;
        
      }

     //Anexo Lattes
      if( isset($request->anexoLattesCoordenador)){
        $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLattesCoordenador, 'Lattes_Coordenador.pdf');
      }

      //Anexo Planilha
      if( isset($request->anexoPlanilhaPontuacao)){
        $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilhaPontuacao, "Planilha.". $request->file('anexoPlanilhaPontuacao')->getClientOriginalExtension());
      }

      // Anexo grupo pesquisa
      if(isset($request->anexoGrupoPesquisa)){
        $trabalho->anexoGrupoPesquisa = Storage::putFileAs($pasta, $request->anexoGrupoPesquisa, "Grupo_de_pesquisa.". $request->file('anexoGrupoPesquisa')->extension());
      }

      return $trabalho;
    }
    
    public function show($id)
    {
        
        // $projeto = Auth::user()->proponentes->trabalhos()->where('id', $id)->first();
        // if(Auth::user()->tipo == 'administrador'){
        //   $projeto = Trabalho::find($id);
        // }
        // if(!$projeto){
        //   // $projeto = Auth::user()->coordenadorComissao->trabalho()->where('id', $id)->first();
         
        //   return back()->withErrors(['Proposta não encontrada!']);
        // }
        $projeto = Trabalho::find($id);
        $edital = Evento::find($projeto->evento_id);
        $grandeAreas = GrandeArea::all();
        $areas = Area::all();
        $subareas = Subarea::all();
        $funcaoParticipantes = FuncaoParticipantes::all();
        $participantes = $projeto->participantes;
        $participantesUsersIds = Participante::where('trabalho_id', $id)->select('user_id')->get();
        $users = User::whereIn('id', $participantesUsersIds)->get();
        $arquivos = Arquivo::where('trabalhoId', $id)->get();
        return view('projeto.visualizar')->with(['projeto' => $projeto,
                                                'grandeAreas' => $grandeAreas,
                                                'areas' => $areas,
                                                'subAreas' => $subareas,
                                                'edital' => $edital,
                                                'users' => $users,
                                                'funcaoParticipantes' => $funcaoParticipantes,
                                                'participantes' => $participantes,
                                                'arquivos' => $arquivos,
                                                'estados' => $this->estados,
                                                'visualizar' => true,
                                                'enum_turno'         => Participante::ENUM_TURNO,
                                           ]);
    }

		public function exportProjeto($id)
    {
        $projeto = Auth::user()->proponentes->trabalhos()->where('id', $id)->first();
        if(!$projeto){
          return back()->withErrors(['Proposta não encontrada!']);
        }
        $edital = Evento::find($projeto->evento_id);
        $grandeAreas = GrandeArea::all();
        $areas = Area::all();
        $subAreas = Subarea::all();
        $funcaoParticipantes = FuncaoParticipantes::all();
        $participantes = Participante::where('trabalho_id', $id)->get();
        $participantesUsersIds = Participante::where('trabalho_id', $id)->select('user_id')->get();
        $users = User::whereIn('id', $participantesUsersIds)->get();
        $arquivos = Arquivo::where('trabalhoId', $id)->get();
				$enum_turno = Participante::ENUM_TURNO;
      	view()->share('projeto.visualizar', [$projeto, $grandeAreas, $areas, $subAreas, $edital,$users, $funcaoParticipantes,$participantes,$arquivos,$enum_turno]);
        
        $pdf = PDF::loadView('projeto.visualizar', compact('projeto', 'grandeAreas', 'areas', 'subAreas', 'edital', 'users', 'funcaoParticipantes', 'participantes', 'arquivos', 'enum_turno'))->setOptions(['defaultFont' => 'sans-serif']);

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function edit($id)
    {
      $proponente = Proponente::where('user_id', Auth::user()->id)->first();
      $projeto = Auth::user()->proponentes->trabalhos()->where('id', $id)->first();
      if(!$projeto){
        return back()->withErrors(['Proposta não encontrada!']);
      }
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
      $rascunho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id',$edital->id)->where('status', 'Rascunho')
                                ->orderByDesc('updated_at')->first();
      
      return view('projeto.editar')->with(['projeto' => $projeto,
                                           'grandeAreas' => $grandeAreas,
                                           'areas' => $areas,
                                           'subAreas' => $subareas,
                                           'edital' => $edital,
                                           'users' => $users,
                                           'funcaoParticipantes' => $funcaoParticipantes,
                                           'participantes' => $participantes,
                                           'arquivos' => $arquivos,
                                           'enum_turno'         => Participante::ENUM_TURNO,
                                           'estados'            => $this->estados,
                                           ]);
    }

    public function destroy(Request $request)
    {
        $projeto = Trabalho::find($request->id);
        //dd($trabalho);
        Storage::deleteDirectory('trabalhos/' . $projeto->evento->id . '/' . $projeto->id );

        $participantes = $projeto->participantes;
        foreach ($participantes as $participante) {
          $plano = $participante->planoTrabalho;
          if($plano)
            $plano->delete();
          $participante->delete();
        }

        $projeto->delete();
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
        ob_end_clean();
        return Storage::download($projeto->anexoProjeto);
      }
      return abort(404);
    }
    public function baixarAnexoGrupoPesquisa($id) {
      $projeto = Trabalho::find($id);
      if (Storage::disk()->exists($projeto->anexoGrupoPesquisa)) {
        ob_end_clean();
        return Storage::download($projeto->anexoGrupoPesquisa);
      }
      return abort(404);
    }

    public function baixarAnexoConsu($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->anexoDecisaoCONSU)) {
        ob_end_clean();
        return Storage::download($projeto->anexoDecisaoCONSU);
      }
      return abort(404);
    }

    public function baixarAnexoComite($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->anexoAutorizacaoComiteEtica)) {
        ob_end_clean();
        return Storage::download($projeto->anexoAutorizacaoComiteEtica);
      }
      return abort(404);
    }

    public function baixarAnexoLattes($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->anexoLattesCoordenador)) {
        ob_end_clean();
        return Storage::download($projeto->anexoLattesCoordenador);
      }
      return abort(404);
    }

    public function baixarAnexoPlanilha($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->anexoPlanilhaPontuacao)) {
        ob_end_clean();
        $file  = $projeto->anexoPlanilhaPontuacao;
        $ext = explode(".", $file);
        
        switch ($ext[1]) {
          case 'xlsx':
            $hearder = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            break;
          case 'xls':
            $hearder = 'application/vnd.ms-excel';
            break;
          case 'ods':
            $hearder = 'application/vnd.oasis.opendocument.spreadsheet';
            break;
          
          default:
            $hearder = 'application/vnd.ms-excel';
            break;
        }
       
        $headers = array(
          "Content-type: {$hearder}",
        );
        

        return Storage::download($projeto->anexoPlanilhaPontuacao, "Planilha.{$ext[1]}",$headers);
      }
      return abort(404);
    }

    public function baixarAnexoJustificativa($id) {
      $projeto = Trabalho::find($id);

      if (Storage::disk()->exists($projeto->justificativaAutorizacaoEtica)) {
        ob_end_clean();
        return Storage::download($projeto->justificativaAutorizacaoEtica);
      }

      return abort(404);
    }

    public function baixarAnexoTemp($eventoId, $nomeAnexo) {
      $proponente = Proponente::where('user_id', Auth::user()->id)->first();

      $trabalho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id',$eventoId)->where('status', 'Rascunho')
                  ->orderByDesc('updated_at')->first();

      if (Storage::disk()->exists($trabalho->$nomeAnexo)) {
        ob_end_clean();
        return Storage::download($trabalho->$nomeAnexo);
      }
      return abort(404);
    }

    public function baixarEventoTemp($nomeAnexo){
      $eventoTemp = Evento::where('criador_id', Auth::user()->id)->where('anexosStatus', 'temporario')
                            ->orderByDesc('updated_at')->first();

      if (Storage::disk()->exists($eventoTemp->$nomeAnexo)) {
        ob_end_clean();
        return Storage::download($eventoTemp->$nomeAnexo);
      }
      return abort(404);
    }



    public function update(UpdateTrabalho $request, $id)
    {
      
      try {    
        if (!$request->has('rascunho') ) {
          $request->merge([
            'status' => 'submetido'
          ]);
        }else{
          $request->merge([
            'status' => 'rascunho'
          ]);
        }
        $evento = Evento::find($request->editalId);
        $request->merge([
          'coordenador_id' => $evento->coordenadorComissao->id
        ]);
        $trabalho = Auth::user()->proponentes->trabalhos()->where('id', $id)->first();
        
        DB::beginTransaction();
        if(!$trabalho){
          return back()->withErrors(['Proposta não encontrada']);
        }
        
        $trabalho->update($request->except([
          'anexoProjeto', 'anexoDecisaoCONSU','anexoPlanilhaPontuacao',
          'anexoLattesCoordenador','anexoGrupoPesquisa','justificativaAutorizacaoEtica','anexoAutorizacaoComiteEtica'
          
        ]));
        $pasta = 'trabalhos/' . $evento->id . '/' . $trabalho->id;
        $trabalho = $this->armazenarAnexosFinais($request, $pasta, $trabalho, $evento);
        $trabalho->save();
        
        if ($request->marcado == null) {
          $idExcluido = $trabalho->participantes->pluck('id');
          
        }else{
          $idExcluido = [];
        }
        
        foreach ($request->participante_id as $key => $value) {
          if($request->marcado != null && array_search( $key, $request->marcado) === false){
            if($value !== null)
              array_push($idExcluido, $value);
          }
        }                  

        foreach ($idExcluido as $key => $value) {
          $trabalho->participantes()->find($value)->delete();
        }
        $trabalho->refresh();
        if($request->has('marcado')){
          foreach ($request->marcado as $key => $part) {
            $part = intval($part);
            
            $passwordTemporario = Str::random(8);
            $data['name'] = $request->name[$part];
            $data['email'] = $request->email[$part];
            $data['password'] = bcrypt($passwordTemporario);
            $data['data_de_nascimento'] = $request->data_de_nascimento[$part];
            $data['cpf'] = $request->cpf[$part];
            $data['tipo'] = 'participante';
            $data['funcao_participante_id'] = 4;
            $data['rg'] = $request->rg[$part];
            $data['celular'] = $request->celular[$part];
            $data['cep'] = $request->cep[$part];
            $data['uf'] = $request->uf[$part];
            $data['cidade'] = $request->cidade[$part];
            $data['rua'] = $request->rua[$part];
            $data['numero'] = $request->numero[$part];
            $data['bairro'] = $request->bairro[$part];
            $data['complemento'] = $request->complemento[$part];

            if($request->instituicao[$part] != "Outra"){
              $data['instituicao'] = $request->instituicao[$part];
            }else{
              $data['instituicao'] = $request->outrainstituicao[$part];
            }

            $data['total_periodos'] = $request->total_periodos[$part];

            if($request->curso[$part] != "Outro"){
              $data['curso'] = $request->curso[$part];
            }else{
              $data['curso'] = $request->outrocurso[$part];
            }

            $data['turno'] = $request->turno[$part];
            $data['periodo_atual'] = $request->periodo_atual[$part];
            $data['ordem_prioridade'] = $request->ordem_prioridade[$part];
            $data['media_do_curso'] = $request->media_do_curso[$part];
            $data['nomePlanoTrabalho'] = $request->nomePlanoTrabalho[$part];

            $participante = Participante::find($request->participante_id[$part]);

            if (!$participante){
              $data['usuarioTemp'] = true;
              $user = User::updateOrCreate(
                ['email' => $data['email']], 
                $data
              );
              $endereco = Endereco::create($data);
              $endereco->user()->save($user);
              $participante = Participante::create($data);
              $user->participantes()->save($participante);
              $trabalho->participantes()->save($participante);

            }else{
              $user = $participante->user;
              $user->update($data);
              $endereco =  $user->endereco;
              $endereco->update($data);
              $participante = $user->participantes->where('trabalho_id', $trabalho->id)->first();
              if (!$participante){
                $participante = Participante::create($data);
                $user->participantes()->save($participante);
                $trabalho->participantes()->save($participante);
              }else{
                $participante->update($data);
              }
              
            }
    
            
    
            if ( $request->has('anexoPlanoTrabalho') && array_key_exists($part,$request->anexoPlanoTrabalho) ) {
              if(Arquivo::where('participanteId', $participante->id)->count()){
                  $arquivo = Arquivo::where('participanteId', $participante->id)->first();
                  $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id .'/';
                  $nome =  $data['nomePlanoTrabalho'] .".pdf";
                  $file = $request->anexoPlanoTrabalho[$part] ;
                  Storage::putFileAs($path, $file, $nome);
                  $arquivo->update([
                    'titulo' => $nome,
                    'nome' => $path . $nome,
                    'data' => now() ,
                  ]);
              }else{
                $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id .'/';
                $nome =  $data['nomePlanoTrabalho'] .".pdf";
                $file = $request->anexoPlanoTrabalho[$part] ;
                Storage::putFileAs($path, $file, $nome);
                $arquivo = new Arquivo();
                $arquivo->titulo = $data['nomePlanoTrabalho'];
                $arquivo->nome = $path . $nome;
                $arquivo->trabalhoId = $trabalho->id;
                $arquivo->data = now();
                $arquivo->participanteId = $participante->id;
                $arquivo->versaoFinal = true;
                $arquivo->save();

              }
              
            }
    
          }
          
        }

        
        
        DB::commit();
        if (!$request->has('rascunho') ) {
          Notification::send(Auth::user(), new SubmissaoNotification($id));
        }else{

        }
        return redirect(route('proponente.projetos'))->with(['mensagem' => 'Proposta atualizada!']);

      } catch (\Throwable $th) {
        DB::rollback();
        return redirect(route('proponente.projetos'))->with(['mensagem' => $th->getMessage()]);
      }

    }


    public function salvar(StoreTrabalho $request) {

      try {    
        if (!$request->has('rascunho') ) {
          $request->merge([
            'status' => 'submetido'
          ]);
        }
        $evento = Evento::find($request->editalId);
        $request->merge([
          'coordenador_id' => $evento->coordenadorComissao->id
        ]);
        
        DB::beginTransaction();

        $trabalho = Auth::user()->proponentes->trabalhos()
                    ->create($request->except([
                      'anexoProjeto', 'anexoDecisaoCONSU','anexoPlanilhaPontuacao',
                      'anexoLattesCoordenador','anexoGrupoPesquisa','anexoAutorizacaoComiteEtica',
                      'justificativaAutorizacaoEtica'
                    ]));
        if($request->has('marcado')){
          foreach ($request->marcado as $key => $part) {
            $part = intval($part);
    
            $passwordTemporario = Str::random(8);
            $data['name'] = $request->name[$part];
            $data['email'] = $request->email[$part];
            $data['password'] = bcrypt($passwordTemporario);
            $data['data_de_nascimento'] = $request->data_de_nascimento[$part];
            $data['cpf'] = $request->cpf[$part];
            $data['tipo'] = 'participante';
            $data['funcao_participante_id'] = 4;
            $data['rg'] = $request->rg[$part];
            $data['celular'] = $request->celular[$part];
            $data['cep'] = $request->cep[$part];
            $data['uf'] = $request->uf[$part];
            $data['cidade'] = $request->cidade[$part];
            $data['rua'] = $request->rua[$part];
            $data['numero'] = $request->numero[$part];
            $data['bairro'] = $request->bairro[$part];
            $data['complemento'] = $request->complemento[$part];

            if($request->instituicao[$part] != "Outra"){
              $data['instituicao'] = $request->instituicao[$part];
            }else{
              $data['instituicao'] = $request->outrainstituicao[$part];
            }

            $data['total_periodos'] = $request->total_periodos[$part];

            if($request->curso[$part] != "Outro"){
              $data['curso'] = $request->curso[$part];
            }else{
              $data['curso'] = $request->outrocurso[$part];
            }

            $data['turno'] = $request->turno[$part];
            $data['periodo_atual'] = $request->periodo_atual[$part];
            $data['ordem_prioridade'] = $request->ordem_prioridade[$part];
            $data['media_do_curso'] = $request->media_do_curso[$part];
            $data['nomePlanoTrabalho'] = $request->nomePlanoTrabalho[$part];
    
            $user = User::where('email' , $data['email'])->first();
            if (!$user){
              $data['usuarioTemp'] = true;
              $user = User::create($data);
              $endereco = Endereco::create($data);
              $endereco->user()->save($user);
            }
            $participante = $user->participantes->where('trabalho_id', $trabalho->id)->first();
            if (!$participante){
              $participante = Participante::create($data);
            }
    
            $user->participantes()->save($participante);
            $trabalho->participantes()->save($participante);
    
            if ( $request->has('anexoPlanoTrabalho') ) {
              $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id .'/';
              $nome =  $data['nomePlanoTrabalho'] .".pdf";
              $file = $request->anexoPlanoTrabalho[$part] ;
              Storage::putFileAs($path, $file, $nome);
              $arquivo = new Arquivo();
              $arquivo->titulo = $data['nomePlanoTrabalho'];
              $arquivo->nome = $path . $nome;
              $arquivo->trabalhoId = $trabalho->id;
              $arquivo->data = now();
              $arquivo->participanteId = $participante->id;
              $arquivo->versaoFinal = true;
              $arquivo->save();
              
            }
    
          }
        }
        $evento->trabalhos()->save($trabalho);
  
        $pasta = 'trabalhos/' . $evento->id . '/' . $trabalho->id;
        $trabalho = $this->armazenarAnexosFinais($request, $pasta, $trabalho, $evento);
        $trabalho->save();

        DB::commit();
        if (!$request->has('rascunho') ) {
          Notification::send(Auth::user(), new SubmissaoNotification($trabalho->id));
          return redirect(route('proponente.projetos'))->with(['mensagem' => 'Proposta submetida!']);
        }else{
          return redirect(route('proponente.projetos'))->with(['mensagem' => 'Rascunho salvo!']);

        }
      } catch (\Throwable $th) {
        DB::rollback();
        return redirect(route('proponente.projetos'))->with(['mensagem' => $th->getMessage()]);
      }

      

    }

    public function atribuirDados(Request $request, $edital, Trabalho $projeto = null) {
      if ($projeto == null) {
        $projeto = new Trabalho();
      } 

      $proponente = User::find(auth()->user()->id)->proponentes;
      $hoje = now();

      $projeto->titulo                           = $request->nomeProjeto;
      $projeto->coordenador_id                   = $edital->coordenadorComissao->id;
      $projeto->grande_area_id                   = $request->grandeArea;
      $projeto->area_id                          = $request->area;
      $projeto->sub_area_id                      = $request->subArea;
      $projeto->pontuacaoPlanilha                = $request->pontuacaoPlanilha;
      $projeto->linkGrupoPesquisa                = $request->linkGrupo;
      $projeto->linkLattesEstudante              = $request->linkLattesEstudante;
      $projeto->data                             = $hoje;
      $projeto->evento_id                        = $request->editalId;
      $projeto->status                           = 'submetido';
      $projeto->proponente_id                    = $proponente->id;
      
      // Salvando anexos no storage
      $projeto->save();
      $pasta = 'trabalhos/' . $edital->id . '/' . $projeto->id;

      $projeto = $this->armazenarAnexosFinais($request, $pasta, $projeto, $edital);
      
      return $projeto;
    }

    public function salvarParticipantes(Request $request, $edital, $projeto, $edicao = false) {
      if ($edicao) {
        
        $participantes = $projeto->participantes;
        $participantesPermanecem = collect();
        // dd($request->all());
        foreach ($request->participante_id as $key => $id) {
          // Novo participante
          if ($id == 0 || $id == null) {
            $userParticipante = User::where('email', $request->emailParticipante[$key])->first();
          
            $participante = new Participante();

            if($userParticipante == null){
              $passwordTemporario = Str::random(8);

              $usuario                = new User();
              $usuario->email         = $request->emailParticipante[$key];
              $usuario->password      = bcrypt($passwordTemporario);
              $usuario->usuarioTemp   = false;
              $usuario->name          = $request->nomeParticipante[$key];
              $usuario->tipo          = 'participante';
              $usuario->instituicao   = $request->universidade[$key];
              $usuario->cpf           = $request->cpf[$key];
              $usuario->celular       = $request->celular[$key];

              $endereco               = new Endereco();
              $endereco->rua          = $request->rua[$key];
              $endereco->numero       = $request->numero[$key];  
              $endereco->bairro       = $request->bairro[$key];
              $endereco->cidade       = $request->cidade[$key];
              $endereco->uf           = $request->uf[$key];
              $endereco->cep          = $request->cep[$key];
              $endereco->complemento  = $request->complemento[$key];
              $endereco->save();

              $usuario->enderecoId  = $endereco->id;

              $usuario->save();

              $participante->user_id                  = $usuario->id;
              $participante->trabalho_id              = $projeto->id;
              $participante->funcao_participante_id   = $request->funcaoParticipante[$key];
              $participante->confirmacao_convite      = true;
              $participante->rg                       = $request->rg[$key];
              $participante->data_de_nascimento       = $request->data_de_nascimento[$key];
              $participante->curso                    = $request->curso[$key];
              $participante->turno                    = $request->turno[$key];
              $participante->ordem_prioridade         = $request->ordem_prioridade[$key];
              $participante->periodo_atual            = $request->periodo_atual[$key];
              $participante->total_periodos           = $request->total_periodos[$key];
              $participante->media_do_curso           = $request->media_geral_curso[$key];
              $participante->save();

              
              $subject = "Participante de Projeto";
              Mail::to($request->emailParticipante[$key])->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, $projeto->titulo, 'Participante', $edital->nome, $passwordTemporario, $subject));
            } else {

              $participante->user_id                  = $userParticipante->id;
              $participante->trabalho_id              = $projeto->id;
              $participante->funcao_participante_id   = $request->funcaoParticipante[$key];
              $participante->confirmacao_convite      = true;
              $participante->rg                       = $request->rg[$key];
              $participante->data_de_nascimento       = $request->data_de_nascimento[$key];
              $participante->curso                    = $request->curso[$key];
              $participante->turno                    = $request->turno[$key];
              $participante->ordem_prioridade         = $request->ordem_prioridade[$key];
              $participante->periodo_atual            = $request->periodo_atual[$key];
              $participante->total_periodos           = $request->total_periodos[$key];
              $participante->media_do_curso           = $request->media_geral_curso[$key];
              $participante->save();

              $subject = "Participante de Projeto";
              Mail::to($request->emailParticipante[$key])
                    ->send(new SubmissaoTrabalho($userParticipante, $subject, $edital, $projeto));

            }
            
            if($request->nomePlanoTrabalho[$key] != null){
              $usuario = User::where('email', $request->emailParticipante[$key])->first();
              $participante = Participante::where([['user_id', '=', $usuario->id], ['trabalho_id', '=', $projeto->id]])->first();

              $path = 'trabalhos/' . $edital->id . '/' . $projeto->id .'/';
              $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
              $file = $request->anexoPlanoTrabalho[$key];
              Storage::putFileAs($path, $file, $nome);

              $agora = now();
              $arquivo = new Arquivo();
              $arquivo->titulo = $request->nomePlanoTrabalho[$key];
              $arquivo->nome = $path . $nome;
              $arquivo->trabalhoId = $projeto->id;
              $arquivo->data = $agora;
              $arquivo->participanteId = $participante->id;
              $arquivo->versaoFinal = true;
              $arquivo->save();
              // dd($arquivo);
            }
          // Editado
          } elseif ($id > 0) {
            // Removo dos cantidatos excluidos
            $participante = Participante::find($id);
            $participantesPermanecem->push($participante);
            $usuario = $participante->user;
            $endereco = $usuario->endereco;
            
            $usuario->usuarioTemp   = false;
            $usuario->name          = $request->nomeParticipante[$key];
            $usuario->tipo          = 'participante';
            $usuario->instituicao   = $request->universidade[$key];
            $usuario->cpf           = $request->cpf[$key];
            $usuario->celular       = $request->celular[$key];

            $usuario->update();

            $endereco->rua          = $request->rua[$key];
            $endereco->numero       = $request->numero[$key];  
            $endereco->bairro       = $request->bairro[$key];
            $endereco->cidade       = $request->cidade[$key];
            $endereco->uf           = $request->uf[$key];
            $endereco->cep          = $request->cep[$key];
            $endereco->complemento  = $request->complemento[$key];
            $endereco->update();

            $participante->rg                       = $request->rg[$key];
            $participante->data_de_nascimento       = $request->data_de_nascimento[$key];
            $participante->curso                    = $request->curso[$key];
            $participante->turno                    = $request->turno[$key];
            $participante->ordem_prioridade         = $request->ordem_prioridade[$key];
            $participante->periodo_atual            = $request->periodo_atual[$key];
            $participante->total_periodos           = $request->total_periodos[$key];
            $participante->media_do_curso           = $request->media_geral_curso[$key];
            $participante->update();

            if($request->anexoPlanoTrabalho != null && array_key_exists($key, $request->anexoPlanoTrabalho) && $request->anexoPlanoTrabalho[$key] != null){

              $planoAtual = $participante->planoTrabalho;
              if(Storage::disk()->exists($planoAtual->nome)) {
                Storage::delete($planoAtual->nome);
              }
              $planoAtual->delete();

              $path = 'trabalhos/' . $edital->id . '/' . $projeto->id .'/';
              $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
              $file = $request->anexoPlanoTrabalho[$key];
              Storage::putFileAs($path, $file, $nome);

              $agora = now();
              $arquivo = new Arquivo();
              $arquivo->titulo = $request->nomePlanoTrabalho[$key];
              $arquivo->nome = $path . $nome;
              $arquivo->trabalhoId = $projeto->id;
              $arquivo->data = $agora;
              $arquivo->participanteId = $id;
              $arquivo->versaoFinal = true;
              $arquivo->save();
            }
          } 
        }
        // Excluidos
        $participantesExcluidos = $participantes->diff($participantesPermanecem);
        foreach ($participantesExcluidos as $participante) {
          $plano = $participante->planoTrabalho;
          if($plano)
            $plano->delete();
          $participante->delete();
        }

        return true;
      }
      if($request->emailParticipante != null) {
        foreach ($request->emailParticipante as $key => $email) {
          $userParticipante = User::where('email', $email)->first();
          
          $participante = new Participante();

          if($userParticipante == null){
            $passwordTemporario = Str::random(8);

            $usuario                = new User();
            $usuario->email         = $email;
            $usuario->password      = bcrypt($passwordTemporario);
            $usuario->usuarioTemp   = false;
            $usuario->name          = $request->nomeParticipante[$key];
            $usuario->tipo          = 'participante';
            $usuario->instituicao   = $request->universidade[$key];
            $usuario->cpf           = $request->cpf[$key];
            $usuario->celular       = $request->celular[$key];

            $endereco               = new Endereco();
            $endereco->rua          = $request->rua[$key];
            $endereco->numero       = $request->numero[$key];  
            $endereco->bairro       = $request->bairro[$key];
            $endereco->cidade       = $request->cidade[$key];
            $endereco->uf           = $request->uf[$key];
            $endereco->cep          = $request->cep[$key];
            $endereco->complemento  = $request->complemento[$key];
            $endereco->save();

            $usuario->enderecoId  = $endereco->id;

            $usuario->save();

            $participante->user_id                  = $usuario->id;
            $participante->trabalho_id              = $projeto->id;
            $participante->funcao_participante_id   = $request->funcaoParticipante[$key];
            $participante->confirmacao_convite      = true;
            $participante->rg                       = $request->rg[$key];
            $participante->data_de_nascimento       = $request->data_de_nascimento[$key];
            $participante->curso                    = $request->curso[$key];
            $participante->turno                    = $request->turno[$key];
            $participante->ordem_prioridade         = $request->ordem_prioridade[$key];
            $participante->periodo_atual            = $request->periodo_atual[$key];
            $participante->total_periodos           = $request->total_periodos[$key];
            $participante->media_do_curso           = $request->media_geral_curso[$key];
            $participante->save();

            $usuario = User::where('email', $email)->first();
            $participante = Participante::where([['user_id', '=', $usuario->id], ['trabalho_id', '=', $projeto->id]])->first();

            $path = 'trabalhos/' . $edital->id . '/' . $projeto->id .'/';
            $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
            $file = $request->anexoPlanoTrabalho[$key];
            Storage::putFileAs($path, $file, $nome);

            $agora = now();
            $arquivo = new Arquivo();
            $arquivo->titulo = $request->nomePlanoTrabalho[$key];
            $arquivo->nome = $path . $nome;
            $arquivo->trabalhoId = $projeto->id;
            $arquivo->data = $agora;
            $arquivo->participanteId = $participante->id;
            $arquivo->versaoFinal = true;
            $arquivo->save();
            $subject = "Participante de Projeto";
            Mail::to($email)->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, $projeto->titulo, 'Participante', $edital->nome, $passwordTemporario, $subject));
          } else {

            $participante->user_id                  = $userParticipante->id;
            $participante->trabalho_id              = $projeto->id;
            $participante->funcao_participante_id   = $request->funcaoParticipante[$key];
            $participante->confirmacao_convite      = true;
            $participante->rg                       = $request->rg[$key];
            $participante->data_de_nascimento       = $request->data_de_nascimento[$key];
            $participante->curso                    = $request->curso[$key];
            $participante->turno                    = $request->turno[$key];
            $participante->ordem_prioridade         = $request->ordem_prioridade[$key];
            $participante->periodo_atual            = $request->periodo_atual[$key];
            $participante->total_periodos           = $request->total_periodos[$key];
            $participante->media_do_curso           = $request->media_geral_curso[$key];
            $participante->save();

            
            
            if ($request->anexoPlanoTrabalho[$key]) {
              $path = 'trabalhos/' . $edital->id . '/' . $projeto->id .'/';
              $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
              $file = $request->anexoPlanoTrabalho[$key];
              Storage::putFileAs($path, $file, $nome);
  
              $agora = now();
              $arquivo = new Arquivo();
              $arquivo->titulo = $request->nomePlanoTrabalho[$key];
              $arquivo->nome = $path . $nome;
              $arquivo->trabalhoId = $projeto->id;
              $arquivo->data = $agora;
              $arquivo->participanteId = $participante->id;
              $arquivo->versaoFinal = true;
              $arquivo->save();
              
            }

            $subject = "Participante de Projeto";
            Mail::to($email)
                  ->send(new SubmissaoTrabalho($userParticipante, $subject, $edital, $projeto));

          }

          // if($request->nomePlanoTrabalho[$key] != null){
          //   $usuario = User::where('email', $email)->first();
          //   $participante = Participante::where([['user_id', '=', $usuario->id], ['trabalho_id', '=', $projeto->id]])->first();

          //   $path = 'trabalhos/' . $edital->id . '/' . $projeto->id .'/';
          //   $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
          //   $file = $request->anexoPlanoTrabalho[$key];
          //   Storage::putFileAs($path, $file, $nome);

          //   $agora = now();
          //   $arquivo = new Arquivo();
          //   $arquivo->titulo = $request->nomePlanoTrabalho[$key];
          //   $arquivo->nome = $path . $nome;
          //   $arquivo->trabalhoId = $projeto->id;
          //   $arquivo->data = $agora;
          //   $arquivo->participanteId = $participante->id;
          //   $arquivo->versaoFinal = true;
          //   $arquivo->save();
          // }
        }
      }

      return true;
    }

    public function atualizar(Request $request, $id) {
      $edital = Evento::find($request->editalId);
      $hoje = now();

      $projeto = Trabalho::find($id);

      if (!($edital->inicioSubmissao < $hoje && $edital->fimSubmissao >= $hoje)) {
        return redirect()->route('inicial')->with(['error'=> 0, 'mensagem' => 'As submissões para o edital '. $edital->titulo .' foram encerradas.']);
      }

      $projeto = $this->atribuirDados($request, $edital, $projeto);
      $projeto->update();

      // dd($request->all());
      // Salvando participantes
      $this->salvarParticipantes($request, $edital, $projeto, true);

      return redirect(route('proponente.projetos'))->with(['mensagem' => 'Projeto atualizado com sucesso!']);
    }
}