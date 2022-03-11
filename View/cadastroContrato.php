<?php
//VERIFICA SESSAO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
}
//

require_once '../Controller/controllerContratos.php';
$controllerContrato = new controllerContratos();

if (filter_input(INPUT_GET, 'acao') === 'Cadastrar' && filter_input(INPUT_GET, 'id') == 0) {
    $idContrato = 0;
    $nomeUnidade = "Selecione";
    $cnpj = "";
    $nomeEmpresarial = "exemplo";
    $numerContrato = "";
    $anoContrato = "";
    $dataInicio = "";
    $dataFim = "";
    $valor = "";
    $idObjetoContrato = "";
    $descricaoObjetoContrato = "Selecione";
    $objContrato = "";
    $ativo = "";
    $urlarquivo = "";
} else {
    $idContrato = filter_input(INPUT_GET, 'id');
    $arrayContrato = $controllerContrato->buscar($idContrato);

    foreach ($arrayContrato as $value) {

        $id_nomeUnidade = explode("|", $value['unidade']);
        $idUnidade = $value['unidade'];
        $nomeUnidade = $id_nomeUnidade[1];

        $id_Fornecedor = explode("|", $value['fornecedor']);
        $idFornecedor = $value['fornecedor'];
        $nomeEmpresarial = $id_Fornecedor[1];
        $cnpj = $value['cnpj_cpf'];


        $numerContrato = $value['numeroContrato'];
        $anoContrato = $value['anoContrato'];
        $dataInicio = $value['dataInicio'];
        $dataFim = $value['dataTermino'];
        $valor = $value['valor'];
        $idObjetoContrato = $value['idObjeto'];
        $descricaoObjetoContrato = $value['DescObjeto'];
        $objContrato = $value['objetoContrato'];
        $urlarquivo = $value['urlArquivo'];
    }
    if ($value['status'] == 1) {
        $ativo = "checked";
    } else {
        $ativo = "";
    }
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Gerenciamento Contrato Acqua</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="../css/folha_frames.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    </head>

    <body>

        <div class="content">
            <header id="cabecarioPagina" class="fixed-top">
                <h1>Cadastro Contrato</h1>
            </header>
            <div id="paginas">
                <form method="POST" action="" class="needs-validation" enctype = "multipart/form-data">
                    <!-- informa o resultado -->
                    <div class="alert alert-success" role="alert" id="resultado">
                        Cadastrado com Sucesso!!!!
                    </div>

                    <!-- Guarda o codigo do Contrato -->
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="codigoContrato"  name="codigoContrato" value="<?= $idContrato ?>">
                    </div>

                    <!-- informa a parceiria -->
                    <div class="form-group">
                        <label id="seleciona">Parceiria</label>
                        <select class="form-control" name="parceiria" id="selecao" disabled="">
                            <option>Selecione</option>
                        </select>
                    </div>

                    <!-- informa o projeto -->
                    <div class="form-group">
                        <label id="seleciona">Projeto</label>
                        <select class="form-control" name="projeto" id="selecao" disabled>
                            <option>Selecione</option>
                        </select>
                    </div>

                                      <!-- informa a Unidade -->
                    <div class="form-group">
                        <label id="seleciona">Centro de Custo:</label>
                        <select class="form-control" name="nomeUnidade" id="selecao">
                            <option value="<?= $idUnidade ?>"><?= $nomeUnidade ?></option>
                        </select>
                    </div>

                    <!-- informa o fornecedor -->
                    <div class="form-group" id="idCnpj">
                        <label id="seleciona">Cnpj Fornecedor:</label>
                        <input type="text" class="form-control" id="cnpjContrato" placeholder="00.000.000/0000-00"
                               name="cnpjContrato" onfocus="" required="requided" value="<?= $cnpj ?>">

                        <input type="hidden" class="form-control" name="codigoFornecedor" id="codigoFornecedor" value="<?= $idFornecedor ?>">
                        <label id="nomeFornecedor" name="nomeFornecedor"><?= $nomeEmpresarial ?></label>
                    </div>

                    <script type="text/javascript">
                        $("#telefone, #cnpjContrato").mask("00.000.000/0000-00");
                    </script>

                    <div class="form-group" id="caixaPequena">
                        <label>Numero do Contrato:</label>
                        <input type="number" class="form-control" id="dadosContrato" placeholder="Numero" name="numeroContrato"
                               required value="<?= $numerContrato ?>">
                    </div>

                    <div class="form-group" id="caixaPequena">
                        <label for="AnoContrato">Ano do Contrato:</label>
                        <input type="number" class="form-control" id="dadosContrato" placeholder="Ano do Contrato"
                               name="anoContrato" required value="<?= $anoContrato ?>">
                    </div>

                    <div class="form-group" id="caixaPequena">
                        <label for="dataInicio">Data do Inicio:</label>
                        <input type="Date" class="form-control" id="dadosContrato" placeholder="Data Inicio Contrato"
                               name="dataInicio" required value="<?= $dataInicio ?>">
                    </div>

                    <div class="form-group" id="caixaPequena">
                        <label for="dataFinal">Data do Termino:</label>
                        <input type="Date" class="form-control" id="dadosContrato" placeholder="Data Final Contrato"
                               name="dataFinal" required value="<?= $dataFim ?>">
                    </div>

                    <div class="form-group" id="caixaPequena">
                        <label>Valor:</label>
                        <input type="text" class="form-control" id="dadosContrato" placeholder="Valor do Contrato" name="valor"
                               required value="<?= $valor ?>">
                    </div>

                    <!-- DIV QUE FARÁ LIGAÇÃO DO CONTRATO COM PLANO OPERATIVO
                    
                    <div class="form-group" id="planoOp">
    
                        <div class="form-group" style="width: 49%; display: inline-block; margin-bottom: 0%;" id="">
                            <label>Plano Operativo</label>
                            <select class="form-control">
                                <option>Selecione</option>
                                <option>001/2019 - Virgencia: 31/12/2019</option>
                            </select>
                        </div>
    
                        <div class="form-group" style="width: 49.5%; display: inline-block; margin-bottom: 0%;" id="">
                            <label>Natureza do Contrato</label>
                            <select class="form-control">
                                <option>Plano Operativo</option>
                                <option>Cardiologia</option>
                            </select>
                        </div>
                    </div>
                    -->

                    <div class="form-group">
                        <label for="seleciona">Selecione o Obejto Contrato</label>
                        <select class="form-control" name="selecaoObjeto" id="selecaoObj">
                            <option value="<?= $idObjetoContrato ?>"><?= $descricaoObjetoContrato ?></option>
                        </select>
                    </div>

                    <div class="form-group" id="objContrato">
                        <label>Descrição sobre o contrato:</label>
                        <textarea id="areaDesc" class="form-control" rows="2" id="" name="objContrato"><?= $objContrato ?></textarea>
                    </div>

                    <div id="caixaPequena" style="width: 50%;">
                        <label>Escolha um arquivo</label>
                        <input type="hidden" name="diretorioArquivo" value="<?= $urlarquivo ?>">
                        <input id="dadosContrato" type="file" class="form-control" name="arquivo" id="">
                    </div>

                    <div class="form-group form-check" id="caixaPequena">
                        <label class="form-check-label"> Ativo
                        </label><input class="form-check-input" type="checkbox" name="ativo" <?= $ativo ?>>
                    </div>

                    <div id="caixaPequena">
                        <button type="submit" name="btnEnviarContrato" class="btn btn-primary"
                                id="btnCadastrar"><?= filter_input(INPUT_GET, 'acao') ?></button>                    
                    </div>

                </form>
            </div>
            <script src="../js/funcoes.js" type="text/javascript"></script>

        </div>

        <?php
        if (isset($_POST['btnEnviarContrato'])) {
            if ($idContrato == 0) {
                if ($controllerContrato->incluir()) {
                    ?>
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Cadastrado com sucesso!!!!";
                        document.getElementById("resultado").style.display = 'block';
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);
                    </script>
                    <?php
                } else {
                    ?>        
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Não foi possível fazer o cadastro do Contrato, por favor verifique os dados!";
                        document.getElementById("resultado").style.display = 'block';
                        document.getElementById("resultado").setAttribute("class", "alert alert-danger");
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);

                    </script>
                    <?php
                }
            } else {
                if ($controllerContrato->alterar()) {
                    ?>
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Contrato alterado com sucesso!!!";
                        document.getElementById("resultado").style.display = 'block';
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);
                    </script>
                    <?php
                } else {
                    ?>        
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Não foi possível fazer a alteração do contrato, por favor verifique seus dados ou entre em contato com adminstrador!!";
                        document.getElementById("resultado").style.display = 'block';
                        document.getElementById("resultado").setAttribute("class", "alert alert-danger");
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);

                    </script>
                    <?php
                }
            }
        }
        ?>
    </body>
</html>
