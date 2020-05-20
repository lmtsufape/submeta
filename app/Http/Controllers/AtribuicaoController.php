<?php

namespace App\Http\Controllers;

use App\Atribuicao;
use Illuminate\Http\Request;
use App\Evento;
use App\Revisor;
use App\User;
use App\Trabalho;
use App\Area;
use App\Mail\EmailLembrete;
use Illuminate\Support\Facades\Mail;

class AtribuicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
          'revisorId'      => ['required', 'integer',],
          'trabalhoId'     => ['required', 'integer'],
        ]);

        $atribuicao = Atribuicao::create([
          'confirmacao' => false,
          'parecer'     => 'processando',
          'revisorId'   => $request->revisorId,
          'trabalhoId'  => $request->trabalhoId,
        ]);

        return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Atribuicao  $atribuicao
     * @return \Illuminate\Http\Response
     */
    public function show(Atribuicao $atribuicao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Atribuicao  $atribuicao
     * @return \Illuminate\Http\Response
     */
    public function edit(Atribuicao $atribuicao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Atribuicao  $atribuicao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Atribuicao $atribuicao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Atribuicao  $atribuicao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atribuicao $atribuicao)
    {
        //
    }

    public function distribuicaoAutomatica(Request $request){
      $this->authorize('isCoordenador', $evento);

      $validatedData = $request->validate([
        'eventoId' => ['required', 'integer'],
      ]);

      $evento = Evento::find($request->eventoId);
      $areas = Area::where('eventoId', $evento->id)->get();
      $areasId = Area::where('eventoId', $evento->id)->select('id')->get();
      $revisores = Revisor::where('eventoId', $evento->id)->get();
      $trabalhos = Trabalho::whereIn('areaId', $areasId)->get();

      foreach ($areas as $area) {
        $trabalhosArea = Trabalho::where('areaId', $area->id)->get();
        $revisoresArea = Revisor::where('areaId', $area->id)->get();
        $numRevisores = count($revisoresArea);
        $i = 0;
        foreach ($trabalhosArea as $trabalho) {
          $atribuicao = Atribuicao::create([
            'confirmacao' => false,
            'parecer'     => 'processando',
            'revisorId'   => $revisoresArea[$i]->id,
            'trabalhoId'  => $trabalho->id,
          ]);
          $i++;
          if($i == $numRevisores){
            $i = 0;
          }
        }
      }

      return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }

    public function distribuicaoPorArea(Request $request){
      $validatedData = $request->validate([
        'eventoId'                     => ['required', 'integer'],
        'areaId'                       => ['required', 'integer', 'min:1'],
        'numeroDeRevisoresPorTrabalho' => ['required', 'integer']
      ]);

      $evento = Evento::find($request->eventoId);
      $this->authorize('isCoordenador', $evento);


      $evento = Evento::find($request->eventoId);
      $area = Area::find($request->areaId);
      $revisores = Revisor::where('areaId', $area->id)->get();
      $trabalhos = Trabalho::where('areaId', $area->id)->get();
      $trabalhosArea = Trabalho::where('areaId', $area->id)->get();
      $revisoresArea = Revisor::where('areaId', $area->id)->get();
      $numRevisores = count($revisores);
      $i = 0;
      foreach ($trabalhosArea as $trabalho) {
        for($j = 0; $j < $request->numeroDeRevisoresPorTrabalho; $j++){
          //checar se ja existe atribuicao para esse revisor se sim entao vai pro proximo
          $atribuicao = Atribuicao::where('revisorId', $revisoresArea[$i]->id)->where('trabalhoId', $trabalho->id)->first();
          if($atribuicao != null){
            $i++;
            if($i == $numRevisores){
              $i = 0;
            }
            continue;
          }
          // atribui para um revisor
          $atribuicao = Atribuicao::create([
            'confirmacao' => false,
            'parecer'     => 'processando',
            'revisorId'   => $revisoresArea[$i]->id,
            'trabalhoId'  => $trabalho->id,
          ]);
          $aux = Revisor::find($revisoresArea[$i]->id);
          $aux->correcoesEmAndamento = $aux->correcoesEmAndamento + 1;
          $aux->save();

          $trabalho = Trabalho::find($trabalho->id);
          $trabalho->avaliado = 'processando';
          $trabalho->save();

          $i++;
          if($i == $numRevisores){
            $i = 0;
          }
        }
      }

      return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }

    public function distribuicaoManual(Request $request){
      $validatedData = $request->validate([
        'eventoId'  => ['required', 'integer'],
        'trabalhoId'=> ['required', 'integer'],
        'revisorId' => ['required', 'integer']
      ]);

      $evento = Evento::find($request->eventoId);
      $this->authorize('isCoordenador', $evento);

      $atribuicao = Atribuicao::create([
        'confirmacao' => false,
        'parecer'     => 'processando',
        'revisorId'   => $request->revisorId,
        'trabalhoId'  => $request->trabalhoId
      ]);

      $trabalho = Trabalho::find($request->trabalhoId);
      $trabalho->avaliado = 'processando';
      $trabalho->save();

      $revisor = Revisor::find($request->revisorId);
      $revisor->correcoesEmAndamento = $revisor->correcoesEmAndamento + 1;
      $revisor->save();

      $subject = "Trabalho atribuido";
      $informacoes = $trabalho->titulo;
      Mail::to($revisor->user->email)
            ->send(new EmailLembrete($revisor->user, $subject, $informacoes));

      return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }

    public function deletePorRevisores(Request $request){
      $validatedData = $request->validate([
        'eventoId'    => ['required', 'integer'],
        'trabalhoId'  => ['required', 'integer'],
        'revisores.*' => ['required', 'integer']
      ]);

      $evento = Evento::find($request->eventoId);
      $this->authorize('isCoordenador', $evento);

      foreach ($request->revisores as $key) {
        $atribuicao = Atribuicao::where('trabalhoId', $request->trabalhoId)->where('revisorId', $key)->first();
        if($atribuicao != null){
          $atribuicao->delete();

          $trabalho = Trabalho::find($request->trabalhoId);
          $trabalho->avaliado = 'nao';
          $trabalho->save();

          $revisor = Revisor::find($key);
          $revisor->correcoesEmAndamento = $revisor->correcoesEmAndamento - 1;
          $revisor->save();
        }

      }

      return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }
}
