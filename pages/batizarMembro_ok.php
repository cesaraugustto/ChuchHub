<?php
//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

//Dados para Pesquisar as informações
$id = $_POST['idMembro'];
$localBatismo = $_POST['localBatismo'];



//Verificando se o usuário já não tem batismo
$verificaBatismo = $conexao->query("SELECT * FROM batismo WHERE idMembro = ".$id);
$collection =  $verificaBatismo->fetchAll();
if(count($collection) > 0){
    echo '<script>alert("Membro já batizado!")</script>';
    echo '<script>location.href="batizarMembro.php";</script>';
}
else{



//Pega a data de hoje
$dataHoje = date('Y/m/d');
$batizadoOnde = "aqui";


    //Dados para inserir
    $comandoInsert = "INSERT INTO batismo (dataBatismo,idMembro,batismoAqui) VALUES (?,?,?)";
    //estudar o que é statement prepare
    $SqlInsert = $conexao->prepare($comandoInsert);

    
    $SqlInsert->bindParam(1, $dataHoje);
    $SqlInsert->bindParam(2, $id);
    $SqlInsert->bindParam(3, $localBatismo);

    if($SqlInsert->execute()){
        echo '<script>alert("Batismo registrado com sucesso!")</script>';
        echo '<script>location.href="batizarMembro.php";</script>';
    }
    else{
        echo 'deu ruim';
    }

}

?>