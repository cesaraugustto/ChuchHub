<?php
//Iniciando variáveis de sessão
session_start();

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();


$login = $_POST['login'];
$senha = $_POST['senha'];

$sql = 'SELECT id, nome, senha, cargo, foto, situacao FROM 
usuario WHERE cpf = "'.$login.'" AND senha = "'.md5($senha).'" AND situacao = "Ativo" LIMIT 1;';


//Preparando para executar o comando SQL com a conexão
$stmt = $conexao->prepare($sql);
$stmt->execute();

if(($stmt) AND ($stmt->rowCount() != 0)){
    foreach($stmt as $dadosBanco){}

    //Atribuindo os dados do usuário logado para informações apresentadas no index
    $_SESSION['id'] = $dadosBanco['id']; //A variável a ser verificada para validar login é essa!
    $_SESSION['foto'] = $dadosBanco['foto'];
    $_SESSION['nome'] = $dadosBanco['nome'];
    $_SESSION['cargo'] = $dadosBanco['cargo'];

    //Direcionando usuário depender do cargo
    if($dadosBanco['cargo'] == 'Administrador'){
        header('Location: index.php');}
    else if($dadosBanco['cargo'] != "Administrador"){
        header('Location: loginMembro.php');}
}
else{
    $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Login e/ou senha inválido(s)</div>";
    echo "<script>location.href = '../index.php'</script>" ;
}

?>