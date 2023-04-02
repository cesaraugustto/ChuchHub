<?php
session_start();
//var_dump($_POST);

include '../Connection/classeConexao.php';
$conexao = getConnection();


$comando = "UPDATE financeiro SET tipo = '".$_POST['tipo']."', observacoes = '".$_POST['observacoes']."' WHERE id =".$_POST['id'];
//echo $comando;


$sql = $conexao->query($comando);

if($sql){
    $_SESSION['msg'] = "<div class='alert alert-success'>Movimentação alterada com sucesso!</div>";
    header("Location: financeiro.php");
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possível completar. Entre em contato com o administrador do sistema!</div>";
    header("Location: financeiro.php");
}
?>