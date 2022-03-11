<?php

//VERIFICA SESSAO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
}
//
require_once '../Controller/controllerContratos.php';
$controllerContrato = new controllerContratos();
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


        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    </head>
    <body>
        <header id="cabecarioPagina" class="fixed-top">
            <h1>Consulta Contrato</h1>
        </header>

        <div id="paginas">
            <form method="POST" action="" class="needs-validation" novalidate>
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
                    <label id="seleciona">Centro de Custo</label>
                    <select id="selecao" class="form-control" name="nomeUnidade">
                        <option value="0">Selecione a unidade</option>
                    </select>
                </div>
                <div class="form-group" id="">
                    <label id="seleciona">Cnpj Fornecedor:</label>
                    <input type="text" class="form-control" id="cnpjContrato" placeholder="00.000.000/0000-00"
                           name="cnpjContrato" onfocus="" required="requided">
                    <input type="hidden" id="codigoFornecedor" name="codigoFornecedor">
                    <label id="nomeFornecedor" name="nomeFornecedor" style="font-weight: bold"></label>
                </div>
                <script type="text/javascript">
                    $("#telefone, #cnpjContrato").mask("00.000.000/0000-00");
                </script>
                
                <button type="submit" name="btnBuscar" class="btn btn-primary" style="width: 100px;"><span class="glyphicon glyphicon-filter"></span>Filtar</button>
            </form>
            <script src="../js/funcoes.js" type="text/javascript"></script>           
        </div>

        <div id="tabela">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Ações</th>
                        <th>Nome fornecedor</th>
                        <th>Unidade</th>
                        <th>    Contrato</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['btnBuscar'])) {
                        $unidade = filter_input(INPUT_POST, 'nomeUnidade', FILTER_SANITIZE_NUMBER_INT);
                        $fornecedor = filter_input(INPUT_POST, 'cnpjContrato', FILTER_SANITIZE_STRING);

                        if (empty($unidade) && empty($fornecedor)) {
                            echo "<script>window.alert('Necessário preencher no minimo um campo')</script>";
                        } else {


                            $resultado = $controllerContrato->listar();
                            foreach ($resultado as $value) {
                                ?>
                                <tr id="contrato"   >
                                    <td><button style="padding: 0px; border: none;margin: 2px;"  id="btnacao" type="button" class="btn btn-outline-info" ><a href="../View/cadastroContrato.php?acao=Alterar&id=<?php echo $value['idContrato'] ?>"><img
                                                    src="../icones/edit16x16.png" style="padding: 0%; margin: 0%"></a>
                                        </button>
                                        <button style="padding: 0px; border: none; margin: 2px;"  id="btnacao" type="button" class="btn btn-outline-info" id="btnVisualizar" data-toggle="modal"
                                                data-target="#detalhe<?php echo $value["idContrato"]; ?>"> <img
                                                src="../icones/detalhe16x16.png" alt="">
                                        </button>
                                        <button style="padding: 0px; border: none;margin: 2px;"  id="btnacao" type="button" class="btn btn-outline-info">
                                            <a href="../php/visualizaArquivo.php?file= <?php echo $value['urlArquivo']; ?>" target="_blank">
                                                <img src="../icones/visualizar16x16.png" alt=""></a>
                                        </button>
                                        <button style="padding: 0px; border: none;margin: 2px;" id="btnacao" type="button" class="btn btn-outline-info" disabled=""><a href="#"><img
                                                    src="../icones/deletar16x16.png" style="padding: 0%; margin: 0%"></a>
                                        </button>

                                    </td>
                                    <td style="font-size: 10pt;"><?php echo $value["nomeEmpresarial"]; ?></td>
                                    <td style="font-size: 10pt;"><?php echo $value["unidade"]; ?></td>
                                    <td style="font-size: 10pt;"><?php echo $value["Contrato"]; ?></td>
                                    <td style="font-size: 10pt;"><?php echo 'R$ ' . number_format($value["valor"], 2, ',', '.'); ?></td>

                                </tr>

                                <!-- Modal -->
                            <div class="modal fade" id="detalhe<?php echo $value["idContrato"]; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Eventos Contratos</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            require_once '../Controller/controllerEventoContrato.php';
                                            $controllerEVentos = new controllerEventoContrato();

                                            $resultadoEvento = $controllerEVentos->listar($value["idContrato"]);


                                            if (count($resultadoEvento) > 0) {
                                                ?>
                                                <?php foreach ($resultadoEvento as $eventos) { ?>
                                                    <div id="blocopopup">
                                                        <div>
                                                            <p style="display: inline-block; width: 120px;">Codigo Evento:</p>
                                                            <p style="display: inline-block; width: 300px;">
                                                                <strong><?php echo utf8_encode($eventos["idEventoContrato"]); ?></strong></p>
                                                        </div>

                                                        <div>
                                                            <p style="display: inline-block; width: 120px;">Numero Evento:</p>
                                                            <p style="display: inline-block; width: 300px;">
                                                                <strong><?php echo utf8_encode($eventos["numeroEvento"]); ?></strong></p>
                                                        </div>

                                                        <div>
                                                            <p style="display: inline-block; width: 120px;">Tipo Evento:</p>
                                                            <p style="display: inline-block; width: 300px;">
                                                                <strong><?php echo utf8_encode($eventos["nomeEvento"]); ?></strong></p>
                                                        </div>

                                                        <div>
                                                            <p style="display: inline-block; width: 120px;">Data Incio:</p>
                                                            <p style="display: inline-block; width: 300px;">
                                                                <strong><?php echo date('d/m/Y', strtotime($eventos["dataInicio"])); ?></strong>
                                                            </p>
                                                        </div>

                                                        <div>
                                                            <p style="display: inline-block; width: 120px;">Data Fim:</p>
                                                            <p style="display: inline-block; width: 300px;">
                                                                <strong><?php echo date('d/m/Y', strtotime($eventos["DataFim"])); ?></strong>
                                                            </p>
                                                        </div>

                                                        <div>
                                                            <p style="display: inline-block; width: 120px;">Motivo:</p>
                                                            <p style="display: inline-block; width: 300px;">
                                                                <strong><?php echo ($eventos["Motivo"]); ?></strong></p>
                                                        </div>

                                                        <div>
                                                            <p style="display: inline-block; width: 120px;">Valor:</p>
                                                            <p style="display: inline-block; width: 300px;">
                                                                <strong><?php echo 'R$ ' . number_format($eventos["valor"], 2, ',', '.'); ?></strong>
                                                            </p>
                                                        </div>

                                                        <button type="button" class="btn btn-outline-info">
                                                            <a href="../php/visualizaArquivo.php?file= <?php echo $eventos['urlArquivo']; ?>" target="_blank">
                                                                <img src="../icones/visualizar16x16.png" alt=""></a>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-info"><a href="../View/cadastroEventoContrato.php?acao=Alterar&id=<?php echo $eventos['idEventoContrato'] ?>"><img
                                                                    src="../icones/edit16x16.png" style="padding: 0%; margin: 0%"></a>
                                                        </button>



                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <p>Contrato não possui Eventos</p>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <?php
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
// put your code here
        ?>
    </body>

</html>
