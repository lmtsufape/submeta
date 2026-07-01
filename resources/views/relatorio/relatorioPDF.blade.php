@php use Carbon\Carbon; @endphp
        <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Relatório Final - {{ $trabalho->evento->nome  }}</title>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .titulo-menu {
            color: rgb(0, 140, 255);
            text-align: center;
        }

        table.info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.info-table.bordered {
            border: 1px solid #ccc;
        }

        table.info-table td {
            width: 50%;
            padding: 5px;
            vertical-align: top;
        }

        .section-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .justified-box {
            border: 1px solid #ccc;
            padding: 5px;
            margin-bottom: 10px;
            text-align: justify;
        }

        table.produtos-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.produtos-table th,
        table.produtos-table td {
            border: 1px solid #ccc;
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
<div class="titulo-menu">
    <h4>Relatório Final - {{ $trabalho->titulo }}</h4>
</div>

<br>

<div class="section-title">
    PARTE 1 - IDENTIFICAÇÃO DO PROJETO
</div>

<br>

<table class="info-table">
    <tr>
        <td colspan="2">
            <strong>{{ __('Edital:') }}</strong>
            {{ $relatorio->trabalho->evento->nome }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>{{ __('N° do processo SIPAC (Projeto):') }}</strong>
            {{ $relatorio->processo_sipac }}
        </td>
        <td>
            <strong>{{ __('Data de início do projeto:') }}</strong>
            {{ Carbon::createFromFormat('Y-m-d', $relatorio->inicio_projeto)->format('d/m/Y') }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>{{ __('Data de conclusão do projeto:') }}</strong>
            {{ Carbon::createFromFormat('Y-m-d', $relatorio->conclusao_projeto)->format('d/m/Y') }}
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <strong>{{ __('Título do projeto:') }}</strong>
            {{ $relatorio->titulo_projeto }}
        </td>
    </tr>
</table>

<br>

<div>
    <h6>Coordenador/a do projeto:</h6>
</div>
<table class="info-table bordered">
    <tr>
        <td>
            <strong>{{ __('Nome:') }}</strong>
            {{ $coordenador->nome }}
        </td>
        <td>
            <strong>{{ __('E-mail Institucional:') }}</strong>
            {{ $coordenador->email_institucional }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>{{ __('Cargo:') }}</strong>
            {{ $coordenador->cargo }}
        </td>
        <td>
            <strong>{{ __('Curso:') }}</strong>
            {{ $coordenador->curso_setor }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>{{ __('CPF:') }}</strong>
            {{ $coordenador->cpf }}
        </td>
        <td>
            <strong>{{ __('Telefone:') }}</strong>
            {{ $coordenador->telefone }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <strong>{{ __('Carga horária de atuação na proposta:') }}</strong>
            {{ $coordenador->ch_total_atuacao }}
        </td>
    </tr>
</table>

<br>

@if($vice_coordenador)
    <div>
        <h6>Vice-Coordenador/a do projeto (caso houver)</h6>
    </div>
    <table class="info-table bordered">
        <tr>
            <td>
                <strong>{{ __('Nome:') }}</strong>
                {{ $vice_coordenador->nome }}
            </td>
            <td>
                <strong>{{ __('E-mail Institucional:') }}</strong>
                {{ $vice_coordenador->email_institucional }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{ __('Cargo:') }}</strong>
                {{ $vice_coordenador->cargo }}
            </td>
            <td>
                <strong>{{ __('Curso:') }}</strong>
                {{ $vice_coordenador->curso_setor }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{ __('CPF:') }}</strong>
                {{ $vice_coordenador->cpf }}
            </td>
            <td>
                <strong>{{ __('Telefone:') }}</strong>
                {{ $vice_coordenador->telefone }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                {{ $vice_coordenador->ch_total_atuacao }}
            </td>
        </tr>
    </table>

    <br>
@endif

<div>
    <strong>{{ __('Área(s) temática(s) principal(is) do projeto, de acordo com a Política Nacional de Extensão') }}</strong>
    <div>
        @foreach($areas_tematicas as $area_tematica)
            {{ $area_tematica->nome }}
            <br>
        @endforeach
    </div>
</div>

<br>

<div>
    <strong>{{ __('Identifique qual(is) Objetivo(s) de Desenvolvimento Sustentáveis (ODS) da Agenda 2030 da ONU, está(ão) presente(s) no projeto') }}</strong>
    <a href="https://brasil.un.org/pt-br/sdgs"
       target="_blank">{{ __('(para maiores esclarecimentos sobre ODS acesse o link)') }}</a>
    <div>
        @foreach($ods as $od)
            {{ $od->nome }}
            <br>
        @endforeach
    </div>
</div>

<hr>

<div class="section-title">
    PARTE 2 - IDENTIFICAÇÃO DA EQUIPE E PARCERIAS
</div>

<br>

<div>
    <h6>Equipe: Integrantes internos à UFAPE</h6>
</div>

@foreach($internos as $interno)
    <table class="info-table bordered">
        <tr>
            <td>
                <strong>{{ __('Nome:') }}</strong>
                {{ $interno->nome }}
            </td>
            <td>
                <strong>{{ __('CPF:') }}</strong>
                {{ $interno->cpf }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{ __('Tipo:') }}</strong>
                {{ $interno->tipo }}
            </td>
            <td>
                <strong>{{ __('Tipo de vínculo:') }}</strong>
                {{ $interno->tipo_vinculo }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{ __('Curso de graduação:') }}</strong>
                {{ $interno->curso_graduacao }}
            </td>
            <td>
                <strong>{{ __('Curso/Setor de Atuação:') }}</strong>
                {{ $interno->curso_setor }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{ __('Data de ingresso na proposta:') }}</strong>
                {{ Carbon::createFromFormat('Y-m-d', $interno->ingresso_proposta)->format('d/m/Y') }}
            </td>
            <td>
                <strong>{{ __('Data de conclusão na proposta:') }}</strong>
                {{ Carbon::createFromFormat('Y-m-d', $interno->conclusao_proposta)->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                {{ $interno->ch_total_atuacao }}
            </td>
        </tr>
    </table>

    <br>
@endforeach

@if($externos->isNotEmpty())
    <div>
        <h6>Equipe: Integrantes externos à UFAPE</h6>
    </div>
@endif

@foreach($externos as $externo)
    <table class="info-table bordered">
        <tr>
            <td>
                <strong>{{ __('Nome:') }}</strong>
                {{ $externo->nome }}
            </td>
            <td>
                <strong>{{ __('CPF:') }}</strong>
                {{ $externo->cpf }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{ __('Instituição de vínculo:') }}</strong>
                {{ $externo->instituicao_vinculo }}
            </td>
            <td>
                <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                {{ $externo->ch_total_atuacao }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{ __('Data de ingresso na proposta:') }}</strong>
                {{ Carbon::createFromFormat('Y-m-d', $externo->ingresso_proposta)->format('d/m/Y') }}
            </td>
            <td>
                <strong>{{ __('Data de conclusão na proposta:') }}</strong>
                {{ Carbon::createFromFormat('Y-m-d', $externo->conclusao_proposta)->format('d/m/Y') }}
            </td>
        </tr>
    </table>

    <br>
@endforeach

<div>
    <strong>{{ __('Houve captação de recursos oriundos de fontes de fomento externas?') }}</strong>
    <br>
    @if($relatorio->captacao_recursos)
        Sim
    @else
        Não
    @endif
</div>

<hr>

<div class="section-title">
    PARTE 3 - RESULTADOS E OBJETIVOS ALCANÇADOS
</div>

<br>

<div>
    <strong>{{ __('1) Resumo:') }}</strong>
    <div class="justified-box">
        {{ $relatorio->resumo }}
    </div>
</div>

<div>
    <strong>{{ __('2) Em que proporção (%) os objetivos da proposta foram alcançados?') }}</strong>
    <div class="justified-box">
        {{ $relatorio->objetivos_alcancados }}%
    </div>
</div>

<div>
    <strong>{{ __('Caso não tenha atingido integralmente (100%) os objetivos propostos, quais deles deixaram de ser alcançados? Justifique.') }}</strong>
    <div class="justified-box">
        {{ $relatorio->justificativa_objetivos_alcancados }}
    </div>
</div>

<div>
    <strong>{{ __('3) Quantas pessoas foram diretamente beneficiadas pela atividade?') }}</strong>
    <div class="justified-box">
        {{ $relatorio->pessoas_beneficiadas }}
    </div>
</div>

<div>
    <strong>{{ __('4) Em que proporção (%) o projeto alcançou o público estimado?') }}</strong>
    <div class="justified-box">
        {{ $relatorio->alcance_publico_estimado }}%
    </div>
</div>

<div>
    <strong>{{ __('Caso não tenha atingido integralmente (100%) a estimativa de público, justifique.') }}</strong>
    <div class="justified-box">
        {{ $relatorio->justificativa_publico_estimado }}
    </div>
</div>

<div>
    <strong>{{ __('5) Quais foram os benefícios do projeto para o público atendido?') }}</strong>
    <div class="justified-box">
        {{ $relatorio->beneficios_publico_atendido }}
    </div>
</div>

<div>
    <strong>{{ __('6) Descreva o/s impacto/s tecnológico/s e/ou científico/s (se houve): Tecnologias desenvolvidas, patentes, inovações etc.') }}</strong>
    <div class="justified-box">
        {{ $relatorio->impactos_tecnologicos_cientificos }}
    </div>
</div>

<div>
    <strong>{{ __('7) Descreva a/s dificuldade/s e/ou desafio/s encontrado/s na execução do projeto? (se houve).') }}</strong>
    <div class="justified-box">
        {{ $relatorio->desafios_encontrados }}
    </div>
</div>

<div>
    <strong>{{ __('8) Qual sua avaliação do projeto executado e qual sua expectativa quanto a continuidade dele?') }}</strong>
    <div class="justified-box">
        {{ $relatorio->avaliacao_projeto_executado }}
    </div>
</div>

<div>
    <strong>{{ __('9) Produtos de extensão gerados de acordo com a Política de Extensão da UFAPE (em caso de dúvidas consulte a resolução de Extensão da UFAPE') }}</strong>
    <a href="http://ufape.edu.br/sites/default/files/resolucoes/CONSEPE_RESOLUCAO_n_006_2022.pdf"
       target="_blank">(Acesse aqui)</a>
</div>

<br>

<table class="produtos-table">
    <thead>
    <tr>
        <th class="text-center">Modalidade</th>
        <th class="text-center">Especificar</th>
        <th class="text-center">Quantidade</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <strong>Produto técnico-científico</strong><br>
            Publicações em revistas, anais, resumos, livros, e-books, capítulo de livro/e-book, apostilas,
            manuais, fascículos, guias, folders, boletins, monografias, kits e relatórios técnicos, traduções,
            dentre outros.
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->tecnico_cientifico }}
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->qtd_tecnico_cientifico }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>Produto de divulgação</strong><br>
            Folders, cartazes, revistas, reportagens, entrevistas, programas de rádio e televisão, vídeos,
            podcasts, ensaios, dentre outros.
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->divulgacao }}
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->qtd_divulgacao }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>Produto didático ou instrucional</strong><br>
            Manuais, cartilhas, apostilas, vídeos, modelos didáticos, cd's e kits didáticos, podcasts, games,
            dentre outros.
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->didatico_instrucional }}
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->qtd_didatico_instrucional }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>Produto multimídia</strong><br>
            Filmes, homepages, apps, podcasts, games, dentre outros.
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->multimidia }}
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->qtd_multimidia }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>Produto artístico-cultural</strong><br>
            Filmes, vídeos, peças teatrais, partituras, performances artísticas, dentre outros.
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->artistico_cultural }}
        </td>
        <td class="text-center">
            {{ $produtos_extensao_gerados->qtd_artistico_cultural }}
        </td>
    </tr>
    </tbody>
</table>

<hr>

<div class="section-title">
    PARTE 4 - ESTATÍSTICAS DA AÇÃO (INDICADORES)
</div>

<br>

<div>
    <strong>{{ __('Prezado/a Coordenador/a, favor preencher o formulário eletrônico com os indicadores do projeto, através do link: ') }}</strong>
    <a href="https://forms.gle/Qfa8YEAjBdmC2aW2A" target="_blank">https://forms.gle/Qfa8YEAjBdmC2aW2A</a>
</div>

<br>

<div>
    Confirmo que preenchi o formulário de indicadores:
    @if($relatorio->formulario_indicadores)
        Sim
    @else
        Não
    @endif
</div>

<hr>

<div class="section-title">
    PARTE 5 - LISTA DE PARTICIPANTES BENEFICIADOS A SEREM CERTIFICADOS
</div>

<br>

<div>
    <strong>{{ __('O projeto desenvolvido contou com alguma atividade passível de certificação envolvendo o público beneficiado?') }}</strong>
    <br>
    @if($relatorio->certificacao_adicinonal)
        Sim
    @else
        Não
    @endif
</div>

<br>

@if($participantes->isNotEmpty())
    <div>
        <h6>Participantes</h6>
    </div>
@endif

@foreach($participantes as $participante)
    <table class="info-table bordered">
        <tr>
            <td>
                <strong>{{ __('Nome:') }}</strong>
                {{ $participante->nome }}
            </td>
            <td>
                <strong>{{ __('CPF:') }}</strong>
                {{ $participante->cpf }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>{{ __('Carga horária:') }}</strong>
                {{ $participante->carga_horaria }}
            </td>
        </tr>
    </table>

    <br>
@endforeach

<hr>
</body>
</html>