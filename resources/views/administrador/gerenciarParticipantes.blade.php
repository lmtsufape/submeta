@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Gerenciar participantes</h3>
    <p><strong>Edital:</strong> {{ $trabalho->evento->nome }}<br><strong>Proposta:</strong> {{ $trabalho->titulo }}</p>
    @if(session('sucesso'))
        <div class="alert alert-success" role="alert">{{ session('sucesso') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
    @endif
    <p>A remoção afeta somente a participação nesta proposta. O cadastro do usuário e os arquivos históricos são preservados.</p>
    @forelse($trabalho->participantes as $participante)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ optional($participante->user)->name ?: 'Usuário indisponível' }}</h5>
                <p>Função atual: {{ optional($participante->funcao)->nome ?: 'Não informada' }}</p>
                @if(optional($participante->funcao)->nome === 'Bolsista')
                    <p class="text-muted">Ao mudar de Bolsista para outra função, os planos deste participante serão removidos da listagem ativa. Os arquivos serão preservados no histórico.</p>
                @endif
                @php
                    $planoAtual = $participante->planoTrabalho;
                    $editando = old('participante_editado') == $participante->id;
                    $funcaoSelecionada = $editando ? old('funcao_participante_id') : $participante->funcao_participante_id;
                @endphp
                <form method="POST" enctype="multipart/form-data" class="editar-participante" action="{{ route('admin.participantes.update', [$trabalho->id, $participante->id]) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="participante_editado" value="{{ $participante->id }}">
                    <div class="form-group">
                        <label for="funcao-{{ $participante->id }}">Função na proposta</label>
                        <select id="funcao-{{ $participante->id }}" name="funcao_participante_id" class="form-control" required>
                            <option value="">Selecione a função</option>
                            @foreach($funcoes as $funcao)
                                <option value="{{ $funcao->id }}" data-bolsista="{{ $funcao->nome === 'Bolsista' ? '1' : '0' }}" {{ $funcaoSelecionada == $funcao->id ? 'selected' : '' }}>{{ $funcao->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dados-plano">
                        <p>Para bolsistas, informe o título e envie o plano em PDF. Se já houver um plano disponível, você pode manter o arquivo atual.</p>
                        @if($planoAtual)
                            <p>Plano cadastrado: {{ $planoAtual->titulo }}.
                                <a href="{{ route('baixar.plano', ['id' => $planoAtual->id]) }}">Baixar plano atual</a>
                            </p>
                        @endif
                        <div class="form-group">
                            <label for="titulo-{{ $participante->id }}">Título do plano de trabalho</label>
                            <input id="titulo-{{ $participante->id }}" name="titulo" class="form-control" type="text" maxlength="255"
                                value="{{ $editando ? old('titulo') : optional($planoAtual)->titulo }}">
                        </div>
                        <div class="form-group">
                            <label for="plano-{{ $participante->id }}">Plano de trabalho (PDF, até 6 MB)</label>
                            <input id="plano-{{ $participante->id }}" name="plano" class="form-control-file" type="file" accept="application/pdf,.pdf">
                            <small>Após erro de validação, selecione o arquivo novamente.</small>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Salvar participante</button>
                </form>
                <form class="mt-3" method="POST" action="{{ route('admin.participantes.destroy', [$trabalho->id, $participante->id]) }}">
                    @csrf
                    @method('DELETE')
                    <div class="form-check mb-2">
                        <input id="remover-{{ $participante->id }}" class="form-check-input" type="checkbox" name="confirmar_remocao" value="1" required>
                        <label for="remover-{{ $participante->id }}" class="form-check-label">Confirmo a remoção deste participante da proposta.</label>
                    </div>
                    <button class="btn btn-danger" type="submit">Remover da proposta</button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Nenhum participante ativo nesta proposta.</div>
    @endforelse
    <a class="btn btn-secondary" href="{{ route('admin.analisarProposta', ['id' => $trabalho->id]) }}">Voltar à proposta</a>
</div>
<script>
document.querySelectorAll('.editar-participante').forEach(function (form) {
    var select = form.querySelector('select');
    var campos = form.querySelector('.dados-plano');
    function atualizarPlano() {
        var bolsista = select.options[select.selectedIndex].getAttribute('data-bolsista') === '1';
        campos.hidden = !bolsista;
        campos.querySelectorAll('input').forEach(function (input) { input.disabled = !bolsista; });
        form.querySelector('[name="titulo"]').required = bolsista;
    }
    select.addEventListener('change', atualizarPlano);
    atualizarPlano();
});
</script>
@endsection
