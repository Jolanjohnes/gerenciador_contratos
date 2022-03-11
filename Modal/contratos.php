<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contratos
 *
 * @author Jolanjohnes Duarte
 */
class contratos {

    //put your code here
    private $idContratos;
    private $numeroContrato;
    private $anoContrato;
    private $dataInicio;
    private $dataTermino;
    private $status;
    private $valor;
    private $idObjeto;
    private $objetoContrato;
    private $idUnidade;
    private $idFornecedor;
    private $urlAquivo;

    function getIdContratos() {
        return $this->idContratos;
    }

    function getNumeroContrato() {
        return $this->numeroContrato;
    }

    function getAnoContrato() {
        return $this->anoContrato;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getDataTermino() {
        return $this->dataTermino;
    }

    function getStatus() {
        return $this->status;
    }

    function getValor() {
        return $this->valor;
    }

    function getObjetoContrato() {
        return $this->objetoContrato;
    }

    function getIdUnidade() {
        return $this->idUnidade;
    }

    function getIdFornecedor() {
        return $this->idFornecedor;
    }

    function getUrlAquivo() {
        return $this->urlAquivo;
    }

    function setIdContratos($idContratos) {
        $this->idContratos = $idContratos;
    }

    function setNumeroContrato($numeroContrato) {
        $this->numeroContrato = $numeroContrato;
    }

    function setAnoContrato($anoContrato) {
        $this->anoContrato = $anoContrato;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataTermino($dataTermino) {
        $this->dataTermino = $dataTermino;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setObjetoContrato($objetoContrato) {
        $this->objetoContrato = $objetoContrato;
    }

    function setIdUnidade($idUnidade) {
        $this->idUnidade = $idUnidade;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setUrlAquivo($urlAquivo) {
        $this->urlAquivo = $urlAquivo;
    }

    function getIdObjeto() {
        return $this->idObjeto;
    }

    function setIdObjeto($idObjeto) {
        $this->idObjeto = $idObjeto;
    }

}
