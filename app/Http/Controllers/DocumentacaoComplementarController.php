<?php

namespace App\Http\Controllers;

use App\Arquivo;
use App\documentacaoComplementar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentacaoComplementarController extends Controller
{
    public function criar(Request $request)
    {
        if($request->docId != null){
            $docComp = DocumentacaoComplementar::find($request->docId);
        }else{
            $docComp = new DocumentacaoComplementar;
            $docComp->save();
        }

        $pasta = 'docComplementar/' . $docComp->id;

        $docComp->termoCompromisso = Storage::putFileAs($pasta, $request->termoCompromisso, "Termo De Compromisso.pdf");
        $docComp->comprovanteMatricula = Storage::putFileAs($pasta, $request->comprovanteMatricula, "Comprovante De Matricula.pdf");
        $docComp->pdfLattes = Storage::putFileAs($pasta, $request->pdfLattes, "Lattes.pdf");
        $docComp->termoCompromisso = Storage::putFileAs($pasta, $request->termoCompromisso, "TermoDeCompromisso.pdf");
        $docComp->participante_id = $request->partcipanteId;
        $docComp->linkLattes = $request->linkLattes;

        $docComp->update();


        return redirect()->back()->with(['sucesso' => "Documentação complementar enviada com sucesso"]);

    }
}
