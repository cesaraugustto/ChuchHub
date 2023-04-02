<?php
session_start();

var_dump($_POST);

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();


//Pega a data de hoje
$dataHoje = date('Y/m/d');


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


$nome = $_POST['nome'];
$id = $_POST['id'];

// Remove os caracteres não numéricos (ponto e hífen) para manter correto no banco de dados
$cpf = $_POST['cpf'];
$cpf = str_replace(array('.', '-'), '', $cpf);

$comando = "UPDATE usuario SET nome = '".$_POST['nome']."', sexo = '".$_POST['sexo']."', 
telefone = '".$_POST['telefone']."', email ='".$_POST['email']."', cpf = '".$cpf."', 
endereco = '".$_POST['endereco']."', cidade ='".$_POST['cidade']."', estado ='".$_POST['uf']."', 
cep ='".$_POST['cep']."', dataNascimento = '".$_POST['dataNascimento']."', estadoCivil = '".$_POST['estadoCivil']."'";


//TRATATIVA PARA CASO NÃO TENHA DATA DE CADASTRO
if(empty($_POST['dataCadastro'])){
    $comando .= ", dataCadastro = null"; }
else{
    $dataCadastro = $_POST['dataCadastro']; 
    $comando .= ", dataCadastro = '".$dataCadastro."'";
}




if($nomeFoto != ""){
    $comando .= ", foto = '".$nomeFoto."'";
}




//Desativando Membro
if($_POST['desativar'] == "Desativar"){
    $comando .= ", situacao = 'inativo'";
}
if($_POST['desativar'] == "Ativar"){
    $comando .= ", situacao = 'Ativo'";
}



//Tratativa para caso o ADM altere a senha
if($_POST['senha'] != "senhapassword"){
    //Atribuindo criptografia a senha
    $senha = $_POST['senha'];
    $senhaCriptografada = md5($senha);
    $comando .= ", senha = '".$senhaCriptografada."'";
}




//Terminando de concatenar a string de pesquisa
$comando .= " WHERE id = ".$_POST['id'];
//echo $comando;




//Executando a pesquisa no banco de dados
$sql = $conexao->query($comando);
if($sql){

    $_SESSION['msg'] = "<div class='alert alert-success'>Membro alterado com sucesso!</div>";
    header("Location: listMembro2.php");
}
else{
    $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possivel efetuar alteração. Entre em contato com o desenvolvedor!</div>";
    header("Location: listMembro2.php");
}

?>