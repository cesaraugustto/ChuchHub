<?php
session_start();

//var_dump($_POST);
//Incluir a conexão
include '../Connection/classeConexao.php';
$conexao = getConnection();

$sql = "DELETE FROM consagracao WHERE id = ".$_POST['id'];
$sqlDelete = $conexao->query($sql);

if($sqlDelete){
    $_SESSION['msg'] = "<div class='alert alert-warning'>Excluido com sucesso!</div>";
    header("Location: consagrarMembro.php");
}
else{ 
    $_SESSION['msg'] = "<div class='alert alert-danger'>Falha ao excluir. Entre em contato com o desenvolvedor!</div>";
    header("Location: consagrarMembro.php");
}

?>