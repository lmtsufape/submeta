<?php

namespace App\Http\Controllers;

use App\Area;
use App\Arquivo;
use App\AvaliacaoRelatorio;
use App\CampoAvaliacao;
use App\AvaliacaoTrabalho;
use App\FuncaoParticipantes;
use App\GrandeArea;
use App\ParecerInterno;
use App\Participante;
use App\SubArea;
use App\Substituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Trabalho;
use App\Evento;
use App\Recomendacao;
use App\User;
use App\Avaliador;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AvaliadorController extends Controller
{
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

	public function index(){
        $flagAvalRelatorio = count(AvaliacaoRelatorio::where('user_id',Auth::user()->id )->get());
    	return view('avaliador.index', compact('flagAvalRelatorio'));
    }

    public function editais(Request $request){

        $user = User::find(Auth::user()->id);
        $eventos = $user->avaliadors->where('user_id',$user->id)->first()->eventos;
        $aval = $user->avaliadors->where('user_id',$user->id)->first();
        foreach ($eventos as $evento){
            $evento->flag=0;
            $trabalhos = Trabalho::where('evento_id',$evento->id)->pluck('id');
            if($aval->trabalhos()->whereIn("trabalho_id",$trabalhos)->count() != 0){
                $evento->flag=1;
            }
        }
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        return view('avaliador.editais', ["eventos"=>$eventos, "hoje" => $hoje]);
    }


    public function visualizarTrabalhos(Request $request){

        $user = User::find(Auth::user()->id);
        $evento = Evento::where('id', $request->evento_id)->first();
        $trabalhosEx = [];
        $trabalhosIn = [];
        $trabalhos = [];
        $aval = $user->avaliadors->where('user_id',$user->id)->first();

        if ($evento->tipoAvaliacao == 'campos' || $evento->tipoAvaliacao == 'link') {
            $trabalhos = $aval->trabalhos->where('evento_id', $request->evento_id);

        } else {
            foreach ($aval->trabalhos->where('evento_id',$evento->id) as $trab){
                if($aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->orderBy('created_at','DESC')->first()->acesso == 2
                    || $aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->orderBy('created_at','DESC')->first()->acesso == 3 ||
                    ($aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->orderBy('created_at','DESC')->first()->acesso == null && $aval->tipo == "Interno")){
                    array_push($trabalhosIn,$aval->trabalhos()->where("trabalho_id",$trab->id)->first());
                }
                if ($aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->orderBy('created_at','DESC')->first()->acesso == 1 ||
                    $aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->orderBy('created_at','DESC')->first()->acesso == 3 ||
                    ($aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->orderBy('created_at','DESC')->first()->acesso == null && $aval->tipo == "Externo")){
                    array_push($trabalhosEx,$aval->trabalhos()->where("trabalho_id",$trab->id)->first());
                }
            }
        }

        return view('avaliador.listarTrabalhos', ['trabalhosEx'=>$trabalhosEx,'trabalhosIn'=>$trabalhosIn, 'trabalhos'=>$trabalhos, 'evento'=>$evento]);

    }

    public function parecer(Request $request){

      $user = User::find(Auth::user()->id);
      $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      $trabalho = $avaliador->trabalhos->find($request->trabalho_id);
      $evento = Evento::find($request->evento);
      $hoje = Carbon::today('America/Recife');
      $hoje = $hoje->toDateString();

      // Verficação de pendencia de substituição
      $aux = count(Substituicao::where('status','Em Aguardo')->whereIn('participanteSubstituido_id',$trabalho->participantes->pluck('id'))->get());
      if($aux != 0){
        return redirect()->back()->withErrors("A proposta ".$trabalho->titulo." possui substituições pendentes");
      }
      if( strtotime($trabalho->created_at . "+ 15 days" ) > strtotime($hoje) ){
        return view('avaliador.parecer', ['trabalho'=>$trabalho, 'evento'=>$evento, 'hoje' => $hoje]);
      } else {
        return redirect(route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id]))->with('error_code', 1800);
      }
        
    }

    public function parecerInterno(Request $request){

        $user = User::find(Auth::user()->id);
        $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
        $trabalho = $avaliador->trabalhos->find($request->trabalho_id);
        $evento = Evento::find($request->evento);
        $parecerInterno = ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
        //Gerais
        $grandeAreas = GrandeArea::all();
        $areas = Area::all();
        $subareas = Subarea::all();
        //
        $participantes = $trabalho->participantes;
        $arquivos = Arquivo::where('trabalhoId', $trabalho->id)->get();
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();

        return view('avaliador.parecerInterno',
            ['trabalho'=>$trabalho,
            'evento'=>$evento,
            'parecer'=>$parecerInterno,
            'grandeAreas' => $grandeAreas,
            'areas' => $areas,
            'subAreas' => $subareas,
            'participantes' => $participantes,
            'enum_turno'         => Participante::ENUM_TURNO,
            'arquivos' => $arquivos,
            'estados' => $this->estados,
            'hoje' => $hoje
            ]);
    }

    public function enviarParecerInterno(Request $request){
        $user = User::find(Auth::user()->id);
        $evento = Evento::where('id', $request->evento_id)->first();
        //$trabalhos = $user->avaliadors->where('user_id',$user->id)->first()->trabalhos->where('evento_id', $request->evento_id);
        $trabalhosEx = [];
        $trabalhosIn = [];
        $trabalhos = [];
        $aval = $user->avaliadors->where('user_id',$user->id)->first();
        foreach ($aval->trabalhos->where('evento_id',$evento->id) as $trab){
            if($aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->acesso == 2 || $aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->acesso == 3 ){
                array_push($trabalhosIn,$aval->trabalhos()->where("trabalho_id",$trab->id)->first());
            }
            if ($aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->acesso == 1 || $aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->acesso == 3){
                array_push($trabalhosEx,$aval->trabalhos()->where("trabalho_id",$trab->id)->first());
            }
        }
        $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
        $trabalho = $avaliador->trabalhos->find($request->trabalho_id);
        $parecerInterno = ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
        $statusParecer = "NAO-RECOMENDADO";
        if(
            $request->anexoLinkLattes=='aceito' && $request->anexoGrupoPesquisa=='aceito' && $request->anexoProjeto=='aceito' &&
            $request->anexoConsu=='aceito' && $request->anexoLattesCoordenador=='aceito' && $request->anexoPlano=='aceito' &&
            $request->anexoGrupoPesquisa=='aceito' && $request->anexoComiteEtica=='aceito' && $request->anexoJustificativa=='aceito'
            ){
                $statusParecer = "RECOMENDADO";
        }
        if($parecerInterno == null) {

            $parecerInterno = ParecerInterno::create([
                'statusLinkLattesProponente' => $request->anexoLinkLattes,
                'statusLinkGrupoPesquisa' => $request->anexoGrupoPesquisa,
                'statusAnexoProjeto' => $request->anexoProjeto,
                'statusAnexoDecisaoCONSU' => $request->anexoConsu,
                'statusAnexoPlanilhaPontuacao' => $request->anexoPlanilha,
                'statusAnexoLattesCoordenador' => $request->anexoLattesCoordenador,
                'statusAnexoGrupoPesquisa' => $request->anexoGrupoPesquisa,
                'statusAnexoAtuorizacaoComiteEtica' => $request->anexoComiteEtica,
                'statusJustificativaAutorizacaoEtica' => $request->anexoJustificativa,
                'statusPlanoTrabalho' => $request->anexoPlano,
                'statusParecer' => $statusParecer,
                'comentario' => $request->comentario,
                'trabalho_id' => $request->trabalho_id,
                'avaliador_id' => $request->avaliador_id,
            ]);
            $parecerInterno->save();
        }else{
            $parecerInterno->statusLinkLattesProponente = $request->anexoLinkLattes;
            $parecerInterno->statusLinkGrupoPesquisa = $request->anexoGrupoPesquisa;
            $parecerInterno->statusAnexoProjeto = $request->anexoProjeto;
            $parecerInterno->statusAnexoDecisaoCONSU = $request->anexoConsu;
            $parecerInterno->statusAnexoPlanilhaPontuacao = $request->anexoPlanilha;
            $parecerInterno->statusAnexoLattesCoordenador = $request->anexoLattesCoordenador;
            $parecerInterno->statusAnexoGrupoPesquisa = $request->anexoLinkLattes;
            $parecerInterno->statusAnexoAtuorizacaoComiteEtica = $request->anexoComiteEtica;
            $parecerInterno->statusJustificativaAutorizacaoEtica = $request->anexoJustificativa;
            $parecerInterno->statusPlanoTrabalho = $request->anexoPlano;
            $parecerInterno->comentario = $request->comentario;
            $parecerInterno->statusParecer = $statusParecer;
            $parecerInterno->update();
        }

        if ($trabalho->avaliadors()->where('status', 1)->count() == $trabalho->avaliadors()->count()) {
            $trabalho->status = "avaliado";
            $trabalho->save();
        }

        return view('avaliador.listarTrabalhos', ['trabalhosEx'=>$trabalhosEx,'trabalhosIn'=>$trabalhosIn, 'trabalhos'=>$trabalhos, 'evento'=>$evento]);
    }

    public function parecerBarema(Request $request) {

        $user = User::find(Auth::user()->id);
        $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
        $trabalho = $avaliador->trabalhos->find($request->trabalho_id);
        $evento = Evento::find($request->evento_id);
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        $camposAvaliacao = CampoAvaliacao::where('evento_id', $evento->id)->get();

        return view('avaliador.parecerBarema', ['trabalho'=>$trabalho, 'evento'=>$evento, 'hoje' => $hoje, 'camposAvaliacao' => $camposAvaliacao ]);
    }

    public function enviarParecerBarema(Request $request) {
        $user = User::find(Auth::user()->id);
        $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
        $camposAvaliacao = CampoAvaliacao::where('evento_id', $request->evento_id)->get();
        $avaliacaoTrab = AvaliacaoTrabalho::where('trabalho_id', $request->trabalho_id)->where('avaliador_id', $avaliador->id)->get();
        $evento = Evento::find($request->evento_id);
        $trabalho = $avaliador->trabalhos->find($request->trabalho_id);
        $data = Carbon::now('America/Recife');

        if ($avaliacaoTrab->count() > 0) {
            foreach ($avaliacaoTrab as $avaliacao) {
                $avaliacao->forceDelete();
            }
        }

        $i = 0;
        $pontuacao = 0;

        foreach ($camposAvaliacao as $campoAvaliacao) {
            //dd("a");
            $avaliacaoTrab = new AvaliacaoTrabalho();
            $avaliacaoTrab->nota = $request->inputField[$i]['nota'];
            $avaliacaoTrab->avaliador_id = $avaliador->id;
            $avaliacaoTrab->campo_avaliacao_id = $campoAvaliacao->id;
            $avaliacaoTrab->trabalho_id = $request->trabalho_id;
            $avaliacaoTrab->save();

            $pontuacao += number_format($request->inputField[$i]['nota']);
            ++$i; 
            
        }

        $avaliador->trabalhos()->updateExistingPivot($trabalho->id,['status'=> 1, 'recomendacao'=>$request->recomendacao, 'created_at' => $data, 'pontuacao' => $pontuacao]);

        if ($trabalho->avaliadors()->where('status', 1)->count() == $trabalho->avaliadors()->count()) {
            $trabalho->status = "avaliado";
            $trabalho->save();
        }

        return redirect(route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id]));
    }

    public function parecerLink(Request $request) {
        $user = User::find(Auth::user()->id);
        $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
        $trabalho = $avaliador->trabalhos->find($request->trabalho_id);
        $evento = Evento::find($request->evento_id);
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();

        return view('avaliador.parecerLink', ['trabalho'=>$trabalho, 'evento'=>$evento, 'hoje' => $hoje]);
    }

    public function enviarParecerLink(Request $request) {
        $user = User::find(Auth::user()->id);
        $evento = Evento::find($request->evento_id);
        $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      	$trabalho = $avaliador->trabalhos->find($request->trabalho_id);
        $data = Carbon::now('America/Recife');

        if ($request->pontuacao == null) {
            $avaliador->trabalhos()->updateExistingPivot($trabalho->id,['status'=> 1, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
        } else {
            $avaliador->trabalhos()->updateExistingPivot($trabalho->id,['status'=> 1, 'recomendacao'=>$request->recomendacao, 'created_at' => $data, 'pontuacao' => $request->pontuacao]);
        }

        if ($trabalho->avaliadors()->where('status', 1)->count() == $trabalho->avaliadors()->count()) {
            $trabalho->status = "avaliado";
            $trabalho->save();
        }
        
        return redirect(route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id]));
    }

    public function parecerPlano(Request $request){

      $user = User::find(Auth::user()->id);
      $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      $plano = $avaliador->planoTrabalhos->where('id', $request->plano_id)->first();
      $evento = Evento::find($request->evento);
      $recomendacaos = Recomendacao::all();
      // dd($plano);
    	return view('avaliador.parecerPlano', ['plano'=>$plano, 'evento'=>$evento, 'recomendacaos'=>$recomendacaos]);
    }

    public function enviarParecer(Request $request){

        $user = User::find(Auth::user()->id);
        

        $evento = Evento::find($request->evento_id);
        //$trabalhos = $user->avaliadors->where('user_id',$user->id)->first()->trabalhos->where('evento_id', $request->evento_id);
        $trabalhosEx = [];
        $trabalhosIn = [];
        $aval = $user->avaliadors->where('user_id',$user->id)->first();
        foreach ($aval->trabalhos->where('evento_id',$evento->id) as $trab){
            if($aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->acesso == 2 || $aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->acesso == 3 ){
                array_push($trabalhosIn,$aval->trabalhos()->where("trabalho_id",$trab->id)->first());
            }
            if ($aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->acesso == 1 || $aval->trabalhos()->where("trabalho_id",$trab->id)->first()->pivot->acesso == 3){
                array_push($trabalhosEx,$aval->trabalhos()->where("trabalho_id",$trab->id)->first());
            }
        }
        $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      	$trabalho = $avaliador->trabalhos->find($request->trabalho_id);
        $data = Carbon::now('America/Recife');
    	if($request->anexoParecer == ''){  
    	    if($evento->tipo == "PIBEX"){
                $avaliador->trabalhos()
                    ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data, 'pontuacao' => $request->pontuacao]);
            }else{
                $avaliador->trabalhos()
                    ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
            }
    	}else{
          $anexoParecer = $request->anexoParecer;
          $path = 'anexoParecer/' . $avaliador->id . $trabalho->id . '/';
          $nome = $anexoParecer->getClientOriginalName();
          Storage::putFileAs($path, $anexoParecer, $nome);
          $anexoParecer = $path . $nome;

          if($evento->tipo == "PIBEX"){
              $avaliador->trabalhos()
                  ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer,'AnexoParecer'=> $anexoParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data, 'pontuacao' => $request->pontuacao]);
          }else{
              $avaliador->trabalhos()
                  ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer,'AnexoParecer'=> $anexoParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
          }
    	}

        if ($trabalho->avaliadors()->where('status', 1)->count() == $trabalho->avaliadors()->count()) { 
            $trabalho->status = "avaliado";
            $trabalho->save();
        }
    	
    	return redirect(route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id]));
    }
    public function conviteResposta(Request $request){
        $user = User::find(Auth::user()->id);
        $evento = Evento::find($request->evento_id);
        $user->avaliadors->eventos()->updateExistingPivot($evento->id, ['convite'=> $request->resposta]);
        return redirect()->back();
    }

    public function listarPlanos(Request $request){

        $user = User::find(Auth::user()->id);
        $evento = Evento::where('id', $request->evento_id)->first();
        $planos = $user->avaliadors->where('user_id',$user->id)->first()->planoTrabalhos;

    	//dd();

    	return view('avaliador.listarPlanos', ['planos'=>$planos, 'evento'=>$evento]);

    }

    public function enviarParecerPlano(Request $request){

        $user = User::find(Auth::user()->id);
        

        $evento = Evento::find($request->evento_id);
        $planos = $user->avaliadors->where('user_id',$user->id)->first()->planoTrabalhos;
      	$avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      	$plano = $avaliador->planoTrabalhos->find($request->plano_id);
        $plano->versao = 1;
        $plano->save();
        $data = Carbon::now('America/Recife');
    	if($request->anexoParecer == ''){  

                $avaliador->planoTrabalhos()
                ->updateExistingPivot($plano->id,['status'=> 1,'parecer'=>$request->textParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
    	}else{
          $anexoParecer = $request->anexoParecer;
          $path = 'anexoParecerPlano/' . $avaliador->id . $plano->id . '/';
          $nome = "parecerPlano.pdf";
          Storage::putFileAs($path, $anexoParecer, $nome);  
          $anexoParecer = $path . $nome;   

			$avaliador->planoTrabalhos()
                ->updateExistingPivot($plano->id,['status'=> 1,'parecer'=>$request->textParecer,'AnexoParecer'=> $anexoParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
    	}
    	
  
    	//	dd($trabalho);

    	return view('avaliador.listarPlanos', ['planos'=>$planos, 'evento'=>$evento ]);
    }

    public function consultaExterno(Request $request) {
        $id = json_decode($request->id) ;
        $trabalho_id = json_decode($request->trabalho_id) ;
        $trabalho = Trabalho::where('id',$trabalho_id)->first();
        $avalSelecionadosId = $trabalho->avaliadors->pluck('id');

        $avaliadores = DB::Table('avaliadors')->join('users','avaliadors.user_id','=','users.id')
            ->join('areas','avaliadors.area_id','=','areas.id')
            ->select('avaliadors.id','areas.nome','users.name','users.instituicao','users.email')
           ->where('avaliadors.area_id', $id)
            ->where('avaliadors.tipo','Externo')
            ->whereNotIn('avaliadors.id', $avalSelecionadosId)->get();
        return response()->json($avaliadores);
        return $avaliadores->toJson();
    }

    public function consultaInterno(Request $request) {
        $id = json_decode($request->id) ;
        $trabalho_id = json_decode($request->trabalho_id) ;
        $trabalho = Trabalho::where('id',$trabalho_id)->first();
        $avalSelecionadosId = $trabalho->avaliadors->pluck('id');

        $avaliadores = DB::Table('avaliadors')->join('users','avaliadors.user_id','=','users.id')
            ->join('areas','avaliadors.area_id','=','areas.id')
            ->select('avaliadors.id','areas.nome','users.name','users.instituicao','users.email')
            ->where('avaliadors.area_id', $id)
            ->where('avaliadors.tipo','Interno')
            ->whereNotIn('avaliadors.id', $avalSelecionadosId)->get();
        return response()->json($avaliadores);
        return $avaliadores->toJson();
    }
}
