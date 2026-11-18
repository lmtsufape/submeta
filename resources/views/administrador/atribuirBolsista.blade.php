@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Atribuir bolsista</h3>
    <p><strong>Edital:</strong> {{ $trabalho->evento->nome }}<br>
        <strong>Proposta:</strong> {{ $trabalho->titulo }}</p>

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>Selecione um usuário já cadastrado pelo CPF. A atribuição adiciona uma participação como bolsista e um novo plano de trabalho à proposta.</p>
    <form method="POST" action="{{ route('admin.bolsista.buscar', ['id' => $trabalho->id]) }}">
        @csrf
        <div class="form-group">
            <label for="cpf">CPF do bolsista</label>
            <input id="cpf" name="cpf" type="text" class="form-control" maxlength="14"
                value="{{ old('cpf', $usuario ? $usuario->cpf : '') }}" placeholder="Com ou sem pontos e traço" required>
        </div>
        <button type="submit" class="btn btn-primary">Buscar usuário</button>
    </form>

    @if($usuario)
        <div class="card mt-4">
            <div class="card-body">
                <h4>Usuário selecionado</h4>
                <p><strong>Nome:</strong> {{ $usuario->name }}<br>
                    <strong>CPF:</strong> {{ $usuario->cpf }}<br>
                    <strong>Instituição:</strong> {{ $usuario->instituicao }}</p>
                <form method="POST" action="{{ route('admin.bolsista.store', ['id' => $trabalho->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cpf" value="{{ $usuario->cpf }}">
                    <div class="form-group">
                        <label for="data_entrada">Data de entrada na proposta</label>
                        <input id="data_entrada" name="data_entrada" type="date" class="form-control"
                            value="{{ old('data_entrada', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="titulo">Título do plano de trabalho</label>
                        <input id="titulo" name="titulo" type="text" class="form-control" maxlength="255" value="{{ old('titulo') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="plano">Plano de trabalho (PDF, até 6 MB)</label>
                        <input id="plano" name="plano" type="file" class="form-control-file" accept="application/pdf,.pdf" required>
                    </div>
                    <button type="submit" class="btn btn-success">Atribuir bolsista e salvar plano</button>
                </form>
            </div>
        </div>
    @endif

    <a class="btn btn-secondary mt-3" href="{{ route('planos.listar', ['id' => $trabalho->id]) }}">Voltar aos planos</a>
</div>
@endsection
