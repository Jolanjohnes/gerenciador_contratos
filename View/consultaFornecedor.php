<?php
//VERIFICA SESSAO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
}
//

require_once '../Controller/controllerFornecedor.php';
$controllerFornecedor = new controllerFornecedor();
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
        <title>Gerenciamento Contrato Acqua</title>
        <link rel="stylesheet" href="../css/folha_frames.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    </head>
    <body>
        <header id="cabecarioPagina" class="fixed-top">
            <h1>Consulta Fornecedores Cadastrados</h1>
        </header>
        
        <div id="paginas" >
            <div name="tabela" id="tabela">
            <table id="tabunidade" class="table-sm table table-hover ">
                <thead>
                    <tr>
                        <th>Ações</th>
                        <th>Codigo</th>
                        <th>Nome Empresarial</th>
                        <th>CNPJ</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultado = $controllerFornecedor->listar();
                    foreach ($resultado as $value) {
                        ?>
                        <tr>
                            <td><button type="button" class="btn btn-outline-info"><a href="../View/cadastroFornecedor.php?acao=Alterar&id=<?php echo $value['idFornecedor'] ?>"><img
                                            src="../icones/edit16x16.png" style="padding: 0%; margin: 0%"></a>
                                </button>
                                <button type="button" class="btn btn-outline-info" disabled><a href="#"><img
                                            src="../icones/deletar16x16.png" style="padding: 0%; margin: 0%"></a>
                                </button>
                            </td>
                            <td><?php echo $value["idFornecedor"]; ?></td>
                            <td><?php echo $value["nomeEmpresarial"]; ?></td>
                            <td><?php echo $value["cnpj_cpf"]; ?></td>

                        </tr>
                    <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>

        </div>
    
        <?php
        // put your code here
        ?>
    </body>
</html>
