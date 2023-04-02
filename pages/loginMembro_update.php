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
        echo 'foto não inserida <br> O nome da foto é : '. $nomeFoto;
    }
    else{
        $foto = $_FILES['foto']['name'];
        $extensao = strtolower(pathinfo($foto, PATHINFO_EXTENSION)); //Transforma de JPG para PNG e transforma em minuscula

        $nomeFoto = md5(time()).".".$extensao;
        $diretorio = "../upload/";
        move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$nomeFoto);
        echo 'foto inserida <br>';
    }
    
}   

$sql = "UPDATE usuario SET telefone = '".$_POST['telefone']."', email = '".$_POST['email']."'";

if(!empty($_POST['senha'])){

        //Atribuindo criptografia a senha
        $senha = $_POST['senha'];
        $senhaCriptografada = md5($senha);
        $sql .= ", senha = '".$senhaCriptografada."'";
}

if($nomeFoto != ""){
    $sql .= ", foto = '".$nomeFoto."'";
}

$sql .= " WHERE id = ".$_POST['id'];

echo $sql;

//Executando a pesquisa no banco de dados
$comando = $conexao->query($sql);
if($comando){

    $_SESSION['msgMembro'] = "<div class='alert alert-success'>Alterado com sucesso!</div>";
    header("Location: loginMembro.php");
}
else{
    $_SESSION['msgMembro'] = "<div class='alert alert-danger'>Falha ao salvar. Entre em contato com administrador!</div>";
    header("Location: loginMembro.php");
}

?>