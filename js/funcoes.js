$(function () {
    function unidade() {
        $.ajax({
            type: 'GET',
            url: '../php/funcoes.php',
            data: {
                acao: 'unidade'
            },
            dataType: 'json',

            success: function (data) {
                console.log(data);
                for (i = 0; i < data.qtd; i++) {
                    $('select[name=nomeUnidade]').append('<option value="' + data.idUnidade[i] + '|' + data.nome[i] + '">' + data.nome[i] + '</option>');
                }
            }
        });
    }

    unidade();

    function eventoContrato() {
        $.ajax({
            type: 'GET',
            url: '../php/funcoes.php',
            data: {
                acao: 'listarEvento'
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                for (i = 0; i < data.qtd; i++) {
                    $('select[name=comboEvento]').append('<option value="' + data.idEvento[i] + '|' + data.nomeEvento[i] + '">' + data.nomeEvento[i] + '</option>');
                }
            }
        });
    }

    eventoContrato();

    function objContrato() {
        $.ajax({
            type: 'GET',
            url: '../php/funcoes.php',
            data: {
                acao: 'objetoContrato'
            },
            dataType: 'json',

            success: function (data) {
                console.log(data);
                for (i = 0; i < data.qtd; i++) {
                    $('select[name=selecaoObjeto]').append('<option value="' + data.idObjeto[i] + '|' + data.descricao[i] + '">' + data.descricao[i] + '</option>');
                }
            }
        });
    }
    
    objContrato();
    function fornecedorContrato(unidade) {
        $.ajax({
            type: 'GET',
            url: '../php/funcoes.php',
            data: {
                acao: 'fornecedor',
                id: unidade
            },
            dataType: 'json',
            beforeSend: function () {
                $('select[name=idcontrato]').html('<option>Carregando ...</option>');
            },
            success: function (data) {
                console.log(data);
                $('select[name=idcontrato]').html('');
                $('select[name=idcontrato]').append("<option>Selecione o Contrato</option>");
                for (i = 0; i < data.qtd; i++) {
                    $('select[name=idcontrato]').append('<option value="' + data.idContrato[i] + '-' + data.nomeEmpresarial[i] + '-' + data.Contrato[i] + '">' + data.nomeEmpresarial[i] + ' - ' + data.Contrato[i] + '</option>');
                }
            }
        });
    }

    function fornecedorCnpj(cnpj) {
        $.ajax({
            type: 'GET',
            url: '../php/funcoes.php',
            data: {
                acao: 'fornecedorCnpj',
                cnpj: cnpj
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#nomeFornecedor').html(data.nomeEmpresarial);
                $('#codigoFornecedor').val(data.idFornecedor + "|" + data.nomeEmpresarial);
            }
        });
    }

    $('select[name=nomeUnidade]').change(function () {
        var id = $(this).val();
        fornecedorContrato(id);
    });

    $("#cnpjContrato").blur(function () {
        var x = $(this).val();
        fornecedorCnpj(x);
        // alert(cnpj);
    });



});


