<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
}
require_once '../Controller/controllerVencimentos.php';
$controllerVenc = new controllerVencimentos();
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
            <h1>Proximos vencimentos</h1>
            <p>Contratos com vencimento menor que 90 dias</p>
        </header>  

        <div id="paginasVencimentos">
            <table id="tabelaVencimentos" class="table table-sm">
                <thead class="">
                <th>Unidade</th>
                <th>Contrato</th>
                <th>Fornecedor</th>
                <th>Vencimento</th>
                </thead>
                <tbody>
                    <?php
                    // put your code here
                    $arrayContrato = $controllerVenc->listar();
                    foreach ($arrayContrato as $value) { ?>
                    <tr>
                        <td><?php echo $value['unidade']; ?></td>
                        <td><?php echo $value['contrato']; ?></td>
                        <td><?php echo $value['fornecedor']; ?></td>
                        <td><?php echo $value['datafim']; ?></td>
                    </tr>
                    
                    <?php
                        
                    }
                    ?>
                </tbody>
            </table>
        </div>


    </body>
</html>
