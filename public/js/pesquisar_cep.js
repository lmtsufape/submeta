//cep1
window.meu_callback1 = function(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua1').value=(conteudo.logradouro);
        document.getElementById('bairro1').value=(conteudo.bairro);
        document.getElementById('cidade1').value=(conteudo.localidade);
        document.getElementById('estado1').value=(conteudo.uf);

    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep1();
        alert("CEP não encontrado.");
    }
}

window.limpa_formulário_cep1 = function () {
    //Limpa valores do formulário de cep.
    document.getElementById('rua1').value=("");
    document.getElementById('bairro1').value=("");
    document.getElementById('cidade1').value=("");
    document.getElementById('estado1').value=("");
}

window.pesquisacep1 = function(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua1').value="...";
            document.getElementById('bairro1').value="...";
            document.getElementById('cidade1').value="...";
            document.getElementById('estado1').value="...";


            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback1';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep1();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep1();
    }
}

//cep2
window.meu_callback2 = function(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua2').value=(conteudo.logradouro);
        document.getElementById('bairro2').value=(conteudo.bairro);
        document.getElementById('cidade2').value=(conteudo.localidade);
        document.getElementById('estado2').value=(conteudo.uf);

    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep2();
        alert("CEP não encontrado.");
    }
}

window.limpa_formulário_cep2 = function () {
    //Limpa valores do formulário de cep.
    document.getElementById('rua2').value=("");
    document.getElementById('bairro2').value=("");
    document.getElementById('cidade2').value=("");
    document.getElementById('estado2').value=("");
}

window.pesquisacep2 = function(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua2').value="...";
            document.getElementById('bairro2').value="...";
            document.getElementById('cidade2').value="...";
            document.getElementById('estado2').value="...";


            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback2';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep2();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep2();
    }
}

//cep2
window.meu_callback3 = function(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua3').value=(conteudo.logradouro);
        document.getElementById('bairro3').value=(conteudo.bairro);
        document.getElementById('cidade3').value=(conteudo.localidade);
        document.getElementById('estado3').value=(conteudo.uf);

    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep3();
        alert("CEP não encontrado.");
    }
}

window.limpa_formulário_cep3 = function () {
    //Limpa valores do formulário de cep.
    document.getElementById('rua3').value=("");
    document.getElementById('bairro3').value=("");
    document.getElementById('cidade3').value=("");
    document.getElementById('estado3').value=("");
}

window.pesquisacep3 = function(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua3').value="...";
            document.getElementById('bairro3').value="...";
            document.getElementById('cidade3').value="...";
            document.getElementById('estado3').value="...";


            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback3';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep3();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep3();
    }
}