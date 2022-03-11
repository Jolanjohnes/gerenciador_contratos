<?php
header ('Content-type: text/html; charset=utf-8');

require_once "../init.php";
$conexao = new conexao();
       
$pdo = $conexao->getConection();
$retorno = array();

if ($_GET['acao'] == 'unidade') {
    try {
        $sql = $pdo->prepare("Select idUnidade, nome from cad_unidade order by nome");
        $sql->execute();
        $n = 0;
        $retorno['qtd'] = $sql->rowCount();
        while ($linha = $sql->fetchObject()) {
            $retorno['nome'][$n] = ($linha->nome);
            $retorno['idUnidade'][$n] = $linha->idUnidade;
            $n++;
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}

if ($_GET['acao'] == 'listarEvento') {
    try {
        $sql = $pdo->prepare("SELECT idEvento, nomeEvento FROM cad_evento order by nomeEvento;");
        $sql->execute();
        $n = 0;
        $retorno['qtd'] = $sql->rowCount();
        while ($linha = $sql->fetchObject()) {
            $retorno['idEvento'][$n] = $linha->idEvento;
            $retorno['nomeEvento'][$n] = utf8_encode($linha->nomeEvento) ;
            $n++;
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}

if($_GET['acao'] == 'fornecedor'){
   
   try {
    $id = $_GET['id'];
    $sql = $pdo->prepare("select idContrato, nomeEmpresarial, CONCAT(numeroContrato, '.', anoContrato) as Contrato from cad_fornecedor inner join cad_contrato on fk_idFornecedor = idFornecedor where fk_idUnidade = :fk_idUnidade;
    ");
    $sql->bindValue(":fk_idUnidade",$id, PDO::PARAM_INT);
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();
    while($linha = $sql->fetchObject()){
        $retorno['nomeEmpresarial'][$n] =utf8_encode($linha->nomeEmpresarial);
        $retorno['idContrato'][$n] = $linha->idContrato;
        $retorno['Contrato'][$n] = $linha->Contrato;
      $n++;
    }
   } catch (Exception $exc) {
        echo $exc->getTraceAsString();
   }
}

if($_GET['acao'] == 'fornecedorCnpj'){
    try {
        $cnpj = $_GET['cnpj'];
        $sql = $pdo->prepare("SELECT * FROM cad_fornecedor where cnpj_cpf = :cnpj_cpf;");
        $sql->bindValue(":cnpj_cpf",$cnpj, PDO::PARAM_INT);
        $sql->execute();
        $n = 0;
        $retorno['qtd'] = $sql->rowCount();
        
        while($linha = $sql->fetchObject()){
            $retorno['nomeEmpresarial'][$n] = ($linha->nomeEmpresarial);
            $retorno['idFornecedor'][$n] = ($linha->idFornecedor);
        $n++;
        }
       

    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
   }
}

if ($_GET['acao'] == 'objetoContrato'){
    try {
        $sql = $pdo->prepare("SELECT * FROM cad_objcontrato;");
        $sql->execute();
        $n = 0;
        $retorno['qtd'] = $sql->rowCount();
        while ($linha = $sql->fetchObject()) {
            $retorno['descricao'][$n] = ($linha->descricao);
            $retorno['idObjeto'][$n] = $linha->idObjeto;
            $n++;
        }
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }

}


die(json_encode($retorno));

?>