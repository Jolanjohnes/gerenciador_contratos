<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controllerVencimentos
 *
 * @author acer
 */
require_once '../Modal/contratosBanco.php';
require_once '../Modal/eventoContratoBanco.php';

class controllerVencimentos {

    //put your code here
    private $contratosBanco;
    private $eventosBanco;

    function __construct() {
        $this->contratosBanco = new contratosBanco();
        $this->eventosBanco = new eventoContratoBanco();
    }

    public function listar() {
        $arrayContrato = $this->contratosBanco->listarContratosVencidos();
        $arrayContratoVenc = array();

        if (count($arrayContrato) > 0) {
            foreach ($arrayContrato as $value) {
                $arrayEvento = $this->eventosBanco->listarEventosVencidos($value['idContrato']);
                if (count($arrayEvento) > 0) {
                  //  echo date('Y-m-d', strtotime("+90 day"))."<br />";
                    foreach ($arrayEvento as $value1) {
                        if ($value1['datafim'] < date('Y-m-d', strtotime("+90 day")) && $value1['fk_idEvento'] != 4) {
                            //print_r($arrayEvento);//
                            array_push($arrayContratoVenc, array('unidade' => $value1['unidade'],
                                'contrato' => $value1['contrato'],
                                'fornecedor' => $value1['nomeEmpresarial'],
                                'datafim' => $value1['datafim']));
                            //$arrayContratoVenc['idContrato'] = $value1['unidade'];
                        }
                    }
                } else {
                    array_push($arrayContratoVenc, array('unidade' => $value['unidade'],
                        'contrato' => $value['contrato'],
                        'fornecedor' => $value['nomeEmpresarial'],
                        'datafim' => $value['dataTermino']));
                }
            }
        }
        return $arrayContratoVenc;
    }

}
