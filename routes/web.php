<?php

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


Route::get('/', 'UserController@index'                                            )->name('home-user');
Route::get('/home', 'HomeController@index'                                        )->name('home')->middleware('verified');

Route::get('/evento/visualizar/naologado/{id}','EventoController@showNaoLogado'   )->name('evento.visualizarNaoLogado');

Auth::routes(['verify' => true]);

//######## Rotas Avaliador  ####################################
Route::prefix('avaliador')->name('avaliador.')->group(function(){
  Route::get('/index',        'AvaliadorController@index'                       )->name('index');
  Route::get('/trabalhos',    'AvaliadorController@visualizarTrabalhos'         )->name('visualizarTrabalho');
  Route::post('/parecer',     'AvaliadorController@parecer'                     )->name('parecer');
  Route::get('/editais',     'AvaliadorController@editais'                     )->name('editais');
  Route::post('/Enviarparecer',     'AvaliadorController@enviarParecer'         )->name('enviarParecer');
});

//######### Proponente  ########################################
Route::get('/proponente/index', 'ProponenteController@index'                      )->name('proponente.index');

//######### Participante ########################################
Route::get('/participante/index', 'ParticipanteController@index'                  )->name('participante.index');

//######### Rotas Administrador #################################
Route::get('/perfil-usuario', 'UserController@minhaConta')->middleware('auth'     )->name('user.perfil');
Route::get('/perfil','UserController@perfil'                                      )->name('perfil')->middleware(['auth', 'verified']);
Route::post('/perfil','UserController@editarPerfil'                               )->name('perfil')->middleware(['auth', 'verified']);


Route::group(['middleware' => ['isTemp', 'auth', 'verified']], function(){

  Route::get('/home/evento',                        'EventoController@index'              )->name('visualizarEvento');

  // ######## rotas de teste #####################################
  Route::get('/coordenador/home',                   'EventoController@index'              )->name('coord.home');
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

  //########## Area da comissao  ###################################
  Route::get(   '/comissoes',             'EventoController@listComissao'                 )->name('comissoes');
  Route::get(   '/area/comissao',         'EventoController@listComissaoTrabalhos'        )->name('area.comissao');

  //###########  Deletar Comissão ###################################
  Route::delete('/evento/apagar-comissao/','ComissaoController@destroy'                   )->name('delete.comissao'); 
  Route::post(  '/evento/numTrabalhos',   'EventoController@numTrabalhos'                 )->name('trabalho.numTrabalhos');

  //########## Modalidade  #######################################
  Route::post(  '/modalidade/criar',      'ModalidadeController@store'                    )->name('modalidade.store');

  //##########  Area  ###########################################
  Route::post(  '/area/criar',            'AreaController@store'                          )->name('area.store');

  //########### Deletar Area ######################################
  Route::delete('/area/deletar/{id}',     'AreaController@destroy'                        )->name('area.delete');
  
  //#########  Deletar Revisores  ##############################
  Route::delete(  '/revisor/apagar',      'RevisorController@destroy'                     )->name('revisor.delete');

  //######### AreaModalidade  ###################################
  Route::post(  '/areaModalidade/criar',  'AreaModalidadeController@store'                )->name('areaModalidade.store');

  //#########  Trabalho  ########################################
  Route::get(   '/trabalho/submeter/{id}','TrabalhoController@index'                      )->name('trabalho.index');
  Route::post(  '/trabalho/novaVersao',   'TrabalhoController@novaVersao'                 )->name('trabalho.novaVersao');
  Route::post(  '/trabalho/criar',        'TrabalhoController@store'                      )->name('trabalho.store');
  Route::get(   '/edital/{id}/projetos',  'TrabalhoController@projetosDoEdital'           )->name('projetos.edital');
  Route::get(   '/projeto/{id}/editar',   'TrabalhoController@edit'                       )->name('trabalho.editar');
  Route::post(   '/projeto/{id}/atualizar',   'TrabalhoController@update'                 )->name('trabalho.update');

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
  Route::get('/baixar/edital/{id}',           'EventoController@baixarEdital'             )->name('baixar.edital');
  Route::get('/baixar/anexo-projeto/{id}', 'TrabalhoController@baixarAnexoProjeto'        )->name('baixar.anexo.projeto');
  Route::get('/baixar/anexo-consu/{id}',   'TrabalhoController@baixarAnexoConsu'          )->name('baixar.anexo.consu');
  Route::get('/baixar/anexo-comite/{id}',  'TrabalhoController@baixarAnexoComite'         )->name('baixar.anexo.comite');
  Route::get('/baixar/anexo-lattes/{id}',  'TrabalhoController@baixarAnexoLattes'         )->name('baixar.anexo.lattes');
  Route::get('/baixar/anexo-planilha/{id}','TrabalhoController@baixarAnexoPlanilha'       )->name('baixar.anexo.planilha');
  Route::get('/baixar/plano-de-trabalho/{id}', 'ArquivoController@baixarPlano'            )->name('baixar.plano');
});

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
  Route::post('/atribuirAvaliadorProjeto',   'AdministradorController@atribuicao'       )->name('atribuicao');
  Route::post('/enviarConviteAvaliador',     'AdministradorController@enviarConvite'    )->name('enviarConvite');
  Route::post('/visualizarParecer',          'AdministradorController@visualizarParecer')->name('visualizarParecer');
  Route::get('/pareceresProjetos',           'AdministradorController@pareceres'        )->name('pareceres');
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
      
  //### Rotas das subareas, id's de nova e salvar são os ids da área a qual a nova subárea pertence #####
  Route::get('/subareas',                 'SubAreaController@index'                   )->name('subarea.index')->middleware('checkAdministrador');
  Route::get('/{id}/subarea/nova',        'SubAreaController@create'                  )->name('subarea.criar')->middleware('checkAdministrador');
  Route::post('/{id}/subarea/salvar',     'SubAreaController@store'                   )->name('subarea.salvar')->middleware('checkAdministrador');
  Route::get('/subarea/detalhes/{id}',    'SubAreaController@show'                    )->name('subarea.show')->middleware('checkAdministrador');
  Route::get('/subarea/editar/{id}',      'SubAreaController@edit'                    )->name('subarea.editar')->middleware('checkAdministrador');
  Route::post('/subarea/atualizar/{id}',  'SubAreaController@update'                  )->name('subarea.atualizar')->middleware('checkAdministrador');
  Route::post('/subarea/excluir/{id}',    'SubAreaController@destroy'                 )->name('subarea.deletar')->middleware('checkAdministrador');

});
 
//############ Evento ##############################################
Route::prefix('evento')->name('evento.')->group(function(){
  Route::get(    '/criar',          'EventoController@create'                           )->name('criar');
  Route::post(   '/criar',          'EventoController@store'                            )->name('criar');
  Route::get(    '/visualizar/{id}','EventoController@show'                             )->name('visualizar');
  Route::get(    '/listar',         'EventoController@listar'                           )->name('listar');
  Route::delete( '/excluir/{id}',   'EventoController@destroy'                          )->name('deletar');
  Route::get(    '/editar/{id}',    'EventoController@edit'                             )->name('editar');
  Route::post(   '/editar/{id}',    'EventoController@update'                           )->name('update');
  Route::post(   '/setResumo',      'EventoController@setResumo'                        )->name('setResumo');
  Route::post(   '/setFoto',        'EventoController@setFotoEvento'                    )->name('setFotoEvento');
  
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
  Route::get('/index',                    'CoordenadorComissaoController@index'                 )->name('index');
  Route::get('/editais',                  'CoordenadorComissaoController@editais'               )->name('editais');
  Route::get('/usuarios',                 'CoordenadorComissaoController@usuarios'              )->name('usuarios');
  Route::get('/listarCoord',              'CoordenadorComissaoController@coordenadorComite'     )->name('coord');
  Route::get('/listarAvaliador',          'CoordenadorComissaoController@avaliador'             )->name('avaliador');
  Route::get('/listarProponente',         'CoordenadorComissaoController@proponente'            )->name('proponente');
  Route::get('/listarParticipante',       'CoordenadorComissaoController@participante'          )->name('participante');
  Route::get('/listarTrabalhos',          'CoordenadorComissaoController@listarTrabalhos'       )->name('listarTrabalhos');
  Route::get('/detalhesEdital',           'CoordenadorComissaoController@detalhesEdital'        )->name('detalhesEdital');
  Route::post('/retornoDetalhes',         'CoordenadorComissaoController@retornoDetalhes'       )->name('retornoDetalhes');
  Route::post('/atribuirAvaliadorTrabalho','TrabalhoController@atribuirAvaliadorTrabalho'       )->name('atribuirAvaliadorTrabalho');
  Route::post('/atribuir',        'TrabalhoController@atribuir'                                 )->name('atribuir');
});

