<?php
session_start();

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();


//If para verificar se existe foto no formulário, e decidir se fará cópia de algum arquivo ou não
if(!empty($_FILES['foto'])){
    if($_FILES['foto']['error'] == 4){
        $nomeFoto = "";
    }
    else{
        $foto = $_FILES['foto']['name'];
        $extensao = strtolower(pathinfo($foto, PATHINFO_EXTENSION)); //Transforma de JPG para PNG e transforma em minuscula

        $nomeFoto = md5(time()).".".$extensao;
        $diretorio = "../upload/";
        move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$nomeFoto);
    }
} 

$comando = "UPDATE crianca SET nome = '".$_POST['nome']."', sexo = '".$_POST['sexo']."', dataNascimento = '".$_POST['dataNascimento']."', nomePai = '".$_POST['nomePai']."', nomeMae = '".$_POST['nomeMae']."'";

//Tratativa caso faça o update do Membro sem ainda ter alterado a data de Inclusao
if(empty($_POST['dataInclusao'])){
    $comando .= ", dataInclusao = null ";
} else { $comando .= ", dataInclusao = '".$_POST['dataInclusao']."'";}

if($nomeFoto != ""){
    $comando .= ", foto = '".$nomeFoto."'";
}


$comando .= " WHERE id = ".$_POST['id'];


//Executando a pesquisa no banco de dados
$sql = $conexao->query($comando);
if($sql){
    $_SESSION['msg'] = "<div class='alert alert-success'>Criança alterada com sucesso!</div>";
    header("Location: apresentarCrianca.php");
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao alterar criança. Entre em contato com o desenvolvedor!</div>";
    header("Location: apresentarCrianca.php");
}


?>