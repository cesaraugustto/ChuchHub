<?php
//var_dump($_POST);/*
//Incluir a conexão
include '../Connection/classeConexao.php';
$conexao = getConnection();



$comando = "UPDATE consagracao SET dataConsagracao = '".$_POST['dataConsagracao']."' WHERE id = ".$_POST['id'];
$sql = $conexao->query($comando);

if($sql){
    echo "<script>alert('Alterado com sucesso!') </script>";
    //echo "<script>location.href = 'cadMembro.php'; </script> ";
    echo "<script>location.href = 'consagrarMembro.php'</script>" ;
}else{
    echo "<script>alert('Deu ruim, contate o adm!') </script>";
    //echo "<script>location.href = 'cadMembro.php'; </script> ";
    echo "<script>location.href = 'consagrarMembro.php'</script>" ;
}


?>