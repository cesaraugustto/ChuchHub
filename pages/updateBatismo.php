<?php
session_start();
if(isset($_SESSION['id'])){


//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

$_SESSION['sessaoMenu'] = 'batismo';

//Abrindo a conexão e executando o comando sql
$comando = "SELECT usuario.id AS 'usuario_id', usuario.nome, usuario.foto, batismo.id AS 'batismo_id', batismo.dataBatismo, batismo.batismoaqui FROM
batismo INNER JOIN usuario ON usuario.id = batismo.idMembro WHERE batismo.id = ".$_GET['batismo_id'];
$sql = $conexao->query($comando);
//Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
foreach ($sql as $dadosBanco){}
if(empty($dadosBanco['foto'])){
    $fotoUsuario = "../upload/fotoSemfoto.png";
}else{ $fotoUsuario = $dadosBanco['foto'];}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar Curso</title>
    <?php include './header.php';?>

    <style>
        .imgPerfil{ width: 10vw; }
            @media(max-width: 425px){
                    .imgPerfil{
                        width: 30vw; 
                    }
            }
    </style>
</head>
<body>
<div class="wrapper">
        <?php include './menu.php';?>

        <div class="main">
            <?php include 'topo.php';?>

            <div class="row mt-3">
                    <div class="col-12">
                    <figure>
                        <div class="text-center">
                            <blockquote class="blockquote">
                                <p style="font-size:14px; ">
                                    <?php if(isset($_SESSION['conteudo']))
                                        { echo $_SESSION['conteudo']; 
                                    ?>
                                </p>
                            </blockquote>

                            <figcaption class="blockquote-footer">
                                <cite title="Source Title">
                                    <?php echo $_SESSION['livro']?>
                                </cite>
                                <?php echo ' '.$_SESSION['capitulo'].':'.$_SESSION['versiculo'];
                                unset($_SESSION['conteudo']);
                                unset($_SESSION['livro']);
                                unset($_SESSION['capitulo']);
                                unset($_SESSION['versiculo']);
                            }?>
                            </figcaption>

                        </div>
                    </figure>
                    </div>
                </div>

            <!--Aqui começa o body-->
            <div class="row px-3 mt-2">
                <div class="col-xl-2"></div>
                <div class="col">
                    <div class="card p-0">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informações do Batismo</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="updateBatismo_ok.php">
                                <div class="row">
                                    <div class="col-3 col-xl-1"></div>
                                    <div class="col-xl-3 col-8">
                                        <img src="../upload/<?php echo $fotoUsuario?>" class="my-1 rounded-4 imgPerfil">
                                    </div>
                                    <div class="col-xl-7 col-12">
                                        <input type="hidden" name="idBatismo" id="idBatismo" value="<?php echo $dadosBanco['batismo_id']?>">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" disabled name="nome" id="nome" value="<?php echo $dadosBanco['nome']?>">

                                        <label>Data do batismo</label>
                                        <input type="date" class="form-control" name="dataBatismo" id="dataBatismo" value="<?php echo $dadosBanco['dataBatismo']?>">

                                        <label>Local do batismo</label>
                                        <select class="form-select m-0" aria-label="Default select example" name="localBatismo" id="localBatismo">
                                            <?php
                                                if($dadosBanco['batismoaqui'] == "Fora"){
                                            ?>
                                                <option value="Fora">Fora</option>
                                                <option value="Aqui">Betel</option>
                                            <?php } else {?>
                                                <option value="Aqui">Betel</option>
                                                <option value="Fora">Fora</option>
                                            <?php }?>

                                        </select>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="mt-4 btn btn-outline-primary">Alterar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2"></div>
                
            </div>


            <footer class="footer">
                    <?php include 'footer.php' ?>
            </footer>
        </div>
</div>


    <script src="../js/app.js"></script>

<script>//Script do alert
    function verificarCampos() {
        const campos = document.querySelectorAll('input[type="text"], input[type="date"], select'); // Seleciona todos os campos de entrada de texto, date e select
        for (let i = 0; i < campos.length; i++) {
            const campo = campos[i];
            const valor = campo.value.trim();
            
            if (valor === "") {
                const alerta = document.createElement("div");
                alerta.classList.add("alert", "alert-danger");
                alerta.textContent = `O campo ${campo.name} está vazio!`;

                const formulario = document.querySelector("form");
                formulario.insertBefore(alerta, formulario.firstChild);

                setTimeout(() => {
                    alerta.remove();
                }, 5000);

                return false; // Cancela o envio do formulário
            }
        }
        
        return true; // Permite o envio do formulário
    }
</script>



</body>
</html>


<?php } else{
        $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
        echo "<script>location.href = '../index.php'</script>" ;
}?>