<?php
//VERIFICA SESSAO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
}
//


require_once '../Controller/controllerEventoContrato.php';
$controllerEventosContratos = new controllerEventoContrato();

if (filter_input(INPUT_GET, 'acao') == 'Cadastrar' && filter_input(INPUT_GET, 'id') == 0) {
    $idEvento = "";
    $nomeUnidade = "Selecione a unidade";
    $contrato = "Selecione um contrato";
    $evento = "Selecione um tipo evento";
    $numeroContrato = "";
    $anoEvento = "";
    $datainicio = "";
    $datafim = "";
    $valor = "";
    $motivo = "";
    $urlarquivo = "";
} else {
    $idEvento = filter_input(INPUT_GET, 'id');
    $arrayEventoContrato = $controllerEventosContratos->buscar($idEvento);
    $arrayUnidade;
    $arrayContrato;
    $arrayEvento;

    foreach ($arrayEventoContrato as $value) {
        $arrayUnidade = explode("|", $value['unidade']);
        $arrayContrato = explode('-', $value['Contrato']);
        $arrayEvento = explode("|", $value['Evento']);
        $numeroContrato = $value['numeroEvento'];
        $anoEvento = $value['anoEvento'];
        $datainicio = $value['dataInicio'];
        $datafim = $value['dataFim'];
        $valor = $value['valor'];
        $motivo = $value['motivo'];
        $urlarquivo = $value['urlArquivo'];
    }



    $nomeUnidade = $arrayUnidade[1];
    $contrato = $arrayContrato[1] . ' - ' . $arrayContrato[2];
    $evento = $arrayEvento[1];
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
    </head>
    <body>

        <header id="cabecarioPagina" class="fixed-top">
            <h1>Cadastro Eventos Contrato</h1>
        </header>
        <div id="paginas">
            <form method="POST" action="" class="needs-validation" enctype = "multipart/form-data">

                <div class="alert alert-success" role="alert" id="resultado">
                    Cadastrado com Sucesso!!!!
                </div>

                <div class="form-group">
                    <input type="hidden" class="form-control" id="codigoContrato"  name="codigoContrato" value="<?= $idEvento ?>">
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

               
                <div class="form-group">
                    <label id="seleciona">Centro de Custo:</label>
                    <select id="selecao" class="form-control" name="nomeUnidade">
                        <option value="<?= $arrayUnidade[0] . '|' . $arrayUnidade[1] ?>"><?= $nomeUnidade ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label id="seleciona">Contrato:</label>
                    <select id="selecao" class="form-control" name="idcontrato">
                        <option value="<?= $arrayContrato[0] . '-' . $arrayContrato[1] . '-' . $arrayContrato[2] ?>"><?= $contrato ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label id="seleciona">Evento Contrato:</label>
                    <select id="selecao" class="form-control" name="comboEvento">
                        <option value="<?= $arrayEvento[0] . '|' . $arrayEvento[1] ?>"><?= $evento ?></option>
                    </select>
                </div>

                <div id="caixaPequena">
                    <label>Numero Evento:</label>
                    <input  id="dadosContrato" type="number" placeholder="" class="form-control" name="numeroEvento" value="<?= $numeroContrato ?>">
                </div>

                <div id="caixaPequena">
                    <label>Ano Evento:</label>
                    <input id="dadosContrato" type="number" class="form-control" name="anoEvento" value="<?= $anoEvento ?>">
                </div>

                <div id="caixaPequena">
                    <label>Data Inicio:</label>
                    <input type="date" class="form-control" name="dataInicio" value="<?= $datainicio ?>">
                </div>

                <div id="caixaPequena">
                    <label>Data Fim:</label>
                    <input id="dadosContrato" type="date" class="form-control" name="dataFim" value="<?= $datafim ?>">
                </div>

                <div id="caixaPequena">
                    <label>Novo Valor:</label>
                    <input id="dadosContrato" type="Number" placeholder="0,00" class="form-control" name="valorEvento" value="<?= $valor ?>">
                </div>

                <div class="form-group" id="Motivo">
                    <label>Motivo</label>
                    <textarea class="form-control" rows="2" id="" name="motivo"><?= $motivo ?></textarea>
                </div>

                <div id="caixaPequena" style="width: 50%;">
                    <label>Escolha um arquivo</label>
                    <input type="hidden" name="diretorioArquivo" value="<?= $urlarquivo ?>">
                    <input id="dadosContrato" type="file" class="form-control" name="arquivo" id="">
                </div>

                <div class="form-group" id="caixaPequena">
                    <button type="submit" name="btnEnviarEvento" class="btn btn-primary"
                            id="btnCadastrar"><?= filter_input(INPUT_GET, 'acao') ?></button>
                </div>

            </form>
        </div>

        <script src="../js/funcoes.js" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


        <?php
// put your code here

        if (isset($_POST['btnEnviarEvento'])) {
            if ($idEvento == 0) {
                if ($controllerEventosContratos->incluir()) {
                    ?>
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Cadastrado com sucesso!!!!";
                        document.getElementById("resultado").style.display = 'block';
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);
                    </script>

                    <?php
                    unset($_POST['btnEnviarEvento']);
                } else {
                    ?>        
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Evento Contrato não Cadastrado!!";
                        document.getElementById("resultado").style.display = 'block';
                        document.getElementById("resultado").setAttribute("class", "alert alert-danger");
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);

                    </script>
                    <?php
                }
            } else {
                if ($controllerEventosContratos->alterar()) {
                    ?>
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Evento contrato alterado com sucesso!!!";
                        document.getElementById("resultado").style.display = 'block';
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);
                    </script>

                    <?php
                } else {
                    ?>        
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Não foi possível alterar o evento, por favor verifique seus dados, ou entre em contato com adminstrador!!";
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

