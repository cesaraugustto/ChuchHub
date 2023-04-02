<?php
session_start();

//var_dump($_POST);
//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

$comando = "UPDATE batismo SET dataBatismo = '".$_POST['dataBatismo']."', batismoaqui = '".$_POST['localBatismo']."'
WHERE id = ".$_POST['idBatismo'];
$sql = $conexao->query($comando);

if($sql){
    $_SESSION['msg'] = "<div class='alert alert-success'>Batismo alterado com sucesso!</div>";
    header("Location: batizarmembro.php");
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao alterar batismo. Entre em contato com o desenvolvedor!</div>";
    header("Location: batizarmembro.php");
}



?>