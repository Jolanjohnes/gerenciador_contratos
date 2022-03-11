<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eventoContratoBanco
 *
 * @author acer
 */
require_once '../init.php';

class eventoContratoBanco {

    //put your code here

    public function __construct() {
        $this->con = new conexao();
        $this->pdo = $this->con->getConection();
    }

    public function inserirEvento(eventoContrato $entEventosContratos) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO `eventoscontratos`(`numeroEvento`,`anoEvento`,`fk_idContrato`,`fk_idEvento`,`dataInicio`,`dataFim`,`motivo`,`valor`,`urlArquivo`) VALUES(:numeroEvento,:anoEvento,:fk_idContrato,:fk_idEvento,:dataInicio, :dataFim, :motivo, :valor, :urlArquivo);");
            
            $stmt->bindValue(':numeroEvento', $entEventosContratos->getNumeroEvento());
            $stmt->bindValue(':anoEvento', $entEventosContratos->getAnoEvento());
            $stmt->bindValue(':fk_idContrato', $entEventosContratos->getFk_idContrato());
            $stmt->bindValue(':fk_idEvento', $entEventosContratos->getFk_idEvento());
            $stmt->bindValue(':dataInicio', $entEventosContratos->getDataInicio());
            $stmt->bindValue(':dataFim', $entEventosContratos->getDataTermino());
            $stmt->bindValue(':motivo', $entEventosContratos->getMotivo());
            $stmt->bindValue(':valor', $entEventosContratos->getValor());
            $stmt->bindValue(':urlArquivo', $entEventosContratos->getUrlArquivo());
            
              /*                          
            $param = array(":numeroEvento" => $entEventosContratos->getNumeroEvento(),
                ":anoEvento" => $entEventosContratos->getAnoEvento(),
                ":fk_idContrato" => $entEventosContratos->getFk_idContrato(),
                ":fk_idEvento" => $entEventosContratos->getFk_idEvento(),
                ":dataInicio" => $entEventosContratos->getDataInicio(),
                ":dataFim" => $entEventosContratos->getDataTermino(),
                ":motivo" => $entEventosContratos->getMotivo(),
                ":valor" => $entEventosContratos->getValor(),
                ":urlArquivo" => $entEventosContratos->getUrlArquivo());
                */
                //var_dump($entEventosContratos);
                
             return $stmt->execute();
            
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function buscarEvento(eventoContrato $entEventoContrato) {
        try {
            $stmt = $this->pdo->prepare("SELECT concat(idUnidade,'|',nome) as unidade,
		concat(idContrato,'-',nomeEmpresarial,'-',numeroContrato,'.',anoContrato) as Contrato,
                concat(idEvento,'|',nomeEvento) as Evento,
                numeroEvento,
                anoEvento,
                eventoscontratos.dataInicio,
                eventoscontratos.dataFim,
                eventoscontratos.valor,
                eventoscontratos.motivo,
                eventoscontratos.urlArquivo
                FROM eventoscontratos
                inner join cad_contrato on cad_contrato.idContrato = eventoscontratos.fk_idContrato
                inner join cad_fornecedor on cad_contrato.fk_idFornecedor = cad_Fornecedor.idFornecedor
                inner join cad_unidade on cad_contrato.fk_idUnidade = cad_unidade.idUnidade
                inner join cad_evento on eventoscontratos.fk_idEvento = cad_evento.idEvento
                where idEventoContrato = :idEvento;");

            $stmt->bindValue(":idEvento", $entEventoContrato->getIdEvento());
            $stmt->execute();
            $arrayEvnto = $stmt->fetchALL(PDO::FETCH_ASSOC);
            //var_dump($arrayContrato);
            return $arrayEvnto;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function alterarEvento(eventoContrato $entEventosContratos) {
        try {
            $stmt = $this->pdo->prepare("UPDATE eventoscontratos SET numeroEvento= :numeroEvento, "
                    . "`anoEvento`= :anoEvento, `fk_idContrato`= :fk_idContrato, `fk_idEvento`= :fk_idEvento, "
                    . "`dataInicio`= :dataInicio, `dataFim`= :dataFim, `motivo`= :motivo, "
                    . "`valor`= :valor, `urlArquivo`= :urlArquivo WHERE `idEventoContrato`= :idEvento and`fk_idContrato`=:fk_idContrato;");
            $param = array(":numeroEvento" => $entEventosContratos->getNumeroEvento(),
                ":anoEvento" => $entEventosContratos->getAnoEvento(),
                ":fk_idContrato" => $entEventosContratos->getFk_idContrato(),
                ":fk_idEvento" => $entEventosContratos->getFk_idEvento(),
                ":dataInicio" => $entEventosContratos->getDataInicio(),
                ":dataFim" => $entEventosContratos->getDataTermino(),
                ":motivo" => $entEventosContratos->getMotivo(),
                ":valor" => $entEventosContratos->getValor(),
                ":urlArquivo" => $entEventosContratos->getUrlArquivo(),
                ":idEvento" => $entEventosContratos->getIdEvento());

            return $stmt->execute($param);
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function listarEvento(eventoContrato $entEventosContratos) {
        try {

            $stmt = $this->pdo->prepare("SELECT idEventoContrato,
                                        CONCAT(numeroEvento,'/',anoEvento) as numeroEvento, 
                                        nomeEvento, dataInicio, DataFim, Motivo, valor, 
                                        eventoscontratos.urlArquivo as urlArquivo 
                                        FROM eventoscontratos
                                        inner join cad_evento on eventoscontratos.fk_idEvento = cad_evento.idEvento 
                                        where fk_idContrato = :fk_idContrato order by numeroEvento;");
            $stmt->bindValue(":fk_idContrato", $entEventosContratos->getIdEvento(), PDO::PARAM_INT);
            $stmt->execute();
            $arrayEvento = $stmt->fetchALL(PDO::FETCH_ASSOC);

            return $arrayEvento;
        } catch (Exception $exc) {
            echo "Erro Listar" . $exc->getMessage();
        }
    }

    public function listarEventosVencidos($codigoContrato) {
        try {
            $stmt = $this->pdo->prepare("SELECT cad_unidade.nome as unidade, concat(numeroContrato,'/',anoContrato) as contrato, nomeEmpresarial, datafim, fk_idEvento
                                        FROM eventoscontratos
                                        inner join cad_contrato on cad_contrato.idContrato = eventoscontratos.fk_idContrato
                                        inner join cad_unidade on cad_unidade.idUnidade = cad_contrato.fk_idUnidade
                                        inner join cad_fornecedor on cad_fornecedor.idfornecedor = cad_contrato.fk_idFornecedor
                                        where fk_idContrato = :codigoContrato
                                        order by numeroEvento DESC LIMIT 1;");
            $stmt->bindValue(":codigoContrato", $codigoContrato);
            $stmt->execute();
            $arrayEvento = $stmt->fetchALL(PDO::FETCH_ASSOC);
            return $arrayEvento;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
