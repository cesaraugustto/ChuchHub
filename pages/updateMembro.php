<?php
session_start();
if(isset($_SESSION['id'])){

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

$_SESSION['sessaoMenu'] = 'membros';


$comando = "SELECT * FROM usuario WHERE id = ".$_GET['id'];

//Abrindo a conexão e executando o comando sql
$sql = $conexao->query("SELECT * FROM usuario WHERE id = ".$_GET['id']);
//Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
foreach ($sql as $dadosBanco){}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Atualizar Membro</title>
    <?php include './header.php';?>
    <?php include './headerCadMembro.php'; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#cpf").mask("000.000.000-00");
            $("#telefone").mask("(00) 00000-0000");
            $("#cep").mask("00000-000");

        })
    </script>
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

            <div class="row pt-3 ps-3 pe-3">
            <form method="POST" action="updateMembro_ok.php" enctype="multipart/form-data" onsubmit="return verificarCampos()">
                <div class="col-xl-12 col-xxl-12 d-flex">
                    <div class="card flex-fill w-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informações de <?php echo $dadosBanco['nome']?></h5>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3 col-12">
                                    <figure class="image-container">
                                        <img id="chosen-image" src="../upload/<?php echo $dadosBanco['foto']?>" class="rounded-4 mb-2" style="width: 150px;">
                                        <figcaption id="file-name"></figcaption>
                                        <input type="file" id="upload-button" name="foto" accept="image/png, image/jpeg">
                                        <label for="upload-button" class="labelFoto p-2 rounded">
                                            <i class="align-middle" data-feather="camera"></i> &nbsp;
                                            Escolha uma foto
                                        </label>
                                    </figure>
                                    </div>
                                    <div class="col-xl-3">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $dadosBanco['nome']?>">

                                        <label>Sexo</label>
                                        <!--Esses if são para deixar marcado o sexo a depender do cadastro-->
                                            <select class="form-select m-0" aria-label="Default select example" id="modalBodySexo" name="sexo">
                                                <option value="F" <?php if($dadosBanco['sexo'] == "F"){ ?> selected <?php }?> >Feminino</option>
                                                <option value="M" <?php if($dadosBanco['sexo'] == "M"){ ?> selected <?php }?> >Masculino</option>
                                            </select>
                                            
                                        <label>CPF</label>
                                        <input type="text" class="form-control" value="<?php echo $dadosBanco['cpf'];?>" name="cpf" id="cpf">
                                    </div>
                                    <div class="col-xl-3">
                                        <label>Telefone</label>
                                        <input type="text" class="form-control" value="<?php echo $dadosBanco['telefone'];?>" name="telefone" id="telefone">

                                        <label>Email</label>
                                        <input type="text" class="form-control" value="<?php echo $dadosBanco['email'];?>" name="email" id="email">

                                        <label>Estado Civil</label>
                                        <input type="text" class="form-control" value="<?php echo $dadosBanco['estadoCivil'];?>" name="estadoCivil" id="estadoCivil">
                                    </div>
                                    <div class="col-xl-3">
                                        <label>Data Nascimento: </label>
                                            <input type="date" class="form-control" value="<?php echo $dadosBanco['dataNascimento'];?>" name="dataNascimento" id="dataNascimento">
                                        <label>Data Entrada</label>
                                            <input type="date" class="form-control" value="<?php echo $dadosBanco['dataCadastro'];?>" name="dataCadastro" id="dataCadastro">    

                                        <!--Para enviar o ID para outra tela-->
                                        <input type="hidden" value="<?php echo $dadosBanco['id'];?>" name="id" id="id">
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3 ps-3 pe-3">
                <div class="col-xl-8 col-xxl-8 d-flex">
                    <div class="card flex-fill w-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Dados Residenciais</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-5">
                                    <label>Endereço</label>
                                    <input type="text" class="form-control" value="<?php echo $dadosBanco['endereco'];?>" name="endereco" id="endereco">

                                    <label>Cidade</label>
                                    <input type="text" class="form-control" value="<?php echo $dadosBanco['cidade'];?>" name="cidade" id="cidade">
                                </div>
                                <div class="col-xl-3">
                                    <label>Estado</label>
                                    <select class="form-select m-0" aria-label="Default select example" name="uf" id="uf">
                                        <option value="<?php echo $dadosBanco['estado'];?>"><?php echo $dadosBanco['estado'];?></option>
                                        <option value="MG">MG</option>
                                        <option value="AC">AC</option>
                                        <option value="AL">AL</option>
                                        <option value="AP">AP</option>
                                        <option value="AM">AM</option>
                                        <option value="BA">BA</option>
                                        <option value="CE">CE</option>
                                        <option value="DF">DF</option>
                                        <option value="ES">ES</option>
                                        <option value="GO">GO</option>
                                        <option value="MA">MA</option>
                                        <option value="MT">MT</option>
                                        <option value="MS">MS</option>
                                        <option value="PA">PA</option>
                                        <option value="PB">PB</option>
                                        <option value="PR">PR</option>
                                        <option value="PE">PE</option>
                                        <option value="PI">PI</option>
                                        <option value="RJ">RJ</option>
                                        <option value="RN">RN</option>
                                        <option value="RS">RS</option>
                                        <option value="RO">RO</option>
                                        <option value="RR">RR</option>
                                        <option value="SC">SC</option>
                                        <option value="SP">SP</option>
                                        <option value="SE">SE</option>
                                    </select>
                                    <label>CEP</label>
                                    <input type="text" class="form-control" value="<?php echo $dadosBanco['cep'];?>" name="cep" id="cep">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-xxl-4 d-flex">
                    <div class="card flex-fill w-100">
                        <div class="card-header"> Dados sistemáticos </div>
                        <div class="card-body">
                            <div class="col-xl-8">
                                <label>Senha</label>
                                <input type="password" class="form-control" value="senhapassword" name="senha" id="senha">

                                <label>Cargo</label>
                                <input type="text" class="form-control" disabled value="<?php echo $dadosBanco['cargo'];?>">
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="row ps-3 mb-5">
                <div class="col-8 col-xl-2">
                    <label>Desativar Membro: </label>
                    <select class="form-select m-0" id="desativar" name="desativar">
                        <option value="sem"></option>
                        <?php if($dadosBanco['situacao'] == 'Ativo'){?>
                            <option value="Desativar">Desativar</option>
                        <?php } else {?>
                            <option value="Ativar">Ativar</option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-xl-8"></div>
                <div class="col">
                    <button type="submit" class="mt-4 btn btn-outline-primary" value="Salvar">Salvar Alterações</button>
                </div>
            </div>
        </form>

            <footer class="footer">
                    <?php include 'footer.php' ?>
            </footer>
        </div>
    </div>


    <script>
    function verificarCampos() {
        const campos = document.querySelectorAll('input[type="text"], input[type="date"], select'); // Seleciona todos os campos de entrada de texto, date e select
        for (let i = 0; i < campos.length; i++) {
            const campo = campos[i];
            const valor = campo.value.trim();
            
            if (valor === "") {
                alert(`O campo ${campo.name} está vazio!`);
                return false; // Cancela o envio do formulário
            }
        }
        
        return true; // Permite o envio do formulário
    }
</script>

    <script src="../js/app.js"></script>
    <script src="../js/imgPreview.js"></script>

    
<script>//Script do alert
    function verificarCampos() {
        const campos = document.querySelectorAll('input[type="text"], input[type="date"], input[type="password"], select'); // Seleciona todos os campos de entrada de texto, date e select
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
                }, 2000);

                return false; // Cancela o envio do formulário
            }
        }
        
        return true; // Permite o envio do formulário
    }
</script>


<!--Função que faz o alert sumir sozinho-->
<script>
    window.setTimeout(function() {
    $(".alert").fadeTo(2000, 0).slideUp(500, function(){
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