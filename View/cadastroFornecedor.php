<?php

//VERIFICA SESSAO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
}
//
require_once '../Controller/controllerFornecedor.php';
$controllerFornecedor = new controllerFornecedor();

if (filter_input(INPUT_GET, 'acao') === 'Cadastrar' && filter_input(INPUT_GET, 'id') == 0) {
    $idFornecedor = 0;
    $nomeEmpresarial = "";
    $nomeFantasia = "";
    $cnpj = "";
    $ativo = "";
    $ativaCampo = "";
} else {
    $idFornecedor = filter_input(INPUT_GET, 'id');
    $ativaCampo = "disabled";
    $arrayFornecedor = $controllerFornecedor->buscar($idFornecedor);

    foreach ($arrayFornecedor as $value) {
        $nomeEmpresarial = $value['nomeEmpresarial'];
        $nomeFantasia = $value['nomeFantasia'];
        $cnpj = $value['cnpj_cpf'];

        if ($value['Status'] == 1) {
            $ativo = "checked";
        } else {
            $ativo = "";
        }
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
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/folha_frames.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    </head>
    <body>
        <header id="cabecarioPagina" class="fixed-top">
            <h1>Cadastro de Fornecedores</h1>
        </header>

        <div id="paginas">
            <form method="POST" action="" id="form" name="form">
                <div class="alert alert-success" role="alert" id="resultado">
                    Cadastrado com Sucesso!!!!
                </div>

                <div class="form-group">
                    <input type="hidden" class="form-control" id="codigoFornecedor"  name="codigoFornecedor" value="<?= $idFornecedor ?>">
                </div>

                <div class="form-group">
                    <label>Nome Empresarial:</label>
                    <input type="text" class="form-control" id="nomeEmp" placeholder="Nome Empresarial" name="nomeEmpresarial" required value="<?= $nomeEmpresarial ?>">
                </div>

                <div class="form-group">
                    <label for="NomeFantasia">Nome Fantasias:</label>
                    <input type="text" class="form-control" id="nomeFant" placeholder="Nome Fantasia" name="nomeFantasia" required value="<?= $nomeFantasia ?>">
                </div>


                <div class="form-group" id="caixaPequena">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" class="form-control" id="cnpj" placeholder="00.000.000/0000-00" name="cnpj" required value="<?= $cnpj ?>" <?= $ativaCampo ?>>
                </div>
                <script type="text/javascript">
                    $("#telefone, #cnpj").mask("00.000.000/0000-00");
                </script>

                <div class="form-group form-check" id="">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="status" <?= $ativo ?>> Ativo
                    </label>   
                </div>

                <button type="submit" name="btnEnviar" class="btn btn-primary"><?= filter_input(INPUT_GET, 'acao') ?></button>
            </form>
        </div>
        <?php
        if (isset($_POST['btnEnviar'])) {
            if ($idFornecedor == 0) {
                if ($controllerFornecedor->incluir()) {
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
                        document.getElementById("resultado").innerHTML = "Erro ao fazer cadastrado do fornecedor!!";
                        document.getElementById("resultado").style.display = 'block';
                        document.getElementById("resultado").setAttribute("class", "alert alert-danger");
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);

                    </script>
                    <?php
                }
            } else {
                if ($controllerFornecedor->alterar()) {
                    ?>
                    <script>
                        document.getElementById('resultado').innerHTML = 'Alterado com sucesso!!!!';
                        document.getElementById('resultado').style.display = 'block';
                        setTimeout(function () {
                            document.getElementById('resultado').style.display = 'none';
                        }, 1500);

                    </script>
                    <?php
                } else {
                    ?>        
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Não foi possivel fazer a atulização da Unidade";
                        document.getElementById("resultado").style.display = 'block';
                        document.getElementById("resultado").setAttribute("class", "alert alert-danger");
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 1500);

                    </script>
                    <?php
                }
            }
        }
        ?>
    </body>

</html>
