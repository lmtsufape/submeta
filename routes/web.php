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
use App\Evento;
Route::get('/', function () {
    if(Auth::check()){
      return redirect()->route('home');
    }

    $eventos = Evento::all();
    return view('index',['eventos'=>$eventos]);
});

Route::get('/#', function () {
    if(Auth::check()){
      return redirect()->route('home');
    }

    $eventos = Evento::all();
    return view('index',['eventos'=>$eventos]);
})->name('cancelarCadastro');

  Route::get('/evento/visualizar/naologado/{id}','EventoController@showNaoLogado')->name('evento.visualizarNaoLogado');

Auth::routes(['verify' => true]);

Route::get('/perfil','UserController@perfil')->name('perfil')->middleware(['auth', 'verified']);
Route::post('/perfil','UserController@editarPerfil')->name('perfil')->middleware(['auth', 'verified']);


Route::group(['middleware' => ['isTemp', 'auth', 'verified']], function(){

  Route::get('/home', 'EventoController@index')->name('home');

  // rotas de teste
  Route::get('/coordenador/home','EventoController@index')->name('coord.home');

  Route::get('/coordenador/evento/detalhes', 'EventoController@detalhes')->name('coord.detalhesEvento');

  // Visualizar trabalhos do usuário
  Route::get('/user/trabalhos', 'UserController@meusTrabalhos')->name('user.meusTrabalhos');

  // Cadastrar Comissão
  Route::post('/evento/cadastrarComissao','ComissaoController@store'                   )->name('cadastrar.comissao');
  Route::post('/evento/cadastrarCoordComissao','ComissaoController@coordenadorComissao')->name('cadastrar.coordComissao');
  // Deletar Comissão
  Route::delete('/evento/apagar-comissao/','ComissaoController@destroy')->name('delete.comissao');
  //Evento
  Route::get(   '/evento/criar',          'EventoController@create'                    )->name('evento.criar');
  Route::post(  '/evento/criar',          'EventoController@store'                     )->name('evento.criar');
  Route::get(   '/evento/visualizar/{id}','EventoController@show'                      )->name('evento.visualizar');
  Route::delete('/evento/excluir/{id}',   'EventoController@destroy'                   )->name('evento.deletar');
  Route::get(   '/evento/editar/{id}',    'EventoController@edit'                      )->name('evento.editar');
  Route::post(   '/evento/editar/{id}',    'EventoController@update'                      )->name('evento.update');
  Route::post(  '/evento/setResumo',      'EventoController@setResumo'                 )->name('evento.setResumo');
  Route::post(  '/evento/setFoto',        'EventoController@setFotoEvento'             )->name('evento.setFotoEvento');
  Route::post(  '/evento/numTrabalhos',    'EventoController@numTrabalhos'             )->name('trabalho.numTrabalhos');
  //Modalidade
  Route::post(  '/modalidade/criar',      'ModalidadeController@store'                 )->name('modalidade.store');
  //Area
  Route::post(  '/area/criar',            'AreaController@store'                       )->name('area.store');
  //Deletar Area
  Route::delete('/area/deletar/{id}',          'AreaController@destroy'                     )->name('area.delete');
  //Revisores
  Route::post(  '/revisor/criar',         'RevisorController@store'                    )->name('revisor.store');
  Route::get(   '/revisor/listarTrabalhos','RevisorController@indexListarTrabalhos'    )->name('revisor.listarTrabalhos');
  Route::post(  '/revisor/email',         'RevisorController@enviarEmailRevisor'       )->name('revisor.email');
  Route::post(  '/revisor/emailTodos',    'RevisorController@enviarEmailTodosRevisores')->name('revisor.emailTodos');
  //Deletar Revisores
  Route::delete(  '/revisor/apagar',      'RevisorController@destroy'                  )->name('revisor.delete');
  //AreaModalidade
  Route::post(  '/areaModalidade/criar',  'AreaModalidadeController@store'             )->name('areaModalidade.store');
  //Trabalho
  Route::get(   '/trabalho/submeter/{id}','TrabalhoController@index'                   )->name('trabalho.index');
  Route::post(  '/trabalho/novaVersao',   'TrabalhoController@novaVersao'              )->name('trabalho.novaVersao');
  Route::post(  '/trabalho/criar',        'TrabalhoController@store'                   )->name('trabalho.store');
  //Atribuição
  Route::get(   '/atribuir',              'AtribuicaoController@distribuicaoAutomatica')->name('distribuicao');
  Route::get(   '/atribuirPorArea',       'AtribuicaoController@distribuicaoPorArea'   )->name('distribuicaoAutomaticaPorArea');
  Route::post(  '/distribuicaoManual',    'AtribuicaoController@distribuicaoManual'    )->name('distribuicaoManual');
  Route::post(  '/removerAtribuicao',     'AtribuicaoController@deletePorRevisores'    )->name('atribuicao.delete');
  // rota downloadArquivo
  Route::get(   '/downloadArquivo',       'HomeController@downloadArquivo'             )->name('download');
  // Area do participante
  Route::get(   '/participante',          'EventoController@areaParticipante'          )->name('area.participante');
  // Area da comissao
  Route::get(   '/comissoes',             'EventoController@listComissao'              )->name('comissoes');
  Route::get(   '/area/comissao',         'EventoController@listComissaoTrabalhos'     )->name('area.comissao');

});
