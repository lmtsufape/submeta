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
Route::get('/avaliador/index', 'AvaliadorController@index'                        )->name('avaliador.index');
Route::get('/avaliador/trabalhos', 'AvaliadorController@visualizarTrabalhos'      )->name('visualizarTrabalho');

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

  
});

Route::prefix('usuarios')->name('admin.')->group(function(){
  //######### Rotas da administração dos usuários ####################
  Route::get('/home-admin',                  'AdministradorController@index'      )->name('index');
  Route::get('/usuarios',                    'AdministradorController@usuarios'   )->name('usuarios');
  Route::get('/novo',                        'AdministradorController@create'     )->name('user.create');
  Route::post('/salvar-novo',                'AdministradorController@salvar'     )->name('user.store');
  Route::get('/editar/{id}',                 'AdministradorController@edit'       )->name('user.edit');
  Route::post('/editar/atualizar/{id}',      'AdministradorController@update'     )->name('user.update');
  Route::post('/editar/deletar/{id}',        'AdministradorController@destroy'    )->name('user.destroy');
  Route::get('/editais',                     'AdministradorController@editais'    )->name('editais');

});

Route::prefix('naturezas')->group(function(){
  //########### Rotas das naturezas     ###############################

  Route::get('/',                             'AdministradorController@naturezas'  )->name('admin.naturezas');
  Route::get('/index',                        'NaturezaController@index'           )->name('natureza.index');
  Route::get('/nova',                         'NaturezaController@create'          )->name('natureza.criar');
  Route::post('/salvar',                      'NaturezaController@store'           )->name('natureza.salvar');
  Route::get('/detalhes/{id}',                'NaturezaController@show'            )->name('natureza.show');
  Route::get('/editar/{id}',                  'NaturezaController@edit'            )->name('natureza.editar');
  Route::get('/atualizar/{id}',              'NaturezaController@update'          )->name('natureza.atualizar');
  Route::get('/excluir/{id}',                'NaturezaController@destroy'         )->name('natureza.deletar');

  //########### Rotas das grandes areas ##############################
  Route::get('/grande-area',                'GrandeAreaController@index'           )->name('grandearea.index');
  Route::get('/grande-area/nova',           'GrandeAreaController@create'          )->name('grandearea.criar');
  Route::post('/grande-area/salvar',        'GrandeAreaController@store'           )->name('grandearea.salvar');
  Route::get('/grande-area/detalhes/{id}',  'GrandeAreaController@show'            )->name('grandearea.show');
  Route::get('/grande-area/editar/{id}',    'GrandeAreaController@edit'            )->name('grandearea.editar');
  Route::post('/grande-area/atualizar/{id}','GrandeAreaController@update'          )->name('grandearea.atualizar');
  Route::post('/grande-area/excluir/{id}',  'GrandeAreaController@destroy'         )->name('grandearea.deletar');
  
  //#### Rotas das areas, id's de nova e salvar são os ids da grande área a qual a nova área pertence ####
  Route::get('/areas',                  'AreaController@index'                      )->name('area.index');
  Route::get('/{id}/area/nova',         'AreaController@create'                     )->name('area.criar');
  Route::post('/{id}/area/salvar',      'AreaController@store'                      )->name('area.salvar');
  Route::get('/area/detalhes/{id}',     'AreaController@show'                       )->name('area.show');
  Route::get('/area/editar/{id}',       'AreaController@edit'                       )->name('area.editar');
  Route::post('/area/atualizar/{id}',   'AreaController@update'                     )->name('area.atualizar');
  Route::post('/area/excluir/{id}',     'AreaController@destroy'                    )->name('area.deletar');
      
  //### Rotas das subareas, id's de nova e salvar são os ids da área a qual a nova subárea pertence #####
  Route::get('/subareas',                 'SubAreaController@index'                   )->name('subarea.index');
  Route::get('/{id}/subarea/nova',        'SubAreaController@create'                  )->name('subarea.criar');
  Route::post('/{id}/subarea/salvar',     'SubAreaController@store'                   )->name('subarea.salvar');
  Route::get('/subarea/detalhes/{id}',    'SubAreaController@show'                    )->name('subarea.show');
  Route::get('/subarea/editar/{id}',      'SubAreaController@edit'                    )->name('subarea.editar');
  Route::post('/subarea/atualizar/{id}',  'SubAreaController@update'                  )->name('subarea.atualizar');
  Route::post('/subarea/excluir/{id}',    'SubAreaController@destroy'                 )->name('subarea.deletar');

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

