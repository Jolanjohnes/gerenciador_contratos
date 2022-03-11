<?php
session_start();
define('ROOT_PATH', '../');
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
}

require_once ROOT_PATH.'/Controller/controllerUsuario.php';
$controllerUsuario  = new controllerUsuario();

        $idUsuario = $_SESSION['idUsuario'];
    $nomeFuncionario = $_SESSION['nomeUsuario'];
    $usuario =  $_SESSION['usuario'];
    $ativo = "checked";

    

?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/folha_frames.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    </head>
    <body>
        
         <header id="cabecarioPagina" class="fixed-top">
            <h1>Alteração de Senha</h1>
        </header>
        
         <div id="paginas">
            <form method="POST" action="" id="form" name="form">
                <div class="alert alert-success" role="alert" id="resultado">
                    Alterado com Sucesso!!!!
                </div>
                
                <div class="form-group" id="caixaPequena">
                     <label>Código Usuário:</label>
                     <input type="text" class="form-control" id="codigoFornecedor"  name="codigoUsuario" value="<?= $idUsuario ?>">
                </div>

                <div class="form-group">
                    <label>Nome Funcionário</label>
                    <input type="text" class="form-control" id="nomeFuncionario" placeholder="Nome Completo" name="nomeFuncionario" disabled="" value="<?= $nomeFuncionario ?>">
                </div>

                <div class="form-group" id="caixaPequena">
                    <label>Usuário</label>
                    <input type="text" class="form-control" id="usuario" placeholder="Digeite o Usuário" name="usuario" value="<?= $usuario ?>">
                </div>
                <div class="form-group" id="caixaPequena">
                    <label>Senha Antiga:</label>
                    <input type="password" class="form-control" id="senhaAntiga" placeholder="*********" name="senhaAntiga" required>
                </div>
                <div class="form-group" id="caixaPequena">
                    <label>Nova Senha:</label>
                    <input type="password" class="form-control" id="novasenha" placeholder="*********" name="novasenha" required>
                </div>
                <!--
                <div class="form-group" id="caixaPequena">
                    <label>Confirmar Senha:</label>
                    <input type="password" class="form-control" id="confirmaSenha" placeholder="**********" name="confirmaSenha" required onfocus="verificaSenhas()">
                </div>-->
                
                <div class="form-group form-check" id="">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="status" <?= $ativo ?>> Ativo
                    </label>   
                </div>
                <button type="submit" name="btlAlteraSenha" class="btn btn-primary">Alterar</button>
            </form>
        </div>
        
        <?php
        // put your code here
        if(isset($_POST['btlAlteraSenha'])){
            if($idUsuario != 0){
                if($controllerUsuario->altera()){
                    ?>
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Senha aterada com sucesso!!!!";
                        document.getElementById("resultado").style.display = 'block';
                        setTimeout(function () {
                            document.getElementById("resultado").style.display = 'none';
                        }, 2000);

                    </script>
                    <?php
                }else{
                     ?>        
                    <script type="text/javascript">
                        document.getElementById("resultado").innerHTML = "Erro ao Alterar Senha!!";
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
