<?php

use App\Notifications\SubmissaoNotification;
use App\Trabalho;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/email', function (Request $request) {
    $id = Trabalho::find(9)->id;
    Notification::send(Auth::user(), new SubmissaoNotification($id));

    return 'Ok';
    // Auth::user()->notify(new SubmissaoTrabalho('teste'));
});

Route::get('/baixarModeloAvaliacao', 'AdministradorController@baixarModeloAvaliacao')->name('baixarModelo');
Route::get('/', 'UserController@index')->name('home-user');
Route::get('/', 'UserController@inicial')->name('inicial');
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/evento/visualizar/naologado/{id}', 'EventoController@showNaoLogado')->name('evento.visualizarNaoLogado');
Route::get('/editais/home', 'EventoController@index')->name('coord.home');
Route::get('/perfil', 'UserController@perfil')->name('perfil');
Auth::routes(['verify' => true]);

//Rota para avaliador atualizar perfil, deixando de ser usuario temporario
Route::post('/perfil-usuario', 'UserController@editarPerfil')->name('perfil.edit')->middleware(['auth', 'verified']);

Route::group(['middleware' => ['isTemp', 'auth', 'verified']], function () {
    //######### Proponente  ########################################
    Route::get('/proponente/index', 'ProponenteController@index')->name('proponente.index');
    Route::get('/proponente/cadastro', 'ProponenteController@create')->name('proponente.create');
    Route::post('/proponente/cadastro', 'ProponenteController@store')->name('proponente.store');
    Route::get('/proponente/editais', 'ProponenteController@editais')->name('proponente.editais');
    Route::get('/projetos-submetidos', 'ProponenteController@projetosDoProponente')->name('proponente.projetos');
    Route::get('/projetos-edital/{id}', 'ProponenteController@projetosEdital')->name('proponente.projetosEdital')->middleware('auth');
    Route::post('/proponente/edital/{edital_id}/projeto/{projeto_id}/solicitar_desligamento/{participante_id}', 'ProponenteController@solicitarDesligamento')->name('proponente.solicitar.desligamento');

    //######## Rotas Avaliador  ####################################
    Route::prefix('avaliacaoRelatorio')->name('avaliacaoRelatorio.')->group(function () {
        Route::post('/atribuirAvaliadorPlano', 'AvaliacaoRelatorioController@atribuicaoAvaliador')->name('atribuicao.avaliador')->middleware('checkRoles:coordenador,administrador');
        Route::get('/removerAvaliadorPlano/{id}', 'AvaliacaoRelatorioController@removerAvaliador')->name('remover.avaliador')->middleware('checkRoles:coordenador,administrador');
    });
    Route::get('/trabalho/planos/avaliacaoRelatorio/{id}', 'AvaliacaoRelatorioController@listarUserRelatorio')->name('planos.avaliacoesUserRelatorio');
    Route::get('/trabalho/planos/avaliacaoApresentacao/{id}', 'AvaliacaoRelatorioController@listarUserApresentacao')->name('planos.avaliacoesUserApresentacao');
    Route::get('/trabalho/planos/avaliacoes/index', 'AvaliacaoRelatorioController@index')->name('planos.avaliacoes.index');
    Route::post('/trabalho/planos/avaliacoes/criaRelatorio', 'AvaliacaoRelatorioController@criarRelatorio')->name('planos.avaliacoesUser.criarRelatorio');
    Route::post('/trabalho/planos/avaliacoes/criaApresentacao', 'AvaliacaoRelatorioController@criarApresentacao')->name('planos.avaliacoesUser.criarApresentacao');

    Route::prefix('areaTematica')->name('areaTematica.')->group(function () {
        Route::get('/editar/{id}', 'AreaTematicaController@edit')->name('edit')->middleware('checkAdministrador');
        Route::post('/atualizar/{id}', 'AreaTematicaController@update')->name('atualizar')->middleware('checkAdministrador');
        Route::post('/excluir/{id}', 'AreaTematicaController@destroy')->name('deletar')->middleware('checkAdministrador');
        Route::post('/salvar', 'AreaTematicaController@store')->name('salvar')->middleware('checkAdministrador');
        Route::get('/nova', 'AreaTematicaController@create')->name('criar')->middleware('checkAdministrador');
    });

    Route::prefix('objetivoDeDenvolvimentoSustentavel')->name('objetivoDeDenvolvimentoSustentavel.')->group(function () {
        Route::get('/editar/{id}', 'ObjetivoDeDesenvolvimentoSustentavelController@edit')->name('edit')->middleware('checkAdministrador');
        Route::post('/atualizar/{id}', 'ObjetivoDeDesenvolvimentoSustentavelController@update')->name('atualizar')->middleware('checkAdministrador');
        Route::post('/excluir/{id}', 'ObjetivoDeDesenvolvimentoSustentavelController@destroy')->name('deletar')->middleware('checkAdministrador');
        Route::post('/salvar', 'ObjetivoDeDesenvolvimentoSustentavelController@store')->name('salvar')->middleware('checkAdministrador');
        Route::get('/novo', 'ObjetivoDeDesenvolvimentoSustentavelController@create')->name('criar')->middleware('checkAdministrador');
    });

    //######### Rotas Administrador #################################
    Route::get('/perfil-usuario', 'UserController@minhaConta')->name('user.perfil')->middleware(['auth', 'verified']);

    //######## Rotas Avaliador  ####################################
    Route::prefix('avaliador')->name('avaliador.')->group(function () {
        Route::get('/index', 'AvaliadorController@index')->name('index')->middleware('auth');
        Route::get('/trabalhos', 'AvaliadorController@visualizarTrabalhos')->name('visualizarTrabalho')->middleware('auth');
        Route::get('/planos', 'AvaliadorController@listarPlanos')->name('listarPlanos')->middleware('auth');
        Route::post('/parecer', 'AvaliadorController@parecer')->name('parecer')->middleware('auth');
        Route::post('/parecer/plano', 'AvaliadorController@parecerPlano')->name('parecer.plano')->middleware('auth');
        Route::get('/editais', 'AvaliadorController@editais')->name('editais')->middleware('auth');
        Route::post('/Enviarparecer', 'AvaliadorController@enviarParecer')->name('enviarParecer')->middleware('auth');
        Route::post('/Enviarparecer/plano', 'AvaliadorController@enviarParecerPlano')->name('enviarParecerPlano')->middleware('auth');
        Route::get('/Resposta', 'AvaliadorController@conviteResposta')->name('conviteResposta')->middleware('auth');

        Route::post('/parecerInterno', 'AvaliadorController@parecerInterno')->name('parecerInterno')->middleware('auth');
        Route::post('/EnviarparecerInterno', 'AvaliadorController@enviarParecerInterno')->name('enviarParecerInterno')->middleware('auth');

        Route::post('/parecerBarema', 'AvaliadorController@parecerBarema')->name('parecerBarema')->middleware('auth');
        Route::post('/EnviarparecerBarema', 'AvaliadorController@enviarParecerBarema')->name('enviarParecerBarema')->middleware('auth');

        Route::post('/parecerLink', 'AvaliadorController@parecerLink')->name('parecerLink')->middleware('auth');
        Route::post('/EnviarparecerLink', 'AvaliadorController@enviarParecerLink')->name('enviarParecerLink')->middleware('auth');
    });

    Route::get('/notificacao/listar', 'NotificacaoController@listar')->name('notificacao.listar')->middleware('auth');
    Route::get('/notificacao/lista', 'NotificacaoController@listarTrab')->name('notificacao.listarTrab')->middleware('auth');
    Route::get('/notificacao/ler/{id}', 'NotificacaoController@ler')->name('notificacao.ler');

    Route::get('/home/edital', 'EventoController@index')->name('visualizarEvento');

    // ######## rotas de teste #####################################

    Route::get('/coordenador/evento/detalhes', 'EventoController@detalhes')->name('coord.detalhesEvento');

    //####### Visualizar trabalhos do usuário ######################
    Route::get('/user/trabalhos', 'UserController@meusTrabalhos')->name('user.meusTrabalhos');

    //######### Cadastrar Comissão ###################################
    Route::post('/evento/cadastrarComissao', 'ComissaoController@store')->name('cadastrar.comissao');
    Route::post('/evento/cadastrarCoordComissao', 'ComissaoController@coordenadorComissao')->name('cadastrar.coordComissao');

    //######### rota downloadArquivo ################################
    Route::get('/downloadArquivo', 'HomeController@downloadArquivo')->name('download');

    //#########  Area do participante ###############################
    Route::get('/participante', 'EventoController@areaParticipante')->name('area.participante');
    Route::get('participante/editais', 'ParticipanteController@editais')->name('participante.editais');
    //######### Participante ########################################
    Route::get('/participante/index', 'ParticipanteController@index')->name('participante.index');
    Route::get('/participante/edital/{id}', 'ParticipanteController@edital')->name('participante.edital');

    //######### Plano de Trablho ########################################
    Route::prefix('/plano/trabalho')->name('plano.trabalho.')->group(function () {
        Route::get('/index/{evento_id}', 'PlanoTrabalhoController@index')->name('index');
        Route::get('/selecionar/{evento_id}', 'PlanoTrabalhoController@selecionarPlanos')->name('selecionarPlanos');
        Route::post('/atribuicao', 'PlanoTrabalhoController@atribuicao')->name('atribuicao');
    });

    //########## Area da comissao  ###################################
    Route::get('/comissoes', 'EventoController@listComissao')->name('comissoes');
    Route::get('/area/comissao', 'EventoController@listComissaoTrabalhos')->name('area.comissao');

    //###########  Deletar Comissão ###################################
    Route::delete('/evento/apagar-comissao/', 'ComissaoController@destroy')->name('delete.comissao');
    Route::post('/evento/numTrabalhos', 'EventoController@numTrabalhos')->name('trabalho.numTrabalhos');

    //##########  Area  ###########################################
    Route::post('/area/criar', 'AreaController@store')->name('area.store');

    //########### Deletar Area ######################################
    Route::delete('/area/deletar/{id}', 'AreaController@destroy')->name('area.delete');

    //#########  Deletar Revisores  ##############################
    Route::delete('/revisor/apagar', 'RevisorController@destroy')->name('revisor.delete');

    //######### AreaModalidade  ###################################
    Route::post('/areaModalidade/criar', 'AreaModalidadeController@store')->name('areaModalidade.store');

    //#########  Trabalho  ########################################
    Route::get('/trabalho/submeter/{id}', 'TrabalhoController@index')->name('trabalho.index');
    // Route::get(   '/trabalho/visualizar/{id}','TrabalhoController@show'                       )->name('trabalho.show');
    Route::post('/trabalho/novaVersao', 'TrabalhoController@novaVersao')->name('trabalho.novaVersao');
    Route::post('/trabalho/criar', 'TrabalhoController@salvar')->name('trabalho.store');
    Route::post('/trabalho/criarRascunho', 'TrabalhoController@storeParcial')->name('trabalho.storeParcial');
    Route::get('/edital/{id}/projetos', 'TrabalhoController@projetosDoEdital')->name('projetos.edital');
    Route::get('/projeto/visualizar/{id}', 'TrabalhoController@show')->name('trabalho.show');
    Route::get('/projeto/solicitarDeclaracao/{id}', 'TrabalhoController@solicitarDeclaracao')->name('trabalho.solicitarDeclaracao');
    Route::get('/projeto/{id}/editar', 'TrabalhoController@edit')->name('trabalho.editar');

    Route::post('/projeto/buscarUsuario', 'TrabalhoController@buscarUsuario')->name('trabalho.buscarUsuario');

    Route::post('/projeto/{id}/atualizar', 'TrabalhoController@update')->name('trabalho.update');
    Route::get('/projeto/{id}/excluir', 'TrabalhoController@destroy')->name('trabalho.destroy');
    Route::get('/projeto/{id}/excluirParticipante', 'TrabalhoController@excluirParticipante')->name('trabalho.excluirParticipante');
    Route::post('/projeto/{trabalho}/solicitarCertificado', 'TrabalhoController@solicitarCertificado')->name('trabalho.solicitarCertificado');
    Route::get('/projeto/exportar/{id}', 'TrabalhoController@exportProjeto')->name('exportar.projeto');
    Route::get('/projeto/substituirParticipante', 'TrabalhoController@telaTrocaPart')->name('trabalho.trocaParticipante');
    Route::post('/projeto/substituirParticipante', 'TrabalhoController@trocaParticipante')->name('trabalho.infoTrocaParticipante');
    Route::get('/showSubstituicoes', 'TrabalhoController@telaShowSubst')->name('trabalho.telaAnaliseSubstituicoes')->middleware('checkRoles:coordenador,administrador');
    Route::post('/aprovarSubstituicao', 'TrabalhoController@aprovarSubstituicao')->name('trabalho.aprovarSubstituicao');
    Route::post('/aprovarProposta/{id}', 'TrabalhoController@aprovarProposta')->name('trabalho.aprovarProposta');

    Route::post('/certificado/{certificado}', 'CertificadoController@update')->name('certificado.update');

    //##########  Bolsas
    Route::get('/bolsas', 'ParticipanteController@listarParticipanteEdital')->name('bolsas.listar');
    Route::post('/bolsas/alteracao', 'ParticipanteController@alterarBolsa')->name('bolsa.alterar');

    //##########  Arquivar Projeto e Plano
    Route::get('/arquivar/projeto', 'TrabalhoController@arquivar')->name('projeto.arquivar');
    Route::get('/arquivar/plano', 'ArquivoController@arquivar')->name('arquivo.arquivar');

    //######### Imprimir Resultado #################################
    Route::get('/usuarios/showResultados/imprimir', 'AdministradorController@imprimirResultados')->name('resultados.gerar');

    //##########  Relatórios
    Route::get('/projeto/planosTrabalho/{id}', 'ArquivoController@listar')->name('planos.listar');
    Route::post('/projeto/planosTrabalho/anexarRelatorio', 'ArquivoController@anexarRelatorio')->name('planos.anexar.relatorio');

    //########## Documentação Complementar
    Route::get('/documentacaoComplementar', 'ParticipanteController@listarParticipanteProjeto')->name('docComplementar.listar');
    Route::post('/documentacaoComplementar/enviar', 'ParticipanteController@atualizarDocComplementar')->name('docComplementar.enviar');

    //#########  Atribuição  #######################################
    Route::get('/atribuir', 'AtribuicaoController@distribuicaoAutomatica')->name('distribuicao');
    Route::get('/atribuirPorArea', 'AtribuicaoController@distribuicaoPorArea')->name('distribuicaoAutomaticaPorArea');
    Route::post('/distribuicaoManual', 'AtribuicaoController@distribuicaoManual')->name('distribuicaoManual');
    Route::post('/removerAtribuicao', 'AtribuicaoController@deletePorRevisores')->name('atribuicao.delete');

    //##########  Revisores #########################################
    Route::post('/revisor/criar', 'RevisorController@store')->name('revisor.store');
    Route::get('/revisor/listarTrabalhos', 'RevisorController@indexListarTrabalhos')->name('revisor.listarTrabalhos');
    Route::post('/revisor/email', 'RevisorController@enviarEmailRevisor')->name('revisor.email');
    Route::post('/revisor/emailTodos', 'RevisorController@enviarEmailTodosRevisores')->name('revisor.emailTodos');

    //########## Rotas de download  de documentos ###########################
    Route::get('/baixar/anexo-projeto/{id}', 'TrabalhoController@baixarAnexoProjeto')->name('baixar.anexo.projeto');
    Route::get('/baixar/anexo-consu/{id}', 'TrabalhoController@baixarAnexoConsu')->name('baixar.anexo.consu');
    Route::get('/baixar/anexo-acao-afirmativa/{id}', 'TrabalhoController@baixarAcaoAfirmativa')->name('baixar.anexo.acao.afirmativa');
    Route::get('/baixar/anexo-comite/{id}', 'TrabalhoController@baixarAnexoComite')->name('baixar.anexo.comite');
    Route::get('/baixar/anexo-justificativa/{id}', 'TrabalhoController@baixarAnexoJustificativa')->name('baixar.anexo.justificativa');
    Route::get('/baixar/anexo-lattes/{id}', 'TrabalhoController@baixarAnexoLattes')->name('baixar.anexo.lattes');
    Route::get('/baixar/anexo-planilha/{id}', 'TrabalhoController@baixarAnexoPlanilha')->name('baixar.anexo.planilha');
    Route::get('/baixar/plano-de-trabalho/{id}', 'ArquivoController@baixarPlano')->name('baixar.plano');
    Route::get('/baixar/anexoGrupoPesquisa/{id}', 'TrabalhoController@baixarAnexoGrupoPesquisa')->name('baixar.anexoGrupoPesquisa');
    Route::get('/baixar/anexo-temp/{eventoId}/{nomeAnexo}', 'TrabalhoController@baixarAnexoTemp')->name('baixar.anexo.temp');
    Route::get('/baixar/evento-temp/{nomeAnexo}', 'TrabalhoController@baixarEventoTemp')->name('baixar.evento.temp');
    Route::get('/baixar/modelo-evento-temp/{nomeAnexo}', 'TrabalhoController@baixarModeloEventoTemp')->name('baixar.modelo.evento.temp');
    Route::get('/baixar/documentosParticipante', 'ParticipanteController@baixarDocumento')->name('baixar.documentosParticipante');
    Route::get('/baixar/anexoDocExtra/{id}', 'TrabalhoController@baixarAnexoDocExtra')->name('baixar.anexo.docExtra');
    Route::get('/baixar/anexoSIPAC/{id}', 'TrabalhoController@baixarAnexoSIPAC')->name('baixar.anexo.SIPAC');
});

Route::get('/baixar/edital/{id}', 'EventoController@baixarEdital')->name('baixar.edital');
Route::get('/baixar/modelos/{id}', 'EventoController@baixarModelos')->name('baixar.modelos');

Route::prefix('usuarios')->name('admin.')->group(function () {
    //######### Rotas da administração dos usuários ####################
    Route::get('/home-admin', 'AdministradorController@index')->name('index')->middleware('checkAdministrador');
    Route::get('/usuarios', 'AdministradorController@usuarios')->name('usuarios')->middleware('checkAdministrador');
    Route::get('/novo', 'AdministradorController@create')->name('user.create')->middleware('checkAdministrador');
    Route::post('/salvar-novo', 'AdministradorController@salvar')->name('user.store')->middleware('checkAdministrador');
    Route::get('/editar/{id}', 'AdministradorController@edit')->name('user.edit')->middleware('checkAdministrador');
    Route::post('/editar/atualizar/{id}', 'AdministradorController@update')->name('user.update')->middleware('checkAdministrador');
    Route::post('/editar/deletar/{id}', 'AdministradorController@destroy')->name('user.destroy')->middleware('checkAdministrador');
    Route::get('/editais', 'AdministradorController@editais')->name('editais');
    Route::get('/atribuir', 'AdministradorController@atribuir')->name('atribuir');
    Route::get('/selecionarAvaliador', 'AdministradorController@selecionar')->name('selecionar');
    Route::get('/selecionarProjetos', 'AdministradorController@projetos')->name('projetos');
    Route::post('/adicionarAvalEvento', 'AdministradorController@adicionar')->name('adicionar');
    Route::post('/removerAvalEvento', 'AdministradorController@remover')->name('remover');
    Route::get('/removerProjAval', 'AdministradorController@removerProjAval')->name('removerProjAval');
    Route::post('/atribuirAvaliadorProjeto', 'AdministradorController@atribuicaoProjeto')->name('atribuicao.projeto');
    Route::post('/enviarConviteEAtribuirProjeto', 'AdministradorController@enviarConviteEAtribuir')->name('convite.atribuicao.projeto');
    Route::get('/reenviarConviteAtribuicaoProjeto', 'AdministradorController@reenviarConviteAtribuicaoProjeto')->name('reenviar.atribuicao.projeto');
    Route::post('/enviarConviteAvaliador', 'AdministradorController@enviarConvite')->name('enviarConvite');
    Route::post('/reenviarConviteAvaliador', 'AdministradorController@reenviarConvite')->name('reenviarConvite');
    Route::post('/visualizarParecer', 'AdministradorController@visualizarParecer')->name('visualizarParecer');
    Route::get('/visualizarParecer', 'AdministradorController@visualizarParecer')->name('visualizarParecer');
    Route::get('/visualizarParecerInterno', 'AdministradorController@visualizarParecerInterno')->name('visualizarParecerInterno');
    Route::get('/visualizarParecerLink', 'AdministradorController@visualizarParecerLink')->name('visualizarParecerLink');
    Route::get('/visualizarParecerBarema', 'AdministradorController@visualizarParecerBarema')->name('visualizarParecerBarema');
    Route::get('/pareceresProjetos', 'AdministradorController@pareceres')->name('pareceres');
    Route::get('/analisarProjetos/{column?}', 'AdministradorController@analisar')->name('analisar')->middleware('checkRoles:coordenador,administrador');
    Route::get('/analisarProposta', 'AdministradorController@analisarProposta')->name('analisarProposta')->middleware('checkRoles:coordenador,administrador');
    Route::get('/showProjetos', 'AdministradorController@showProjetos')->name('showProjetos');
    Route::get('/showResultados', 'AdministradorController@showResultados')->name('showResultados')->middleware(['auth', 'verified']);
});

Route::prefix('naturezas')->group(function () {
    //########### Rotas das naturezas     ###############################

    Route::get('/', 'AdministradorController@naturezas')->name('admin.naturezas')->middleware('checkAdministrador');
    Route::get('/index', 'NaturezaController@index')->name('natureza.index')->middleware('checkAdministrador');
    Route::get('/nova', 'NaturezaController@create')->name('natureza.criar')->middleware('checkAdministrador');
    Route::post('/salvar', 'NaturezaController@store')->name('natureza.salvar')->middleware('checkAdministrador');
    Route::get('/detalhes/{id}', 'NaturezaController@show')->name('natureza.show')->middleware('checkAdministrador');
    Route::get('/editar/{id}', 'NaturezaController@edit')->name('natureza.editar')->middleware('checkAdministrador');
    Route::get('/atualizar/{id}', 'NaturezaController@update')->name('natureza.atualizar')->middleware('checkAdministrador');
    Route::get('/excluir/{id}', 'NaturezaController@destroy')->name('natureza.deletar')->middleware('checkAdministrador');

    //########### Rotas das grandes areas ##############################
    Route::get('/grande-area', 'GrandeAreaController@index')->name('grandearea.index')->middleware('checkAdministrador');
    Route::get('/grande-area/nova', 'GrandeAreaController@create')->name('grandearea.criar')->middleware('checkAdministrador');
    Route::post('/grande-area/salvar', 'GrandeAreaController@store')->name('grandearea.salvar')->middleware('checkAdministrador');
    Route::get('/grande-area/detalhes/{id}', 'GrandeAreaController@show')->name('grandearea.show')->middleware('checkAdministrador');
    Route::get('/grande-area/editar/{id}', 'GrandeAreaController@edit')->name('grandearea.editar')->middleware('checkAdministrador');
    Route::post('/grande-area/atualizar/{id}', 'GrandeAreaController@update')->name('grandearea.atualizar')->middleware('checkAdministrador');
    Route::post('/grande-area/excluir/{id}', 'GrandeAreaController@destroy')->name('grandearea.deletar')->middleware('checkAdministrador');

    //#### Rotas das areas, id's de nova e salvar são os ids da grande área a qual a nova área pertence ####
    Route::get('/areas', 'AreaController@index')->name('area.index')->middleware('checkAdministrador');
    Route::get('/{id}/area/nova', 'AreaController@create')->name('area.criar')->middleware('checkAdministrador');
    Route::post('/{id}/area/salvar', 'AreaController@store')->name('area.salvar')->middleware('checkAdministrador');
    Route::get('/area/detalhes/{id}', 'AreaController@show')->name('area.show')->middleware('checkAdministrador');
    Route::get('/area/editar/{id}', 'AreaController@edit')->name('area.editar')->middleware('checkAdministrador');
    Route::post('/area/atualizar/{id}', 'AreaController@update')->name('area.atualizar')->middleware('checkAdministrador');
    Route::post('/area/excluir/{id}', 'AreaController@destroy')->name('area.deletar')->middleware('checkAdministrador');
    Route::post('/areas/', 'AreaController@consulta')->name('area.consulta');
    Route::post('/avalConExterno/', 'AvaliadorController@consultaExterno')->name('aval.consultaExterno');
    Route::post('/avalConInterno/', 'AvaliadorController@consultaInterno')->name('aval.consultaInterno');

    //### Rotas das subareas, id's de nova e salvar são os ids da área a qual a nova subárea pertence #####
    Route::get('/subareas', 'SubAreaController@index')->name('subarea.index')->middleware('checkAdministrador');
    Route::get('/{id}/subarea/nova', 'SubAreaController@create')->name('subarea.criar')->middleware('checkAdministrador');
    Route::post('/{id}/subarea/salvar', 'SubAreaController@store')->name('subarea.salvar')->middleware('checkAdministrador');
    Route::get('/subarea/detalhes/{id}', 'SubAreaController@show')->name('subarea.show')->middleware('checkAdministrador');
    Route::get('/subarea/editar/{id}', 'SubAreaController@edit')->name('subarea.editar')->middleware('checkAdministrador');
    Route::post('/subarea/atualizar/{id}', 'SubAreaController@update')->name('subarea.atualizar')->middleware('checkAdministrador');
    Route::post('/subarea/excluir/{id}', 'SubAreaController@destroy')->name('subarea.deletar')->middleware('checkAdministrador');
    Route::post('/subarea/', 'SubAreaController@consulta')->name('subarea.consulta');

    Route::post('/funcao-participante/store', 'ParticipanteController@storeFuncao')->name('funcao_participante.store');
    Route::post('/funcao-participante/{id}/update', 'ParticipanteController@updateFuncao')->name('funcao_participante.update');
    Route::get('/funcao-participante/{id}/destroy', 'ParticipanteController@destroyFuncao')->name('funcao_participante.destroy');
});

Route::prefix('cursos')->name('cursos.')->group(function (){
    //#################### Rotas de cursos #########################
    Route::get('index', 'CursoController@index')->name('index')->middleware('checkAdministrador');
    Route::get('nova', 'CursoController@create')->name('criar')->middleware('checkAdministrador');
    Route::post('salvar','CursoController@store')->name('salvar')->middleware('checkAdministrador');
    Route::get('editar/{id}', 'CursoController@edit')->name('editar')->middleware('checkAdministrador');
    Route::post('editar/{id}', 'CursoController@update')->name('update')->middleware('checkAdministrador');
    Route::delete('exluir/{id}', 'CursoController@destroy')->name('excluir')->middleware('checkAdministrador');
    //Route::get('novo')->name('novo');
});

//############ Evento ##############################################
Route::prefix('evento')->name('evento.')->group(function () {
    Route::get('/criar', 'EventoController@create')->name('criar')->middleware('checkRoles:coordenador,administrador');
    Route::post('/criar', 'EventoController@store')->name('criar')->middleware('checkRoles:coordenador,administrador');
    Route::get('/visualizar/{id}', 'EventoController@show')->name('visualizar')->middleware('auth');
    Route::get('/listar', 'EventoController@listar')->name('listar')->middleware('auth');
    Route::delete('/excluir/{id}', 'EventoController@destroy')->name('deletar')->middleware('checkRoles:coordenador,administrador');
    Route::get('/editar/{id}', 'EventoController@edit')->name('editar')->middleware('checkRoles:coordenador,administrador');
    Route::post('/editar/{id}', 'EventoController@update')->name('update')->middleware('checkRoles:coordenador,administrador');
    Route::post('/setResumo', 'EventoController@setResumo')->name('setResumo')->middleware('checkAdministrador');
    Route::post('/setFoto', 'EventoController@setFotoEvento')->name('setFotoEvento')->middleware('checkAdministrador');
});

//########## Rotas de administrador responsavel (Reitor ou pro-reitor)########
Route::prefix('adminResp')->name('adminResp.')->group(function () {
    Route::get('/index', 'AdministradorResponsavelController@index')->name('index');
    Route::get('/editais', 'AdministradorResponsavelController@editais')->name('editais');
    Route::get('/usuarios', 'AdministradorResponsavelController@usuarios')->name('usuarios');
    Route::get('/atribuir', 'AdministradorResponsavelController@atribuirPermissao')->name('atribuir');
    Route::post('/atribuir', 'AdministradorResponsavelController@atribuirPermissao')->name('atribuir');
    Route::post('/verPermissao', 'AdministradorResponsavelController@verPermissao')->name('verPermissao');
});

//########### Rotas Coordenador ##################################
Route::prefix('coordenador')->name('coordenador.')->group(function () {
    Route::get('/index', 'CoordenadorComissaoController@index')->name('index');
    Route::get('/editais', 'CoordenadorComissaoController@editais')->name('editais');
    Route::get('/usuarios', 'CoordenadorComissaoController@usuarios')->name('usuarios');
    Route::get('/listarCoord', 'CoordenadorComissaoController@coordenadorComite')->name('coord');
    Route::get('/listarAvaliador', 'CoordenadorComissaoController@avaliador')->name('avaliador');
    Route::get('/listarProponente', 'CoordenadorComissaoController@proponente')->name('proponente');
    Route::get('/listarParticipante', 'CoordenadorComissaoController@participante')->name('participante');
    Route::get('/listarTrabalhos', 'CoordenadorComissaoController@listarTrabalhos')->name('listarTrabalhos');
    Route::get('/detalhesEdital/{evento_id}', 'CoordenadorComissaoController@detalhesEdital')->name('detalhesEdital');
    Route::post('/retornoDetalhes', 'CoordenadorComissaoController@retornoDetalhes')->name('retornoDetalhes');
    Route::post('/atribuirAvaliadorTrabalho', 'TrabalhoController@atribuirAvaliadorTrabalho')->name('atribuirAvaliadorTrabalho');
    Route::post('/atribuir', 'TrabalhoController@atribuir')->name('atribuir');
    Route::post('/atribuir', 'TrabalhoController@atribuir')->name('atribuir');
    Route::post('/resposta-solicitacao-desligamento/{desligamento_id}', 'CoordenadorComissaoController@respostaDesligamento')->name('resposta.desligamento');
});
