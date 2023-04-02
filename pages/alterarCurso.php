<?php
session_start();
if(isset($_SESSION['id'])){


//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

$_SESSION['sessaoMenu'] = 'curso';


//Abrindo a conexão e executando o comando sql
$comando = "SELECT usuario.id AS 'usuario_id', usuario.nome, cursoobreiro.id AS 'curso_id',
cursoobreiro.dataInicio, cursoobreiro.dataFim, cursoobreiro.nomeProfessor, cursoobreiro.nomeCurso
FROM cursoobreiro INNER JOIN usuario ON usuario.id = cursoobreiro.idAluno WHERE cursoobreiro.id =".$_GET['id'];


$sql = $conexao->query($comando);
//Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
foreach ($sql as $dadosBanco){}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar Curso</title>
    <?php include './header.php';?>
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
            <div class="row pt-3 px-3">
                <div class="row mb-5">
                    <div class="col-xl-2">
                    </div>
                    <div class="col">
                    <form method="POST" action="excluirCurso.php">
                            <button type="submit" class="btn btn-outline-danger">Excluir</button>
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'];?>">
                        </form>
                    </div>
                </div>
                <div class="col-xl-2"></div>
                <div class="col">
                    <div class="card p-0">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informações do Curso</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="./updateCurso.php" onsubmit="return verificarCampos()">
                            <div class="row">
                                <div class="col-6">
                                    <label>Aluno</label>
                                    <input type="text" class="form-control" name="nomeAluno" id="nomeAluno" value="<?=$dadosBanco['nome']?>" disabled>

                                    <input type="hidden" class="form-control" value="<?=$dadosBanco['curso_id']?>" name="id" id="id">
                                </div>
                                <div class="col-6">
                                    <label>Curso</label>
                                    <select class="form-select m-0" aria-label="Default select example" name="nomeCurso" id="nomeCurso">
                                        
                                            <option value="Obreiro" <?php if($dadosBanco['nomeCurso'] == "Obreiro"){ echo "selected";}?> >Obreiro</option>
                                            <option value="Básico Teologia" <?php if($dadosBanco['nomeCurso'] == "Básico Teologia"){ echo "selected";}?>>Básico Teologia</option>
                                            <option value="Capelania" <?php if($dadosBanco['nomeCurso'] == "Capelania"){ echo "selected";}?>>Capelania</option>
                                            <option value="Missões" <?php if($dadosBanco['nomeCurso'] == "Missões"){ echo "selected";}?>>Missões</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Professor</label>
                                    <input type="text" class="form-control" name="nomeProfessor" id="nomeProfessor" value="<?=$dadosBanco['nomeProfessor']?>">
                                </div>
                                <div class="col-6">
                                    <label>Data Inicio</label>
                                    <input type="date" class="form-control" name="dataInicio" id="dataInicio" value=<?= $dadosBanco['dataInicio']?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Data Fim</label>
                                    <input type="date" class="form-control" name="dataFim" id="dataFim" value=<?= $dadosBanco['dataFim']?>>
                                </div>
                                <div class="col">
                                    <button type="submit" class="mt-4 btn btn-outline-primary">Salvar</button>
                                </div>
                            </div>
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