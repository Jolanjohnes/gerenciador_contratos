<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controllerUsuario
 *
 * @author acer
 */
require_once ROOT_PATH . '/Modal/usuario.php';
require_once ROOT_PATH . '/Modal/usuarioBanco.php';

class controllerUsuario {

    //put your code here
    private $usuario;
    private $usuarioBanco;

    function __construct() {
        $this->usuario = new usuario();
        $this->usuarioBanco = new usuarioBanco();
    }

    public function validaUsuario() {

        $this->usuario->setUsuario(filter_input(INPUT_POST, 'usuario'));
        $this->usuario->setSenha(filter_input(INPUT_POST, 'senha'));

        return $this->usuarioBanco->buscarUsuario($this->usuario);
    }

    public function altera() {
        
        $this->usuario->setIdUsuario(filter_input(INPUT_POST, 'codigoUsuario'));
        $this->usuario->setUsuario(filter_input(INPUT_POST, 'usuario'));
        $this->usuario->setSenha(filter_input(INPUT_POST, 'senhaAntiga'));

        $novaSenha = filter_input(INPUT_POST, 'novasenha');
        $arrayUsuario = $this->usuarioBanco->buscarUsuario($this->usuario);

        if (count($arrayUsuario) > 0) {
            $this->usuario->setSenha($novaSenha);
            return $this->usuarioBanco->alterarSenha($this->usuario);
        } else {
            echo "<script>window.alert('Senha antiga não confere');</script>";
        }
    }

}
