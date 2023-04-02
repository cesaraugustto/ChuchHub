<?php
session_start();
//var_dump($_POST);/*
//Incluir a conexão
include '../Connection/classeConexao.php';
$conexao = getConnection();


//Pega a data de hoje
$dataHoje = date('Y/m/d');


$id = $_POST['id'];
$cargo = $_POST['cargo'];

//Aqui, preciso atualizar o cargo do usuário atual e após 
//isso inserir na tabela update o cargo novo
$comando = "UPDATE usuario SET cargo = '".$cargo."' WHERE id =".$id;
echo $comando;
$sql = $conexao->query($comando);


$insertConsagrar = "INSERT INTO consagracao (novoCargo,dataConsagracao,idMembro) VALUES (?,?,?)";
$sqlConsagrar = $conexao->prepare($insertConsagrar);


$sqlConsagrar->bindParam(1, $cargo);
$sqlConsagrar->bindParam(2, $_POST['dataConsagracao']);
$sqlConsagrar->bindParam(3, $id);


if($sqlConsagrar->execute() && $sql){
    $_SESSION['msg'] = "<div class='alert alert-success'>Membro consagrado com sucesso!</div>";
    header("Location: consagrarMembro.php");
}
else{ 
    $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possivel efetuar consagração. Entre em contato com o desenvolvedor!</div>";
    header("Location: consagrarMembro.php");
}
?>