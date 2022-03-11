<?php
//VERIFICA SESSAO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
}
//

require_once '../Controller/controllerUnidade.php';
$controllerUnidade = new controllerUnidade();

if (filter_input(INPUT_GET, 'acao') === 'Cadastrar' && filter_input(INPUT_GET, 'id') == 0) {
    $nomeUnidade = "";
    $idUnidade = 0;
} else {
    $idUnidade = $_GET['id'];
    $arrayUnidade = $controllerUnidade->buscar($idUnidade);
    foreach ($arrayUnidade as $value) {
        $nomeUnidade = $value['nome'];
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

    </head>
    <body>
        <header id="cabecarioPagina" class="fixed-top">
            <h1>Cadastro Unidade</h1>
        </header>
        <div id="paginas">
            <form method="POST" action="" class="needs-validation" novalidate>
                <div class="form-group">
                    <div class="alert alert-success" role="alert" id="resultado">
                        Cadastrado com Sucesso!!!!
                    </div>
                    <div class="input-group-prepend">

                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="codigoUnidade" name="codigoUnidade" value="<?= $idUnidade ?>">
                    </div>

                    <div class="form-group">
                        <label>Nome Unidade:</label>
                        <input type="text" class="form-control" id="nomeEmp" placeholder="Nome Unidade" name="nomeUnidade" required value="<?= $nomeUnidade ?>">
                    </div>

                </div>
                <button type="submit" name="btnEnviar" class="btn btn-primary"><?= $_GET['acao'] ?></button>
            </form>
        </div>
        <?php
// put your code here

        if (isset($_POST['btnEnviar'])) {
            if ($_POST['codigoUnidade'] == 0) {
                if ($controllerUnidade->incluir()) {
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
                        document.getElementById("resultado").innerHTML = "Unidade não Cadastrada!!";
                        document.getElementById("resultado").style.display = 'block';
                        document.getElementById("resultado").setAttribute("class", "alert alert-danger");
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);

                    </script>
                    <?php
                }
            } else {
                //echo "<script>window.alert('Alterar')</script>";
                //chamar codigo de alteração.
                if ($controllerUnidade->alterar()) {
                    ?>
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Alterado com sucesso!!!!";
                        document.getElementById("resultado").style.display = 'block';
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);
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
                        }, 2000);

                    </script>
                    <?php
                }
            }
        }
        ?>
    </body>
</html>
