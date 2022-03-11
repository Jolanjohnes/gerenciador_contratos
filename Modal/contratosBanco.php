<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contratosBanco
 *
 * @author Jolanjohnes Duarte
 */
require_once '../init.php';

class contratosBanco {

    //put your code here
    function __construct() {
        $this->con = new conexao();
        $this->pdo = $this->con->getConection();
    }

    private function verificaContrato($numeroContrato, $anoContrato) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM contratosacqua.cad_contrato where numeroContrato = :numero and anoContrato = :ano;");
            $stmt->bindValue(":numero", $numeroContrato);
            $stmt->bindValue(":ano", $anoContrato);
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

    public function inserirContrato(contratos $entContratos) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO cad_contrato (numeroContrato, anoContrato, dataInicio, dataTermino, status, Valor, objetoContrato, fk_idUnidade, fk_idFornecedor, urlArquivo, fk_idObjeto) "
                                        . "VALUES (:numeroContrato, :anoContrato, :dataInicio, :dataTermino, :status, :Valor, :objetoContrato, :fk_idUnidade, :fk_idFornecedor, :urlArquivo, :fk_idObjeto);");
            $param = array(
                ":numeroContrato" => $entContratos->getNumeroContrato(),
                ":anoContrato" => $entContratos->getAnoContrato(),
                ":dataInicio" => $entContratos->getDataInicio(),
                ":dataTermino" => $entContratos->getDataTermino(),
                ":status" => $entContratos->getStatus(),
                ":Valor" => $entContratos->getValor(),
                ":objetoContrato" => $entContratos->getObjetoContrato(),
                ":fk_idUnidade" => $entContratos->getIdUnidade(),
                ":fk_idFornecedor" => $entContratos->getIdFornecedor(),
                ":urlArquivo" => $entContratos->getUrlAquivo(),
                ":fk_idObjeto" => $entContratos->getIdObjeto());

            if (!$this->verificaContrato($entContratos->getNumeroContrato(), $entContratos->getAnoContrato())) {
              //   var_dump($entContratos);
               return ($stmt->execute($param));
            }
        } catch (Exception $ex) {
            echo "ERRO 01: {$ex->getMessage()}";
        }
    }

    public function buscarContrato(contratos $entContratos) {
        try {
            $stmt = $this->pdo->prepare("SELECT idContrato, concat(idUnidade,'|',nome) as unidade ,
                                        cnpj_cpf, concat(idFornecedor,'|',nomeEmpresarial) fornecedor,
                                        numeroContrato, anoContrato, dataInicio, dataTermino, valor,
                                        idObjeto, cad_objcontrato.descricao as DescObjeto, objetoContrato, 
                                        cad_contrato.status, cad_contrato.urlArquivo
                                        FROM contratosacqua.cad_contrato
                                        inner join cad_unidade on cad_unidade.idUnidade = cad_contrato.fk_idUnidade
                                        inner join cad_fornecedor on cad_fornecedor.idFornecedor = cad_contrato.fk_idFornecedor
                                        inner join cad_objcontrato on cad_objcontrato.idObjeto = cad_contrato.fk_idObjeto where idContrato = :idContrato;");
            $stmt->bindValue(":idContrato", $entContratos->getIdContratos());
            $stmt->execute();
            $arrayContrato = $stmt->fetchALL(PDO::FETCH_ASSOC);
            return $arrayContrato;
        } catch (Exception $exc) {
            echo "ERRO BUSCAR" . $exc->getMessage();
        }
    }

    public function alterarContrato(contratos $entContratos) {
        try {
            $stmt = $this->pdo->prepare("UPDATE cad_contrato SET numeroContrato= :numeroContrato, anoContrato= :anoContrato,"
                    . "                 dataInicio= :dataInicio, dataTermino=:dataTermino, status= :status, Valor= :valor, "
                    . "                 objetoContrato= :objContrato, fk_idUnidade= :idUnidade, fk_idFornecedor= :idFornecedor, "
                    . "                 urlArquivo = :url"
                    . "                 WHERE idContrato= :idContrato;");

            $param = array(
                ":numeroContrato" => $entContratos->getNumeroContrato(),
                ":anoContrato" => $entContratos->getAnoContrato(),
                ":dataInicio" => $entContratos->getDataInicio(),
                ":dataTermino" => $entContratos->getDataTermino(),
                ":status" => $entContratos->getStatus(),
                ":valor" => $entContratos->getValor(),
                ":objContrato" => $entContratos->getObjetoContrato(),
                ":idUnidade" => $entContratos->getIdUnidade(),
                ":idFornecedor" => $entContratos->getIdFornecedor(),
                ":idContrato" => $entContratos->getIdContratos(),
                ":url" => $entContratos->getUrlAquivo());

            return $stmt->execute($param);
        } catch (Exception $ex) {
            echo "ERRO ATUALIZAR: {$ex->getMessage()}";
        }
    }

    public function listarContrato(contratos $entContratos) {
        try {

            if ($entContratos->getIdFornecedor() != null) {

                $stmt = $this->pdo->prepare("SELECT idContrato, nomeEmpresarial, nome as unidade, CONCAT(numeroContrato, '/', anoContrato) as Contrato, valor, urlArquivo FROM contratosacqua.cad_contrato
                inner join cad_fornecedor on cad_contrato.fk_idFornecedor = cad_fornecedor.idFornecedor
                inner join cad_unidade on cad_contrato.fk_idUnidade = cad_unidade.idUnidade 
                where fk_idFornecedor = :fornecedor order by unidade;");
                $stmt->bindValue(":fornecedor", $entContratos->getIdFornecedor());
            } elseif ($entContratos->getIdUnidade() != null) {
                $stmt = $this->pdo->prepare("SELECT idContrato, nomeEmpresarial, nome as unidade, CONCAT(numeroContrato, '/', anoContrato) as Contrato, valor, urlArquivo FROM contratosacqua.cad_contrato
                inner join cad_fornecedor on cad_contrato.fk_idFornecedor = cad_fornecedor.idFornecedor
                inner join cad_unidade on cad_contrato.fk_idUnidade = cad_unidade.idUnidade 
                where fk_idUnidade = :unidade order by nomeEmpresarial;");
                $stmt->bindValue(":unidade", $entContratos->getIdUnidade(), PDO::PARAM_INT);
            } elseif ($entContratos->getIdFornecedor() != null && $entContratos->getIdUnidade() != null) {
                $stmt = $this->pdo->prepare("SELECT idContrato, nomeEmpresarial, nome as unidade, CONCAT(numeroContrato, '/', anoContrato) as Contrato, valor, urlArquivo FROM contratosacqua.cad_contrato
                inner join cad_fornecedor on cad_contrato.fk_idFornecedor = cad_fornecedor.idFornecedor
                inner join cad_unidade on cad_contrato.fk_idUnidade = cad_unidade.idUnidade 
                where fk_idUnidade = :unidade and idFornecedor = :idFornecedor order by nomeEmpresarial;");

                $stmt->bindValue(":unidade", $entContratos->getIdUnidade(), PDO::PARAM_INT);
                $stmt->bindValue(":idFornecedor", $entContratos->getIdFornecedor());
            }

            $stmt->execute();

            $row = $stmt->fetchALL(PDO::FETCH_ASSOC);


            if ($row > 0) {
                return $row;
            }
        } catch (Exception $ex) {
            echo "ERRO Listar: {$ex->getMessage()}";
        }
    }

    public function listarContratosVencidos() {
        try {
            $stmt = $this->pdo->prepare("SELECT idContrato, cad_unidade.nome as unidade, nomeEmpresarial,
                                        concat(numeroContrato,'/',anoContrato) as contrato, dataTermino 
                                        FROM cad_contrato
                                        inner join cad_unidade on cad_unidade.idUnidade = cad_contrato.fk_idUnidade
                                        inner join cad_fornecedor on cad_fornecedor.idFornecedor = cad_contrato.fk_idFornecedor 
                                        where dataTermino < DATE_ADD(NOW(), INTERVAL 90 DAY);");
            $stmt->execute();
            $arrayContrato = $stmt->fetchALL(PDO::FETCH_ASSOC);
            return $arrayContrato;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
