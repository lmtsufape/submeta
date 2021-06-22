<?php

use App\Http\Middleware\checkCoordenador;
use App\Trabalho;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SubmissaoNotification;
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

Route::get('/', 'UserController@index'                                            )->name('home-user');
Route::get('/', 'UserController@inicial'                                          )->name('inicial');
Route::get('/home', 'HomeController@index'                                        )->name('home')->middleware('verified');

Route::get('/evento/visualizar/naologado/{id}','EventoController@showNaoLogado'   )->name('evento.visualizarNaoLogado');
Route::get('/editais/home'                    ,'EventoController@index'           )->name('coord.home');
Route::get('/perfil','UserController@perfil')->name('perfil');
Auth::routes(['verify' => true]);



//######### Proponente  ########################################
Route::get( '/proponente/index',      'ProponenteController@index'                  )->name('proponente.index');
Route::get( '/proponente/cadastro',   'ProponenteController@create'                 )->name('proponente.create');
Route::post('/proponente/cadastro',   'ProponenteController@store'                  )->name('proponente.store');
Route::get( '/proponente/editais',    'ProponenteController@editais'                )->name('proponente.editais');
Route::get( '/projetos-submetidos',   'ProponenteController@projetosDoProponente'   )->name('proponente.projetos');
Route::get( '/projetos-edital/{id}',       'ProponenteController@projetosEdital'         )->name('proponente.projetosEdital')->middleware('auth');


//######### Rotas Administrador #################################
Route::get('/perfil-usuario',                  'UserController@minhaConta'        )->name('user.perfil')->middleware(['auth', 'verified']);
Route::post('/perfil-usuario',                 'UserController@editarPerfil'      )->name('perfil.edit')->middleware(['auth', 'verified']);


Route::group(['middleware' => ['isTemp', 'auth', 'verified']], function(){

  //######## Rotas Avaliador  ####################################
  Route::prefix('avaliador')->name('avaliador.')->group(function(){
    Route::get('/index',          'AvaliadorController@index'                )->name('index')->middleware('auth');
    Route::get('/trabalhos',     'AvaliadorController@visualizarTrabalhos'   )->name('visualizarTrabalho')->middleware('auth');
    Route::get('/planos',     'AvaliadorController@listarPlanos'         )->name('listarPlanos')->middleware('auth');
    Route::post('/parecer',       'AvaliadorController@parecer'              )->name('parecer')->middleware('auth');
    Route::post('/parecer/plano',       'AvaliadorController@parecerPlano'   )->name('parecer.plano')->middleware('auth');
    Route::get('/editais',        'AvaliadorController@editais'              )->name('editais')->middleware('auth');
    Route::post('/Enviarparecer', 'AvaliadorController@enviarParecer'        )->name('enviarParecer')->middleware('auth');
    Route::post('/Enviarparecer/plano', 'AvaliadorController@enviarParecerPlano'   )->name('enviarParecerPlano')->middleware('auth');
    Route::get('/Resposta', 'AvaliadorController@conviteResposta'            )->name('conviteResposta')->middleware('auth');
  });


  Route::get('/home/edital',                        'EventoController@index'              )->name('visualizarEvento');

  // ######## rotas de teste #####################################

  Route::get('/coordenador/evento/detalhes',         'EventoController@detalhes'          )->name('coord.detalhesEvento');

  //####### Visualizar trabalhos do usuário ######################
  Route::get('/user/trabalhos',                     'UserController@meusTrabalhos'        )->name('user.meusTrabalhos');

  //######### Cadastrar Comissão ###################################
  Route::post('/evento/cadastrarComissao','ComissaoController@store'                      )->name('cadastrar.comissao');
  Route::post('/evento/cadastrarCoordComissao','ComissaoController@coordenadorComissao'   )->name('cadastrar.coordComissao');

  //######### rota downloadArquivo ################################
  Route::get(   '/downloadArquivo',       'HomeController@downloadArquivo'                )->name('download');

  //#########  Area do participante ###############################
  Route::get(   '/participante',          'EventoController@areaParticipante'             )->name('area.participante');
  Route::get(   'participante/editais',   'ParticipanteController@editais'                )->name('participante.editais');
  //######### Participante ########################################
  Route::get('/participante/index',         'ParticipanteController@index'          )->name('participante.index');
  Route::get('/participante/edital/{id}',    'ParticipanteController@edital'        )->name('participante.edital');

  //######### Plano de Trablho ########################################
  Route::prefix('/plano/trabalho')->name('plano.trabalho.')->group(function(){
    Route::get('/index/{evento_id}',     'PlanoTrabalhoController@index'        )->name('index');
    Route::get('/selecionar/{evento_id}', 'PlanoTrabalhoController@selecionarPlanos' )->name('selecionarPlanos');
    Route::post('/atribuicao',            'PlanoTrabalhoController@atribuicao' )->name('atribuicao');
    
  });

  //########## Area da comissao  ###################################
  Route::get(   '/comissoes',             'EventoController@listComissao'                 )->name('comissoes');
  Route::get(   '/area/comissao',         'EventoController@listComissaoTrabalhos'        )->name('area.comissao');

  //###########  Deletar Comissão ###################################
  Route::delete('/evento/apagar-comissao/','ComissaoController@destroy'                   )->name('delete.comissao');
  Route::post(  '/evento/numTrabalhos',   'EventoController@numTrabalhos'                 )->name('trabalho.numTrabalhos');

  //##########  Area  ###########################################
  Route::post(  '/area/criar',            'AreaController@store'                          )->name('area.store');

  //########### Deletar Area ######################################
  Route::delete('/area/deletar/{id}',     'AreaController@destroy'                        )->name('area.delete');

  //#########  Deletar Revisores  ##############################
  Route::delete(  '/revisor/apagar',      'RevisorController@destroy'                     )->name('revisor.delete');

  //######### AreaModalidade  ###################################
  Route::post(  '/areaModalidade/criar',  'AreaModalidadeController@store'                )->name('areaModalidade.store');

  //#########  Trabalho  ########################################
  Route::get(   '/trabalho/submeter/{id}',  'TrabalhoController@index'                      )->name('trabalho.index');
  Route::get(   '/trabalho/visualizar/{id}','TrabalhoController@show'                       )->name('trabalho.show');
  Route::post(  '/trabalho/novaVersao',     'TrabalhoController@novaVersao'                 )->name('trabalho.novaVersao');
  Route::post(  '/trabalho/criar',          'TrabalhoController@salvar'                      )->name('trabalho.store');
  Route::post(  '/trabalho/criarRascunho',  'TrabalhoController@storeParcial'               )->name('trabalho.storeParcial');
  Route::get(   '/edital/{id}/projetos',    'TrabalhoController@projetosDoEdital'           )->name('projetos.edital');
  Route::get(   '/projeto/visualizar/{id}', 'TrabalhoController@show'                       )->name('trabalho.show');
  Route::get(   '/projeto/{id}/editar',     'TrabalhoController@edit'                       )->name('trabalho.editar');
  Route::post(   '/projeto/{id}/atualizar', 'TrabalhoController@atualizar'                  )->name('trabalho.update');
  Route::get(   '/projeto/{id}/excluir',    'TrabalhoController@destroy'                    )->name('trabalho.destroy');
  Route::get(   '/projeto/{id}/excluirParticipante','TrabalhoController@excluirParticipante')->name('trabalho.excluirParticipante');
  Route::get(   '/projeto/exportar/{id}','TrabalhoController@exportProjeto'                 )->name('exportar.projeto');


  //#########  Atribuição  #######################################
  Route::get(   '/atribuir',              'AtribuicaoController@distribuicaoAutomatica'   )->name('distribuicao');
  Route::get(   '/atribuirPorArea',       'AtribuicaoController@distribuicaoPorArea'      )->name('distribuicaoAutomaticaPorArea');
  Route::post(  '/distribuicaoManual',    'AtribuicaoController@distribuicaoManual'       )->name('distribuicaoManual');
  Route::post(  '/removerAtribuicao',     'AtribuicaoController@deletePorRevisores'       )->name('atribuicao.delete');

  //##########  Revisores #########################################
  Route::post(  '/revisor/criar',         'RevisorController@store'                       )->name('revisor.store');
  Route::get(   '/revisor/listarTrabalhos','RevisorController@indexListarTrabalhos'       )->name('revisor.listarTrabalhos');
  Route::post(  '/revisor/email',         'RevisorController@enviarEmailRevisor'          )->name('revisor.email');
  Route::post(  '/revisor/emailTodos',    'RevisorController@enviarEmailTodosRevisores'   )->name('revisor.emailTodos');

  //########## Rotas de download  de documentos ###########################
  Route::get('/baixar/anexo-projeto/{id}', 'TrabalhoController@baixarAnexoProjeto'        )->name('baixar.anexo.projeto');
  Route::get('/baixar/anexo-consu/{id}',   'TrabalhoController@baixarAnexoConsu'          )->name('baixar.anexo.consu');
  Route::get('/baixar/anexo-comite/{id}',  'TrabalhoController@baixarAnexoComite'         )->name('baixar.anexo.comite');
  Route::get('/baixar/anexo-justificativa/{id}',  'TrabalhoController@baixarAnexoJustificativa')->name('baixar.anexo.justificativa');
  Route::get('/baixar/anexo-lattes/{id}',  'TrabalhoController@baixarAnexoLattes'         )->name('baixar.anexo.lattes');
  Route::get('/baixar/anexo-planilha/{id}','TrabalhoController@baixarAnexoPlanilha'       )->name('baixar.anexo.planilha');
  Route::get('/baixar/plano-de-trabalho/{id}', 'ArquivoController@baixarPlano'            )->name('baixar.plano');
  Route::get('/baixar/anexoGrupoPesquisa/{id}', 'ArquivoController@baixarAnexoGrupoPesquisa' )->name('baixar.anexoGrupoPesquisa');
  Route::get('/baixar/anexo-temp/{eventoId}/{nomeAnexo}', 'TrabalhoController@baixarAnexoTemp')->name('baixar.anexo.temp');
  Route::get('/baixar/evento-temp/{nomeAnexo}', 'TrabalhoController@baixarEventoTemp'            )->name('baixar.evento.temp');
});

Route::get('/baixar/edital/{id}',           'EventoController@baixarEdital'             )->name('baixar.edital');
Route::get('/baixar/modelos/{id}',          'EventoController@baixarModelos'            )->name('baixar.modelos');

Route::prefix('usuarios')->name('admin.')->group(function(){
  //######### Rotas da administração dos usuários ####################
  Route::get('/home-admin',                  'AdministradorController@index'      )->name('index')->middleware('checkAdministrador');
  Route::get('/usuarios',                    'AdministradorController@usuarios'   )->name('usuarios')->middleware('checkAdministrador');
  Route::get('/novo',                        'AdministradorController@create'     )->name('user.create')->middleware('checkAdministrador');
  Route::post('/salvar-novo',                'AdministradorController@salvar'     )->name('user.store')->middleware('checkAdministrador');
  Route::get('/editar/{id}',                 'AdministradorController@edit'       )->name('user.edit')->middleware('checkAdministrador');
  Route::post('/editar/atualizar/{id}',      'AdministradorController@update'     )->name('user.update')->middleware('checkAdministrador');
  Route::post('/editar/deletar/{id}',        'AdministradorController@destroy'    )->name('user.destroy')->middleware('checkAdministrador');
  Route::get('/editais',                     'AdministradorController@editais'          )->name('editais');
  Route::get('/atribuir',                    'AdministradorController@atribuir'         )->name('atribuir');
  Route::get('/selecionarAvaliador',         'AdministradorController@selecionar'       )->name('selecionar');
  Route::get('/selecionarProjetos',          'AdministradorController@projetos'         )->name('projetos');
  Route::post('/adicionarAvalEvento',        'AdministradorController@adicionar'        )->name('adicionar');
  Route::post('/removerAvalEvento',          'AdministradorController@remover'          )->name('remover');
  Route::post('/atribuirAvaliadorProjeto',   'AdministradorController@atribuicaoProjeto')->name('atribuicao.projeto');
  Route::post('/enviarConviteAvaliador',     'AdministradorController@enviarConvite'    )->name('enviarConvite');
  Route::post('/visualizarParecer',          'AdministradorController@visualizarParecer')->name('visualizarParecer');
  Route::get('/pareceresProjetos',           'AdministradorController@pareceres'        )->name('pareceres');
  Route::get('/analisarProjetos',            'AdministradorController@analisar'         )->name('analisar');
});

Route::prefix('naturezas')->group(function(){
  //########### Rotas das naturezas     ###############################

  Route::get('/',                             'AdministradorController@naturezas'  )->name('admin.naturezas')->middleware('checkAdministrador');
  Route::get('/index',                        'NaturezaController@index'           )->name('natureza.index')->middleware('checkAdministrador');
  Route::get('/nova',                         'NaturezaController@create'          )->name('natureza.criar')->middleware('checkAdministrador');
  Route::post('/salvar',                      'NaturezaController@store'           )->name('natureza.salvar')->middleware('checkAdministrador');
  Route::get('/detalhes/{id}',                'NaturezaController@show'            )->name('natureza.show')->middleware('checkAdministrador');
  Route::get('/editar/{id}',                  'NaturezaController@edit'            )->name('natureza.editar')->middleware('checkAdministrador');
  Route::get('/atualizar/{id}',              'NaturezaController@update'          )->name('natureza.atualizar')->middleware('checkAdministrador');
  Route::get('/excluir/{id}',                'NaturezaController@destroy'         )->name('natureza.deletar')->middleware('checkAdministrador');

  //########### Rotas das grandes areas ##############################
  Route::get('/grande-area',                'GrandeAreaController@index'           )->name('grandearea.index')->middleware('checkAdministrador');
  Route::get('/grande-area/nova',           'GrandeAreaController@create'          )->name('grandearea.criar')->middleware('checkAdministrador');
  Route::post('/grande-area/salvar',        'GrandeAreaController@store'           )->name('grandearea.salvar')->middleware('checkAdministrador');
  Route::get('/grande-area/detalhes/{id}',  'GrandeAreaController@show'            )->name('grandearea.show')->middleware('checkAdministrador');
  Route::get('/grande-area/editar/{id}',    'GrandeAreaController@edit'            )->name('grandearea.editar')->middleware('checkAdministrador');
  Route::post('/grande-area/atualizar/{id}','GrandeAreaController@update'          )->name('grandearea.atualizar')->middleware('checkAdministrador');
  Route::post('/grande-area/excluir/{id}',  'GrandeAreaController@destroy'         )->name('grandearea.deletar')->middleware('checkAdministrador');

  //#### Rotas das areas, id's de nova e salvar são os ids da grande área a qual a nova área pertence ####
  Route::get('/areas',                  'AreaController@index'                      )->name('area.index')->middleware('checkAdministrador');
  Route::get('/{id}/area/nova',         'AreaController@create'                     )->name('area.criar')->middleware('checkAdministrador');
  Route::post('/{id}/area/salvar',      'AreaController@store'                      )->name('area.salvar')->middleware('checkAdministrador');
  Route::get('/area/detalhes/{id}',     'AreaController@show'                       )->name('area.show')->middleware('checkAdministrador');
  Route::get('/area/editar/{id}',       'AreaController@edit'                       )->name('area.editar')->middleware('checkAdministrador');
  Route::post('/area/atualizar/{id}',   'AreaController@update'                     )->name('area.atualizar')->middleware('checkAdministrador');
  Route::post('/area/excluir/{id}',     'AreaController@destroy'                    )->name('area.deletar')->middleware('checkAdministrador');
  Route::post('/areas/',                 'AreaController@consulta'                   )->name('area.consulta');

  //### Rotas das subareas, id's de nova e salvar são os ids da área a qual a nova subárea pertence #####
  Route::get('/subareas',                 'SubAreaController@index'                   )->name('subarea.index')->middleware('checkAdministrador');
  Route::get('/{id}/subarea/nova',        'SubAreaController@create'                  )->name('subarea.criar')->middleware('checkAdministrador');
  Route::post('/{id}/subarea/salvar',     'SubAreaController@store'                   )->name('subarea.salvar')->middleware('checkAdministrador');
  Route::get('/subarea/detalhes/{id}',    'SubAreaController@show'                    )->name('subarea.show')->middleware('checkAdministrador');
  Route::get('/subarea/editar/{id}',      'SubAreaController@edit'                    )->name('subarea.editar')->middleware('checkAdministrador');
  Route::post('/subarea/atualizar/{id}',  'SubAreaController@update'                  )->name('subarea.atualizar')->middleware('checkAdministrador');
  Route::post('/subarea/excluir/{id}',    'SubAreaController@destroy'                 )->name('subarea.deletar')->middleware('checkAdministrador');
  Route::post('/subarea/',                 'SubAreaController@consulta'                )->name('subarea.consulta');

  Route::post('/funcao-participante/store', 'ParticipanteController@storeFuncao'      )->name('funcao_participante.store');
  Route::post('/funcao-participante/{id}/update', 'ParticipanteController@updateFuncao')->name('funcao_participante.update');
  Route::get('/funcao-participante/{id}/destroy', 'ParticipanteController@destroyFuncao')->name('funcao_participante.destroy');
});

//############ Evento ##############################################
Route::prefix('evento')->name('evento.')->group(function(){
  Route::get(    '/criar',          'EventoController@create'                           )->name('criar')->middleware('checkAdministrador');
  Route::post(   '/criar',          'EventoController@store'                            )->name('criar')->middleware('checkAdministrador');
  Route::get(    '/visualizar/{id}','EventoController@show'                             )->name('visualizar')->middleware('auth');
  Route::get(    '/listar',         'EventoController@listar'                           )->name('listar')->middleware('auth');

  Route::delete( '/excluir/{id}',   'EventoController@destroy'                          )->name('deletar')->middleware('checkAdministrador');
  Route::delete( '/excluir/{id}',   'EventoController@destroy'                          )->name('deletar')->middleware(checkCoordenador::class);

  Route::get(    '/editar/{id}',    'EventoController@edit'                             )->name('editar')->middleware('checkAdministrador');
  Route::get(    '/editar/{id}',    'EventoController@edit'                             )->name('editar')->middleware(checkCoordenador::class);

  Route::post(   '/editar/{id}',    'EventoController@update'                           )->name('update')->middleware('checkAdministrador');
  Route::post(   '/editar/{id}',    'EventoController@update'                           )->name('update')->middleware(checkCoordenador::class);

  Route::post(   '/setResumo',      'EventoController@setResumo'                        )->name('setResumo')->middleware('checkAdministrador');
  Route::post(   '/setFoto',        'EventoController@setFotoEvento'                    )->name('setFotoEvento')->middleware('checkAdministrador');

});

//########## Rotas de administrador responsavel (Reitor ou pro-reitor)########
Route::prefix('adminResp')->name('adminResp.')->group(function(){

  Route::get('/index',                'AdministradorResponsavelController@index'              )->name('index');
  Route::get('/editais',              'AdministradorResponsavelController@editais'            )->name('editais');
  Route::get('/usuarios',             'AdministradorResponsavelController@usuarios'           )->name('usuarios');
  Route::get('/atribuir',             'AdministradorResponsavelController@atribuirPermissao'  )->name('atribuir');
  Route::post('/atribuir',            'AdministradorResponsavelController@atribuirPermissao'  )->name('atribuir');
  Route::post('/verPermissao',        'AdministradorResponsavelController@verPermissao'       )->name('verPermissao');

});

//########### Rotas Coordenador ##################################
Route::prefix('coordenador')->name('coordenador.')->group(function(){
  Route::get('/index',                        'CoordenadorComissaoController@index'                 )->name('index');
  Route::get('/editais',                      'CoordenadorComissaoController@editais'               )->name('editais');
  Route::get('/usuarios',                     'CoordenadorComissaoController@usuarios'              )->name('usuarios');
  Route::get('/listarCoord',                  'CoordenadorComissaoController@coordenadorComite'     )->name('coord');
  Route::get('/listarAvaliador',              'CoordenadorComissaoController@avaliador'             )->name('avaliador');
  Route::get('/listarProponente',             'CoordenadorComissaoController@proponente'            )->name('proponente');
  Route::get('/listarParticipante',           'CoordenadorComissaoController@participante'          )->name('participante');
  Route::get('/listarTrabalhos',              'CoordenadorComissaoController@listarTrabalhos'       )->name('listarTrabalhos');
  Route::get('/detalhesEdital/{evento_id}',   'CoordenadorComissaoController@detalhesEdital'        )->name('detalhesEdital');
  Route::post('/retornoDetalhes',             'CoordenadorComissaoController@retornoDetalhes'       )->name('retornoDetalhes');
  Route::post('/atribuirAvaliadorTrabalho',   'TrabalhoController@atribuirAvaliadorTrabalho'        )->name('atribuirAvaliadorTrabalho');
  Route::post('/atribuir',                    'TrabalhoController@atribuir'                         )->name('atribuir');
});
