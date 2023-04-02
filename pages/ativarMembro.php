<?php
session_start();

//Incluir a conexão
include '../Connection/classeConexao.php';
$conexao = getConnection();
//var_dump($_POST);

if($_POST['situacao'] == 'Ativo'){
    $comando = "UPDATE usuario SET situacao = 'Ativo' WHERE id =".$_POST['id'];

    //Executando a pesquisa no banco de dados
    $sql = $conexao->query($comando);
    if($sql){
        $_SESSION['msg'] = "<div class='alert alert-success'>Membro ativado com sucesso!</div>";
        header("Location: listMembro2.php");
    }
    else{ echo 'deu ruim'; }
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Falha ao reativar membro. Entre em contato com o desenvolvedor.!</div>";
    header("Location: listMembro2.php");
}


?>