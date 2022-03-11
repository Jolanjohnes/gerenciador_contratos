<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controllerContratos
 *
 * @author Jolanjohnes Duarte
 */
require_once '../Modal/contratos.php';
require_once '../Modal/contratosBanco.php';

class controllerContratos {

    //put your code here
    private $contratos;
    private $contratosBanco;

    public function __construct() {
        $this->contratos = new contratos();
        $this->contratosBanco = new contratosBanco();
    }

    private function upload($nomeUnidade, $nomeFornecedor, $numeroContrato, $anoContrato) {
        try {
            if (!empty($_FILES['arquivo']['name'])) {
                $extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
                $novo_nome = "contrato-" . $numeroContrato . '.' . $anoContrato . '-' . $nomeFornecedor . $extensao;
                $diretorio = "../ArquivosContratos/contratos/{$nomeUnidade}/";
                if (!is_dir($diretorio)) {
                    mkdir($diretorio);
                }
                $this->contratos->setUrlAquivo($diretorio . $novo_nome);
                return move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $novo_nome);
            } else {
                return false;
            }
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
        $situacao = (filter_input(INPUT_POST, 'ativo') == 'on') ? true : false;
        $idUnidade = explode("|", filter_input(INPUT_POST, 'nomeUnidade'));
        $idFornecedor = explode("|", filter_input(INPUT_POST, 'codigoFornecedor'));
        $idObjetoContrato  = explode("|", filter_input(INPUT_POST, 'selecaoObjeto'));

        //atribui as variaveis da classe abastrata//
        $this->contratos->setIdUnidade($idUnidade[0]);
        $this->contratos->setIdFornecedor($idFornecedor[0]);
        $this->contratos->setNumeroContrato(filter_input(INPUT_POST, 'numeroContrato'));
        $this->contratos->setAnoContrato(filter_input(INPUT_POST, 'anoContrato'));
        $this->contratos->setDataInicio(filter_input(INPUT_POST, 'dataInicio'));
        $this->contratos->setDataTermino(filter_input(INPUT_POST, 'dataFinal'));
        $this->contratos->setValor(filter_input(INPUT_POST, 'valor'));
        $this->contratos->setIdObjeto($idObjetoContrato[0]);
        $this->contratos->setObjetoContrato(filter_input(INPUT_POST, 'objContrato'));

        $this->contratos->setStatus($situacao);

        if ($this->upload($idUnidade[1], $idFornecedor[1], $this->contratos->getNumeroContrato(), $this->contratos->getAnoContrato())) {
            //executa o codigo de cadastramento//
            //print_r($this->contratos);
            return $this->contratosBanco->inserirContrato($this->contratos);
        } else {
            $this->contratos->setUrlAquivo(NULL);
            return  $this->contratosBanco->inserirContrato($this->contratos);
        }
    }

    public function alterar() {
        //Extrai informações das variavel Global $_POST//
        $situacao = (filter_input(INPUT_POST, 'ativo') == 'on') ? true : false;
        $idUnidade = explode("|", filter_input(INPUT_POST, 'nomeUnidade'));
        $idFornecedor = explode("|", filter_input(INPUT_POST, 'codigoFornecedor'));

        //atribui as variaveis da classe abastrata//
        $this->contratos->setIdContratos(filter_input(INPUT_POST, 'codigoContrato'));
        $this->contratos->setIdUnidade($idUnidade[0]);
        $this->contratos->setIdFornecedor($idFornecedor[0]);
        $this->contratos->setNumeroContrato(filter_input(INPUT_POST, 'numeroContrato'));
        $this->contratos->setAnoContrato(filter_input(INPUT_POST, 'anoContrato'));
        $this->contratos->setDataInicio(filter_input(INPUT_POST, 'dataInicio'));
        $this->contratos->setDataTermino(filter_input(INPUT_POST, 'dataFinal'));
        $this->contratos->setValor(filter_input(INPUT_POST, 'valor'));
        $this->contratos->setObjetoContrato(filter_input(INPUT_POST, 'objContrato'));
        $this->contratos->setStatus($situacao);
        //verifficar se existe arquivo selecionado, deletar, fazer o upload
        if (empty($_FILES['arquivo']['name'])) {
            $this->contratos->setUrlAquivo(filter_input(INPUT_POST, 'diretorioArquivo'));
        } else {
            $this->deletaArquivo(filter_input(INPUT_POST, 'diretorioArquivo'));
            $this->upload($idUnidade[1], $idFornecedor[1], $this->contratos->getNumeroContrato(), $this->contratos->getAnoContrato());
        }

        // var_dump($this->contratos);
        return $this->contratosBanco->alterarContrato($this->contratos);
    }

    public function buscar($codigoContrato) {
        $this->contratos->setIdContratos($codigoContrato);
        return $this->contratosBanco->buscarContrato($this->contratos);
    }

    public function listar() {
        if (filter_input(INPUT_POST, 'nomeUnidade') == 0) {
            $this->contratos->setIdUnidade(null);
        } else {
            $idUnidade = explode("|", filter_input(INPUT_POST, 'nomeUnidade'));
            $this->contratos->setIdUnidade($idUnidade[0]);
        }
        if (empty(filter_input(INPUT_POST, 'codigoFornecedor'))) {
            $this->contratos->setIdFornecedor(null);
        } else {
            $idFornecedor = explode("|", filter_input(INPUT_POST, 'codigoFornecedor'));
            $this->contratos->setIdFornecedor($idFornecedor[0]);
        }

        $arrayContrato = $this->contratosBanco->listarContrato($this->contratos);
        return $arrayContrato;
    }

}
