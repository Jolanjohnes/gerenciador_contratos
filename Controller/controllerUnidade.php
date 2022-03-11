<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controllerUnidade
 *
 * @author Jolanjohnes Duarte
 */
require_once '../Modal/unidade.php';
require_once '../Modal/unidadeBanco.php';

class controllerUnidade {

    //put your code here

    private $unidade;
    private $unidadeBanco;

    function __construct() {
        $this->unidade = new unidade();
        $this->unidadeBanco = new unidadeBanco();
    }
    
    public function incluir() {
        $this->unidade->setNomeUnidade(filter_input(INPUT_POST,'nomeUnidade' ));
        return $this->unidadeBanco->inserirUnidade($this->unidade);
    }
    
    public function alterar(){
        $this->unidade->setIdUnidade(filter_input(INPUT_POST, 'codigoUnidade'));
        $this->unidade->setNomeUnidade(filter_input(INPUT_POST,'nomeUnidade'));
        return $this->unidadeBanco->alterarUnidade($this->unidade);
    }


    public function deletar(){
        $this->unidade->setIdUnidade(filter_input(INPUT_POST, 'codigoUnidade'));
        return $this->unidadeBanco->deletarUnidade($this->unidade);
    }

    public function listar(){        
       $arrayUnidade = $this->unidadeBanco->listarUnidade();
       return($arrayUnidade);
    }
    
    public function buscar($codigoUnidade){
       $this->unidade->setIdUnidade($codigoUnidade);
         return $this->unidadeBanco->buscarUnidade($this->unidade);
    }
    

}
