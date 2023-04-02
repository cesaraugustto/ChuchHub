<?php
session_start();
//var_dump($_POST);

//Incluir a conexão
include '../Connection/classeConexao.php';
$conexao = getConnection();

//Pega a data de hoje
$dataHoje = date('Y/m/d');




//If para verificar se existe foto no formulário, e decidir se fará cópia de algum arquivo ou não
if($_FILES['foto']['error'] == 4){
    $nomeFoto = "";
} else{
    $foto = $_FILES['foto']['name'];
    $extensao = strtolower(pathinfo($foto, PATHINFO_EXTENSION)); //Transforma de JPG para PNG e transforma em minuscula

    $nomeFoto = md5(time()).".".$extensao;
    $diretorio = "../upload/";
    move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$nomeFoto); }



//Tratativa para caso a data de apresentação da criança ainda não tenha sido preenchida
if(empty($_POST['dataInclusao'])){
    $comando = "INSERT INTO crianca (nome,sexo,dataNascimento,foto,nomePai,nomeMae) VALUES (?,?,?,?,?,?)";
    $sql = $conexao->prepare($comando);

    $sql->bindParam(1,$_POST['nome']);
    $sql->bindParam(2,$_POST['sexo']);
    $sql->bindParam(3,$_POST['dataNascimento']);
    $sql->bindParam(4,$nomeFoto);
    $sql->bindParam(5,$_POST['nomePai']);
    $sql->bindParam(6,$_POST['nomeMae']); 
} else {
    $comando = "INSERT INTO crianca (nome,sexo,dataNascimento,dataInclusao,foto,nomePai,nomeMae) VALUES (?,?,?,?,?,?,?)";
    $sql = $conexao->prepare($comando);

    $sql->bindParam(1,$_POST['nome']);
    $sql->bindParam(2,$_POST['sexo']);
    $sql->bindParam(3,$_POST['dataNascimento']);
    $sql->bindParam(4,$_POST['dataInclusao']);
    $sql->bindParam(5,$nomeFoto);
    $sql->bindParam(6,$_POST['nomePai']);
    $sql->bindParam(7,$_POST['nomeMae']);
}




if($sql->execute()){
    $_SESSION['msg'] = "<div class='alert alert-success'>Criança apresentada com sucesso!</div>";
    header("Location: apresentarCrianca.php");
}
else{ 
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao incluir criança. Entre em contato com ADM de sistema!</div>";
    header("Location: apresentarCrianca.php");
}


?>