<?php

namespace App\Http\Controllers;

use App\Arquivo;
use App\Notificacao;
use App\User;
use Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Carbon\Carbon;
use App\Notifications\RelatorioRecebimentoNotification;
use App\Administrador;


class ArquivoController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function show(Arquivo $arquivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Arquivo $arquivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arquivo $arquivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arquivo $arquivo)
    {
        //
    }

    public function baixarPlano($id) {
        $arquivo = Arquivo::find($id);

        if (Storage::disk()->exists($arquivo->nome)) {
            ob_end_clean();
            return Storage::download($arquivo->nome);
        }
        return abort(404);
    }

    public function listar($id){
        $arquivos = Arquivo::where('trabalhoId',$id)->get();
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        return view('planosTrabalho.listar')->with(['arquivos' => $arquivos, 'hoje' => $hoje]);
    }

    public function anexarRelatorio(Request $request){
        try{
            $arquivo = Arquivo::where('id',$request->arqId)->first();
            $pasta = 'planoTrabalho/' . $arquivo->id;
            if($request->relatorioParcial != null) {
                $arquivo->relatorioParcial = Storage::putFileAs($pasta, $request->relatorioParcial, "RelatorioParcial.pdf");
                //Coordenador
                $userTemp = User::find($arquivo->trabalho->evento->coordenadorComissao->user_id);
                $notificacao = Notificacao::create([
                    'remetente_id' => Auth::user()->id,
                    'destinatario_id' => $arquivo->trabalho->evento->coordenadorComissao->user_id,
                    'trabalho_id' => $arquivo->trabalho->id,
                    'lido' => false,
                    'tipo' => 3,
                ]);
                $notificacao->save();
                Notification::send($userTemp, new RelatorioRecebimentoNotification($arquivo->trabalho->id,$userTemp,
                $arquivo->trabalho->evento->nome,$arquivo->trabalho->titulo,'Parcial'));
                //Admins
                $admins = Administrador::all();
                foreach ($admins as $admin) {
                    $userTemp = User::find($admin->user_id);
                    $notificacao = Notificacao::create([
                        'remetente_id' => Auth::user()->id,
                        'destinatario_id' => $admin->user_id,
                        'trabalho_id' => $arquivo->trabalho->id,
                        'lido' => false,
                        'tipo' => 3,
                    ]);
                    $notificacao->save();
                    Notification::send($userTemp, new RelatorioRecebimentoNotification($arquivo->trabalho->id,$userTemp,
                    $arquivo->trabalho->evento->nome,$arquivo->trabalho->titulo,'Parcial'));
                }

            }
            if($request->relatorioFinal != null) {
                $arquivo->relatorioFinal = Storage::putFileAs($pasta, $request->relatorioFinal, "RelatorioFinal.pdf");
                //Coordenador
                $userTemp = User::find($arquivo->trabalho->evento->coordenadorComissao->user_id);
                $notificacao = Notificacao::create([
                    'remetente_id' => Auth::user()->id,
                    'destinatario_id' => $arquivo->trabalho->evento->coordenadorComissao->user_id,
                    'trabalho_id' => $arquivo->trabalho->id,
                    'lido' => false,
                    'tipo' => 4,
                ]);
                $notificacao->save();
                Notification::send($userTemp, new RelatorioRecebimentoNotification($arquivo->trabalho->id,$userTemp,
                    $arquivo->trabalho->evento->nome,$arquivo->trabalho->titulo,'Final'));
                //Admins
                $admins = Administrador::all();
                foreach ($admins as $admin) {
                    $userTemp = User::find($admin->user_id);
                    $notificacao = Notificacao::create([
                        'remetente_id' => Auth::user()->id,
                        'destinatario_id' => $admin->user_id,
                        'trabalho_id' => $arquivo->trabalho->id,
                        'lido' => false,
                        'tipo' => 4,
                    ]);
                    $notificacao->save();
                    Notification::send($userTemp, new RelatorioRecebimentoNotification($arquivo->trabalho->id,$userTemp,
                        $arquivo->trabalho->evento->nome,$arquivo->trabalho->titulo,'Final'));
                }
            }
            $arquivo->save();
            return redirect(route('planos.listar', ['id' => $request->projId]))->with(['sucesso' => "Relatório enviado com sucesso"]);
        }catch (Exception $th){

        }
    }
}
