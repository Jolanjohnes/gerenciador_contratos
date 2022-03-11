<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bancoFornecedor
 *
 * @author acer
 */
require_once '../init.php';

class bancoFornecedor {

    //put your code here

    function __construct() {
        $this->con = new conexao();
        $this->pdo = $this->con->getConection();
    }

    private function verificaCnpj($cnpj) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM cad_fornecedor WHERE cnpj_cpf = :cnpj");
            $stmt->bindValue(":cnpj", $cnpj);
            $stmt->execute();
            $reposta = $stmt->fetchALL(PDO::FETCH_ASSOC);
            if (count($reposta) == 1) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function inserirFornecedor(fornecedor $entFornecedor) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO cad_fornecedor (nomeFantasia, nomeEmpresarial, cnpj_cpf, Status) VALUES (:nomeFantasia, :nomeEmpresarial, :cnpj, :status)");

            $param = array(
                ":nomeFantasia" => $entFornecedor->getNomeFantasia(),
                ":nomeEmpresarial" => $entFornecedor->getNomeEmpresarial(),
                ":cnpj" => $entFornecedor->getCnpj(),
                ":status" => $entFornecedor->getStatus()
            );


            if (!$this->verificaCnpj($entFornecedor->getCnpj())) {
                return $stmt->execute($param);
            }
        } catch (Exception $ex) {
            echo "ERRO INSERIR: {$ex->getMessage()}";
        }
    }

    public function alterarFornecedor(fornecedor $entFornecedor) {
        try {
            $stmt = $this->pdo->prepare("UPDATE cad_fornecedor SET nomeFantasia= :nomeFantasia, nomeEmpresarial= :nomeEmpresarial, cnpj_cpf= :cnpj, Status= :status WHERE idFornecedor= :idFornecedor;");

            $param = array(
                ":nomeFantasia" => $entFornecedor->getNomeFantasia(),
                ":nomeEmpresarial" => $entFornecedor->getNomeEmpresarial(),
                ":cnpj" => $entFornecedor->getCnpj(),
                ":status" => $entFornecedor->getStatus(),
                ":idFornecedor" => $entFornecedor->getIdFornecedor());

            return $stmt->execute($param);
        } catch (Exception $ex) {
            echo "ERRO ATUALIZAR: {$ex->getMessage()}";
        }
    }

    public function listarFornecedor() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM cad_fornecedor ORDER BY nomeEmpresarial ASC;");

            $stmt->execute();
            $arrayFornecedor = $stmt->fetchALL(PDO::FETCH_ASSOC);
            return $arrayFornecedor;
        } catch (Exception $ex) {
            echo "ERRO LISTAR: {$ex->getMessage()}";
        }
    }

    public function buscarFornecedor(fornecedor $entFornecedor) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM cad_fornecedor WHERE idFornecedor = :idFornecedor;");
            $stmt->bindValue(":idFornecedor", $entFornecedor->getIdFornecedor());
            $stmt->execute();
            $arrayFornecedor = $stmt->fetchALL(PDO::FETCH_ASSOC);
            return $arrayFornecedor;
        } catch (Exception $exc) {
            echo "ERRO BUSCAR" . $exc->getMessage();
        }
    }

}
