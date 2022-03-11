<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fornecedor
 *
 * @author Jolanjohnes Duarte
 */

class fornecedor {
    //put your code here
    private $idFornecedor;
    private $nomeFantasia;
    private $nomeEmpresarial;
    private $cnpj;
    private $status;
    
    function getNomeFantasia() {
        return $this->nomeFantasia;
    }

    function getNomeEmpresarial() {
        return $this->nomeEmpresarial;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getStatus() {
        return $this->status;
    }

    function setNomeFantasia($nomeFantasia) {
        $this->nomeFantasia = $nomeFantasia;
    }

    function setNomeEmpresarial($nomeEmpresarial) {
        $this->nomeEmpresarial = $nomeEmpresarial;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getIdFornecedor() {
        return $this->idFornecedor;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }


    
}
