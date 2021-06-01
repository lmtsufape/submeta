@extends('layouts.app')

@section('content')

<div>
  {{-- action="{{route('trabalho.store')}}" --}}
  <form method="POST" id="criarProjetoForm"  action="{{route('trabalho.store')}}" enctype="multipart/form-data" >
  @csrf
  <input type="hidden" name="editalId" value="{{$edital->id}}">

  <div class="container">
    <div class="row justify-content-center">

      @component('evento.formulario.projeto', ['grandeAreas' => $grandeAreas])
      @endcomponent
      
      @component('evento.formulario.proponente')
      @endcomponent
      
      @component('evento.formulario.anexos')
      @endcomponent
      
      @component('evento.formulario.participantes', ['estados' => $estados, 'enum_turno' => $enum_turno])
      @endcomponent
      
      @component('evento.formulario.finalizar')
      @endcomponent

    </div>
  </div>
  </form>
  <div id="participanteFirst" >
    <div class="form-row" style="display: none" id="participantePrimeiro">
      <button type="button" class="btn btn-danger" id="buttonRemover" onclick="removerPart(this)" >Remover participante</button>
      <div class="col-md-12">
        <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante" href="#collapseParticipante" role="button" aria-expanded="false" aria-controls="collapseParticipante" style="width: 100%; text-align:left">
          <div class="d-flex justify-content-between align-items-center">
            <h4 id="tituloParticipante" style="color: #01487E; font-size:17px; margin-top:5px">Participante<span id="pontos" style="display: none;">:</span> <span style="display: none;" id="display"></span>  </h4>
          </div>
        </a>
      </div>
      <div class="col-md-12">
        <div class="collapse" id="collapseParticipante">
          <div class="container">
              <div class="row">
                <input type="hidden"  name="funcaoParticipante[]" value="4">
                <div class="col-md-12 mt-3"><h5>Dados do participante</h5></div>
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Nome completo'])
                        <input type="text" class="form-control " id="nomeParticipante"  name="nomeParticipante[]" placeholder="Nome Completo" required />
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'E-mail'])
                        <input type="email" class="form-control"  name="emailParticipante[]" placeholder="E-mail" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Data de nascimento'])
                        <input type="date" class="form-control" name="data_de_nascimento[]" placeholder="Data de nascimento" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'CPF'])
                        <input type="text" class="form-control cpf"  name="cpf[]" placeholder="CPF" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'RG'])
                        <input type="number" class="form-control"  min="1" maxlength="8" name="rg[]" placeholder="RG" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Celular'])
                        <input type="tel" class="form-control celular"  name="celular[]" placeholder="Celular" required/>
                      @endcomponent
                </div>
                <div class="col-md-12"><h5>Endereço</h5></div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'CEP'])
                        <input type="number" class="form-control" name="cep[]" placeholder="CEP" required/>
                      @endcomponent
                </div>           
                                   
                <div class="col-6">
                  @component('componentes.select', ['label' => 'Estado'])
                    <select name="uf[]" id="estado" class="form-control"   style="visibility: visible" required>
                      <option value="" disabled selected>-- Selecione uma opção --</option>
                      @foreach ($estados as $sigla => $nome)
                        <option @if(old('uf') == $sigla ) selected @endif value="{{ $sigla }}">{{ $nome }}</option>
                      @endforeach
                    </select>
                  @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Cidade'])
                        <input type="text" class="form-control"  name="cidade[]" placeholder="Cidade" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Bairro'])
                        <input type="text" class="form-control"  name="bairro[]" placeholder="Bairro" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Rua'])
                        <input type="text" class="form-control"  name="rua[]" placeholder="Rua" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Número'])
                        <input type="text" class="form-control"  name="numero[]" placeholder="Número" required/>
                      @endcomponent
                </div>                              
                <div class="col-12">
                      @component('componentes.input', ['label' => 'Complemento'])
                        <input type="text" id="complemento" class="form-control" name="complemento[]"  pattern="[A-Za-z]+" placeholder="Complemento" required/>
                      @endcomponent
                </div>
                <div class="col-md-12"><h5>Dados do curso</h5></div>                               
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Universidade'])
                        <input type="text" class="form-control" name="universidade[]" placeholder="Universidade" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Curso'])
                        <input type="text" class="form-control" name="curso[]" placeholder="Curso" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                  @component('componentes.select', ['label' => 'Turno'])
                    <select name="turno[]" class="form-control" required>
                      <option value="" disabled selected>-- Selecione uma opção --</option>
                      @foreach ($enum_turno as $key => $value)
                        <option @if(old('turno') == $value ) selected @endif value="{{ $value }}">{{ $value }}</option>
                      @endforeach
                    </select>
                  @endcomponent
                </div>
                @php
                  $options = array('6' => 6, '7' => 7,'8' => 8,'9' => 9,'10' => 10,'11' => 11,'12' => 12); 
                @endphp                              
                <div class="col-6">
                  @component('componentes.select', ['label' => 'Total de períodos do curso'])
                    <select name="total_periodos[]"  class="form-control" onchange="gerarPeriodo(this)" required>
                      <option value="" disabled selected>-- Selecione uma opção --</option>
                      @foreach ($options as $key => $value)
                        <option @if(old('total_periodos') == $key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                      @endforeach
                    </select>
                  @endcomponent
                </div>                              
                <div class="col-6">
                  @component('componentes.select', ['label' => 'Período atual'])
                    <select name="periodo_atual[]"  class="form-control" required >
                      <option value="" disabled selected>-- Selecione uma opção --</option>
                      
                    </select>
                  @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.select', ['label' => 'Ordem de prioridade'])
                        <select name="ordem_prioridade[]"  class="form-control" required>
                          <option value="" disabled selected>-- ORDEM --</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                        </select>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
                      <input type="number" class="form-control media" name="media_geral_curso[]" min="0" max="10" step="0.01"  required>
                      @endcomponent
                </div>
                <div class="col-md-12"><h5>Plano de trabalho</h5></div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Título'])
                        <input type="text" class="form-control" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" required>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Anexo(.pdf)'])
                        <input type="file" class="input-group-text" name="anexoPlanoTrabalho[]" accept=".pdf" placeholder="Anexo do Plano de Trabalho" required/>
                      @endcomponent
                </div>                              
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row" style="display: none">
      {{-- <button type="button" onload="myScript(this)" onclick="subir(this)" >Subir</button>
      <button type="button" onload="myScript(this)" onclick="descer(this)">Descer</button> --}}
      <button type="button" class="btn btn-danger" id="buttonRemover" onclick="removerPart(this)" >Remover participante</button>
      <div class="col-md-12">
        <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante" href="#collapseParticipante" role="button" aria-expanded="false" aria-controls="collapseParticipante" style="width: 100%; text-align:left">
          <div class="d-flex justify-content-between align-items-center">
            <h4 id="tituloParticipante" style="color: #01487E; font-size:17px; margin-top:5px">Participante<span id="pontos" style="display: none;">:</span> <span style="display: none;" id="display"></span>  </h4>
          </div>
        </a>
      </div>
      <div class="col-md-12">
        <div class="collapse" id="collapseParticipante">
          <div class="container">
              <div class="row">
                <input type="hidden"  name="funcaoParticipante[]" value="4">
                <div class="col-md-12 mt-3"><h5>Dados do participante</h5></div>
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Nome completo'])
                        <input type="text" class="form-control "   name="nomeParticipante[]" placeholder="Nome Completo" required />
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'E-mail'])
                        <input type="email" class="form-control"  name="emailParticipante[]" placeholder="E-mail" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Data de nascimento'])
                        <input type="date" class="form-control" name="data_de_nascimento[]" placeholder="Data de nascimento" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'CPF'])
                        <input type="text" class="form-control cpf"  name="cpf[]" placeholder="CPF" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'RG'])
                        <input type="number" class="form-control"  min="1" maxlength="8" name="rg[]" placeholder="RG" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Celular'])
                        <input type="tel" class="form-control celular"  name="celular[]" placeholder="Celular" required/>
                      @endcomponent
                </div>
                <div class="col-md-12"><h5>Endereço</h5></div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'CEP'])
                        <input type="number" class="form-control" name="cep[]" placeholder="CEP" required/>
                      @endcomponent
                </div>           
                                   
                <div class="col-6">
                  @component('componentes.select', ['label' => 'Estado'])
                    <select name="uf[]" id="estado" class="form-control"   style="visibility: visible" required>
                      <option value="" disabled selected>-- Selecione uma opção --</option>
                      @foreach ($estados as $sigla => $nome)
                        <option @if(old('uf') == $sigla ) selected @endif value="{{ $sigla }}">{{ $nome }}</option>
                      @endforeach
                    </select>
                  @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Cidade'])
                        <input type="text" class="form-control"  name="cidade[]" placeholder="Cidade" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Bairro'])
                        <input type="text" class="form-control"  name="bairro[]" placeholder="Bairro" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Rua'])
                        <input type="text" class="form-control"  name="rua[]" placeholder="Rua" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Número'])
                        <input type="text" class="form-control"  name="numero[]" placeholder="Número" required/>
                      @endcomponent
                </div>                              
                <div class="col-12">
                      @component('componentes.input', ['label' => 'Complemento'])
                        <input type="text"  class="form-control" name="complemento[]"  pattern="[A-Za-z]+" placeholder="Complemento" required/>
                      @endcomponent
                </div>
                <div class="col-md-12"><h5>Dados do curso</h5></div>                               
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Universidade'])
                        <input type="text" class="form-control" name="universidade[]" placeholder="Universidade" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Curso'])
                        <input type="text" class="form-control" name="curso[]" placeholder="Curso" required/>
                      @endcomponent
                </div>                              
                <div class="col-6">
                  @component('componentes.select', ['label' => 'Turno'])
                    <select name="turno[]" class="form-control" required>
                      <option value="" disabled selected>-- Selecione uma opção --</option>
                      @foreach ($enum_turno as $key => $value)
                        <option @if(old('turno') == $value ) selected @endif value="{{ $value }}">{{ $value }}</option>
                      @endforeach
                    </select>
                  @endcomponent
                </div>
                @php
                  $options = array('6' => 6, '7' => 7,'8' => 8,'9' => 9,'10' => 10,'11' => 11,'12' => 12); 
                @endphp                              
                <div class="col-6">
                  @component('componentes.select', ['label' => 'Total de períodos do curso'])
                    <select name="total_periodos[]"  class="form-control" onchange="gerarPeriodo(this)" required>
                      <option value="" disabled selected>-- Selecione uma opção --</option>
                      @foreach ($options as $key => $value)
                        <option @if(old('total_periodos') == $key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                      @endforeach
                    </select>
                  @endcomponent
                </div>                              
                <div class="col-6">
                  @component('componentes.select', ['label' => 'Período atual'])
                    <select name="periodo_atual[]"  class="form-control" required >
                      <option value="" disabled selected>-- Selecione uma opção --</option>
                      
                    </select>
                  @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.select', ['label' => 'Ordem de prioridade'])
                        <select name="ordem_prioridade[]"  class="form-control" required>
                          <option value="" disabled selected>-- ORDEM --</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                        </select>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
                      <input type="number" class="form-control media" name="media_geral_curso[]" min="0" max="10" step="0.01"  required>
                      @endcomponent
                </div>
                <div class="col-md-12"><h5>Plano de trabalho</h5></div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Título'])
                        <input type="text" class="form-control" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" required>
                      @endcomponent
                </div>                              
                <div class="col-6">
                      @component('componentes.input', ['label' => 'Anexo(.pdf)'])
                        <input type="file" class="input-group-text" name="anexoPlanoTrabalho[]" accept=".pdf" placeholder="Anexo do Plano de Trabalho" required/>
                      @endcomponent
                </div>                              
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal de Aviso Edit -->
  <div class="modal fade" id="exampleModalAnexarDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" id="idCorCabecalhoModalDocumento">
                <h5 class="modal-title" id="exampleModalLabel2" style="font-size:20px; margin-top:7px; color:white; font-weight:bold; font-family: 'Roboto', sans-serif;">Aviso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12" style="font-family: 'Roboto', sans-serif;"><label id="idTituloDaMensagemModalDocumento"></label></div>
                <div class="col-12" style="font-family: 'Roboto', sans-serif; margin-top:10px;">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal"style="width:200px;">Fechar</button>
        </div>
    </div>
  </div>
  </div>

</div>

@endsection

@section('javascript')


<script>
    
    
  let buttonMais = document.getElementById('buttonMais');
  let buttonMenos = document.getElementById('buttonMenos');
  let buttonForm = document.getElementById('buttonForm');
  let buttonSubmit = document.getElementById('idButtonSubmitProjeto');
  let parts = document.getElementById('participante');
  let partsFirst = document.getElementById('participanteFirst');
  // let buttonRemover = document.getElementById('buttonRemover');
  // var item1 = $( "#participante" )[ 0 ];
  // var participante $( "#participante" ).find( item1 )
  const participante = partsFirst.firstElementChild;
  // const participante = document.getElementById('participantePrimeiro');
  let contador = 2;
  // var validator = $( "#formPart" ).validate();

  buttonSubmit.addEventListener('click', (e)=>{
    $('.collapse').addClass('show')
  })

  function gerarPeriodo(e){
    var select = e.parentElement.parentElement.nextElementSibling;
    selectPeriodos = select.children[0].children[1];
    var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
    for(var i = 0; i < parseInt(e.value); i++) {
      html += `<option value="${i+1}">${i+1}º</option>`;
    }
    $(selectPeriodos).html('');
    $(selectPeriodos).append(html);

  }

  function subir(e){
    if(e.parentElement.previousElementSibling){
      var atual = e.parentElement;
      var anterior = e.parentElement.previousElementSibling;
      console.log(atual)
      console.log(anterior)
      atual.insertAdjacentElement('afterend', anterior)
      anterior.insertAdjacentElement('beforebegin', atual)
    }
  }

  function descer(e){
    if(e.parentElement.nextElementSibling){
      var atual = e.parentElement;
      var proximo = e.parentElement.nextElementSibling;
      proximo.insertAdjacentElement('afterend', atual)
      atual.insertAdjacentElement('beforebegin', proximo)
    }
  }
  function removerPart(e){
    if(e.parentElement){
      if(parts.children.length <= 1){
        
      }else{
        parts.removeChild(e.parentElement);
        contador--;
      }
      
    }
  }

  buttonMais.addEventListener("click", (e) => {
    
    // console.log("{{ $edital->numParticipantes }}")
    if(parts.children.length  >= "{{ $edital->numParticipantes }}"){
      alert('Limite de participante.')
    }else{
      contador++;
      var cln = participante.cloneNode(true);
      cln.style.display = 'block';
      // console.log(cln.children[2].firstElementChild.id)
      // console.log(cln.children[1].firstElementChild.href)
      // var id = cln.children[2].firstElementChild.id;
      // var href = cln.children[1].firstElementChild.href;
      // cln.children[2].firstElementChild.id = id + contador;
      // cln.children[1].firstElementChild.href = href + contador;
      // console.log(cln.children[2].firstElementChild.id)
      // console.log(cln.children[1].firstElementChild.href)
      // console.log(cln.style.display = 'block')
      for (i = 0; i < cln.children.length; i++) {
        for (let index = 0; index < cln.children[i].querySelectorAll('input').length; index++) {
          let input = cln.children[i].querySelectorAll('input')[index];
          let name = input.getAttributeNode("name").value;
          name = name.replace("[", "");
          name = name.replace("]", "");
          input.getAttributeNode("name").value = name + '['+ contador +']';
          // input.getAttributeNode("disabled").value = " ";
          let select = cln.children[i].querySelectorAll('select')[index];
          if(select){
            let selectName = select.getAttributeNode("name").value;
            selectName = selectName.replace("[", "");
            selectName = selectName.replace("]", "");
            // console.log(select.getAttributeNode("name").value)
            select.getAttributeNode("name").value = selectName + '['+ contador +']';
          }
          
        }
      }
      
      parts.appendChild(cln);

    }

    
  });

  

</script>


<script>
  
  $( document ).ready( function () {

    $('#nomeParticipante').keyup(function () {
      $('#display').text($(this).val());
      if($('#nomeParticipante').val() == ""){
        $('#display').hide();
        $('#pontos').hide();
      }else{
        $('#display').show();
        $('#pontos').show();
      }
    });

    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/);
    });

    $('.cep').mask('00000000');
    $('.cpf').mask('000.000.000-00');
    $('.numero').mask('0000000000000');
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };
    $('.celular').mask(SPMaskBehavior, spOptions);
    $('.sus').mask('000 0000 0000 0000');

    $("input[type='file']").on("change", function () {
     if(this.files[0].size > 2000000) {
      //  console.log($(this).parents( ".col-sm-5" ))
       alert("O tamanho do arquivo deve ser menor que 2MB!");
       $(this).val('');
       
     }
    });

    

    $.validator.setDefaults( {
      
      submitHandler: function (form) {
        form.submit();
      }
    } );
    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo &eacute; requerido.",
        remote: "Por favor, corrija este campo.",
        email: "Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.",
        url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
        date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
        dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
        number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
        digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
        creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
        equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
        accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
        maxlength: jQuery.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
        minlength: jQuery.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
        rangelength: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
        range: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
        max: jQuery.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
        min: jQuery.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}.")
    });
    $( "#criarProjetoForm" ).validate( {
      lang: 'PT_BR',
      rules: {
        firstname: "required",
        username: {
          required: true,
          minlength: 2
        },
        password: {
          required: true,
          minlength: 5
        },
        confirm_password: {
          required: true,
          minlength: 5,
          equalTo: "#password"
        },
        email: {
          required: true,
          email: true,
          
        },
        "complemento[]":{

          
        },
        "nomeParticipante[]":{
          required:true,
          alpha:true,
        },
        'rg[]':{
          required: true,
          maxlength: 8,
        },
        
        agree: "required"
      },
      messages: {
        // nomeProjeto: "O nome do projeto é obrigatório.",
        
        // 'emailParticipante[]': "Este campo é obrigatório.",
        // 'data_de_nascimento[]': "Este campo é obrigatório.",
        // 'cpf[]': "Este campo é obrigatório.",
        // 'rg[]': {
        //   required: "Este campo é obrigatório.",
        //   maxlength: "Este campo deve conter no máximo 8 números."
        // },
        // 'celular[]': "Este campo é obrigatório.",
        // 'cep[]': "Este campo é obrigatório.",
        // 'uf[]': "Este campo é obrigatório.",
        // 'cidade[]': "Este campo é obrigatório.",
        // 'bairro[]': "Este campo é obrigatório.",
        // 'rua[]': "Este campo é obrigatório.",
        // 'numero[]': "Este campo é obrigatório.",
        // 'complemento[]': "Este campo é obrigatório.",
        // 'universidade[]': "Este campo é obrigatório.",
        // 'curso[]': "Este campo é obrigatório.",
        // 'turno[]': "Este campo é obrigatório.",
        // 'total_periodos[]': "Este campo é obrigatório.",
        // 'periodo_atual[]': "Este campo é obrigatório.",
        // 'ordem_prioridade[]': "Este campo é obrigatório.",
        // 'media_geral_curso[]': "Este campo é obrigatório.",
        // 'nomePlanoTrabalho[]': "Este campo é obrigatório.",
        // 'anexoPlanoTrabalho[]': "Este campo é obrigatório.",
        // grandeArea: "Escolha uma grande área.",
        // area: "Escolha uma área.",
        // linkGrupo: "Este campo é obrigatório.",
        // pontuacaoPlanilha: "Este campo é obrigatório.",
        // anexoProjeto: "Este campo é obrigatório.",
        // anexoLattesCoordenador: "Este campo é obrigatório.",
        // anexoConsuPreenchido: "Este campo é obrigatório.",
        // anexoGrupoPesquisa: "Este campo é obrigatório.",
        // anexoPlanilha: "Este campo é obrigatório.",
        // anexoComiteEtica: "Este campo é obrigatório.",
        // inputJustificativa: "Este campo é obrigatório.",
        // "nomeParticipante[]": {
        //   required: "O nome do participante é obrigatório.",
        //   alpha: "Não é permitido números."
        // },
        // username: {
        //   required: "Please enter a username",
        //   minlength: "Your username must consist of at least 2 characters"
        // },
        // password: {
        //   required: "Please provide a password",
        //   minlength: "Your password must be at least 5 characters long"
        // },
        // confirm_password: {
        //   required: "Please provide a password",
        //   minlength: "Your password must be at least 5 characters long",
        //   equalTo: "Please enter the same password as above"
        // },
        // email: "Please enter a valid email address",
        // agree: "Please accept our policy"
      },
      errorElement: "em",
      errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "invalid-feedback" );

        if ( element.prop( "type" ) === "checkbox" ) {
          error.insertAfter( element.parent( "label" ) );
        } else {
          error.insertAfter( element );
        }
      },
      highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
      },
      unhighlight: function (element, errorClass, validClass) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
      }
    } );
    
  } );
</script>


<script type="text/javascript">

  function validarCPF(valor){
      var soma = 0;
      var resto;
      var inputCPF = valor.match(/\d/g).join('');

      if(inputCPF == '00000000000') return false;

      if(inputCPF.length >11) return false;

      for(i=1; i<=9; i++) soma = soma + parseInt(inputCPF.substring(i-1, i)) * (11 - i);
      resto = (soma * 10) % 11;

      if((resto == 10) || (resto == 11)) resto = 0;
      if(resto != parseInt(inputCPF.substring(9, 10))) return false;

      soma = 0;
      for(i = 1; i <= 10; i++) soma = soma + parseInt(inputCPF.substring(i-1, i))*(12-i);
      resto = (soma * 10) % 11;

      if((resto == 10) || (resto == 11)) resto = 0;
      if(resto != parseInt(inputCPF.substring(10, 11))) return false;
      return true;
  }

  /*
  * FUNCAO: Gerar as areas
  *
  */
  function areas() {
      var grandeArea = $('#grandeArea').val();
      $.ajax({
          type: 'POST',
          url: '{{ route('area.consulta') }}',
          data: 'id='+grandeArea ,
          headers:
          {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: (dados) => {

          if (dados.length > 0) {
            if($('#oldArea').val() == null || $('#oldArea').val() == ""){
              var option = '<option selected disabled>-- Área --</option>';
            }
            $.each(dados, function(i, obj) {
              if($('#oldArea').val() != null && $('#oldArea').val() == obj.id){
                option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
              }else{
                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
              }
            })
          } else {
            var option = "<option selected disabled>-- Área --</option>";
          }
          $('#area').html(option).show();
          subareas();
        },
          error: (data) => {
              console.log(data);
          }

      })
    }
  /*
  * FUNCAO: Gerar as subareas
  *
  */
  function subareas() {
      var area = $('#area').val();
      $.ajax({
          type: 'POST',
          url: '{{ route('subarea.consulta') }}',
          data: 'id='+area ,
          headers:
          {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: (dados)=> {
          if (dados.length > 0) {
            if($('#oldSubArea').val() == null || $('#oldSubArea').val() == ""){
              var option = '<option selected disabled>-- Subárea --</option>';
            }
            $.each(dados, function(i, obj) {
              if($('#oldSubArea').val() != null && $('#oldSubArea').val() == obj.id){
                option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
              }else{
                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
              }
            })
          } else {
            var option = "<option selected disabled>-- Subárea --</option>";
          }
          $('#subArea').html(option).show();
        },
          error: (dados) => {
              console.log(dados);
          }

      })

    }
    /*  
  * FUNCAO: funcao responsavel pelo abre e fecha da area "possui autorizacoes especiais?"
  *
  */
  function displayAutorizacoesEspeciais(valor){
      if(valor == "sim"){
        document.getElementById("radioSim").checked = true;
        document.getElementById("radioNao").checked = false;
        document.getElementById("displaySim").style.display = "block";
        document.getElementById("displayNao").style.display = "none";
        document.getElementById("idAvisoAutorizacaoEspecial").style.display = "none";
      }else if(valor == "nao"){
        document.getElementById("radioSim").checked = false;
        document.getElementById("radioNao").checked = true;
        document.getElementById("displaySim").style.display = "none";
        document.getElementById("displayNao").style.display = "block";
        document.getElementById("idAvisoAutorizacaoEspecial").style.display = "none";
      }
    }
    /*  
  * FUNCAO: funcao responsavel pela verificacao dos arquivos anexados (PDF)
  *
  */
  function verificarArquivoAnexado_pdf(item, legenda){
      
      if(item.files[0].type.split('/')[1] != "pdf"){
          document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
          document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado não é do tipo PDF! ";
          document.getElementById(legenda).innerHTML = "O arquivo deve ser no formato PDF de até 2MB.";
          document.getElementById(item.id).value = "";
          $("#exampleModalAnexarDocumento").modal({show: true});
      }else if(item.files[0].size > 2000000 && item.files[0].type.split('/')[1] == "pdf"){
          document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
          document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado é maior que 2MB!";
          document.getElementById(legenda).innerHTML = "O arquivo deve ser no formato PDF de até 2MB.";
          document.getElementById(item.id).value = "";
          $("#exampleModalAnexarDocumento").modal({show: true});
      }else{
        document.getElementById(legenda).innerHTML = item.value.split('\\')[2];
      }
    }
  /* FUNCAO: funcao responsavel pela verificacao dos arquivos anexados (XLS, XLSX, ODS)
  *
  */
  function verificarArquivoAnexado_xls_xlsx_ods(item, legenda){
      if(item.files[0].name.split('.')[1] == "xls" || item.files[0].name.split('.')[1] == "ods" || item.files[0].name.split('.')[1] == "xlsx"){
          if(item.files[0].size > 2000000){
            document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
            document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado é maior que 2MB!";
            document.getElementById(legenda).innerHTML = "Formato do arquivo: XLS, XLSX ou ODS de até 2MB.";
            document.getElementById(item.id).value = "";
            $("#exampleModalAnexarDocumento").modal({show: true});
          }else{
            document.getElementById(legenda).innerHTML = item.value.split('\\')[2];
          }
      }else{
        document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
        document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado não é do tipo XLS, XLSX ou ODS! ";
        document.getElementById(legenda).innerHTML = "Formato do arquivo: XLS, XLSX ou ODS de até 2MB.";
        document.getElementById(item.id).value = "";
        $("#exampleModalAnexarDocumento").modal({show: true});
      }
      
  }
  /*
  * FUNCAO: Gerar periodos 1
  *
  */
  // function gerarPeriodos1(select) {
  //     var div = select.parentElement.parentElement;
  //     var selectPeriodos = div.children[22].children[1];
  //     var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
  //     for(var i = 0; i < parseInt(select.value); i++) {
  //       html += `<option value="${i+1}">${i+1}º</option>`;
  //     }
  //   });
  // });

  // $(document).ready(function(){
  //   $(".cpf").change(function(){
  //     console.log(this.parentElement.children[0])
  //     if (validarCPF(retirarFormatacao(this.value))) {

  //       this.parentElement.children[0].style.display = "none";
  //       this.parentElement.children[1].style.display = "block";
  //     } else {
  //       this.parentElement.children[0].style.display = "block";
  //       this.parentElement.children[1].style.display = "none";
  //     }
  //   });
  // });

  // function validarCPF(strCPF) {
  //   var soma;
  //   var resto;
  //   soma = 0;    
  //   // Verifica se foi informado todos os digitos corretamente
  //   if (strCPF.length != 11) {
  //     return false;
  //   }

  //   // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
  //   if (varificarDigitos(strCPF)) {
  //       return false;
  //   }

  //   // Faz o calculo para validar o CPF
  //   for (var t = 9; t < 11; t++) {
  //       for (var d = 0, c = 0; c < t; c++) {
  //           d += strCPF[c] * ((t + 1) - c);
  //       }
  //       d = ((10 * d) % 11) % 10;
  //       if (strCPF[c] != d) {
  //         return false;
  //       }
  //   }
  //   return true;
  // }

  // function retirarFormatacao(strCpf) {
  //   resultado = "";
  //   for(var i = 0; i < strCpf.length; i++) {
  //     if (strCpf[i] != "." && strCpf[i] != "-") {
  //       resultado += strCpf[i];
  //     }
  //   }
  //   return resultado;
  // }

  // function varificarDigitos(strCpf) {
  //   var cont = 1;
  //   dig1 = strCpf[0];

  //   for(var i = 1; i < strCpf.length; i++) {
  //     if(dig1 == strCpf[i]) {
  //       cont++;
  //     }
  //   }
  //   if (cont == strCpf.length) {
  //     return true;
  //   }
  //   return false;
  // }

  // function checarCpfs() {
  //   var validacoes = document.getElementsByClassName("cpf-invalido");
  //   var count = validacoes.length;
  //   var quant = 0;
  //   for(var i = 0; i < validacoes.length; i++) {
  //     if (validacoes[i].style.display == "none") {
  //       quant++;
  //     }
  //   }
  //   if(quant == count) {
  //     return true;
  //   }
  //   return false;
  // }
</script>
@endsection
