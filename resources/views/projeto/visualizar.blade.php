@extends('layouts.app')

@section('content')

<div>
  {{-- action="{{route('trabalho.store')}}" --}}
  <form method="POST" id="criarProjetoForm" action="{{route('trabalho.update', ['id' => $projeto->id])}}" enctype="multipart/form-data" >
  @csrf
  <input type="hidden" name="editalId" value="{{$edital->id}}">

  <div class="container">
    @if (session('mensagem'))
        <div class="alert alert-warning" role="alert">
            {{ session('mensagem') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mt-1" >
            {{$errors->first()}}
        </div>
    @endif

    <div class="row justify-content-center" style="margin-top: 4rem">

      @component('projeto.formularioVisualizar.projeto2',
                ['edital' => $edital, 'projeto' => $projeto])
      @endcomponent

      @component('projeto.formularioVisualizar.proponente2', ['projeto' => $projeto, 'edital' => $edital, 'areasTematicas' => $areasTematicas])
      @endcomponent

      @component('projeto.formularioVisualizar.anexos2', ['edital' => $edital,'projeto' => $projeto])
      @endcomponent
      
      @if ($edital->numParticipantes != 0)
      @component('projeto.formularioVisualizar.participantes2', ['projeto' => $projeto, 'edital' => $edital])
      @endcomponent
      @endif

      @if($edital->natureza_id == 3)
        @component('projeto.formularioVisualizar.integrantes', ['projeto' => $projeto, 'edital' => $edital, 'trabalhos_user' => $trabalhos_user])
        @endcomponent
      @endif

      @component('projeto.formularioVisualizar.relatorio',['edital' => $edital,'projeto' => $projeto,'flagSubstituicao' =>$flagSubstituicao,
                                                           'AvalRelatParcial' => $AvalRelatParcial, 'AvalRelatFinal' => $AvalRelatFinal, 'cont' => 0])
      @endcomponent

      @component('projeto.formularioVisualizar.resultado2',
                    ['projeto' => $projeto])
      @endcomponent
      
      {{-- @component('projeto.formularioVisualizar.finalizar', ['projeto' => $projeto])
      @endcomponent --}}
    </div>
    
    <div class="row justify-content-end" style="padding: 15px;">
      <a href="{{ url()->previous() }}" class="btn btn-primary" style="font-size: 16px;">Voltar</a>
    </div>

  </div>
  </form>
  <div class="modal fade" id="modalSelecionarDiscentes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Selecione os discentes que dejesa solicitar certificado/declaração</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                <form id="certificadoForm" action="{{route('trabalho.solicitarCertificado', $projeto)}}" method="POST">
                    @csrf
                    <div class="form-check">
                      <input name="users[]" class="form-check-input" type="checkbox" value="{{$projeto->proponente->user->id}}" id="pa-{{$projeto->proponente->user->id}}">
                      <label class="form-check-label" for="pa-{{$projeto->proponente->user->id}}">
                          {{$projeto->proponente->user->name}}
                      </label>
                  </div>
                    @foreach ($projeto->participantes as $participante)
                        <div class="form-check">
                            <input name="users[]" class="form-check-input" type="checkbox" value="{{$participante->user->id}}" id="pa-{{$participante->user->id}}">
                            <label class="form-check-label" for="pa-{{$participante->user->id}}">
                                {{$participante->user->name}}
                            </label>
                        </div>
                    @endforeach
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between px-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="certificadoForm" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>
  <div id="participanteFirst" >
    @component('componentes.participante', ['enum_turno' => $enum_turno,'estados' => $estados, ])
      
    @endcomponent
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
<!-- Modal -->
<div class="modal fade" id="modalCpfInvalido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: red;">
              <h5 class="modal-title" id="exampleModalLabel2" style="font-size:20px; margin-top:7px; color:white; font-weight:bold; font-family: 'Roboto', sans-serif;">Aviso</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        Existe um CPF inválido em um dos discentes por favor corrija para continuar.
      </div>
      {{-- <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary"></button> 
        {{-- <button type="button" class="btn btn-primary">Certo</button> 
      </div> --}}
    </div>
  </div>
</div>
</div>
@endsection

@section('javascript')

    <style>
        body{font-family:Calibri, Tahoma, Arial}
        .TabControl{ width:100%; overflow:hidden; height:400px}
        .TabControl #header{ width:100%; overflow:hidden}
        .TabControl #content{ width:100%; overflow:hidden; height:100%; }
        .TabControl .abas{display:inline;}
        .TabControl .abas li{float:left}
        .aba{width:100px; height:30px; border-radius:5px 5px 0 0;
            text-align:center; padding-top:5px;}
        .ativa{width:100px; height:30px; border-radius:5px 5px 0 0;
            text-align:center; padding-top:5px; background:#27408B;}
        .ativa span, .selected span{color:#fff}
        .TabControl .conteudo{width:100%; display:none; height:100%;}
        .selected{width:100px; height:30px; border-radius:5px 5px 0 0;
            text-align:center; padding-top:5px; background:#27408B}

        .card:hover{
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2);
        }
        .card-body{
            font-size:18.4px;
        }
        h6,h5{
            font-size:18.4px;
        }
    </style>

<script>

    if(document.getElementById("radioSim").checked){
      document.getElementById("radioSim").checked = true;
      document.getElementById("radioNao").checked = false;
      document.getElementById("displaySim").style.display = "block";
      document.getElementById("displayNao").style.display = "none";
      document.getElementById("idAvisoAutorizacaoEspecial").style.display = "none";
    }else{
      document.getElementById("radioSim").checked = false;
      document.getElementById("radioNao").checked = true;
      document.getElementById("displaySim").style.display = "none";
      document.getElementById("displayNao").style.display = "block";
      document.getElementById("idAvisoAutorizacaoEspecial").style.display = "none";
    }
    
  let buttonSubmit = document.getElementById('idButtonSubmitProjeto');
  let parts = document.getElementById('participante');
  let partsFirst = document.getElementById('participanteFirst');
  const participante = partsFirst.firstElementChild;
  let contador = 0;

  buttonSubmit.addEventListener('click', (e)=>{
    $('.collapse').addClass('show')
  })

  function gerarPeriodo(e){
    var select = e.parentElement.parentElement.nextElementSibling;
    selectPeriodos = select.children[0].children[1];
    var html = `<option value="" disabled selected>-- TOTAL DE PERÍODOS --</option>`;
    for(var i = 0; i < parseInt(e.value); i++) {
      html += `<option value="${i+1}">${i+1}º</option>`;
    }
    $(selectPeriodos).html('');
    $(selectPeriodos).append(html);

  }

  function removerPart(e){
    console.log(e)
    if(e.parentElement.parentElement){
      if(parts.children.length <= 1){
        
      }else{
        parts.removeChild(e.parentElement.parentElement);
        contador--;
      }
      
    }
  }

  buttonMais.addEventListener("click", (e) => {
    
    if(parts.children.length  >= "{{ $edital->numParticipantes }}"){
      alert('Limite de participante.')
    }else{
      contador++;
      var cln = participante.cloneNode(true);
      cln.setAttribute('style', " "); 
      var id = cln.children[2].firstElementChild.id;
      var id2 = cln.children[0].firstElementChild.id;
      cln.children[2].firstElementChild.setAttribute('id', id + contador);
      cln.children[0].firstElementChild.setAttribute('href', "#collapseParticipante" + contador);
      cln.children[0].firstElementChild.setAttribute('id', id2 + contador);

      for (i = 0; i < cln.children.length; i++) {
        for (let index = 0; index < cln.children[i].querySelectorAll('input').length; index++) {
          let input = cln.children[i].querySelectorAll('input')[index];
          let name = input.getAttributeNode("name").value;
          name = name.replace("[]", "");
          input.getAttributeNode("name").value = name + '['+ contador +']';
          let select = cln.children[i].querySelectorAll('select')[index];
          if(select){
            let selectName = select.getAttributeNode("name").value;
            selectName = selectName.replace("[", "");
            selectName = selectName.replace("]", "");
            select.getAttributeNode("name").value = selectName + '['+ contador +']';
          }
          
        }
      }
      var SPMaskBehavior = function (val) {
          return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
      },
      spOptions = {
          onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
          }
      };
      parts.appendChild(cln);
      // console.log(cln);
      $(cln).find(".cpf").val("").mask("000.000.000-00");
      // $("input.cpf:text").val("").mask("000.000.000-00");
      $("input.celular:text").val("").mask(SPMaskBehavior, spOptions);
      $("input.cep:text").val("").mask("00000-000");

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
    // $('.cpf').mask('000.000.000-00');
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
          maxlength: 12,
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

  //       this.parentElement.children[1].style.display = "none";
  //       this.parentElement.children[2].style.display = "block";
  //     } else {
  //       this.parentElement.children[1].style.display = "block";
  //       this.parentElement.children[2].style.display = "none";
  //     }
  //   });
  // });

  function checarCPFdoCampo(input) {
    if (input.value.length == 14) {
      if (validarCPF(retirarFormatacao(input.value))) {
        input.parentElement.children[1].style.display = "none";
        input.parentElement.children[2].style.display = "block";
      } else {
        input.parentElement.children[1].style.display = "block";
        input.parentElement.children[2].style.display = "none";
      }
    } else {
      input.parentElement.children[1].style.display = "none";
      input.parentElement.children[2].style.display = "none";
    }
  }

  function validarCPF(strCPF) {
    var soma;
    var resto;
    soma = 0;    
    // Verifica se foi informado todos os digitos corretamente
    if (strCPF.length != 11) {
      return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (varificarDigitos(strCPF)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for (var t = 9; t < 11; t++) {
        for (var d = 0, c = 0; c < t; c++) {
            d += strCPF[c] * ((t + 1) - c);
        }
        d = ((10 * d) % 11) % 10;
        if (strCPF[c] != d) {
          return false;
        }
    }
    return true;
  }

  function retirarFormatacao(strCpf) {
    resultado = "";
    for(var i = 0; i < strCpf.length; i++) {
      if (strCpf[i] != "." && strCpf[i] != "-") {
        resultado += strCpf[i];
      }
    }
    return resultado;
  }

  function varificarDigitos(strCpf) {
    var cont = 1;
    dig1 = strCpf[0];

    for(var i = 1; i < strCpf.length; i++) {
      if(dig1 == strCpf[i]) {
        cont++;
      }
    }
    if (cont == strCpf.length) {
      return true;
    }
    return false;
  }

  function checarCpfs() {
    var validacoes = document.getElementsByClassName("cpf-invalido");
    var count = validacoes.length;
    var quant = 0;
    for(var i = 0; i < validacoes.length; i++) {
      if (validacoes[i].style.display == "none") {
        quant++;
      }
    }
    if(quant == count) {
      return true;
    }
    return false;
  }

  function submeterProposta() {
      document.getElementById("submeterFormProposta").click();
    // if (checarCpfs()) {
    // } else {
    //   $("#modalCpfInvalido").modal('show');
    // }
  }

  function mascaraCPF(input) {
    var numeros = "0123456789.-";
    var resultado = "";
    if (input.value.length < 14) {
      for (var i = 0; i < input.value.length; i++) {
        if (numeros.indexOf(input.value[i]) > -1) {
          if ((i == 2 || i == 6) && input.value[i+1] != ".") {
            resultado += input.value[i] + ".";
          } else if (i == 10 && input.value[i+1] != "-") {
            resultado += input.value[i] + "-";
          } else {
            resultado += input.value[i];
          }
        }
      }
    } else {
      for (var i = 0; i < 14; i++) { 
        resultado += input.value[i];
      }
    }
    input.value = resultado;
  }
</script>
@endsection
