<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ReqGET = filter_input(INPUT_GET, "file", FILTER_DEFAULT);
// var_dump($ReqGET);

if (empty($ReqGET)) {
    echo "<h4>Não foi possível carregar o arquivo, faça o upload novamente ou entre em contato com o Adminstrator</h4>";
} else {
    $diretorio = explode("/", $ReqGET);
    $filename = $diretorio[4];
    // TIPO DE ARQUIVO          UNIDADE    
    $filepath = "../ArquivosContratos/" . trim($diretorio[2]) . '/' . trim($diretorio[3]) . '/' . $filename;
    Inputheader($filename, $filepath);
}

function Inputheader($Filename, $Filepath) {

    header("Content-disposition: inline; filename = {$Filename}");
    header('Content-type: application/pdf');
    readfile($Filepath);
}
