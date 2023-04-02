<?php
session_start();

//var_dump($_POST);

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();



$idAluno = $_POST['idAluno'];
$nomeProfessor = $_POST['nomeProfessor'];
$dataInicio = $_POST['dataInicio'];
$dataFim = $_POST['dataFim'];
$nomeCurso = $_POST['nomeCurso'];


$sql = "INSERT INTO cursoobreiro (dataInicio,dataFim,idAluno,nomeProfessor,nomeCurso) VALUES (?,?,?,?,?)";

//estudar o que é statement prepare
$incluirCurso = $conexao->prepare($sql);
//Passando os parâmetros
$incluirCurso->bindParam(1, $dataInicio);
$incluirCurso->bindParam(2, $dataFim);
$incluirCurso->bindParam(3, $idAluno);
$incluirCurso->bindParam(4, $nomeProfessor);
$incluirCurso->bindParam(5, $nomeCurso);

//O execute serve para executar a função SQL
//O if serve para tratamento do possível erro
if($incluirCurso->execute()){

    $_SESSION['msg'] = "<div class='alert alert-success'>Curso cadastrado com sucesso!</div>";
    header("Location: cursoObreiro.php");
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao salvar curso. Entre em contato com o desenvolvedor!</div>";
    header("Location: cursoObreiro.php");
}



?>