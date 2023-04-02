<?php
session_start();

$valor = str_replace( '.' , '', $_POST['valorInserir'] ); // Removeu todos os pontos
$valor = str_replace( ',', '.', $valor); // Substitui todas as virgulas por ponto.
$valor = str_replace('R$','',$valor);


//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

//Pega a data de hoje
$dataHoje = date('Y/m/d');


$sql = "INSERT INTO financeiro (tipo, valor, observacoes, dataMovimentacao) VALUES (?,?,?,?)";
$inserirFinanceiro = $conexao->prepare($sql);

$inserirFinanceiro->bindParam(1, $_POST['tipo']);
$inserirFinanceiro->bindParam(2, $valor);
$inserirFinanceiro->bindParam(3, $_POST['obs']);
$inserirFinanceiro->bindParam(4, $dataHoje);

if($inserirFinanceiro->execute()){
    
    $_SESSION['msg'] = "<div class='alert alert-success'>Movimentação registrada com sucesso!</div>";
    header("Location: financeiro.php");
    
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Falha ao registrar movimentação. Entre em contato com o desenvolvedor!</div>";
    header("Location: financeiro.php");
}

?>