<?php
session_start();

var_dump($_POST);
var_dump($_FILES);


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
        $diretorio = "../site/images/galeria/";
        move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$nomeFoto);
    }
    
}   

$comando = "UPDATE galeria SET foto = '".$nomeFoto."' WHERE id = ".$_POST['id'];
//Executando a pesquisa no banco de dados
$sql = $conexao->query($comando);


//Verificações pra saber se deu certo
if($sql){

    $_SESSION['msg'] = "<div class='alert alert-success'>Galeria atualizada com sucesso!</div>";
    header("Location: galeria.php");
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possivel efetuar alteração. Entre em contato com o desenvolvedor!</div>";
    header("Location: galeria.php");
}

?>
