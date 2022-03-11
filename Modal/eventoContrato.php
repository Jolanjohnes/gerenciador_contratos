<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eventoContrato
 *
 * @author Jolanjohnes Duarte
 */
class eventoContrato {
    //put your code here
    private $idEvento;
    private $numeroEvento;
    private $anoEvento;
    private $fk_idContrato;
    private $fk_idEvento;
    private $dataInicio;
    private $dataTermino;
    private $motivo;
    private $valor;
    private $urlArquivo;
    
    function getIdEvento() {
        return $this->idEvento;
    }

    function getNumeroEvento() {
        return $this->numeroEvento;
    }

    function getAnoEvento() {
        return $this->anoEvento;
    }

    function getFk_idContrato() {
        return $this->fk_idContrato;
    }

    function getFk_idEvento() {
        return $this->fk_idEvento;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getDataTermino() {
        return $this->dataTermino;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function getValor() {
        return $this->valor;
    }

    function getUrlArquivo() {
        return $this->urlArquivo;
    }

    function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    function setNumeroEvento($numeroEvento) {
        $this->numeroEvento = $numeroEvento;
    }

    function setAnoEvento($anoEvento) {
        $this->anoEvento = $anoEvento;
    }

    function setFk_idContrato($fk_idContrato) {
        $this->fk_idContrato = $fk_idContrato;
    }

    function setFk_idEvento($fk_idEvento) {
        $this->fk_idEvento = $fk_idEvento;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataTermino($dataTermino) {
        $this->dataTermino = $dataTermino;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setUrlArquivo($urlArquivo) {
        $this->urlArquivo = $urlArquivo;
    }


}
