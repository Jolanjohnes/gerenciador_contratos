<?php
//armazenar em buffer a saída
ob_start();
session_start();
define('ROOT_PATH', dirname(__FILE__));
require_once ROOT_PATH . "/Controller/controllerUsuario.php";
$controllerUsuario = new controllerUsuario();
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
        <link rel="stylesheet" href="css/folha_index.css">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
       
    </head>
    <body>

        <div class="container ">
            <div class="box">
                <div class="cabecario">
                    <h2>Login</h2>
                </div>

                <form class="login100-form validate-form" method="POST" >
                    <div class="inputBox">
                        <input type="text" name="usuario" required="">
                        <label>Usuário</label>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="senha" required="">
                        <label>Senha</label>
                    </div>					
                    <button type="submit" name="logar" value="Entrar">Entrar</button>
                    <div class="links">
                        <label><a href="#">Solicitar Cadastro</a></label>                    
                        <label><a href="#">Recupera Senha</a></label>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['logar'])) {

            $arrayUsuario = $controllerUsuario->validaUsuario();
            //var_dump($arrayUsuario);

            if (count($arrayUsuario) == 1) {
                foreach ($arrayUsuario as $value) {
                  if($value['fk_idPerfil'] == 0){
                        header("Location: home_admin.php");
                    }else if($value['fk_idPerfil'] == 1){
                        header("Location: home_cont.php"); 
                    }else if($value['fk_idPerfil'] == 2){
                          header("Location: home_outros.php"); 
                    }
                    $_SESSION['nomeUsuario'] = $value['nome'];
                    $_SESSION['idUsuario'] = $value['idUsuario'];
                    $_SESSION['usuario'] = $value['usuario'];
                    $_SESSION['perfil'] = $value['fk_idPerfil'];
                   // header("Location: home.php");
                }
            } else {
                header("Location: index.php");
            }
        }
        ?>
    </body>
</html>
