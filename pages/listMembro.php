<?php
//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

$_SESSION['sessaoMenu'] = 'membros';

/* 
//Para cada item cadastrado vou atribuir a variável dadosBanco
foreach($sql as $dadosBanco){
    echo "Nome ->". $dadosBanco['nome']. ", Sexo->". $dadosBanco['sexo']. "<br>";
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Link para biblioteca Jquery para o DataTable-->
    <link href="./css/jquery.dataTables.min.css" rel="stylesheet"> 
    <title>Document</title>

</head>
<body>
    <h1>Listagem de Membros</h1>
<div class="container">
        <table id="tabela">
            <thead>
                <tr><td>Nome</td><td>Sexo</td></tr>
            </thead>
            <tbody>
                <?php
                //Abrindo a conexão e executando o comando sql
                $sql = $conexao->query("SELECT * FROM usuario;");
                //A cada linha que a pesquisa encontrar vai atribuir o valor dela em $row
                while($row = $sql->fetch()) {?>
                <tr>
                    <td><a href="updateMembro.php"><?php echo $row['nome']; ?></a></td>
                    <td><?php echo $row['sexo']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
</div>

<button><a href="index.php">Voltar</a></button>

<script src="js/jquery-3.5.1.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<!--Inicialização do DataTable, com o id da tabela-->
<script>$(document).ready(function () {
    $('#tabela').DataTable(
        
    );
});</script>

</body>
</html>