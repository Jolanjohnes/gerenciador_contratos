<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of unidadeBanco
 *
 * @author Jolanjohnes Duarte
 */
require_once '../init.php';
class unidadeBanco {

    //put your code here

    function __construct() {
        $this->con = new conexao();
        $this->pdo = $this->con->getConection();
    }

    function inserirUnidade(unidade $entUnidade) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO cad_unidade (nome) VALUES (:nomeUnidade);");
            $param = array(":nomeUnidade" => $entUnidade->getNomeUnidade());

            return $stmt->execute($param);
        } catch (Exception $exc) {
            echo "ERRO INSERIR - ". $exc->getMessage();
        }
    }

    function listarUnidade() {
        try {
            $stmt = $this->pdo->prepare("SELECT idUnidade, nome FROM cad_unidade ORDER BY nome");
            $stmt->execute();
            $arrayUnidade = $stmt->fetchALL(PDO::FETCH_ASSOC);
            return $arrayUnidade;
        } catch (Exception $exc) {
            echo "ERRO LISTAR - ". $exc->getMessage();
        }
    }
    
    function deletarUnidade(unidade $entUnidade){
         try {
            $stmt = $this->pdo->prepare("DELETE FROM cad_unidade WHERE idUnidade= :idUnidade;");
            $stmt->bindValue(":idUnidade", $entUnidade->getIdUnidade());
           
            return $stmt->execute();            
           
        } catch (Exception $exc) {
            echo "ERRO DELETAR - ". $exc->getMessage();
        }
    }
    
    function alterarUnidade(unidade $entUnidade){
         try {
            $stmt = $this->pdo->prepare("UPDATE cad_unidade SET nome= :nomeUnidade WHERE idUnidade=:idUnidade;");
            $stmt->bindValue(":nomeUnidade", $entUnidade->getNomeUnidade());
            $stmt->bindValue(":idUnidade", $entUnidade->getIdUnidade());
           
            return $stmt->execute();            
           
        } catch (Exception $exc) {
            echo "ERRO ALTERAR - ". $exc->getMessage();
        }
    }

    function buscarUnidade(unidade $entUnidade){
         try {
            $stmt = $this->pdo->prepare("SELECT * FROM cad_unidade where idUnidade = :idUnidade;");
            $stmt->bindValue(":idUnidade", $entUnidade->getIdUnidade());
            $stmt->execute();
            $arrayUnidade = $stmt->fetchALL(PDO::FETCH_ASSOC);
            return $arrayUnidade;
        } catch (Exception $exc) {
            echo "ERRO BBUSCAR - ". $exc->getMessage();
        }
    }
}
