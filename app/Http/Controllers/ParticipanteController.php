<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Evento;
use App\Trabalho;
use App\Participante;
use App\FuncaoParticipantes;
use Auth;

class ParticipanteController extends Controller
{
    public function index(){

    	return view('participante.index');
    }
    public function editais(){

        $eventos = Evento::all();
        return view('participante.editais', ['eventos'=> $eventos] );
    }

    public function edital($id){
        $edital = Evento::find($id);
        $trabalhosId = Trabalho::where('evento_id', '=', $id)->select('id')->get();
        $meusTrabalhosId = Participante::where('user_id', '=', Auth()->user()->id)
            ->whereIn('trabalho_id', $trabalhosId)->select('trabalho_id')->get();
        $projetos = Trabalho::whereIn('id', $meusTrabalhosId)->get();
        //$projetos = Auth::user()->participantes->where('user_id', Auth::user()->id)->first()->trabalhos;


        //dd(Auth::user()->proponentes);

        return view('participante.projetos')->with(['edital' => $edital, 'projetos' => $projetos]);
    }

    public function storeFuncao(Request $request) {
        $validated = $request->validate([
            'newFuncao'      => 'required',
            'nome_da_função' => 'required',
        ]);

        $funcao = new FuncaoParticipantes();
        $funcao->nome = $request->input('nome_da_função');

        $funcao->save();

        return redirect()->back()->with(['mensagem' => 'Função de participante cadastrada com sucesso!']);
    }

    public function updateFuncao(Request $request, $id) {
        $validated = $request->validate([
            'editFuncao' => 'required',
            'nome_da_função'.$id => 'required',
        ]);

        $funcao = FuncaoParticipantes::find($id);
        if ($funcao->participantes->count() > 0) {
            return redirect()->back()->with(['error' => 'Essa função não pode ser editada pois participantes estão vinculados a ela!']);
        }

        $funcao->nome = $request->input('nome_da_função'.$id);
        $funcao->update();

        return redirect()->back()->with(['mensagem' => 'Função de participante salva com sucesso!']);
    }

    public function destroyFuncao($id) {
        $funcao = FuncaoParticipantes::find($id);
        if ($funcao->participantes->count() > 0) {
            return redirect()->back()->with(['error' => 'Essa função não pode ser excluída pois participantes estão vinculados a ela!']);
        }

        $funcao->delete();
        return redirect()->back()->with(['mensagem' => 'Função de participante deletada com sucesso!']);
    }

    public function baixarDocumento(Request $request) {

        if (Storage::disk()->exists($request->pathDocumento)) {
            ob_end_clean();
            return Storage::download($request->pathDocumento);
        }
        return abort(404);
    }

    public function listarParticipanteEdital(){
        $participantes = Participante::all();
        $trabalhos = Trabalho::all();
        return view('administrador.listarBolsas')->with(['participantes' => $participantes, 'trabalhos' => $trabalhos]);
    }

    public function listarParticipanteProjeto(Request $request){
        $trabalho = Trabalho::find($request->projeto_id);
        $participantes = $trabalho->participantes;

        if(Auth::user()->id != $trabalho->proponente->user->id){
            return redirect()->back();
        }

        return view('documentacaoComplementar.listar')->with(['participantes' => $participantes, 'trabalho' => $trabalho]);
    }

    public function alterarBolsa(Request $request){
        $participante = Participante::find($request->id);
        $participante->tipoBolsa = $request->tipo;
        $participante->save();
        return redirect()->back()->with(['sucesso' => 'Definição da bolsa realizada com sucesso!']);
    }

    public function atualizarDocComplementar(Request $request){
        $participante = Participante::find($request->partcipanteId);
        $pasta = 'participantes/' . $participante->id;
        $editalTipo = $request->eventoTipo;
        $participante->anexoTermoCompromisso = Storage::putFileAs($pasta, $request->termoCompromisso, "Termo_de_Compromisso.pdf");
        $participante->anexoComprovanteMatricula = Storage::putFileAs($pasta, $request->comprovanteMatricula, "Comprovante_de_Matricula.pdf");
        $participante->anexo_cpf_rg = Storage::putFileAs($pasta, $request->anexo_cpf_rg, "Anexo_CPF_RG." . $request->file('anexo_cpf_rg')->getClientOriginalExtension());

        if($request->eventoTipo != "PIBEX"){
            $participante->anexoLattes = Storage::putFileAs($pasta, $request->pdfLattes, "Curriculo_Lattes.pdf");
            $participante->linkLattes = $request->linkLattes;
        }
        
        if($request->comprovanteBancario != null){
            $participante->anexoComprovanteBancario = Storage::putFileAs($pasta, $request->comprovanteBancario, "Comprovante_Bancario." . $request->file('comprovanteBancario')->getClientOriginalExtension());
        }
        if($request->autorizacaoPais != null){
            $participante->anexoAutorizacaoPais = Storage::putFileAs($pasta, $request->autorizacaoPais, "Autorização_dos_Pais.pdf");
        }
        
        $participante->update();
        
        //dd($request);
        return redirect()->back()->with(['sucesso'=>"Documentação complementar enviada com sucesso"]);
    }
}
