<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controllerEventoContrato
 *
 * @author Jolanjohnes Duarte
 */
require_once '../Modal/eventoContrato.php';
require_once '../Modal/eventoContratoBanco.php';

class controllerEventoContrato {

    //put your code here
    private $eventosContratos;
    private $eventosContratosBanco;

    public function __construct() {
        $this->eventosContratos = new eventoContrato();
        $this->eventosContratosBanco = new eventoContratoBanco();
    }

    private function upload($nomeUnidade, $tipoEvento, $numeroEvento, $nomeFornecedor, $numeroContrato) {
        try {
            //pega os 4 ultimos caracteres no caso queremos os (.pdf)
            $extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
            //Cria novo nome para o arquivo.               
            $novo_nome = $numeroEvento . " " . $tipoEvento . ' - contr ' . $numeroContrato . ' ' . $nomeFornecedor . $extensao;
            $diretorio = "../ArquivosContratos/eventos/{$nomeUnidade}/";
            //verifica se existe o diretorio, caso nao exista ele cria
            if (!is_dir($diretorio)) {
                mkdir($diretorio);
            }
            //seta para a classe abastrata o valor do diretorio para ser guardado no banco de dados
            $this->eventosContratos->setUrlArquivo($diretorio . $novo_nome);
            //retorna se o upload teve sucesso ou não.
            return move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $novo_nome);
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

     private function deletaArquivo($arquivo) {
        if (file_exists($arquivo)) {
            if (@unlink($arquivo)) {
                return true;
            } else {
                return FALSE;
            }
        }
    }
    
    public function incluir() {

        //Extrai informações das variavel Global $_POST//
        $nomeUnidade = explode("|", filter_input(INPUT_POST, 'nomeUnidade'));
        $idContrato = explode("-", filter_input(INPUT_POST, 'idcontrato'));
        $idEvento = explode("|", filter_input(INPUT_POST, 'comboEvento'));

        //seta os valores para a variavel abastrata
        $this->eventosContratos->setNumeroEvento(filter_input(INPUT_POST, 'numeroEvento'));
        $this->eventosContratos->setAnoEvento(filter_input(INPUT_POST, 'anoEvento'));
        $this->eventosContratos->setDataInicio(filter_input(INPUT_POST, 'dataInicio'));
        $this->eventosContratos->setDataTermino(filter_input(INPUT_POST, 'dataFim'));
        $this->eventosContratos->setMotivo(filter_input(INPUT_POST, 'motivo'));
        if(empty(filter_input(INPUT_POST, 'valorEvento'))){
            $this->eventosContratos->setValor(NULL);
        }else{
            $this->eventosContratos->setValor(filter_input(INPUT_POST, 'valorEvento'));
        }
        
        $this->eventosContratos->setUrlArquivo(null);
        $this->eventosContratos->setFk_idEvento($idEvento[0]);
        $this->eventosContratos->setFk_idContrato($idContrato[0]);

        if ($this->upload($nomeUnidade[1], $idEvento[1], $this->eventosContratos->getNumeroEvento(), $idContrato[1], $idContrato[2])) {
            //print_r($this->eventosContratos);
            return $this->eventosContratosBanco->inserirEvento($this->eventosContratos);
        }
    }
    
    public function alterar() {
         //Extrai informações das variavel Global $_POST//
        $nomeUnidade = explode("|", filter_input(INPUT_POST, 'nomeUnidade'));
        $idContrato = explode("-", filter_input(INPUT_POST, 'idcontrato'));
        $idEvento = explode("|", filter_input(INPUT_POST, 'comboEvento'));

        //seta os valores para a variavel abastrata
        $this->eventosContratos->setNumeroEvento(filter_input(INPUT_POST, 'numeroEvento'));
        $this->eventosContratos->setAnoEvento(filter_input(INPUT_POST, 'anoEvento'));
        $this->eventosContratos->setDataInicio(filter_input(INPUT_POST, 'dataInicio'));
        $this->eventosContratos->setDataTermino(filter_input(INPUT_POST, 'dataFim'));
        $this->eventosContratos->setMotivo(filter_input(INPUT_POST, 'motivo'));
        $this->eventosContratos->setValor(filter_input(INPUT_POST, 'valorEvento'));
        $this->eventosContratos->setUrlArquivo(null);
        $this->eventosContratos->setFk_idEvento($idEvento[0]);
        $this->eventosContratos->setFk_idContrato($idContrato[0]);
        
        
        if (empty($_FILES['arquivo']['name'])){
            $this->eventosContratos->setUrlArquivo(filter_input(INPUT_POST, 'diretorioArquivo'));
        }else{
            $this->deletaArquivo(filter_input(INPUT_POST, 'diretorioArquivo'));
            $this->upload($nomeUnidade[1], $idEvento[1], $this->eventosContratos->getNumeroEvento(), $idContrato[1], $idContrato[2]);
        }        
       // var_dump($this->eventosContratos);
        return $this->eventosContratosBanco->alterarEvento($this->eventosContratos);
        
    }   
    
    public function buscar($codigoEvento){
        $this->eventosContratos->setIdEvento($codigoEvento);
        return $this->eventosContratosBanco->buscarEvento($this->eventosContratos);
    }
    
    public function listar($codigoContrato) {
                
        $this->eventosContratos->setIdEvento($codigoContrato);
        $arrayEventos = $this->eventosContratosBanco->listarEvento($this->eventosContratos);
       // var_dump($arrayEventos);
        return $arrayEventos;
    }
}
