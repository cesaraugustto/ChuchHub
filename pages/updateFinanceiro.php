<?php
session_start();
if(isset($_SESSION['id'])){
$_SESSION['sessaoMenu'] = 'financeiro';

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $comando = "SELECT * FROM financeiro WHERE id = ".$id;
}else{
    echo "<script>alert('Sem parametro GET!') </script>";
    //echo "<script>location.href = 'cadMembro.php'; </script> ";
    echo "<script>location.href = 'financeiro.php'</script>" ;
}

//Abrindo a conexão e executando o comando sql
$sqlComando = $conexao->query($comando);
foreach($sqlComando as $sql){}

?>
<!DOCTYPE html>
<html lang="en">
<head>


        <!--Máscara de valor, tive que tirar do header pois entrava em conflito com a máscara de cpf-->
        <script src="https://plentz.github.io/jquery-maskmoney/javascripts/jquery.maskMoney.min.js" type="text/javascript"></script>


    <title>Editar Movimentação</title>
    <?php include './header.php';?>
    <?php include './headerCadMembro.php'; ?>
</head>
<body onload="formatarMoeda()">
<div class="wrapper">
        <?php include './menu.php';?>

        <div class="main">
            <?php include 'topo.php';?>

            
            <div class="row p-3">
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
            <div class="row mt-3">
                <div class="col-xl-1"></div>
                <div class="col">
                    <?php 
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']); }
                    ?>
                </div>
                <div class="col-xl-1"></div>
            </div>

            <!--Body começa aqui-->
            <div class="row mx-4">
                <div class="col-xl-2"></div>
                <div class="col-xl-8">   
                    <div class="card p-0">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Editar movimentação</h5>
                        </div>
                        <div class="card-body mb-3">
                            <div class="row mb-3">
                                <div class="col-xl-3"></div>
                                <div class="col">
                                    <form method="POST" action="excluirMovimentacao.php">
                                        <button type="submit" class="btn btn-outline-danger">Excluir</button>
                                        <input type="hidden" id="id" name="id" value="<?php echo $sql['id'];?>">
                                    </form>
                                </div>
                            </div>
                            <form method="POST" action="./updateMovimentacao.php" onsubmit="return verificarCampos()">
                                <input type="hidden" value="<?php echo $sql['id']?>" name="id" id="id">
                                <div class="row">
                                    <div class="col-xl-3"></div>
                                    <div class="col-xl-2 col-12">
                                        <label>Valor</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="valorUpdate" id="valorUpdate" value="<?php echo $sql['valor']?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-12">
                                        <label>Tipo</label>
                                        <select class="form-select m-0" aria-label="Default select example" name="tipo" id="tipo">
                                            <option value="Entrada" <?php if($sql['tipo'] == "Entrada"){ echo 'selected';}?>>Entrada</option>
                                            <option value="Saída"<?php if ($sql['tipo'] == "Saída"){echo 'selected';}?>>Saída</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3"></div>
                                    <div class="col-xl-3 col-12">
                                        <label>Data</label>
                                        <input type="date" id="data" name="data" class="form-control" value="<?php echo $sql['dataMovimentacao']?>" min="" max="">
                                    </div>


                                <div class="col-xl-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3"></div>
                                    <div class="col-xl-5 col-12">
                                        <label>Observações</label>
                                        <textarea class="form-control" id="observacoes" name="observacoes"><?php echo $sql['observacoes']?></textarea>
                                    </div>
                                    <div class="col-xl-2"></div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-xl-6"></div>
                                    <div class="col-xl-2 col-12 mt-4 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-outline-primary" value="Salvar">Salvar</button>
                                    </div>
                                    <div class="col-xl-4"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                <div class="col-xl-2"></div>   
            </div><!--Fim do card principal-->
        </div>


        <footer class="footer">
            <?php include 'footer.php' ?>
        </footer>


</div>

    <!--Menu-->
    <script src="../js/app.js"></script>

    <!--Máscara valor-->
    <script>
        function formatarMoeda() {
            const valorInput = document.getElementById('valorUpdate');
            const valor = parseFloat(valorInput.value);
            const valorFormatado = valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            valorInput.value = valorFormatado;
        }
        $(function(){
            $('#valorUpdate').maskMoney({
                prefix:'R$ ',
                allowNegative: true,
                thousands:'.', decimal:',',
                affixesStay: true});
        })
    </script>
<script>
    function verificarCampos() {
        const campos = document.querySelectorAll('input[type="date"]'); // Seleciona todos os campos de entrada de texto, date e select
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
                    alerta.classList.add("show");
                    alerta.classList.remove("fade");
                    setTimeout(() => {
                    alerta.remove();
                    }, 3000);
                }, 100);

                return false; // Cancela o envio do formulário
            }
        }
        
        return true; // Permite o envio do formulário
    }
</script>

<!--Função que faz o alert sumir sozinho-->
<script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>
</body>
</html>

<?php } else{
        $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
        echo "<script>location.href = '../index.php'</script>" ;
}?>