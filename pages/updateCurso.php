<?php
session_start();

include '../Connection/classeConexao.php';
$conexao = getConnection();

//var_dump($_POST);

$comando = "UPDATE cursoobreiro SET dataInicio = '".$_POST['dataInicio']."', dataFim = '".$_POST['dataFim']."', nomeProfessor = '".$_POST['nomeProfessor']."', nomeCurso = '".$_POST['nomeCurso']."' WHERE id =".$_POST['id'];

$sql = $conexao->query($comando);

if($sql){
    $_SESSION['msg'] = "<div class='alert alert-success'>Curso Alterado com sucesso!</div>";
    header("Location: cursoObreiro.php");
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possível efetuar. Entre em contato com o desenvolvedor!</div>";
    header("Location: cursoObreiro.php");
}
?>