<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controllerFornecedor
 *
 * @author Jolanjohnes Duarte
 */
require_once '../Modal/fornecedor.php';
require_once '../Modal/fornecedorBanco.php';

class controllerFornecedor {

    //put your code here

    private $fornecedor;
    private $bancoFornecedor;

    public function __construct() {
        $this->fornecedor = new fornecedor();
        $this->bancoFornecedor = new bancoFornecedor();
    }

    public function incluir() {
        $this->fornecedor->setNomeEmpresarial($_POST['nomeEmpresarial']);
        $this->fornecedor->setNomeFantasia($_POST['nomeFantasia']);
        $this->fornecedor->setCnpj($_POST['cnpj']);
        $this->fornecedor->setStatus(1);
                return $this->bancoFornecedor->inserirFornecedor($this->fornecedor);
    }

    public function alterar() {
        $this->fornecedor->setIdFornecedor($_POST['codigoFornecedor']);
        $this->fornecedor->setNomeEmpresarial($_POST['nomeEmpresarial']);
        $this->fornecedor->setNomeFantasia($_POST['nomeFantasia']);
        //$this->fornecedor->setCnpj($_POST['cnpj']);
       // $this->fornecedor->setStatus(1);
        
       return  $this->bancoFornecedor->alterarFornecedor($this->fornecedor);
    }

    public function listar() {
        $arrayForneedor = $this->bancoFornecedor->listarFornecedor();
        return $arrayForneedor;
    }

    public function buscar($codigoFornecedor) {
        $this->fornecedor->setIdFornecedor($codigoFornecedor);
        return $this->bancoFornecedor->buscarFornecedor($this->fornecedor);
    }

}
