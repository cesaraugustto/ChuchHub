<?php
session_start();

//var_dump($_POST);

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

//Atribuindo criptografia a senha e retirando a máscara do cpf
$a = str_replace(".","",$_POST['cpf']);
$senha = str_replace("-","",$a);
$senhaCriptografada = md5($senha);
$cpf = $senha;


if(isset($_POST['switchAdm'])){
    $cargo = 'Administrador';
}else{
    $cargo = 'Membro';
}

$dataHoje = date('Y/m/d');
$situacaoMembro = 'Ativo';



//If para verificar se existe foto no formulário, e decidir se fará cópia de algum arquivo ou não
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

var_dump($_POST);

$sql = 'INSERT INTO usuario (nome,sexo,telefone,email,cargo,cpf,endereco,cidade,estado,cep,dataNascimento,dataCadastro,foto,senha,situacao,estadoCivil) VALUES
(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

//estudar o que é statement prepare
$stmt = $conexao->prepare($sql);

//passando os parâmetros
$stmt->bindParam(1, $_POST['nome']);
$stmt->bindParam(2, $_POST['sexo']);
$stmt->bindParam(3, $_POST['telefone']);
$stmt->bindParam(4, $_POST['email']);
$stmt->bindParam(5, $cargo);
$stmt->bindParam(6, $cpf);
$stmt->bindParam(7, $_POST['endereco']);
$stmt->bindParam(8, $_POST['cidade']);
$stmt->bindParam(9, $_POST['uf']);
$stmt->bindParam(10, $_POST['cep']);
$stmt->bindParam(11, $_POST['dataNasc']);
$stmt->bindParam(12, $_POST['dataCadastro']);
$stmt->bindParam(13, $nomeFoto);
$stmt->bindParam(14, $senhaCriptografada);
$stmt->bindParam(15, $situacaoMembro);
$stmt->bindParam(16, $_POST['estadoCivil']);


//O execute serve para executar a função SQL
//O if serve para tratamento do possível erro
if($stmt->execute()){

    if(empty($_POST['dataBatismo'])){
        $dataBatismo = null;
    }else {$dataBatismo = $_POST['dataBatismo'];}
    

    //Para inserir o batismo preciso do ultimo usuário cadastrado
    $sqlUsuario = "SELECT max(id) FROM usuario";
    //Pegando maior usuário para colocar como chave estrangeira no batismo
    $maiorUsuario = $conexao->query($sqlUsuario);
    foreach ($maiorUsuario as $dadosUltimoUsuario){};
    

    

    //Dados para inserir batismo
    $comandoInsert = "INSERT INTO batismo (dataBatismo,idMembro,batismoAqui) VALUES (?,?,?)";
    //estudar o que é statement prepare
    $SqlInsert = $conexao->prepare($comandoInsert);

    $SqlInsert->bindParam(1, $dataBatismo);
    $SqlInsert->bindParam(2, $dadosUltimoUsuario['max(id)']);
    $SqlInsert->bindParam(3, $_POST['localBatismo']);

    if($SqlInsert->execute()){
        $_SESSION['msg'] = "<div class='alert alert-success'>Membro cadastrado com sucesso!</div>";
        header("Location: listMembro2.php");
    }
    else{
        $_SESSION['msg'] = "<div class='alert alert-success'>Erro ao salvar. Gentileza entrar em contato com o Administrador!</div>";
        header("Location: cadMembro.php");
    }

}
else{
    echo 'Erro ao salvar, ENTRE EM CONTATO COM O ADMINISTRADOR';
}


?>