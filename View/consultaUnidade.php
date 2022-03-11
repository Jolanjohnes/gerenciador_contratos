<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//VERIFICA SESSAO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
}
//

require_once '../Controller/controllerUnidade.php';
$controllerUnidade = new controllerUnidade();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciamento Contrato Acqua</title>
        <link rel="stylesheet" href="../css/folha_frames.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    </head>
    <body>

        <header id="cabecarioPagina" class="fixed-top">
            <h1>Consulta Unidades Cadastradas</h1>
        </header>
        <div name="tabela" id="paginas">
            <table id="tabunidade" class="table-sm table table-hover">
                <thead>
                    <tr>
                        <th>Ações</th>
                        <th>Codigo</th>
                        <th>Nome Unidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultado = $controllerUnidade->listar();
                    foreach ($resultado as $value) {
                        ?>
                        <tr>
                            <td><button type="button" class="btn btn-outline-info"><a href="../View/cadastroUnidade.php?acao=Alterar&id=<?php echo $value['idUnidade'] ?>"><img
                                            src="../icones/edit16x16.png" style="padding: 0%; margin: 0%"></a>
                                </button>
                                <button type="button" class="btn btn-outline-info" disabled=""><a href="#"><img
                                            src="../icones/deletar16x16.png" style="padding: 0%; margin: 0%"></a>
                                </button>
                            </td>
                            <td><?php echo $value["idUnidade"]; ?></td>
                            <td><?php echo $value["nome"]; ?></td>

                        </tr>
                    <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <?php
        // put your code here
        ?>
    </body>
</html>
