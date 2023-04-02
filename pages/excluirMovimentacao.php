<?php
session_start();

//var_dump($_POST);
//Incluir a conexão
include '../Connection/classeConexao.php';
$conexao = getConnection();

$sql = "DELETE FROM financeiro WHERE id = ".$_POST['id'];
$sqlDelete = $conexao->query($sql);

if($sqlDelete){
    echo "<script>alert('Excluido com sucesso!') </script>";
    echo "<script>location.href = 'financeiro.php'</script>" ;

    $_SESSION['msg'] = "<div class='alert alert-warning'>Movimentação excluida com sucesso!</div>";
    header("Location: financeiro.php");
}
else{ 
    $_SESSION['msg'] = "<div class='alert alert-danger'>Falha ao registrar movimentação. Entre em contato com o desenvolvedor!</div>";
    header("Location: financeiro.php");
}

?>